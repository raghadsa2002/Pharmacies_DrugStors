<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {

        // التحقق من صحة البيانات
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        // جلب pharmacy_id من الجلسة
        $pharmacyId = Auth::guard('pharmacy')->user()->id;


        // التأكد من أن الطلب يعود لنفس الصيدلية
        $order = Order::where('id', $request->order_id)
                      ->where('pharmacy_id', $pharmacyId)
                      ->firstOrFail();

        // التحقق من عدم وجود تقييم سابق
        if ($order->review) {
            return back()->with('error', 'تم تقييم هذا الطلب مسبقًا.');
        }

        // إنشاء التقييم
        Review::create([
            'order_id' => $order->id,
            'pharmacy_id' => $pharmacyId,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'تم إرسال تقييمك بنجاح.');
    }

    public function index()
    {
        $reviews = Review::with(['order', 'order.pharmacy']) // جلب الطلب والصيدلية المرتبطة به
            ->latest()
            ->get();
    
        return view('admin.reviews.index', compact('reviews'));
    }


    public function managerIndex()
    {
        // استدعاء التقييمات مع معلومات الطلب والصيدلي
        $reviews = Review::with(['order', 'pharmacist'])->latest()->get();
    
        return view('manager.reviews.index', compact('reviews'));
    }


}