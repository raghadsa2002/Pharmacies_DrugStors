<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Pharmacy;
use App\Models\Medicine;
use App\Models\Offer;
use App\Models\StoreHouse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // استرجاع جميع الطلبات مع تفاصيل الصيدلاني والدواء
        $storehouseId = Auth::guard('store_houses')->user()->id;
        $orders = Order::whereHas('medicine', function ($query) use ($storehouseId) {
            $query->where('store_houses_id', $storehouseId);
        })->with(['pharmacy', 'medicine'])->get();
        // return dd($orders);
        // إرجاع العرض مع البيانات
        return view('orders.index', compact('orders'));
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

        $order->status = $request->status;
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Order status updated successfully!');
    }

    public function create()
    {
        $medicines = Medicine::all();
        return view('orders.create', compact('medicines'));
    }

    public function pharmacyOrders()
    {
        $orders = Order::where('pharmacy_id', Auth::guard('pharmacy')->user()->id)
            ->with(['medicine', 'offer']) // جلب العلاقة مع الدواء والعرض لو احتجتيهم
            ->get();
    
        return view('orders.pharmacy_index', compact('orders'));
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
}