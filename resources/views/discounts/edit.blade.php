<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Discount</title>

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
                                    <h4 class="card-title">Edit Discount</h4>

                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif

                                    <form method="POST" action="{{ route('discounts.update', $discount->id) }}">
                                        @csrf
                                        @method('PUT')

                                        <div class="form-group">
                                            <label for="medicine_id">Medicine</label>
                                            <select name="medicine_id" id="medicine_id" class="form-control" required>
                                                @foreach($medicines as $medicine)
                                                    <option value="{{ $medicine->id }}" {{ $medicine->id == $discount->medicine_id ? 'selected' : '' }}>
                                                        {{ $medicine->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="discounted_price">Discounted Price</label>
                                            <input type="number" name="discounted_price" id="discounted_price" class="form-control" value="{{ $discount->discounted_price }}" required>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Update Discount</button>
                                    </form>
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