<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Pharmaceutical Companies Archive Table</title>

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

         <!-- @include('layouts.Admin.Setting') -->

            <!-- partial:../../partials/_sidebar.html -->

            @include('layouts.Admin.Sidebar')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Pharmaceutical Companies Archive Table</h4>

                                    {{-- message section --}}
                                    @if (session('success_message'))
                                        <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show"
                                            role="alert">
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            {{ session('success_message') }}
                                        </div>
                                    @endif
                                    @if (session('error_message'))
                                        <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show"
                                            role="alert">
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            {{ session('error_message') }}
                                        </div>
                                    @endif
                                    {{-- end message section --}}

                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Status</th>
                                                    <th>Phone</th>
                                                    <th>City</th>
                                                    <th>Address</th>
                                                    <th>Created By</th>
                                                    <th>Created Date</th>
                                                    <th>Last Updated Date</th>
                                                    <th>Deleted Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pharmaceuticalCompanies as $pharmaceuticalCompany)
                                                    <tr>
                                                        <td>{{ $pharmaceuticalCompany->name }}</td>
                                                        <td>
                                                            <label
                                                                class="badge {{ $pharmaceuticalCompany->status == 1 ? 'badge-success' : 'badge-danger' }}">
                                                                {{ $pharmaceuticalCompany->status == 1 ? 'Active' : 'Not Active' }}
                                                            </label>
                                                        </td>
                                                        <td>{{ $pharmaceuticalCompany->phone }}</td>
                                                        <td>{{ $pharmaceuticalCompany->city }}</td>
                                                        <td>{{ $pharmaceuticalCompany->address }}</td>
                                                        <td>{{ $pharmaceuticalCompany->admin->name }}</td>
                                                        <td>{{ $pharmaceuticalCompany->created_at }}</td>
                                                        <td>{{ $pharmaceuticalCompany->updated_at }}</td>
                                                        <td>{{ $pharmaceuticalCompany->deleted_at }}</td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-secondary dropdown-toggle"
                                                                    type="button" id="dropdownMenuButton"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                    Action
                                                                </button>
                                                                <div class="dropdown-menu"
                                                                    aria-labelledby="dropdownMenuButton">
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('admin.pharmaceuticalCompanies.restore', $pharmaceuticalCompany->id) }}">Restore</a>
                                                                    <form
                                                                        action="{{ route('admin.pharmaceuticalCompanies.force.delete', $pharmaceuticalCompany->id) }}"
                                                                        method="POST" class="delete-form">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button class="dropdown-item delete-button"
                                                                            type="submit">
                                                                            Force Delete
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
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

                @include('layouts.Admin.Footer')
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>

    @include('layouts.Admin.LinkJS')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent form submission

                const form = this.closest('.delete-form');

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
