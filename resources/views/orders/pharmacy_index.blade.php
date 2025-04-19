<!DOCTYPE html>
<html lang="en">
@include('website.layouts.websiteHeader')

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Medicines</title>

    <!-- Bootstrap CSS (إذا كنتِ تستخدمينه) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Orders List</h2>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>Order ID</th>
                        <th>Pharmacy Name</th>
                        <th>Medicine Name</th>
                        <th>Quantity</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->pharmacy->name ?? 'Unknown Pharmacy' }}</td>
                        <td>
    @if ($order->offer && $order->offer->title)
        {{ $order->offer->title }}
    @elseif ($order->medicine && $order->medicine->name)
        {{ $order->medicine->name }}
    @else
        <span class="text-danger fw-bold">Invalid Order</span>
    @endif
</td>
                        <td>{{ $order->quantity }}</td>
                        <td>{{ $order->status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS (إذا كنتِ تستخدمينه) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
@include('website.layouts.websiteFooter')