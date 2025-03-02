<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Pharmacy;
use App\Models\Medicine;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    // عرض الطلبات في صفحة المستودع
    public function index()
    {
      // جلب الطلبات الخاصة بالمستودع المسجل الدخول
$orders = Order::with(['pharmacy', 'medicine'])
->where('store_houses_id', Auth::guard('store_houses')->user()->id)
->get();
        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'quantity' => 'required|integer|min:1',
        ]);
        
        // تحديد المستودع بناءً على الدواء المطلوب
        $medicine = Medicine::findOrFail($request->medicine_id);
        
        // التأكد من أن الدواء مرتبط بمستودع
        if (!$medicine->store_houses_id) {
            return redirect()->back()->with('error', 'This medicine is not available in any storehouse.');
        }
        
        // إنشاء الطلب وتحديد المستودع الصحيح
        $order = new Order();
        $order->pharmacy_id = Auth::guard('pharmacy')->user()->id;
        $order->medicine_id = $request->medicine_id;
        $order->store_houses_id = $medicine->store_houses_id; // ربط الطلب بالمستودع المناسب
        $order->quantity = $request->quantity;
        $order->status = 'Pending';
        $order->save();
        
        return redirect()->back()->with('success', 'Order placed successfully!');
    }
    
    // تحديث حالة الطلب (مقبول، مرفوض، انتظار)
    public function updateStatus(Request $request, $id)
    {
        // العثور على الطلب
        $order = Order::findOrFail($id);
        // التحقق من أن الحالة المدخلة صحيحة
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        // تحديث حالة الطلب
        $order->status = $request->status;
        $order->save();

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('orders.index')->with('success', 'Order status updated successfully!');
    }

    // عرض صفحة إرسال الطلبات (اختياري حسب التصميم)
    public function create()
    {
        // جلب الأدوية والصيدليات للمساعدة في اختيار الدواء
        $medicines = Medicine::all();
        return view('orders.create', compact('medicines'));
    }
    public function pharamcyOrders()
    {
        $medicines = Order::where('pharmacy_id', Auth::guard('pharmacy')->user()->id)->get();
    
        return view('orders.pharmacy_index', compact('medicines'));
    }
}