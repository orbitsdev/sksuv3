<?php

namespace App\Http\Middleware;

use App\Http\Controllers\RoleChangerController;
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
                'user'=> Auth::user() ? Auth::user() : null
           ],
            'notification'=> session('notification'),
            'flash'=> [
                'warning' => session('warning'), 
                'success' => session('success'), 
            ],
            'can'=> [
                'isOsas' => Auth::user() ?  Auth::user()->hasRole('osas') : null,
                'isSboAdviser' => Auth::user() ?  Auth::user()->hasRole('sbo-adviser') : null,
                'isSboStudent' => Auth::user() ?  Auth::user()->hasRole('sbo-student') : null,
                'isGuest' => Auth::user() ?  Auth::user()->hasRole('guest') : null,
                'isSuperAdmin' => Auth::user() ?  Auth::user()->hasRole('super-admin') : null,
                'isDeveloper' => Auth::user() ?  Auth::user()->hasRole('developer') : null,
                'isDirector' => Auth::user() ?  Auth::user()->hasRole('campus-director') : null,
                'isVpa' => Auth::user() ?  Auth::user()->hasRole('vpaa') : null,
                'isGuestOrStudent' => Auth::user() ?  Auth::user()->hasRoleOf(['guest','sbo-student']) : null,
            ],
            'sbocurrentschool' => Auth::user() ? RoleChangerController::sboCurrentSchool() : null,

            // 'currentschool'=> Auth::user() ?  Auth::user()->hasRole('sbo-adviser') ? Auth::user()->campus : null : null
                        
            'csrf_token' => csrf_token(),
                
        ]);
    }
}
