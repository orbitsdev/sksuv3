<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Inertia\Inertia;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as supportrequest;


class SchoolYearController extends Controller
{

    public function index(Request $request)
    {



        return Inertia::render('osas/schoolyear', [
            'years' => SchoolYear::query()
                ->when(supportrequest::input('search'), function ($query, $search) {
                    $query->where('from', 'like', "%{$search}%")->orWhere('to', 'like', "%{$search}%");
                })->latest()->withCount('campus_advisers')
                ->paginate(10)
                ->withQueryString(),
            'filters' => supportrequest::only(['search'])
        ]);
    }


    public function create(Request $request)
    {
        $school_year = SchoolYear::create([
            'from' => $request->input('fromYear'),
            'to' => $request->input('toYear'),
        ]);

        return redirect()->back()->with('toast', 'School Year Created');;
    }

    public function deleteSelected(Request $request)
    {


        $collection  = SchoolYear::whereIn('id', $request->input('ids'))->get();

        //get guest role
        $role = Role::where('name', 'guest')->first();




        foreach ($collection as $data) {



            //  chnage role of campus adviser and delete
            if ($data->campus_advisers()->count() > 0) {


                foreach ($data->campus_advisers as $adviser) {


                    if ($adviser->organizations->count()) {
                    }

                    GlobalOrganizationController::deleteOrganizationByCampusAdviser($adviser->id);

                    $adviser->user->roles()->sync($role->id);
                    $adviser->delete();
                }
            }


            if ($data->campus_directors()->count() > 0) {

                foreach ($data->campus_advisers as $director) {

                    // dd($director->user);
                    $director->user->roles()->sync($role->id);
                    $director->delete();
                }
            }
        }

        SchoolYear::whereIn('id', $request->input('ids'))->delete();

        return redirect()->back()->with('toast', 'School Year Created');
    }
}
