<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Create Offer</title>

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
                    <h4 class="card-title mb-4">Create Offer</h4>

                    {{-- Display validation errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('offers.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="title">Offer Title</label>
                            <input type="text" name="title" id="title" class="form-control" required value="{{ old('title') }}">
                        </div>

                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" required value="{{ old('start_date') }}">
                        </div>

                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" required value="{{ old('end_date') }}">
                        </div>

                        <h5 class="mt-4">Offer Items (Medicines)</h5>
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
                                <tr>
                                    <td>
                                        <select name="items[0][medicine_id]" class="form-control" required>
                                            @foreach($medicines as $medicine)
                                                <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select name="items[0][type]" class="form-control type-select" required>
                                            <option value="discount">Discount</option>
                                            <option value="free">Free</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="items[0][value]" class="form-control value-field" min="0" placeholder="Value" required>
                                    </td>
                                    <td><input type="number" name="items[0][required_quantity]" class="form-control" min="1" placeholder="Qty" required>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm remove-row-btn">Remove</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <button type="submit" class="btn btn-primary">Create Offer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

  @include('layouts.Admin.Footer')
   @include('layouts.Admin.LinkJS')

    <script>
        let rowIndex = 1;

        function toggleValueField(row) {
            const typeSelect = row.querySelector('.type-select');
            const valueField = row.querySelector('.value-field');

            if (typeSelect && valueField) {
                if (typeSelect.value === 'free') {
                    valueField.style.display = 'none';
                    valueField.disabled = true;
                } else {
                    valueField.style.display = '';
                    valueField.disabled = false;
                }
            }
        }

        document.getElementById('add-row-btn').addEventListener('click', function() {
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
                    <input type="number" name="items[${rowIndex}][required_quantity]" class="form-control" min="1" placeholder="Qty" required>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-row-btn">Remove</button>
                </td>
            `;

            tbody.appendChild(newRow);

            toggleValueField(newRow);

            const typeSelect = newRow.querySelector('.type-select');
            if (typeSelect) {
                typeSelect.addEventListener('change', () => toggleValueField(newRow));
            }

            newRow.querySelector('.remove-row-btn').addEventListener('click', function() {
                newRow.remove();
            });

            rowIndex++;
        });

        // Initial event listeners for existing row
        document.querySelectorAll('#offer-items-table tbody tr').forEach(row => {
            toggleValueField(row);

            const typeSelect = row.querySelector('.type-select');
            if (typeSelect) {
                typeSelect.addEventListener('change', () => toggleValueField(row));
            }

            const removeBtn = row.querySelector('.remove-row-btn');
            if (removeBtn) {
                removeBtn.addEventListener('click', function () {
                    row.remove();
                });
            }
        });
    </script>
</body>
</html>