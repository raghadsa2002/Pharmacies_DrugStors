<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Offer</title>

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
                    <h4 class="card-title mb-4">Edit Offer</h4>

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('offers.update', $offer->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="title">Offer Title</label>
                            <input type="text" name="title" id="title" class="form-control" required value="{{ old('title', $offer->title) }}">
                        </div>

                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" required value="{{ old('start_date', $offer->start_date->format('Y-m-d')) }}">
                        </div>

                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" required value="{{ old('end_date', $offer->end_date->format('Y-m-d')) }}">
                        </div>

                        <input type="hidden" name="deleted_items" id="deleted-items">

                        <h5 class="mt-4">Offer Items</h5>
                        <table class="table table-bordered" id="offer-items-table">
                            <thead>
                                <tr>
                                    <th>Medicine</th>
                                    <th>Type</th>
                                    <th>Value</th>
                                    <th>Required Quantity</th>
                                    <th style="width: 80px;">
                                        <button type="button" id="add-row-btn" class="btn btn-success btn-sm">Add</button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($offer->items as $index => $item)
                                    <tr>
                                        <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                                        <td>
                                            <select name="items[{{ $index }}][medicine_id]" class="form-control" required>
                                                @foreach($medicines as $medicine)
                                                    <option value="{{ $medicine->id }}" {{ $medicine->id == $item->medicine_id ? 'selected' : '' }}>{{ $medicine->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="items[{{ $index }}][type]" class="form-control type-select" required>
                                                <option value="discount" {{ $item->type == 'discount' ? 'selected' : '' }}>Discount</option>
                                                <option value="free" {{ $item->type == 'free' ? 'selected' : '' }}>Free</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="items[{{ $index }}][value]" class="form-control value-field" min="0" placeholder="Value" value="{{ $item->value }}" {{ $item->type == 'free' ? 'style=display:none;' : '' }} {{ $item->type == 'free' ? 'disabled' : '' }}>
                                        </td>
                                        <td>
                                            <input type="number" name="items[{{ $index }}][required_quantity]" class="form-control" min="1" value="{{ $item->required_quantity }}" required>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm remove-row-btn">Remove</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <button type="submit" class="btn btn-primary">Update Offer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

     @include('layouts.Admin.Footer')
   @include('layouts.Admin.LinkJS')

    <script>
      let rowIndex = {{ $offer->items->count() }};

function toggleValueField(row) {
    const typeSelect = row.querySelector('select[name*="[type]"]');
    const valueInput = row.querySelector('.value-field');

    if (typeSelect && valueInput) {
        if (typeSelect.value === 'free') {
            valueInput.style.display = 'none';
            valueInput.disabled = true;
            valueInput.value = ''; // نمسح القيمة عشان ما تبعت في الفورم
        } else {
            valueInput.style.display = '';
            valueInput.disabled = false;
        }
    }
}

function reindexRows() {
    const rows = document.querySelectorAll('#offer-items-table tbody tr');
    rows.forEach((row, index) => {
        const medicineSelect = row.querySelector('select[name*="[medicine_id]"]');
        const typeSelect = row.querySelector('select[name*="[type]"]');
        const valueInput = row.querySelector('input[name*="[value]"]');
        const qtyInput = row.querySelector('input[name*="[required_quantity]"]');
        const idInput = row.querySelector('input[name*="[id]"]');

        if (medicineSelect) medicineSelect.name = items[${index}][medicine_id];
        if (typeSelect) typeSelect.name = items[${index}][type];
        if (valueInput) valueInput.name = items[${index}][value];
        if (qtyInput) qtyInput.name = items[${index}][required_quantity];
        if (idInput) idInput.name = items[${index}][id];
    });
}

document.getElementById('add-row-btn').addEventListener('click', function () {
    const tbody = document.querySelector('#offer-items-table tbody');
    const newRow = document.createElement('tr');

    newRow.innerHTML = `
        <td>
            <select name="items[${rowIndex}][medicine_id]" class="form-control" required>
                @foreach($medicines as $medicine)
                    <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <select name="items[${rowIndex}][type]" class="form-control type-select" required>
                <option value="discount">Discount</option>
                <option value="free">Free</option>
            </select>
        </td>
        <td>
            <input type="number" name="items[${rowIndex}][value]" class="form-control value-field" min="0" placeholder="Value" required>
        </td>
        <td>
            <input type="number" name="items[${rowIndex}][required_quantity]" class="form-control" min="1" required>
        </td>
        <td>
            <button type="button" class="btn btn-danger btn-sm remove-row-btn">Remove</button>
        </td>
    `;

    tbody.appendChild(newRow);
    toggleValueField(newRow);

    newRow.querySelector('.type-select').addEventListener('change', () => toggleValueField(newRow));
    newRow.querySelector('.remove-row-btn').addEventListener('click', function () {
        newRow.remove();
        reindexRows();
    });

    rowIndex++;
    reindexRows();
});

document.querySelectorAll('#offer-items-table tbody tr').forEach(row => {
    toggleValueField(row);

    const typeSelect = row.querySelector('.type-select');
    if (typeSelect) {
        typeSelect.addEventListener('change', () => toggleValueField(row));
    }

    const removeBtn = row.querySelector('.remove-row-btn');
    if (removeBtn) {
        removeBtn.addEventListener('click', function () {
            const itemIdInput = row.querySelector('input[name*="[id]"]');
            const deletedInput = document.getElementById('deleted-items');
            if (itemIdInput) {
                const deletedIds = deletedInput.value ? deletedInput.value.split(',') : [];
                deletedIds.push(itemIdInput.value);
                deletedInput.value = deletedIds.join(',');
            }
            row.remove();
            reindexRows();
        });
    }
});
    </script>
</body>
</html>