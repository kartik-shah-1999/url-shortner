<?php

namespace App\Http\Controllers;

use App\Models\UserCompany;
use App\Models\UserRole;
use App\RoleEnum;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    protected $companies, $loggedInUserRole;

    public function __construct(){
        $this->companies = Company::all();
        $this->loggedInUserRole = auth()->user()->roles[0]->pivot->user_role;
    }
    public function index(){
        return view('company')->with('companies', $this->companies);
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
        if($this->loggedInUserRole === RoleEnum::SUPERADMIN){
            $filterUsers = RoleEnum::ADMIN;
        }else if($this->loggedInUserRole === RoleEnum::ADMIN){
            $filterUsers = RoleEnum::MEMBER;
        }
        // return 'logged in user role: '.$this->loggedInUserRole.' filter user id : '.$filterUsers;
        $users = User::with('roles')
                ->where('id','!=',auth()->user()->id)
                ->get();
        return view('invite')
               ->with('users',$users)
               ->with('companies', $this->companies);
    }

    public function inviteUser(Request $request, $user){
        $request->validate([
            'company_selected' => ['required']
        ]);
        UserCompany::updateOrCreate([
            'user_id'    => $user,
            'company_id' => $request->input('company_selected'),
            'assignee' => auth()->user()->id
        ]);
        return response()->json(['redirectUrl' => '/dashboard/invite']);
    }

    public function updateRole(Request $request, $user){
        $request->validate([
            'role_selected' => ['required' | 'numeric']
        ]);
        UserRole::where('user_id', $user)
                ->update([
                    'user_role' => $request->input('role_selected')
                ]);
        return response()->json(['redirectUrl' => '/dashboard/role']);
    }
}
