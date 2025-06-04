<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Pharmacy;
use App\Models\Medicine;
use App\Models\Offer;
use App\Models\StoreHouse;
use App\Models\StockMovement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Notifications\LowStockNotification;
 use App\Notifications\OrderStatusChangedNotification;
class OrderController extends Controller
{
    // عرض الطلبات للمستودع
    public function index(Request $request)
    {
        $storehouseId = Auth::guard('store_houses')->user()->id;

        $orders = Order::where('store_houses_id', $storehouseId);

        if ($request->filled('status')) {
            $orders->where('status', $request->status);
        }

        if ($request->filled('pharmacy_id')) {
            $orders->where('pharmacy_id', $request->pharmacy_id);
        }

        if ($request->filled('medicine_id')) {
            $medicineId = $request->medicine_id;
            $orders->whereHas('orderItems', function ($q) use ($medicineId) {
                $q->where('medicine_id', $medicineId);
            });
        }

        $orders = $orders->with(['pharmacy', 'orderItems.medicine'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $pharmacies = Pharmacy::all();
        $medicines = Medicine::where('store_houses_id', $storehouseId)->get();

        return view('orders.index', compact('orders', 'pharmacies', 'medicines'));
    }

    // صفحة المنتجات
    public function products()
    {
        $medicines = Medicine::where('store_houses_id', Auth::guard('store_houses')->id())
                            ->where('stock', '>', 0)
                            ->get();
        
        return view('website.products', compact('medicines'));
    }

    // صفحة السلة
    public function cartIndex()
    {
        return view('cart.index');
    }

    // عملية الشراء (Checkout) من السلة
  public function checkout(Request $request)
{
    $cartItems = $request->input('cart');
    $pharmacyId = Auth::guard('pharmacy')->id();

    if (empty($cartItems) || !is_array($cartItems)) {
        return response()->json(['success' => false, 'message' => 'Cart is empty or invalid.']);
    }

    $firstMedicine = Medicine::find($cartItems[0]['id'] ?? null);
    if (!$firstMedicine) {
        return response()->json(['success' => false, 'message' => 'Invalid medicine in cart.']);
    }

    $storehouseId = $firstMedicine->store_houses_id;

    $totalPrice = 0;
    $orderItems = [];

    foreach ($cartItems as $item) {
        $medicine = Medicine::find($item['id'] ?? null);

        if (!$medicine || $medicine->store_houses_id != $storehouseId) {
            return response()->json(['success' => false, 'message' => 'All medicines must be from the same storehouse.']);
        }

        $subtotal = $medicine->price * $item['quantity'];
        $totalPrice += $subtotal;

        $orderItems[] = [
            'medicine_id' => $medicine->id,
            'quantity' => $item['quantity'],
            'price' => $medicine->price,
        ];
    }

    $order = Order::create([
        'pharmacy_id' => $pharmacyId,
        'store_houses_id' => $storehouseId,
        'status' => 'pending',
        'total_price' => $totalPrice, ]);
        // إرسال إشعار للمدير بوجود طلب جديد
        $storehouse = StoreHouse::find($storehouseId);
        $storehouse->notify(new \App\Notifications\NewOrderNotification($order));
   

    foreach ($orderItems as $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'medicine_id' => $item['medicine_id'],
            'quantity' => $item['quantity'],
            'price' => $item['price'],
        ]);
    }

    return response()->json(['success' => true, 'message' => 'Order placed successfully.']);
}

    // تغيير حالة الطلب من قبل المستودع
    public function updateStatus(Request $request, $id)
    {
        $order = Order::with('orderItems.medicine')->findOrFail($id);

        $request->validate(['status' => 'required|in:pending,approved,rejected']);
        if ($request->status === 'approved') {
            foreach ($order->orderItems as $item) {
                $medicine = $item->medicine;

                if ($medicine->stock < $item->quantity) {
                    return redirect()->back()->with('error', "Insufficient stock for medicine: {$medicine->name}");
                }

                $previousStock = $medicine->stock;
                $medicine->stock -= $item->quantity;
                $medicine->save();

                StockMovement::create([
                    'medicine_id' => $medicine->id,
                    'type' => 'decrease',
                    'quantity' => $item->quantity,
                    'previous_stock' => $previousStock,
                    'new_stock' => $medicine->stock,
                ]);

                if ($medicine->stock < 50) {
                    $storehouse = $medicine->storehouse;
                    $storehouse->notify(new LowStockNotification($medicine));
                }
            }
        }

        $order->status = $request->status;
        $order->save();
   
        // إرسال إشعار للصيدلية
        $order->pharmacy->notify(new OrderStatusChangedNotification($order->id, $order->status));

        return redirect()->route('orders.index')->with('success', 'Order status updated successfully.');
    }

    // طلبات الصيدلي (صفحة My Orders)
    public function pharmacyOrders(Request $request)
    {
        $query = Order::with(['orderItems.medicine', 'offer', 'storehouse'])
            ->where('pharmacy_id', Auth::guard('pharmacy')->id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('medicine')) {
            $search = $request->medicine;
            $query->whereHas('orderItems.medicine', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            })->orWhereHas('offer', function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        }

        if ($request->filled('storehouse_id')) {
            $query->where('store_houses_id', $request->storehouse_id);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $orders = $query->latest()->paginate(10);
        $storehouses = StoreHouse::all();

        return view('orders.pharmacy_index', compact('orders', 'storehouses'));
    }
  // داخل OrderController
public function show($id)
{
    $order = Order::with('pharmacy', 'orderItems.medicine')->findOrFail($id);
    return view('orders.show', compact('order'));
}
// public function orderOffer(Request $request, $offerId)
public function orderOffer(Request $request)
{
    $pharmacyId = Auth::guard('pharmacy')->id();
    $offerId = $request->input('offer_id');

    $offer = Offer::with(['offer_items.medicine', 'storehouse'])->findOrFail($offerId);

    // تأكد أن العرض فعّال
    if (now()->lt($offer->start_date) || now()->gt($offer->end_date)) {
        return redirect()->back()->with('error', 'This offer is not currently available.');
    }

    // تأكد أن الصيدلية ما طلبت هذا العرض من قبل
    $existingOrder = Order::where('pharmacy_id', $pharmacyId)
        ->where('offer_id', $offerId)
        ->first();

    if ($existingOrder) {
        return redirect()->back()->with('error', 'You have already ordered this offer.');
    }

    $totalPrice = 0;

    // جمع العناصر المطلوبة
    $orderItems = [];
    foreach ($offer->offer_items as $item) {
        if ($item->type === 'discount') {
            $price = $item->medicine->price - ($item->medicine->price * $item->value / 100);
            $totalPrice += $price * $item->required_quantity;
        } else {
            $price = 0; // مجاني
        }

        $orderItems[] = [
            'medicine_id' => $item->medicine_id,
            'quantity' => $item->required_quantity,
            'price' => $price,
        ];
    }

    // إنشاء الطلب
    $order = Order::create([
        'pharmacy_id' => $pharmacyId,
        'store_houses_id' => $offer->storehouse->id,
        'status' => 'pending',
        'total_price' => $totalPrice,
        'offer_id' => $offer->id,
    ]);

    // حفظ العناصر
    foreach ($orderItems as $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'medicine_id' => $item['medicine_id'],
            'quantity' => $item['quantity'],
            'price' => $item['price'],
        ]);
    }
return redirect()->back()->with('success', 'Offer ordered successfully.');
}
}