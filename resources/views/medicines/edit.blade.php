<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Medicine</title>

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
                                    <h4 class="card-title">Edit Medicine</h4>
                                    <form class="forms-sample" method="POST" action="{{ route('medicines.update', $medicine->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $medicine->name) }}" placeholder="Medicine Name" required>
                                        </div>

                                        
                                        <div class="form-group">
                                            <label for="price">Price</label>
                                            <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $medicine->price) }}" step="0.01" placeholder="Price" required>
                                        </div>

                                       
                                        <div class="form-group">
                                            <label for="stock">Stock</label>
                                            <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $medicine->stock) }}" placeholder="Stock Quantity" required>
                                        </div>

                                        
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="Available" {{ old('status', $medicine->status) == 'Available' ? 'selected' : '' }}>Available</option>
                                                <option value="Unavailable" {{ old('status', $medicine->status) == 'Unavailable' ? 'selected' : '' }}>Unavailable</option>
                                            </select>
                                        </div>

                                       
                                        <div class="form-group">
                                            <label for="category_id">Category</label>
                                            <select class="form-control" id="category_id" name="category_id" required>
                                                @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', $medicine->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter description">{{ old('description', $medicine->description) }}</textarea>
                                        </div>

                                        


                                       
<div class="form-group">
    <label for="company_id">Pharmaceutical Company</label>
    <select class="form-control" id="company_id" name="company_id" required>
        @foreach ($companies as $company)
            <option value="{{ $company->id }}" 
                {{ $medicine->company_id == $company->id ? 'selected' : '' }}>
                {{ $company->name }}
            </option>
        @endforeach
    </select>
</div>

                                        
                                        <div class="form-group">
                                            <label for="image">Image</label>
                                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                            @if ($medicine->image)
                                                <img src="{{ asset('storage/images/' . $medicine->image) }}" width="100" alt="Medicine Image">
                                            @endif
                                        </div>

                                        
                                        <button type="submit" class="btn btn-primary mr-2">Update</button>
                                        <a href="{{ route('medicines.index') }}" class="btn btn-light">Cancel</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>