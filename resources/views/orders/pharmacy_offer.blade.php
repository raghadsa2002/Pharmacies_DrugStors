@include('website.layouts.websiteHeader')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Available Offers</title>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #ffffff;
            padding: 30px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            border: none;
            border-radius: 15px;
            transition: transform 0.2s ease-in-out;
        }
        .card:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 20px rgba(25, 155, 133, 0.1);
        }
        .card-title {
            font-weight: bold;
            color: #00796b;
            text-align: center;
        }
        .offer-item {
            background-color: #f5f5f5;
            padding: 10px;
            margin-bottom: 8px;
            border-radius: 8px;
        }
        .timer {
            font-weight: bold;
            font-size: 1.1rem;
            color: #e74c3c;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Available Offers</h2>

    <div class="row">
        @foreach ($offers as $offer)
            <div class="col-md-4 mb-4">
                <div class="card shadow" style="background-color: #fafafa; border: 2px solid #00bcd4;">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <!-- عنوان العرض -->
                        <h5 id="offer-title-{{ $offer->id }}" class="card-title">{{ $offer->title }}</h5>
                        
                        <!-- سعر العرض (مخفي) -->
                        <p id="offer-price-{{ $offer->id }}" style="display:none;">{{ $offer->price }}</p>
                        
                        <p class="text-center text-muted">Storehouse: {{ $offer->storehouse->name }}</p>

                        <div class="d-flex flex-wrap gap-3"><div class="d-flex flex-wrap justify-content-start gap-3" style="row-gap: 20px;">
    @foreach ($offer->offer_items as $item)
        <div class="offer-item border rounded p-3" style="width: 280px; min-height: 220px;">
            <strong>{{ $item->medicine->name }}</strong><br>

            {{-- السعر الأصلي --}}
            <span class="text-muted" style="text-decoration: line-through;">
                Original Price: {{ number_format($item->medicine->price, 2) }} $
            </span><br>

            {{-- نوع العرض --}}
            Type:
            <span class="badge bg-{{ $item->type == 'discount' ? 'primary' : 'success' }}">
                {{ ucfirst($item->type) }}
            </span><br>

            Quantity Required: {{ $item->required_quantity }}<br>

            @if ($item->type === 'discount')
                @php
                    $discountedPrice = $item->medicine->price * (1 - $item->value / 100);
                @endphp

                <span class="text-info">Discount: {{ $item->value }}%</span><br>

                <span class="fw-bold text-success">
                    After Discount: {{ number_format($discountedPrice, 2) }} $
                </span>

               

            @elseif ($item->type === 'free')
             
            @endif
        </div>
    @endforeach

</div>
                        </div>

                        <!-- مؤقت انتهاء العرض -->
                        <p id="timer-{{ $offer->id }}" class="text-center timer">Loading...</p>

                        <!-- اختيار الكمية -->
                        

                        <!-- زر الإضافة -->
                  <form method="POST" action="{{ route('orders.offer', $offer->id) }}">
    @csrf
    <input type="hidden" name="offer_id" value="{{ $offer->id }}">
    <button type="submit" class="btn btn-success w-100">Order Now</button>
</form>
                    </div>
                </div>
            </div>

            <script>
                // مؤقت العرض
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
                            // Hide add to cart button and quantity input if expired
                            const cardBody = timerElement.closest('.card-body');
                            if (cardBody) {
                                const btn = cardBody.querySelector('button');
                                const qtyInput = cardBody.querySelector('input[type="number"]');
                                if (btn) btn.style.display = 'none';
                                if (qtyInput) qtyInput.style.display = 'none';
                            }
                        } else {
                            timerElement.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

                            if (distance < 3600000) {
                                timerElement.style.color = "red";
                            }
                        }
                    }, 1000);
                }

                startTimer("{{ $offer->end_date }}", "timer-{{ $offer->id }}");

                // إضافة العرض للسلة
             function addOfferToCart(offerId) {
    const quantityInput = document.getElementById('quantity-' + offerId);
    const quantity = parseInt(quantityInput.value);

    if (isNaN(quantity) || quantity < 1) {
        alert('Please enter a valid quantity');
        return;
    }

    const offerTitle = document.getElementById('offer-title-' + offerId).innerText.trim();
    const offerPriceText = document.getElementById('offer-price-' + offerId).innerText.trim();
    const offerPrice = parseFloat(offerPriceText);

    const cart = JSON.parse(localStorage.getItem('cart')) || [];

    const exists = cart.find(item => item.type === 'offer' && item.id === offerId);
    if (exists) {
        alert("This offer is already in your cart.");
        return;
    }

    const offerCard = document.getElementById('offer-title-' + offerId).closest('.card-body');
    const offerItems = offerCard.querySelectorAll('.offer-item');
    const offerDetails = [];

    for (const item of offerItems) {
        const name = item.querySelector('strong')?.innerText || '';
        const originalPriceText = item.querySelector('.text-muted')?.innerText || '';
        const originalPrice = parseFloat(originalPriceText.replace(/[^\d.]/g, ''));

        const typeText = item.querySelector('.badge')?.innerText.toLowerCase();
        const valueText = item.querySelector('.text-info, .text-success')?.innerText || '';
        const value = parseFloat(valueText.replace(/[^\d.]/g, ''));

        const quantityRequiredText = item.innerText.match(/Quantity Required: (\d+)/);
        const requiredQuantity = quantityRequiredText ? parseInt(quantityRequiredText[1]) : 1;

        // تحقق إن الكمية أقل من المطلوبة
      //  if (quantity < requiredQuantity) {
        //    alert(`To benefit from this offer on "${name}", you need to buy at least ${requiredQuantity} units.`);
        //    return;
       // }

        offerDetails.push({
            medicine_name: name,
            original_price: originalPrice,
            type: typeText,
            value: value,
            required_quantity: requiredQuantity
        });
    }

    cart.push({
        type: 'offer',
        id: offerId,
        name: offerTitle,
        price: offerPrice,
        quantity: quantity,
        items: offerDetails
    });

    localStorage.setItem('cart', JSON.stringify(cart));
    alert("Offer added to cart!");
    updateCartCount();
}


                function updateCartCount() {
                    const cart = JSON.parse(localStorage.getItem('cart')) || [];
                    const count = cart.length;
                    const cartCountElement = document.getElementById('cart-count');
                    if (cartCountElement) {
                        cartCountElement.innerText = count;
                    }
                }

                document.addEventListener('DOMContentLoaded', updateCartCount);
            </script>
        @endforeach
    </div>
</div>

</body>
</html>
@include('website.layouts.websiteFooter')