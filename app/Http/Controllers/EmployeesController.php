<?php

namespace App\Http\Controllers;

use App\Company;
use App\Employee;
use Illuminate\Http\Request;


class EmployeesController extends Controller
{
    public function index(){
        $employees = Employee::orderBy('id', 'DESC')->with('company')->paginate(10);

        return response()->json($employees, 200);
    }

    public function show($id){
        $employee = Employee::find($id);
        return response()->json($employee, 200);
    }

    public function create(Request $request){
        $request->merge(['company_id' => Company::first()->id]); //hardcoded
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'company_id' => 'required',
        ]);
        $employee = Employee::create($request->all());
        return response()->json($employee, 200);
    }

    public function update(Request $request){
        $request->merge(['company_id' => Company::first()->id]); //hardcoded
        $company = Employee::find($request->id);
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'company_id' => 'required',
        ]);
        $company->update($request->all());
        return $company;
    }

    public function delete($id){
        $employee = Employee::find($id);
        if ($employee) {
            $employee->delete();
        }
    }
}
