<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Exception;


class ProfileController extends Controller


{


    public function uploadFileOss($path,  $file)
    {


        $storage = Storage::disk("oss");

        $filename = strtotime(now()) . '.' . $file->getClientOriginalExtension();
        $full_path = $path . $filename;
        $extension = $file->getClientOriginalExtension();
        // dd($extension);
        try {

            $storage->put($full_path, file_get_contents($file));
            return [
                'owned_by' => $path,
                'folder' => $path,
                'file_name' => $file->getClientOriginalName(),
                'file_type' => $file->getClientOriginalExtension(),
                'url' => $full_path,

            ];
        } catch (Exception $e) {
            dd($e);
        }
    }



    public function updateProfile(Request $request)
    {

        // dd($request->all());

        $validated = $request->validate([

            'first_name' => ['required'],
            'last_name' => ['required'],
            'profile' => ['image', 'mimes:jpeg,png', 'max:5120'],
        ]);


        if ($request->has('profile')) {



            $file_data =     $this->uploadFileOss('profile/', $request->profile);
            $user =  User::find($request->id);
            $file =  $user->files()->create($file_data);
            $user->profile_image_url = $file->file_url;
            $user->save();
        }
    }
}
