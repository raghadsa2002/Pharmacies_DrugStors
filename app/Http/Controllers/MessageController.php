<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $ticketId)
{
    $request->validate([
        'message' => 'required',
    ]);

    $message = new Messages ();
    $message->ticket_id = $ticketId;
    $message->message = $request->message;

    if (Auth::guard('pharmacy')->check()) {
        $message->pharmacy_id = Auth::guard('pharmacy')->id();
    } elseif (Auth::guard('storehouse')->check()) {
        $message->storehouse_id = Auth::guard('storehouse')->id();
    }

    $message->save();

    return redirect()->route('chat.show', $ticketId);
}

    /**
     * Display the specified resource.
     */
    public function showChat($ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);
        $messages = Messages::where('ticket_id', $ticketId)->orderBy('created_at')->get();

        return view('pharmacy.chat', compact('ticket', 'messages'));
    }
    public function sendMessage(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'message' => 'required|string'
        ]);

        $message = new Messages();
        $message->ticket_id = $request->ticket_id;

        // تحديد من هو المُرسل (صيدلاني أم مدير مستودع)
        if (Auth::guard('pharmacy')->check()) {
            $message->pharmacy_id = Auth::guard('pharmacy')->id();
        } elseif (Auth::guard('storehouse')->check()) {
            $message->storehouse_id = Auth::guard('storehouse')->id();
        }

        $message->message = $request->message;
        $message->save();

        return redirect()->route('tickets.chat', $ticketId)->with('success', 'Message sent');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
    }
}
