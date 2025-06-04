<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Order #{{ $order->id }} - Details</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal&display=swap');

        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f4f0fa; /* بنفسجي فاتح */
            margin: 0;
            padding: 30px;
            color: #3a2a56;
        }

        .container {
            background-color: #fff;
            max-width: 900px;
            margin: auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(58, 42, 86, 0.1);
            transition: box-shadow 0.3s ease;
        }
        .container:hover {
            box-shadow: 0 8px 30px rgba(58, 42, 86, 0.2);
        }

        h2 {
            margin-bottom: 25px;
            color: #512da8; /* بنفسجي غامق */
            font-size: 26px;
            font-weight: 700;
        }

        .order-meta {
            margin-bottom: 25px;
            font-size: 15px;
            line-height: 1.5;
        }

        .order-meta p {
            margin: 6px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            box-shadow: 0 0 10px rgba(81, 45, 168, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        thead {
            background-color: #673ab7; /* أرجواني غامق */
            color: white;
        }

        th, td {
            padding: 14px 18px;
            border-bottom: 1px solid #ddd;
            text-align: left;
            font-size: 15px;
            transition: background-color 0.3s;
        }

        tbody tr:hover {
            background-color: #ede7f6; /* ظل بنفسجي فاتح */
            cursor: default;
        }

        tfoot td {
            font-weight: 700;
            background-color: #f3e5f5;
            font-size: 16px;
        }

        .back-btn {
            margin-top: 30px;
            display: inline-block;
            background-color: #673ab7;
            color: white;
            padding: 12px 26px;
            text-decoration: none;
            border-radius: 10px;
            font-size: 15px;
            box-shadow: 0 3px 10px rgba(103, 58, 183, 0.4);
            transition: background-color 0.3s;
        }

        .back-btn:hover {
            background-color: #512da8;
            box-shadow: 0 6px 18px rgba(81, 45, 168, 0.6);
        }
    </style>
</head>
<body>

<div class="container" role="main" aria-label="Order details">
    <h2>Order #{{ $order->id }} - {{ $order->pharmacy->name }}</h2>

    <div class="order-meta" aria-live="polite">
        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
        <p><strong>Total Price:</strong> ${{ number_format($order->total_price, 2) }}</p>
        <p><strong>Order Date:</strong> {{ $order->created_at->format('Y-m-d') }}</p>
    </div>

    <table aria-describedby="order-items">
        <thead>
            <tr>
                <th scope="col">medicines</th>
                <th scope="col">Quantity</th>
                <th scope="col">Unit Price</th>
                <th scope="col">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderItems as $item)
                <tr>
                    <td>{{ $item->medicine->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align: right;">Total:</td>
                <td>${{ number_format($order->total_price, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <a href="{{ route('orders.index') }}" class="back-btn" role="button" aria-label="Back to orders list">← Back to Orders</a>
</div>

</body>
</html>