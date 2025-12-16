<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(){
        $companies = Company::all();
        return view('company')->with('companies', $companies);
    }

    public function createCompany(Request $request){
        $request->validate([
            'name' => 'required | string | max:50'
        ]);

        $company = Company::create([
            'name' => $request->name,
            'created_by' => auth()->user()->id
        ]);

        if(!$company){
            return back()->with('error','Error processing the request');
        }
        return back()->with('success','Company created successfully');
    }
}
