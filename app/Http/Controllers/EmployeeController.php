<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Storehouse;
use Illuminate\Http\Request;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::where('storehouse_id',Auth::guard('store_houses')->user()->id)->with('storehouse')->get();
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
            'password' => 'required',
        ]);
        $employee = new Employee();
        $employee->storehouse_id = Auth::guard('store_houses')->user()->id;
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->address = $request->address;
        $employee->password = $request->password;
       
        $employee->save();

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