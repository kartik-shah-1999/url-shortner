<?php

namespace App\Http\Controllers;

use App\Models\UserRole;
use App\RoleEnum;
use App\Models\User;
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

    public function roleView(){
        $filterUsers = null;
        $loggedInUser = auth()->user()->id;
        if((int)$loggedInUser === RoleEnum::SUPERADMIN){
            $filterUsers = RoleEnum::ADMIN;
        }else if((int)$loggedInUser === RoleEnum::ADMIN){
            $filterUsers = RoleEnum::MEMBER;
        }
        $users = User::with('roles')->where('id','!=',$loggedInUser)->get();
        return view('role')->with('users',$users);
    }

    public function inviteView(){
        $filterUsers = null;
        $loggedInUser = auth()->user()->id;
        if((int)$loggedInUser === RoleEnum::SUPERADMIN){
            $filterUsers = RoleEnum::ADMIN;
        }else if((int)$loggedInUser === RoleEnum::ADMIN){
            $filterUsers = RoleEnum::MEMBER;
        }
        $users = User::with('roles')->where('id','!=',$loggedInUser)->get();
        return view('invite')->with('users',$users);
    }

    public function updateRole(Request $request, $user){
        UserRole::where('user_id', $user)
                ->update([
                    'user_role' => $request->input('role_selected')
                ]);
        return response()->json(['redirectUrl' => '/dashboard/role']);
    }
}
