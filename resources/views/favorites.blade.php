@include('website.layouts.websiteHeader')

<div class="container my-5">
  <h2 class="text-center">My Favorites</h2>
  <div class="row" id="favoritesList">
    <!-- يتم ملء المحتوى باستخدام JavaScript -->
  </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    // جلب المفضلات من localStorage
    const favorites = JSON.parse(localStorage.getItem('favorites')) || [];
    const favoritesList = document.getElementById('favoritesList');

    if (favorites.length === 0) {
        favoritesList.innerHTML = '<p class="text-center">No favorites yet!</p>';
    } else {
        favorites.forEach(product => {
            const productHTML = `
            <div class="col-sm-6 col-lg-4 text-center item mb-4">
                <img src="${product.image}" alt="${product.name}" style="width: 200px; height: auto;">
                <h3 class="text-dark">${product.name}</h3>
                <p class="price">$${product.price}</p>
                <button class="btn btn-danger remove-favorite" data-id="${product.id}">Remove</button>
            </div>
            `;
            favoritesList.innerHTML += productHTML;
        });

        // زر حذف من المفضلات
        document.querySelectorAll('.remove-favorite').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const updatedFavorites = favorites.filter(product => product.id !== id);
                localStorage.setItem('favorites', JSON.stringify(updatedFavorites));
                alert("Product removed from favorites!");
                location.reload(); // تحديث الصفحة
            });
        });
    }
});
</script>

@include('website.layouts.websiteFooter')