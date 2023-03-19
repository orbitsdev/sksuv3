<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as supportrequest;


class OsasController extends Controller
{



    public function index()
    {

        return Inertia::render('superadmin/index', [
            'users'=> User::query()->
            when(supportrequest::input('search'), function($query, $search){
                $query->where('first_name', 'like', "%{$search}%")->orWhere('last_name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
            })->whereHas('roles', function($query){
                $query->whereIn('name', ['osas', 'guest']);
            })->with('roles')->latest()->paginate(10)->withQueryString(),
            'filters'=> supportrequest::only(['search'])

        ]);
    }



    public function changeUserRoles(Request $request)
    {


        // dd($request->all());



        $collection = User::whereIn('id', $request->input('user_ids'))->get();

        $role = Role::where('id', $request->role_id)->first();
        
        foreach ($collection as $data) {
            $data->roles()->sync($role->id);
        }


        return redirect()->back()->with('notification', 'chnage');
    }


    public function deleteSelected(Request $request)
    {



        $collection = User::whereIn('id', $request->input('ids'))->get();



        $role =   Role::where('name', 'guest')->first();



        foreach ($collection as $data) {
            $data->user->roles()->sync($role->id);
        }



        return redirect()->back()->with('notification', 'Campus Delete');
    }
}
