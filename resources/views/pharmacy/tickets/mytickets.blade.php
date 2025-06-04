<!-- resources/views/pharmacy/ticket/mytickets.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-4">My Tickets</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- ✅ جدول عرض التيكتات الخاصة بالصيدلاني الحالي -->
        @if($tickets->isEmpty())
            <div class="alert alert-warning">
                No tickets found.
            </div>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Order ID</th>
                        <th>Storehouse ID</th>
                        <th>Pharmacy ID</th>
                        <th>Message</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->id }}</td>
                            <td>{{ $ticket->order_id }}</td>
                            <td>{{ $ticket->storehouse_id }}</td>
                            <td>{{ $ticket->pharmacy_id }}</td>
                            <td>{{ $ticket->message }}</td>
                            <td>
                                @if ($ticket->status === 'open')
                                    <span class="badge bg-success">Open</span>
                                @else
                                    <span class="badge bg-secondary">Closed</span>

                                    <a href="{{ route('tickets.chat', ['id' => $ticket->id]) }}" class="btn btn-success mt-3 float-end">open Chat</a>
                                    <a href="{{ route('chat.show', $ticket->id) }}" class="btn btn-success btn-sm">open Chat</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>


 
</body>
</html>