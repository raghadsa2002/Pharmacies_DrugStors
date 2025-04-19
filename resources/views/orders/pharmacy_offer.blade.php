
@include('website.layouts.websiteHeader')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Available Offers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color:rgb(255, 255, 255);
            padding: 30px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            transition: transform 0.2s ease-in-out;
            border: none;
            border-radius: 15px;
            color: #333;
            height: 100%;
        }

        .card:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        .card-color-1 { background-color:rgb(248, 243, 243); }
        .card-color-2 { background-color:rgb(255, 255, 255); }
        .card-color-3 { background-color: #f3fcf5; }

        .card-title {
            font-weight: bold;
            color: #2c3e50;
            text-align: center;
            font-size: 1.3rem;
        }

        .btn-primary {
            background-color: #5c7cfa;
            border: none;
        }

        .btn-primary:hover {
            background-color: #4c6ef5;
        }

        .offer-note {
            font-size: 0.9rem;
            font-style: italic;
            color: #888;
        }

        .price-line {
            text-decoration: line-through;
            color: #888;
        }

        .price-after {
            color: #27ae60;
            font-weight: bold;
        }

        .timer {
            font-size: 1.1rem;
            font-weight: bold;
            color: #e74c3c;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="mb-4 text-center">Available Offers</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
    @foreach ($offers as $offer)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow" style="background-color:rgb(244, 243, 243); border-radius: 15px; border: 2px solid #00bcd4;">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h5 class="card-title text-center" style="font-weight: bold; font-size: 1.4rem; color: #00796b;">
                        {{ $offer->title }}
                    </h5>

                    <!-- Medicine names -->
                    <p class="card-text text-center" style="font-size: 1rem; font-weight: bold; color: #00796b;">
                        {{ $offer->medicine1->name ?? '---' }} + {{ $offer->medicine2->name ?? '---' }}
                    </p>

                    <!-- Discount -->
                    <p class="card-text text-center"><strong>Discount:</strong> {{ $offer->discount_price }}%</p>

                    <!-- Old Price with Strike and New Price -->
                    @php
                        $medicine1_price = $offer->medicine1->price ?? 0;
                        $medicine2_price = $offer->medicine2->price ?? 0;
                        $total_price = $medicine1_price + $medicine2_price;
                        $discounted_price = $total_price - ($total_price * $offer->discount_price / 100);
                    @endphp

                    <p class="card-text text-center">
                        <strong>Original Price:</strong>
                        <span style="text-decoration: line-through; color: #888;">${{ number_format($total_price, 2) }}</span>
                    </p>

                    <p class="card-text text-center">
                        <strong>Discounted Price:</strong>
                        <span style="color: #27ae60; font-weight: bold;">${{ number_format($discounted_price, 2) }}</span>
                    </p>

                    <!-- Timer -->
                    <p class="card-text text-center" id="timer-{{ $offer->id }}" style="font-weight: bold; font-size: 1.1rem; color: #d32f2f;">
                        Loading...
                    </p>

                    <!-- Order Form -->
                    @php
    $isExpired = \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($offer->end_date));
@endphp

@if (!$isExpired)
    <!-- Order Form -->
    <form method="POST" action="{{ route('offers.order', $offer->id) }}">
        @csrf
        <div class="mb-2">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" name="quantity" class="form-control" min="1" required>
        </div>
        <button type="submit" class="btn btn-info text-white w-100">Order Offer</button>
    </form>
@else
    <p class="text-center text-muted mt-2" style="font-style: italic;">This offer has expired and cannot be ordered.</p>
@endif
                </div>
            </div>
        </div>

        <script>
            function startTimer(endDate, elementId) {
                const countDownDate = new Date(endDate).getTime();

                const x = setInterval(function () {
                    const now = new Date().getTime();
                    const distance = countDownDate - now;

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    const timerElement = document.getElementById(elementId);

                    if (distance < 0) {
                        clearInterval(x);
                        timerElement.innerHTML = "Offer expired";
                        timerElement.style.color = "gray";
                    } else {
                        timerElement.innerHTML = days + "d " + hours + "h "
                            + minutes + "m " + seconds + "s ";

                        if (distance < 3600000) {
                            timerElement.style.color = "red";
                        }
                    }
                }, 1000);
            }startTimer("{{ $offer->end_date }}", "timer-{{ $offer->id }}");
        </script>
    @endforeach
</div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function updateTimers() {
        const timers = document.querySelectorAll('.timer');
        timers.forEach(timer => {
            const endDateStr = timer.dataset.end;
            const endDate = new Date(endDateStr);
            const now = new Date();
            const diff = endDate - now;

            if (diff <= 0) {
                timer.innerText = "Expired";
                timer.style.color = '#888';
                return;
            }

            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
            const minutes = Math.floor((diff / 1000 / 60) % 60);
            const seconds = Math.floor((diff / 1000) % 60);

            timer.innerText = ${days}d ${hours}h ${minutes}m ${seconds}s left;
        });
    }

    updateTimers();
    setInterval(updateTimers, 1000);
</script>

</body>
</html>
@include('website.layouts.websiteFooter')