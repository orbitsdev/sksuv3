<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Models\CampusAdviser;
use PhpParser\Node\Expr\Cast;
use Illuminate\Support\Facades\Storage;

class GlobalOrganizationController extends Controller
{


    public function __construct()
    {
        $fcontroller = app('App\Http\Controllers\FileController');
    }


    static function deleteImageOsss($path)
    {
        if ($path) {
            $storage = Storage::disk('oss');
            if ($storage->has($path)) {
                try {
                    $storage->delete($path);
                } catch (Exception $e) {
                    \Log::info(["Failed to delete file path = ", $path]);
                }
            }
        }
    }
    static function deleteOrganizationByCampusAdviser($adviser_id)
    {

        $collection = Organization::where('campus_adviser_id', $adviser_id)->get();

        // dd($collection);


        foreach ($collection as  $data) {



            if ($data->organization_requirements) {
                $data->organization_requirements->each(function ($org) {
                    if ($org->file) {
                        $org->file->each(function ($file) {
                            if ($file) {


                                self::deleteImageOsss($file->url);

                                // $this->deleteImageOss($)
                                $file->delete();
                            }
                        });
                    }

                    $org->delete();
                });
            }

            if ($data->requirements) {
                $data->requirements()->detach();
            }

            if ($data->certificate) {
                $data->certificate()->delete();
            }
            if ($data->remarks) {
                $data->remarks()->delete();
            }
            if ($data->organization_process) {
                $data->organization_process()->delete();
            }
        }

        Organization::where('campus_adviser_id', $adviser_id)->delete();
    }
}
