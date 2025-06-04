 
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


<div class="table-container">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Medicines & Quantities</th>
                    <th>Storehouse</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
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
                        <div class="dropdown">
                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#" class="dropdown-item review-order" data-order-id="{{ $order->id }}">Review Order</a></li>
                                <li><a href="#" class="dropdown-item create-ticket" data-order-id="{{ $order->id }}" data-storehouse-id="{{ $order->storehouse_id }}">Create Ticket</a>></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $orders->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- Review Modal -->
<div id="ReviewModal" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
    <div class="modal-content" style="max-width: 500px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; background: #fff;">
        <h4 id="modalMedicineName">Review Order</h4>
        <form action="{{ route('reviews.store') }}" method="POST" class="p-3 bg-light border rounded">
            @csrf
            <input type="hidden" name="order_id" id="order_id" value="">
            <div class="row mb-2">
                <div class="col-md-3">
                    <label for="rating">التقييم:</label>
                    <select name="rating" id="rating" class="form-select" required>
                        <option value="5">ممتاز</option>
                        <option value="4">جيد جداً</option>
                        <option value="3">جيد</option>
                        <option value="2">ضعيف</option>
                        <option value="1">سيء</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="comment">ملاحظات:</label>
                    <textarea name="comment" id="comment" class="form-control" placeholder="اكتب ملاحظتك هنا..."></textarea>


</div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">إرسال التقييم</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Create Ticket Modal -->
<div id="TicketModal" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
    <div class="modal-content" style="max-width: 500px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; background: #fff;">
        <h4>إنشاء تيكت</h4>
        <form action="{{ route('tickets.store') }}" method="POST">
            @csrf
            <input type="hidden" name="order_id" id="ticket_order_id">
            <input type="hidden" name="storehouse_id" id="ticket_storehouse_id">
            <div class="mb-3">
                <label for="message" class="form-label">ما هي المشكلة؟</label>
                <textarea name="message" id="ticket_message" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">إرسال</button>
        </form>
    </div>
</div>
<script>
    document.querySelectorAll('.create-ticket').forEach(button => {
    button.addEventListener('click', function () {
        const orderId = this.getAttribute('data-order-id');
        const storehouseId = this.getAttribute('data-storehouse-id');

        document.getElementById('ticket_order_id').value = orderId;
        document.getElementById('ticket_storehouse_id').value = storehouseId;

        document.getElementById('TicketModal').style.display = 'flex';
    });
});

window.addEventListener('click', function (event) {
    const ticketModal = document.getElementById('TicketModal');
    if (event.target === ticketModal) {
        ticketModal.style.display = 'none';
    }
});
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('ReviewModal');

        document.querySelectorAll('.review-order').forEach(button => {
            button.addEventListener('click', function () {
                const orderId = this.getAttribute('data-order-id');
                document.getElementById('order_id').value = orderId;
                modal.style.display = 'flex';
            });
        });

        window.addEventListener('click', function (event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  
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
