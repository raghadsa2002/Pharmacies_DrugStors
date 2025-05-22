<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Medicines</title>

    @include('layouts.Admin.LinkHeader')
    @include('layouts.Admin.LinkSideBar') <!-- تضمين الشريط الجانبي -->

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body>
    <div class="container-scroller">
        @include('layouts.Admin.Header')  <!-- هيدر الصفحة -->

        <div class="container-fluid page-body-wrapper">
            @include('layouts.Admin.Sidebar')  <!-- الشريط الجانبي نفسه -->

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Order List</h4>
                                    <form method="GET" action="{{ route('orders.index') }}" class="mb-4">
    <div class="row">
        <!-- Pharmacy filter -->
        <div class="col-md-3">
            <label>Pharmacy</label>
            <select name="pharmacy_id" class="form-control">
                <option value="">All</option>
                @foreach($pharmacies as $pharmacy)
                    <option value="{{ $pharmacy->id }}" {{ request('pharmacy_id') == $pharmacy->id ? 'selected' : '' }}>
                        {{ $pharmacy->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Medicine filter -->
        <div class="col-md-3">
            <label>Medicine</label>
            <select name="medicine_id" class="form-control">
                <option value="">All</option>
                @foreach($medicines as $medicine)
                    <option value="{{ $medicine->id }}" {{ request('medicine_id') == $medicine->id ? 'selected' : '' }}>
                        {{ $medicine->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Status filter -->
        <div class="col-md-2">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="">All</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            </select>
        </div>

       

        
      <!-- Search button -->
<div class="col-md-2">
    <label style="visibility: hidden;">Search</label>
    <button type="submit" class="btn btn-primary w-100">Search</button>
</div>

       
    </div>
</form>

                                    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <!-- جدول عرض البيانات -->
                                    <div class="table-responsive">
                                    <table class="table">
    <thead>
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
                <td>{{ $order->pharmacy?->name ?? 'غير معروف' }}</td>  
                <td>
                    @if ($order->offer)
                        {{ 'عرض: ' . ($order->offer->title ?? 'بدون اسم') }}
                    @elseif ($order->medicine)
                        {{ $order->medicine->name }}
                    @elseif ($order->medicine1 || $order->medicine2)
                        {{ 'عرض بين: ' . optional($order->medicine1)->name . ' و ' . optional($order->medicine2)->name }}
                    @else
                        غير موجود
                    @endif
                </td>
                <td>{{ $order->quantity }}</td>
                <td>
                    @if($order->status != 'Pending')
                        {{ $order->status }}
                    @endif
                    @if($order->status == 'Pending')
                        <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                            @csrf
                            @method('POST')
                            <select name="status" class="form-control">
                                <option value="approved" {{ $order->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ $order->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                            <button type="submit" class="btn btn-primary mt-2">Update Status</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="pagination">
        {{ $orders->appends(request()->query())->links('pagination::bootstrap-4') }}  <!-- هذا يعرض روابط البيجينيشن -->
    </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                @include('layouts.Admin.Footer')
            </div>
        </div>
    </div>

    @include('layouts.Admin.LinkJS')

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent form submission

                const form = this.closest('form'); // Find the closest form for delete

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit form if confirmed
                    }
                });
            });
        });
    </script>
</body>

</html>