<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function addToCart(Request $request)
    {
        $medicineId = $request->medicine_id;
        $quantity = (int)$request->quantity;

        $medicine = Medicine::findOrFail($medicineId);

        $cart = session()->get('cart', []);

        if (isset($cart[$medicineId])) {
            $cart[$medicineId]['quantity'] += $quantity;
        } else {
            $cart[$medicineId] = [
                'id'       => $medicine->id,
                'name'     => $medicine->name,
                'price'    => $medicine->discount?->discounted_price ?? $medicine->price,
                'image'    => $medicine->image,
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'message' => 'Added to cart successfully!',
            'cart_count' => count($cart)
        ]);
    }

    public function remove(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Item removed from cart.');
    }

    public function checkout()
    {
        $cart = session('cart', []);
        if(empty($cart)) {
            return redirect()->route('cart.show')->with('error', 'Your cart is empty.');
        }

        // هنا تضيف منطق تخزين الطلب في قاعدة البيانات

        session()->forget('cart');

        return redirect()->route('cart.show')->with('success', 'Order placed successfully!');
    }
}