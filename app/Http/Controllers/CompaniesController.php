<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class CompaniesController extends Controller
{
    public function index(){
        $companies = Company::orderBy('id', 'DESC')->paginate(10);
        return response()->json($companies, 200);
    }

    public function show($id){
        $company = Company::find($id);
        return response()->json($company, 200);
    }

    public function create(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'nullable|email',
            'logo' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'website' => 'nullable'
        ]);
        $logo = null;
        if ($request->logo) {
            Storage::delete('app/public/images/companies/' . $company->logo);
            $filename = uniqid() . '.' . $request->file('logo')->extension();
            $request->logo->move(storage_path('app/public/images/companies'),  $filename);
            $logo = $filename;
        }
        $company = Company::create($request->all());
        $company->logo = $logo;
        $company->update();
        return $company;
    }

    public function update(Request $request){
        $company = Company::find($request->id);
        $request->validate([
            'name' => 'required',
            'email' => 'nullable|email',
            'logo' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'website' => 'nullable'
        ]);
        $logo = null;
        if ($request->logo) {
            $filename = uniqid() . '.' . $request->file('logo')->extension();
            $request->logo->move(storage_path('app/public/images/companies'),  $filename);
            $logo = $filename;
        }
        $company->update($request->all());
        $company->logo = $logo;
        $company->update();
        return $company;
    }

    public function delete($id){
        $company = Company::where('id', $id)->with('employees')->first();
        if ($company) {
            Storage::delete('app/public/images/companies/' . $company->logo);
            foreach ($company->employees as $employee) {
                $employee->delete();
            }
            $company->delete();
        }
    }

}
