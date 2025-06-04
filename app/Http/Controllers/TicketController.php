<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Order;
 
class TicketController extends Controller
{
    public function index()
    {
        $pharmacyId = auth()->guard('pharmacy')->id();

        $pharmacyId = auth('pharmacy')->id(); // تأكد guard = pharmacy
        $tickets = Ticket::where('pharmacy_id', $pharmacyId)->with('storehouse')->get();
        return view('pharmacy.tickets.mytickets', compact('tickets'));
    }

    public function getMessages($id)
    {
        $ticket = Ticket::with('messages', 'pharmacy', 'storehouse')->findOrFail($id);
        return view('pharmacy.tickets.chat', compact('ticket'));
    }
    public function closeTicket($id)
{
    $ticket = Ticket::findOrFail($id);
    $ticket->status = 'closed';
    $ticket->save();

    return redirect()->back()->with('success', 'The ticket has been closed successfully.');
}



public function sendMessage(Request $request, $id)
{
    $request->validate([
        'message' => 'required|string|max:1000',
    ]);

    $ticket = Ticket::findOrFail($id);
    $ticket->message = $request->message;
    $ticket->sender = 'storehouse'; // عم تسجل من طرف مين
    $ticket->save();

    return redirect()->back()->with('success', 'Message sent successfully.');
}



    public function store(Request $request)
{
    $request->validate([
        'order_id' => 'required|exists:orders,id',
        'message' => 'required|string'
    ]);

  // جلب المخزن المرتبط بالطلب
    $order = Order::findOrFail($request->order_id);
    $storehouseId = $order->store_houses_id; 
    // return var_dump($order);
    Ticket::create([
        'order_id' => $request->order_id,
        'storehouse_id' => $storehouseId, // يتم جلبه تلقائيًا
        'pharmacy_id' => auth('pharmacy')->id(),
        'message' => $request->message,
        'status' => 'open',
    ]);

    return redirect()->back()->with('success', 'Ticket created successfully.');
}
    public function myTickets()
{
    $pharmacyId = Auth::guard('pharmacy')->id();

    $tickets = Ticket::where('pharmacy_id', $pharmacyId)->get();

    return view('pharmacy.tickets.mytickets', compact('tickets'));
}


public function storehouseTickets()
{
    $storehouseId = auth()->guard('store_houses')->id();

    $tickets = Ticket::with('pharmacy')
        ->where('storehouse_id', $storehouseId)
        ->get();

        // return dd($storehouseId);
    return view('admin.StoreHouse.storetickets.myticketsstore', compact('tickets'));
}


}