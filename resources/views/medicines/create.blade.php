<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Create Pharmacy</title>

    @include('layouts.Admin.LinkHeader')
    @include('layouts.Admin.LinkSideBar')
</head>

<body>
    <div class="container-scroller">
        <!-- partial:../../partials/_navbar.html -->

        @include('layouts.Admin.Header')
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:../../partials/_settings-panel.html -->

            @include('layouts.Admin.Setting')


            <!-- partial -->
            <!-- partial:../../partials/_sidebar.html -->

            @include('layouts.Admin.Sidebar')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">

                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Add New Medicine</h4>
                                    <form class="forms-sample" method="POST" action="{{ route('medicines.store') }}" enctype="multipart/form-data">
                                        @csrf

                                        <!-- اسم الدواء -->
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Medicine Name" required>
                                        </div>

                                        <!-- السعر -->
                                        <div class="form-group">
                                            <label for="price">Price</label>
                                            <input type="number" class="form-control" id="price" name="price" placeholder="Price" step="0.01" required>
                                        </div>

                                        <!-- الكمية في المخزون -->
                                        <div class="form-group">
                                            <label for="stock">Stock</label>
                                            <input type="number" class="form-control" id="stock" name="stock" placeholder="Stock Quantity" required>
                                        </div>

                                        <!-- الحالة -->
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="Available">Available</option>
                                                <option value="Unavailable">Unavailable</option>
                                            </select>
                                        </div>

                                        <!-- التصنيف -->
                                        <div class="form-group">
                                            <label for="category_id">Category</label>
                                            <select class="form-control" id="category_id" name="category_id" required>
                                                @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- الوصف -->
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter description"></textarea>
                                        </div>

                                        <!-- الشركة المصنعة -->
                                        <div class="form-group">
                                            <label for="manufacturer">Manufacturer</label>
                                            <input type="text" class="form-control" id="manufacturer" name="manufacturer" placeholder="Manufacturer Name">
                                        </div>

                                        <!-- الصورة -->
                                        <div class="form-group">
                                            <label for="image">Image</label>
                                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                        </div>

                                        <!-- زر الإرسال -->
                                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                        <a href="{{ route('medicines.index') }}" class="btn btn-light">Cancel</a>
                                    </form>
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
    
    <script>
        document.querySelector('.file-upload-browse').addEventListener('click', function() {
            document.querySelector('.file-upload-default').click(); // Trigger the file input click
        });

        document.querySelector('.file-upload-default').addEventListener('change', function() {
            let fileName = this.files[0].name; // Get the file name
            document.querySelector('.file-upload-info').value = fileName; // Display file name in the text input
        });
    </script>
</body>

</html>