@include('website.layouts.websiteHeader')

<style>
    .quantity-btn {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: none;
        color: white;
        color: #51eaea;
        

        font-weight: bold;
        line-height: 1;
    }

    .cart-icon-btn {
        background: none;
        border: none;
        color: #51eaea;
        font-size: 1.8rem;
        cursor: pointer;
        transition: transform 0.2s ease-in-out;
    }

    .cart-icon-btn:hover {
        transform: scale(1.1);
    }
</style>

<div class="site-section">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2>Products</h2>
            </div>
        </div>

        <!-- الفلاتر -->
        <form method="GET" action="{{ route('medicines.products') }}">
            <div class="d-flex justify-content-center gap-3 mb-4 flex-wrap">
                <!-- الفلاتر مثل ما كانت -->
                <select name="company_id" class="form-control" style="min-width: 220px;">
                    <option value="">-- Select Company --</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>

                <select name="category_id" class="form-control" style="min-width: 220px;">
                    <option value="">-- Select Category --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <select name="storehouse_id" class="form-control" style="min-width: 220px;">
                    <option value="">-- Select Storehouse --</option>
                    @foreach ($storehouses as $storehouse)
                        <option value="{{ $storehouse->id }}" {{ request('storehouse_id') == $storehouse->id ? 'selected' : '' }}>
                            {{ $storehouse->name }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-primary px-4">Search</button>
            </div>
        </form>

        <!-- قائمة الأدوية -->
       @if(isset($medicines) && $medicines->count() > 0)
<div class="row g-4">
    @foreach ($medicines as $medicine)
        <div class="col-sm-6 col-lg-4 text-center item mb-4">
            <span class="tag d-block mb-2">{{ $medicine->name }}</span>

            <img src="{{ asset('DashboardAssets/images/' . $medicine->image) }}" 
                 alt="{{ $medicine->name }}" 
                 class="img-fluid rounded" 
                 style="width: 200px; height: 200px; object-fit: cover;">

            <h3 class="text-dark mt-2">{{ $medicine->name }}</h3>

            <p class="mb-1">Company: {{ $medicine->company?->name ?? 'N/A' }}</p>
            <p class="mb-1">Category: {{ $medicine->category?->name ?? 'N/A' }}</p>
            <p class="mb-1">Storehouse: {{ $medicine->storehouse?->name ?? 'N/A' }}</p>

            @if($medicine->discount)
                <p class="text-muted mb-0"><del>${{ number_format($medicine->price, 2) }}</del></p>
                <p class="text-danger mb-2">${{ number_format($medicine->discount->discounted_price, 2) }}</p>
            @else
                <p style="visibility: hidden;"><del>--</del></p>
                <p class="mb-2">${{ number_format($medicine->price, 2) }}</p>
            @endif

             <span 
  class="favorite-icon" 
  data-id="{{ $medicine->id }}" 
  data-name="{{ $medicine->name }}" 
  data-image="{{ asset('DashboardAssets/images/' . $medicine->image) }}" 
  data-price="{{ $medicine->price }}" 
  style="cursor: pointer; color: gray; font-size: 24px;">
  <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12.7692 6.70483C9.53846 2.01902 4 3.90245 4 8.68256C4 13.4627 13.2308 20 13.2308 20C13.2308 20 22 13.2003 22 8.68256C22 4.16479 16.9231 2.01903 13.6923 6.70483L13.2308 7.0791L12.7692 6.70483Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
</span>

            <div class="d-flex justify-content-center align-items-center gap-2 mb-2">
                <button class="quantity-btn qty-decrease" data-id="{{ $medicine->id }}">-</button>
                <input type="number" id="quantity-{{ $medicine->id }}" value="1" min="1" style="width: 50px; text-align: center;">
                <button class="quantity-btn qty-increase" data-id="{{ $medicine->id }}">+</button>
            </div>

            <button class="cart-icon-btn add-to-cart-btn" 
                    data-id="{{ $medicine->id }}" 
                    data-name="{{ $medicine->name }}" 
                    data-price="{{ $medicine->discount ? $medicine->discount->discounted_price : $medicine->price }}">
                <i class="fa fa-shopping-cart"></i>
            </button>
        </div>

        
    @endforeach
</div>
@else
    <p class="text-center mt-5">No medicines match your search criteria.</p>
@endif


<script>
document.addEventListener('DOMContentLoaded', () => {
    // +/-
    document.querySelectorAll('.qty-increase').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.dataset.id;
            const input = document.getElementById(`quantity-${id}`);
            input.value = parseInt(input.value) + 1;
        });
    });

    document.querySelectorAll('.qty-decrease').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.dataset.id;
            const input = document.getElementById(`quantity-${id}`);
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        });
    });

    // إضافة للسلة
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.dataset.id;
            const name = button.dataset.name;
            const price = parseFloat(button.dataset.price);
            const qty = parseInt(document.getElementById(`quantity-${id}`).value);

            let cart = JSON.parse(localStorage.getItem('cart')) || [];

            const existingIndex = cart.findIndex(item => item.id == id && item.type === 'normal');

            if (existingIndex !== -1) {
                cart[existingIndex].quantity += qty;
            } else {
                cart.push({ id, name, price, quantity: qty, type: 'normal' });
            }

            localStorage.setItem('cart', JSON.stringify(cart));
            alert('Added to cart!');
            updateCartCount();
        });
    });

    function updateCartCount() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const countElem = document.getElementById('cart-count');
        if (countElem) {
            const totalQuantity = cart.reduce((sum, item) => sum + item.quantity, 0);
            countElem.textContent = totalQuantity;
        }
    }

    updateCartCount();
    // المفضلة
    let favorites = JSON.parse(localStorage.getItem('favorites')) || [];

    document.querySelectorAll('.favorite-icon').forEach(icon => {
        const id = icon.getAttribute('data-id');
        const isFavorite = favorites.some(fav => fav.id === id);
        if (isFavorite) {
            icon.style.color = 'red';
        }

        icon.addEventListener('click', function () {
            const product = {
                id: this.getAttribute('data-id'),
                name: this.getAttribute('data-name'),
                image: this.getAttribute('data-image'),
                price: this.getAttribute('data-price')
            };

            const isFavorite = favorites.some(fav => fav.id === product.id);
            if (!isFavorite) {
                favorites.push(product);
                localStorage.setItem('favorites', JSON.stringify(favorites));
                this.style.color = 'red'; // تغيير اللون إلى الأحمر
                alert(product.name + " has been added to your favorites!");
            } else {
                favorites = favorites.filter(fav => fav.id !== product.id);
                localStorage.setItem('favorites', JSON.stringify(favorites));
                this.style.color = 'gray'; // تغيير اللون إلى الرمادي
                alert(product.name + " has been removed from your favorites!");
            }
        });
    });
});




</script>