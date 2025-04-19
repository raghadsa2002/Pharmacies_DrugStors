<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PharmacistOfferController extends Controller
{
    public function index()
    {
        $offers = Offer::whereDate('start_date', '<=', now())
                       ->whereDate('end_date', '>=', now())
                       ->with(['medicine1', 'medicine2', 'storehouse']) // تأكدي إن هذي العلاقات معرفة
                       ->get();
    
        return view('orders.pharmacy_offer', compact('offers'));
    }

    public function order($offerId)
    {
        $pharmacist = Auth::guard('pharmacy')->user();
        $offer = Offer::findOrFail($offerId);

        Order::create([
            'pharmacy_id' => $pharmacist->id,
            'medicine_id' => $offer->medicine1_id,
            'quantity' => 1,
            'storehouses_id' => $offer->store_houses_id,
            'ordered_from_offer' => true,
            'offer_id' => $offer->id,
        ]);

        return redirect()->back()->with('success', 'تم طلب العرض بنجاح!');
    }
}