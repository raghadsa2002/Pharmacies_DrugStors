<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Employee</title>

    @include('layouts.Admin.LinkHeader')  
    @include('layouts.Admin.LinkSideBar')  

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body>
    <div class="container-scroller">
        @include('layouts.Admin.Header')  

        <div class="container-fluid page-body-wrapper">
         <!-- @include('layouts.Admin.Setting') -->  
            @include('layouts.Admin.Sidebar')  

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Edit Employee</h4>
                                    <p class="card-description"> Update employee information </p>

                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif

                                    <form method="POST" action="{{ route('employees.update', $employee->id) }}">
                                        @csrf
                                        @method('PUT')

                                        <!-- Name -->
                                        <div class="form-group">
                                            <label for="name">Employee Name</label>
                                            <input type="text" class="form-control" id="name" name="name" 
                                                value="{{ old('name', $employee->name) }}" placeholder="Enter employee name">
                                        </div>

                                        <!-- Email -->
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" 
                                                value="{{ old('email', $employee->email) }}" placeholder="Enter employee email">
                                        </div>

                                        <!-- Phone -->
                                        <div class="form-group">
                                            <label for="phone">Phone</label>
                                            <input type="text" class="form-control" id="phone" name="phone" 
                                                value="{{ old('phone', $employee->phone) }}" placeholder="Enter phone number">
                                        </div>

                                        <!-- Address -->
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <input type="text" class="form-control" id="address" name="address" 
                                                value="{{ old('address', $employee->address) }}" placeholder="Enter address">
                                        </div>

                                        <!-- Storehouse -->
                                        <div class="form-group">
                                            <label for="storehouse">Storehouse</label>
                                            <select class="form-control" id="storehouse" name="storehouse_id">
                                                <option value="" disabled>Select a storehouse</option>
                                                @foreach($storehouses as $storehouse)
                                                    <option value="{{ $storehouse->id }}" 
                                                        {{ old('storehouse_id', $employee->storehouse_id) == $storehouse->id ? 'selected' : '' }}>
                                                        {{ $storehouse->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <button type="submit" class="btn btn-primary mr-2">Save</button>
                                        <a href="{{ route('employees.index') }}" class="btn btn-light">Cancel</a>
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
</body>

</html>