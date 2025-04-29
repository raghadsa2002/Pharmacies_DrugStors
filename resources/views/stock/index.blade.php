<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Stock Management</title>

    @include('layouts.Admin.LinkHeader')
    @include('layouts.Admin.LinkSideBar')
</head>
<body>
<div class="container-scroller">
    @include('layouts.Admin.Header')

    <div class="container-fluid page-body-wrapper">
        @include('layouts.Admin.Sidebar')

        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Stock Management</h4>

                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @elseif(session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Medicine Name</th>
                                                <th>Current Stock</th>
                                                <th>Update Stock</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($medicines as $medicine)
                                            <tr>
                                                <td>{{ $medicine->id }}</td>
                                                <td>{{ $medicine->name }}</td>
                                                <td>{{ $medicine->stock }}</td>
                                                <td>
                                                    <form action="{{ route('stock.update', $medicine->id) }}" method="POST" class="d-flex">
                                                        @csrf
                                                        @method('PUT')
                                                        <select name="type" class="form-control mr-2" required>
                                                            <option value="">Select</option>
                                                            <option value="increase">Increase</option>
                                                            <option value="decrease">Decrease</option>
                                                        </select>
                                                        <input type="number" name="quantity" class="form-control mr-2" min="1" required>
                                                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
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

            @include('layouts.Admin.Footer')
        </div>
    </div>
</div>

@include('layouts.Admin.LinkJS')
</body>
</html>