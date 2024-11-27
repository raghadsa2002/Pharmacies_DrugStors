<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Category</title>

    @include('layouts.Admin.LinkHeader')  <!-- تضمين روابط CSS الخاصة بالثيم -->
    @include('layouts.Admin.LinkSideBar')  <!-- تضمين الشريط الجانبي -->

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body>
    <div class="container-scroller">
        @include('layouts.Admin.Header')  <!-- هيدر الصفحة -->

        <div class="container-fluid page-body-wrapper">
            @include('layouts.Admin.Setting')  <!-- إعدادات الشريط الجانبي -->
            @include('layouts.Admin.Sidebar')  <!-- الشريط الجانبي نفسه -->

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Edit Category</h4>
                                    <p class="card-description"> Update category information </p>

                                    <!-- التحقق من الأخطاء -->
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif

                                    <!-- فورم التعديل -->
                                    <form method="POST" action="{{ route('categories.update', $category->id) }}">
                                        @csrf
                                        @method('PUT')

                                        <div class="form-group">
                                            <label for="name">Category Name</label>
                                            <input type="text" class="form-control" id="name" name="name" 
                                                value="{{ old('name', $category->name) }}" placeholder="Enter category name">
                                        </div>

                                        <button type="submit" class="btn btn-primary mr-2">Save</button>
                                        <a href="{{ route('categories.index') }}" class="btn btn-light">Cancel</a>
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

    @include('layouts.Admin.LinkJS')  <!-- تضمين روابط JavaScript الخاصة بالثيم -->

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent form submission

                const form = this.closest('form'); // Find the closest form for delete

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
                        form.submit(); // Submit form if confirmed
                    }
                });
            });
        });
    </script>
</body>

</html>