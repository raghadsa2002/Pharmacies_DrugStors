<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Medicines</title>

    @include('layouts.Admin.LinkHeader')
    @include('layouts.Admin.LinkSideBar') <!-- تضمين الشريط الجانبي -->

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
                                    <h4 class="card-title">Medicines List</h4>

                                    
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif

                                    <!-- جدول عرض البيانات -->
                                    <div class="table-responsive">
                                        <table class="table">
                                        <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Price</th>
        <th>Category</th>
        <th>Stock</th>
        <th>Status</th>
        <th>Description</th> 
        <th>Manufacturer</th> 
        <th>Image</th> 
        <th>Created At</th>
        <th>Updated At</th>
        <th>Actions</th>
    </tr>
</thead>
<tbody>
    @foreach ($medicines as $medicine)
    <tr>
        <td>{{ $medicine->id }}</td>
        <td>{{ $medicine->name }}</td>
        <td>{{ $medicine->price }}</td>
        <td>{{ $medicine->category->name }}</td>
        <td>{{ $medicine->stock }}</td>
        <td>{{ $medicine->status }}</td>
        <td>{{ $medicine->description }}</td> <!-- عرض الوصف -->
        <td>{{ $medicine->manufacturer }}</td> <!-- عرض الشركة المصنعة -->
        <td>
            @if($medicine->image)
                <img src="{{ asset('images/medicines/' . $medicine->image) }}" alt="{{ $medicine->name }}" style="width: 50px; height: 50px;"> <!-- عرض الصورة -->
            @else
                No Image
            @endif
        </td>
        <td>{{ $medicine->created_at }}</td>
        <td>{{ $medicine->updated_at }}</td>
        <td>
            <a href="{{ route('medicines.edit', $medicine->id) }}" class="btn btn-warning btn-sm">Edit</a>
            <form action="{{ route('medicines.destroy', $medicine->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm delete-button">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</tbody>
                                        </table>
                                    </div>
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