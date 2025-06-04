<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PharmacistOfferController extends Controller
{
    public function index()
    {
        $offers = Offer::whereDate('start_date', '<=', now())
                       ->whereDate('end_date', '>=', now())
                       ->with(['offer_items.medicine', 'storehouse'])
                       ->get();

        return view('orders.pharmacy_offer', compact('offers'));
    }
}