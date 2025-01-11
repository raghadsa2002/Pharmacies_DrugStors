<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Storehouse;
use Illuminate\Http\Request;
use App\Http\Controllers\EmployeeController;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('storehouse')->get();
        return view('employees.index', compact('employees'));
    }


    public function create()
    {
        $storehouses = Storehouse::all();
        return view('employees.create', compact('storehouses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees',
            'phone' => 'required|string|max:15',
            'address' => 'nullable|string',
            'storehouse_id' => 'required|exists:store_houses,id',
            'password' => 'required',
        ]);

        Employee::create($validated);

        return redirect()->route('employees.index')->with('success', 'Employee added successfully');
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $storehouses = Storehouse::all();
        return view('employees.edit', compact('employee', 'storehouses'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $id,
            'phone' => 'required|string|max:15',
            'address' => 'nullable|string',
            'storehouse_id' => 'required|exists:store_houses,id',
        ]);

        $employee = Employee::findOrFail($id);
        $employee->update($validated);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully');
    }
}