{{-- resources/views/offers/index.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Offers List</title>

       @include('layouts.Admin.LinkHeader')
    @include('layouts.Admin.LinkSideBar')

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />
</head>
<body>
    <div class="container-scroller">
        @include('layouts.Admin.Header')

        <div class="container-fluid page-body-wrapper">
            @include('layouts.Admin.Sidebar')

            <div class="main-panel">
                <div class="content-wrapper">
                    <h4 class="card-title mb-4">Offers List</h4>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                   

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Items Count</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($offers as $offer)
                            <tr>
                                <td>{{ $offer->id }}</td>
                                <td>{{ $offer->title }}</td>
                                <td>{{ $offer->start_date->format('Y-m-d') }}</td>
                                <td>{{ $offer->end_date->format('Y-m-d') }}</td>
                                <td>{{ $offer->items->count() }}</td>
                                <td>
                                    <a href="{{ route('offers.edit', $offer->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    
                                    <form action="{{ route('offers.destroy', $offer->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this offer?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No offers found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    <div class="mt-3">
                        {{ $offers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

  @include('layouts.Admin.Footer')
   @include('layouts.Admin.LinkJS')
</body>
</html>