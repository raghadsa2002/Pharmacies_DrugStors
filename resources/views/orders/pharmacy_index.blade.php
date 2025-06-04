<!DOCTYPE html>
<html lang="en">
@include('website.layouts.websiteHeader')

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pharmacy Orders</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />

    <style>
        .page-title {
            font-size: 28px;
            font-weight: bold;
            color: rgb(66, 193, 185);
            text-align: center;
            margin: 40px 0 25px;
        }

        .filter-container {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.04);
            margin-bottom: 30px;
        }

        .btn-filter {
            background-color: rgb(66, 193, 185);
            color: black;
            font-size: 14px;
            border-radius: 8px;
            padding: 8px 20px;
            transition: 0.3s ease;
        }

        .btn-filter:hover {
            background-color: rgb(218, 217, 233);
        }

        .table-container {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.03);
        }

        .table thead {
            background-color: rgb(209, 206, 237);
        }

        .table th {
            text-align: center;
            font-weight: 600;
            color: rgb(26, 121, 120);
        }

        .table td {
            text-align: center;
            vertical-align: middle;
        }

        .modal-content {
            max-width: 500px;
            margin: auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
        }
    </style>
</head>

<body>

    <h2 class="page-title">Pharmacy Orders</h2>

    @if ($errors->any())
    <div class="alert alert-danger container">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Filters -->
    <form method="GET" action="{{ route('pharmacy.orders') }}" class="filter-container row mx-2 g-3">
        <div class="col-md-2">
            <label>Status</label>
            <select name="status" class="form-select form-control-sm">
                <option value="">All</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>

        <div class="col-md-2">
            <label>Storehouse</label>
            <select name="storehouse_id" class="form-select form-control-sm">
                <option value="">All</option>
                @foreach ($storehouses as $storehouse)
                <option value="{{ $storehouse->id }}" {{ request('storehouse_id') == $storehouse->id ? 'selected' : '' }}>
                    {{ $storehouse->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label>From Date</label>
            <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control form-control-sm" />
        </div>

        <div class="col-md-2">
            <label>To Date</label>
            <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control form-control-sm" />
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-filter w-100">Search</button>
        </div>
    </form>

    <!-- Table -->
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Medicines & Quantities</th>
                <th>Storehouse</th>
                <th>Status</th>
                <th>Review</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>

                    <td>
                        <ul class="list-unstyled mb-0">
                            @foreach ($order->orderItems as $item)
                                <li>
                                    @if ($item->offer)
                                        <strong>{{ $item->offer->title }}</strong>
                                    @elseif ($item->medicine)
                                        <strong>{{ $item->medicine->name }}</strong>
                                    @else
                                        <span class="text-danger">Invalid</span>
                                    @endif
                                    — Quantity: {{ $item->quantity }}
                                </li>
                            @endforeach
                        </ul>
                    </td>

                    <td>
                        @php
                            $storehouse = null;
                            $firstItem = $order->orderItems->first();
                            if ($firstItem?->offer?->medicine?->storehouse) {
                                $storehouse = $firstItem->offer->medicine->storehouse->name;
                            } elseif ($firstItem?->medicine?->storehouse) {
                                $storehouse = $firstItem->medicine->storehouse->name;
                            }
                        @endphp
                        {{ $storehouse ?? 'N/A' }}
                    </td>

                    <td>{{ ucfirst($order->status) }}</td>

                    <td>
                        @if(!$order->review && $order->status != 'pending')
                            <button class="btn btn-sm btn-outline-primary review-order" data-order-id="{{ $order->id }}">Review</button>
                        @elseif($order->review)
                            <span class="text-success fw-bold">{{ $order->review->rating }}/5</span><br />
                            <small>{{ $order->review->comment }}</small>
                        @else
                            <span class="text-muted">No Review</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No orders found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

        <div class="mt-3">
            {{ $orders->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <!-- Modal -->
    <div id="ReviewModal" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
        <div class="modal-content">
            <h4>Review Order</h4>
            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf
                <input type="hidden" name="order_id" id="order_id" />
                <div class="mb-3">
                    <label for="rating" class="form-label">Rating</label>
                    <select name="rating" id="rating" class="form-select" required>
                        <option value="5">Excellent</option>
                        <option value="4">Very Good</option>
                        <option value="3">Good</option>
                        <option value="2">Poor</option>
                        <option value="1">Bad</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="comment" class="form-label">Comment</label>
                    <textarea name="comment" id="comment" rows="3" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Submit Review</button>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('ReviewModal');document.querySelectorAll('.review-order').forEach(button => {
                button.addEventListener('click', function () {
                    document.getElementById('order_id').value = this.getAttribute('data-order-id');
                    modal.style.display = 'flex';
                });
            });

            window.addEventListener('click', function (event) {
                if (event.target === modal) modal.style.display = 'none';
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
@include('website.layouts.websiteFooter')