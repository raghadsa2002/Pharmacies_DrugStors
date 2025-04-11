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
        // التحقق من المستودع الذي سجل الدخول
        $storehouse = Auth::guard('store_houses')->user();
    
        // جلب الموظفين المرتبطين فقط بهذا المستودع
        $employees = Employee::where('storehouse_id', $storehouse->id)->with('storehouse')->get();
    
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
        'password' => 'required|min:6',
    ]);

    // جلب المستودع الخاص بالمستخدم الحالي وإضافته تلقائياً
    $validated['storehouse_id'] = Auth::guard('store_houses')->user()->id;
    $validated['password'] = bcrypt($request->password); 

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