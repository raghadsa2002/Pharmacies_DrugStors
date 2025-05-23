<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Pharmacy;
use App\Models\Medicine;
use App\Models\Offer;
use App\Models\StoreHouse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Notifications\LowStockNotification;

class OrderController extends Controller
{
    public function index(Request $request)
{
    $storehouseId = Auth::guard('store_houses')->user()->id;

    // استعلام الطلبات الأساسي
    $orders = Order::whereHas('medicine', function ($query) use ($storehouseId) {
        $query->where('store_houses_id', $storehouseId);
    });

    // الفلاتر
    if ($request->filled('status')) {
        $orders->where('status', $request->status);
    }

    if ($request->filled('pharmacy_id')) {
        $orders->where('pharmacy_id', $request->pharmacy_id);
    }

    if ($request->filled('medicine_id')) {
        $orders->where('medicine_id', $request->medicine_id)
               ->whereNull('offer_id'); // نتأكد إنها مو عرض
    }

    // جلب البيانات مع العلاقات والترتيب والبيجينيشن
    $orders = $orders->with(['pharmacy', 'medicine'])
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    $pharmacies = Pharmacy::all();
    $medicines = Medicine::where('store_houses_id', $storehouseId)->get();

    return view('orders.index', compact('orders', 'pharmacies', 'medicines'));
}

  

    public function store(Request $request)
    {
        $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'quantity' => 'required|integer|min:1',
        ]);
        
        // جلب الدواء
        $medicine = Medicine::findOrFail($request->medicine_id);
        
        // التحقق إذا كان الدواء متاح في المستودع
        if (!$medicine->store_houses_id) {
            return redirect()->back()->with('error', 'This medicine is not available in any storehouse.');
        }
        
        // جلب pharmacy_id من الجلسة
        $pharmacyId = Auth::guard('pharmacy')->user()->id;

        // إنشاء الطلب
        $order = new Order();
        $order->pharmacy_id = $pharmacyId;
        $order->medicine_id = $request->medicine_id;  // التأكد من إرسال medicine_id
        $order->store_houses_id = $medicine->store_houses_id;
        $order->quantity = $request->quantity;
        $order->status = 'Pending';
        $order->save();
        
        return redirect()->back()->with('success', 'Order placed successfully!');
    }
    
    public function updateStatus(Request $request, $id)
{
    $order = Order::findOrFail($id);

    $request->validate([
        'status' => 'required|in:pending,approved,rejected',
    ]);

    // إذا الحالة جديدة "approved" ننفذ عمليات الخصم والتخزين
    if ($request->status === 'approved') {
        $medicine = Medicine::findOrFail($order->medicine_id);

        // تحقق من الكمية
        if ($medicine->stock < $order->quantity) {
            return redirect()->back()->with('error', 'Cannot approve this order. The requested quantity exceeds the available stock');
        }

        // خصم الكمية
        $previousStock = $medicine->stock;
        $medicine->stock -= $order->quantity;
        $medicine->save();

        // حفظ حركة المخزون
        \App\Models\StockMovement::create([
            'medicine_id' => $medicine->id,
            'type' => 'decrease',
            'quantity' => $order->quantity,
            'previous_stock' => $previousStock,
            'new_stock' => $medicine->stock,
        ]);
        // check if stock less than 50 
        // if($medicine->stock < 50) {
        //     $user->notify(new LowStockNotification(['medican' => medican name, 'stock' => 'stock current be ' .$medicine->stock ]));
        // }
    }

    // تحديث الحالة
    $order->status = $request->status;
    $order->save();

    return redirect()->route('orders.index')->with('success', 'تم تحديث حالة الطلب بنجاح.');
}

    public function create()
    {
        $medicines = Medicine::all();
        return view('orders.create', compact('medicines'));
    }

    public function pharmacyOrders(Request $request)
    {
        $query = Order::with(['medicine', 'offer', 'storehouse'])
            ->where('pharmacy_id', Auth::guard('pharmacy')->id());
    
        // فلتر الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
    
        // فلتر اسم الدواء (من medicine أو offer)
        if ($request->filled('medicine')) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('medicine', function ($q2) use ($request) {
                    $q2->where('name', 'like', '%' . $request->medicine . '%');
                })->orWhereHas('offer', function ($q3) use ($request) {
                    $q3->where('title', 'like', '%' . $request->medicine . '%');
                });
            });
        }
    
        // فلتر اسم المستودع
        if ($request->filled('storehouse_id')) {
            $query->where('store_houseS_id', $request->storehouse_id);
        }
    
        // فلتر التاريخ من
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
    
        // فلتر التاريخ إلى
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
    
        $orders = $query->latest()->paginate(10); // بدلاً من get()
        $storehouses = StoreHouse::all(); // تأكدي من اسم الموديل
    
        return view('orders.pharmacy_index', compact('orders', 'storehouses'));
    }

    public function createOrder(Request $request, $offerId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
    
        // الحصول على العرض بناءً على المعرف
        $offer = Offer::findOrFail($offerId);
    
        // تحقق من أن أحد الأدوية في العرض غير فارغ
        $medicineId = null;
        if ($offer->medicine_id_1) {
            $medicineId = $offer->medicine_id_1;
        } elseif ($offer->medicine_id_2) {
            $medicineId = $offer->medicine_id_2;
        }
    
        // إذا لم يكن هناك دواء في العرض، إرجاع خطأ
        if (!$medicineId) {
            return redirect()->back()->with('error', 'No valid medicine in this offer.');
        }
    
        // إنشاء الطلب
        
        $order = Order::create([
            'pharmacy_id' => Auth::guard('pharmacy')->user()->id,
            'store_houses_id' => $offer->store_houses_id,
            'offer_id' => $offer->id,
            'medicine_id_1' => $offer->medicine_id_1,
            'medicine_id_2' => $offer->medicine_id_2,
            'medicine_id' => $medicineId, // حفظ الدواء المتاح
            'quantity' => $request->quantity,
            'status' => 'pending',
        ]);
    
        // إرجاع النجاح
        return redirect()->route('orders.pharmacyOffers')->with('success', 'تم إرسال الطلب بنجاح');
    }

    public function approveOrder($orderId)
{
    // استرجاع الطلب بناءً على ID
    $order = Order::findOrFail($orderId);

    // الحصول على الأدوية في الطلب
    $medicine = Medicine::findOrFail($order->medicine_id);

    // التحقق من المخزون
    if ($medicine->stock < $order->quantity) {
        return redirect()->back()->with('error', 'Not enough stock available for this order.');
    }

    // تقليص الكمية من المخزون
    $medicine->stock -= $order->quantity;
    $medicine->save();

    // تحديث حالة الطلب
    $order->status = 'approved'; // تحديث حالة الطلب إلى "موافق عليه"
    $order->save();

    // تسجيل حركة المخزون
    StockMovement::create([
        'medicine_id' => $medicine->id,
        'type' => 'decrease',
        'quantity' => $order->quantity,
        'previous_stock' => $medicine->stock + $order->quantity, // القيمة قبل التغيير
        'new_stock' => $medicine->stock,
    ]);

    return redirect()->back()->with('success', 'Order approved and stock updated.');
}
}