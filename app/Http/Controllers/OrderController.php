<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Pharmacy;
use App\Models\Medicine;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    
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
        
      
        $medicine = Medicine::findOrFail($request->medicine_id);
        
        
        if (!$medicine->store_houses_id) {
            return redirect()->back()->with('error', 'This medicine is not available in any storehouse.');
        }
        
       
        $order = new Order();
        $order->pharmacy_id = Auth::guard('pharmacy')->user()->id;
        $order->medicine_id = $request->medicine_id;
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
    public function pharamcyOrders()
    {
        $medicines = Order::where('pharmacy_id', Auth::guard('pharmacy')->user()->id)->get();
    
        return view('orders.pharmacy_index', compact('medicines'));
    }
}