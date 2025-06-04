د<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <style>
        .chat-container {
            max-width: 600px;
            margin: auto;
            margin-top: 40px;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .chat-messages {
            height: 300px;
            overflow-y: scroll;
            margin-bottom: 20px;
            padding: 10px;
            background: #fff;
            border: 1px solid #ddd;
        }
        .chat-message {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 8px;
        }
        .chat-message.self {
            background-color: #dcf8c6;
            text-align: right;
        }
        .chat-message.other {
            background-color: #f1f0f0;
            text-align: left;
        }
        .chat-input {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .send-button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            margin-left: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <h4>Chat for Ticket #{{ $ticket->id }}</h4>

        <div class="chat-messages" id="chat-messages">
            @foreach ($messages as $msg)
                <div class="chat-messages {{ $msg->pharmacy_id ? 'self' : 'other' }}">
                    {{ $msg->messages }}
                </div>
            @endforeach
        </div>

        <form method="POST" action="{{ route('tickets.send', $ticket->id) }}">
            @csrf
            <div style="display: flex;">
                <input type="text" name="message" class="chat-input" placeholder="Type your message...">
                <button type="submit" class="send-button">Send</button>
            </div>
        </form>
    </div>
</body>
</html>