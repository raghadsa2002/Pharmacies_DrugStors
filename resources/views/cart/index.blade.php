@include('website.layouts.websiteHeader')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f9f9f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 40px 20px;
        }

        .cart-item {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.2s ease-in-out;
        }

        .cart-item:hover {
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        }

        .item-name {
            font-weight: 600;
            font-size: 18px;
            color: #333;
        }

        .text-muted {
            color: #888 !important;
        }

        .btn-qty {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            font-size: 16px;
            padding: 0;
            line-height: 34px;
            background-color: #e4f3ff;
            border: none;
            color: #007bbf;
        }

        .btn-qty:hover {
            background-color: #d0ebff;
        }

        .quantity-box {
            width: 42px;
            text-align: center;
            border: none;
            font-size: 16px;
            color: #333;
            background-color: transparent;
        }

        .total-price {
            font-size: 20px;
            font-weight: 600;
            color: #555;
            text-align: right;
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }

        .btn-checkout {
            background-color:rgb(83, 141, 119);
            color: #fff;
            border: none;
            transition: 0.3s;
        }

        .btn-checkout:hover {
            background-color:rgb(67, 176, 174);
        }

        .btn-remove {
            background-color: #ffe6e6;
            color: #d44;
            font-size: 14px;
        }

        .btn-remove:hover {
            background-color:rgb(197, 123, 123);
        }

        h3 {
            text-align: center;
            color: #444;
            font-weight: 500;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

<div class="container">
    <h3> Your Cart</h3>

    <div id="cart-container"></div>

    <div class="total-price">
        Total: <span id="total-price">0</span> $
    </div>

    <button class="btn btn-checkout w-100 mt-4 py-2" onclick="checkoutCart()">Complete Order</button>
</div>

<script>
    function loadCart() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const container = document.getElementById('cart-container');
        const totalPriceElement = document.getElementById('total-price');
        container.innerHTML = '';
        let total = 0;

        if (cart.length === 0) {
            container.innerHTML = '<p class="text-center text-muted">Your cart is empty.</p>';
            totalPriceElement.innerText = '0';
            return;
        }

        cart.forEach((item, index) => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;

            const div = document.createElement('div');
            div.className = 'cart-item';
            div.innerHTML = `
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="item-name">${item.name}</div>
                        <div class="text-muted">Price: ${item.price} $</div>
                        <div class="text-muted">Subtotal: <span class="item-total">${itemTotal.toFixed(2)}</span> $</div>
                    </div>
                    <div class="d-flex align-items-center"><button class="btn btn-qty me-2" onclick="changeQuantity(${index}, -1)">−</button>
                        <input type="text" class="quantity-box" value="${item.quantity}" readonly>
                        <button class="btn btn-qty ms-2" onclick="changeQuantity(${index}, 1)">+</button>
                        <button class="btn btn-remove btn-sm ms-3" onclick="removeFromCart(${index})">Remove</button>
                    </div>
                </div>
            `;
            container.appendChild(div);
        });

        totalPriceElement.innerText = total.toFixed(2);
    }

    function changeQuantity(index, delta) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        cart[index].quantity += delta;
        if (cart[index].quantity < 1) cart[index].quantity = 1;
        localStorage.setItem('cart', JSON.stringify(cart));
        loadCart();
        updateCartCount();
    }

    function removeFromCart(index) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        cart.splice(index, 1);
        localStorage.setItem('cart', JSON.stringify(cart));
        loadCart();
        updateCartCount();
    }

    function updateCartCount() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const cartCountElement = document.getElementById('cart-count');
        if (cartCountElement) {
            cartCountElement.innerText = cart.length;
        }
    }

    function checkoutCart() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        if (cart.length === 0) {
            alert('Your cart is empty.');
            return;
        }

        fetch('{{ route("checkout") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ cart })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Order placed successfully!');
                localStorage.removeItem('cart');
                window.location.href = "{{ route('homePage') }}";
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(() => alert('Error submitting the order'));
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadCart();
        updateCartCount();
    });
</script>

</body>
</html>
@include('website.layouts.websiteFooter')