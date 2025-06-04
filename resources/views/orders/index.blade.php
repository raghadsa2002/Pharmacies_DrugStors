<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Order List</title>

    @include('layouts.Admin.LinkHeader')
    @include('layouts.Admin.LinkSideBar')

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />
</head>

<body>
    <div class="container-scroller">
        @include('layouts.Admin.Header')

        <div class="container-fluid page-body-wrapper">
            @include('layouts.Admin.Sidebar')

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Order List</h4>

                                    <form method="GET" action="{{ route('orders.index') }}" class="mb-4">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Pharmacy</label>
                                                <select name="pharmacy_id" class="form-control">
                                                    <option value="">All</option>
                                                    @foreach($pharmacies as $pharmacy)
                                                        <option value="{{ $pharmacy->id }}" 
                                                            {{ request('pharmacy_id') == $pharmacy->id ? 'selected' : '' }}>
                                                            {{ $pharmacy->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Medicine</label>
                                                <select name="medicine_id" class="form-control">
                                                    <option value="">All</option>
                                                    @foreach($medicines as $medicine)
                                                        <option value="{{ $medicine->id }}" 
                                                            {{ request('medicine_id') == $medicine->id ? 'selected' : '' }}>
                                                            {{ $medicine->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-2">
                                                <label>Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="">All</option>
                                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                                </select>
                                            </div>

                                            <div class="col-md-2">
                                                <label style="visibility: hidden;">Search</label><button type="submit" class="btn btn-primary w-100">Search</button>
                                            </div>
                                        </div>
                                    </form>

                                    @if(session('error'))
                                        <div class="alert alert-danger">{{ session('error') }}</div>
                                    @endif

                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Pharmacy Name</th>
                                                    <th>details</th>
                                                    <th>Status</th>
                                                    <th>Change Status</th>
                                                    <th>Total Price</th>
                                                    <th>Order Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($orders as $order)
                                                    <tr>
                                                        <td>{{ $order->id }}</td>
                                                        <td>{{ $order->pharmacy?->name ?? 'Unknown' }}</td>
                                                        <td>
                                                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-primary">View Details</a>
                                                        </td>

                                                        <td>{{ ucfirst($order->status) }}</td>

                                                        <td>
                                                            <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                                                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                                    <option value="approved" {{ $order->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                                                    <option value="rejected" {{ $order->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                                </select>
                                                            </form>
                                                        </td>

                                                        <td>
                                                            {{ $order->total_price !== null ? number_format($order->total_price, 2) : 'N/A' }}
                                                        </td>
                                                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center">No orders found.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>

                                        <div class="pagination">
                                            {{ $orders->appends(request()->query())->links('pagination::bootstrap-4') }}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @include('layouts.Admin.Footer')
            </div>
        </div>
    </div>

    @include('layouts.Admin.LinkJS')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();

                const form = this.closest('form');

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
                        form.submit();
                    }
                });
            });
        });
    </script>
</body>

</html>