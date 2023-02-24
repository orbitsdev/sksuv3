<?php

namespace App\Http\Middleware;

use Inertia\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth'=> [
                'user'=> Auth::user()
            ],
            'notification'=> session('notification'),
            'flash'=> [
                'warning' => session('warning'), 
                'success' => session('success'), 
            ],
            'can'=> [
                'isOsas' => Auth::user()->hasRole('osas'),
                'isSboAdviser' => Auth::user()->hasRole('sbo-adviser'),
                'isSboStudent' => Auth::user()->hasRole('sbo-student'),
                'isGuest' => Auth::user()->hasRole('guest'),
                'isSuperAdmin' => Auth::user()->hasRole('super-admin'),
                'isDeveloper' => Auth::user()->hasRole('developer'),
                'isDirector' => Auth::user()->hasRole('campus-director'),
                'isVpa' => Auth::user()->hasRole('vpaa'),
            ],
                        

                
        ]);
    }
}
