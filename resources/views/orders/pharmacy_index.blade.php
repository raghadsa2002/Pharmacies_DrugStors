<!DOCTYPE html>
<html lang="en">
@include('website.layouts.websiteHeader')

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Medicines</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


    <style>
       

        .page-title {
            font-size: 32px;
            font-weight: 700;
            text-align: center;
            color:rgb(66, 193, 185);
            margin-bottom: 30px;
        }

        .filter-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.04);
            margin-bottom: 30px;
        }

        .filter-container label {
            font-weight: 500;
        }

        .btn-filter {
            background-color:rgb(66, 193, 185);
            
            color: black;
            padding: 8px 20px;
            font-size: 14px;
            border-radius: 8px;
            transition: 0.3s ease;
        }

        .btn-filter:hover {
            background-color:rgb(218, 217, 233);
            
        }

        .table-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.03);
        }

        .table thead {
            background-color:rgb(209, 206, 237);
        }

        .table th {
            text-align: center;
            font-weight: 600;
            color:rgb(26, 121, 120);
        }

        .table td {
            text-align: center;
            vertical-align: middle;
        }

        .text-danger {
            font-weight: bold;
        }
    </style>
</head>

<body>

        <h2 class="page-title">Orders List</h2>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="GET" action="{{ route('pharmacy.orders') }}" class="filter-container row g-3">
    <div class="col-md-2">
        <label for="status">Status</label>
        <select name="status" id="status" class="form-select form-control-sm">
            <option value="">All</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
    </div>

    <div class="col-md-2">
        <label for="storehouse_id">Storehouse</label>
        <select name="storehouse_id" id="storehouse_id" class="form-select form-control-sm">
            <option value="">All</option>
            @foreach ($storehouses as $storehouse)
                <option value="{{ $storehouse->id }}" {{ request('storehouse_id') == $storehouse->id ? 'selected' : '' }}>
                    {{ $storehouse->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2">
        <label for="medicine">Medicine</label>
        <input type="text" id="medicine" name="medicine" value="{{ request('medicine') }}" class="form-control form-control-sm">
    </div>

    <div class="col-md-2">
        <label for="from_date">From Date</label>
        <input type="date" id="from_date" name="from_date" value="{{ request('from_date') }}" class="form-control form-control-sm">
    </div>

    <div class="col-md-2">
        <label for="to_date">To Date</label>
        <input type="date" id="to_date" name="to_date" value="{{ request('to_date') }}" class="form-control form-control-sm">
    </div>

  
    <!-- زر البحث بنفس عرض الأعمدة -->
    <div class="col-md-2">
        <label>&nbsp;</label> <!-- Empty label for spacing -->
        <button type="submit" class="btn btn-filter w-100">SEARCH</button>
    </div>
</form>

        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-bordered">

                    <thead>
                        <tr>
                        <th>Order ID</th>
                            <th>Storehouse Name</th>
                            <th>Medicine Name</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th>Order Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->storehouse->name ?? 'Unknown Storehouse' }}</td>
                            <td>
                                @if ($order->offer && $order->offer->title)
                                    {{ $order->offer->title }}
                                @elseif ($order->medicine && $order->medicine->name)
                                    {{ $order->medicine->name }}
                                @else
                                    <span class="text-danger">Invalid Order</span>
                                @endif
                            </td>
                            <td>{{ $order->quantity }}</td>
                            <td>{{ $order->status }}</td>
                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
            {{ $orders->withQueryString()->links('pagination::bootstrap-5') }}
</div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
@include('website.layouts.websiteFooter')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>


</html>
@include('website.layouts.websiteFooter')