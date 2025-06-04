<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Store House Table</title>

    @include('layouts.Admin.LinkHeader')
    @include('layouts.Admin.LinkSideBar')
</head>

<body>
    <style>
     
     .chat-container {
    margin-left: 30px;
  margin-bottom: 10px;
  width: 100%;
    position: fixed;
    bottom: 0;
    overflow: hidden;
  justify-content: center;
  align-items: center;
  font-size: 1rem;
  line-height: 1.5rem;
  
}

.chat-messages {
    height: 300px;
    overflow-y: scroll;
    padding: 10px;
  
}

.chat-input {
    width: calc(100% - 150px);
    padding: 10px;
    box-sizing: border-box;
    border: 2px solid #ccc;
    background-color: transparent;
  border-radius: 15px;
  font-family: victor mono;
  font-weight: 700;
}

.send-button {
  background-color: transparent;
    border: none;
    cursor: pointer;
    margin-left: 6px;
}

.chat-message {
    margin-bottom: 10px;
    padding: 5px;
    border-radius: 5px;
    background-color: #000000;
  color: wheat;
}

        </style>
    <div class="container-scroller">
        <!-- partial:../../partials/_navbar.html -->

        @include('layouts.Admin.Header')
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:../../partials/_settings-panel.html -->

         <!-- @include('layouts.Admin.Setting') -->

            <!-- partial:../../partials/_sidebar.html -->

            @include('layouts.Admin.Sidebar')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Tickets Received from Pharmacies</h4>
                
    @if($tickets->isEmpty())
        <div class="alert alert-warning">No tickets found.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Pharmacy Name</th>
                    <th>Order ID</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->pharmacy->name ?? 'N/A' }}</td>
                        <td>{{ $ticket->order_id }}</td>
                        <td>{{ $ticket->message }}</td>
                        <td>
                            @if ($ticket->status === 'open')
                                <span class="badge bg-success">Open</span>
                            @else
                                <span class="badge bg-secondary">Closed</span>
                            @endif
                        </td>
                        <td>
                        <div class="d-flex justify-content-start">
                            <a  href="{{ route('tickets.openchat', $ticket->id) }}" class="btn btn-success">Open Chat</a>
                            <a  href="{{ route('tickets.closechat', $ticket->id) }}" class="btn btn-danger">Close Chat</a>
                        </div>
                       
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('chat.show', $ticket->id) }}" class="btn btn-success btn-sm">New Chat</a>
    @endif

</div>





<!-- ✅ زر New Chat بأسفل الجدول -->

   



 

<div class="chat-container">
        <div class="chat-messages" id="chat-messages">
            <!-- Chat messages will appear here -->
        </div>
      
    </script>
</body>

</html>














</body>
</html>