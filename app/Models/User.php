<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Vpa;
use App\Models\Role;
use App\Models\Officer;
use App\Models\CampusAdviser;
use App\Models\SocialAccount;
use App\Models\CampusDirector;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];
    protected $guarded = [];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // 'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function socialAccounts(){
        return $this->hasMany(SocialAccount::class);
    }

    
    public function roles(){
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }

    public function hasRoleOf($roles){
        
        if($this->roles()->whereIn('name', $roles)->first()){
            return true;
        }
        
        return false;
    }

    public function hasRole($role){
        
        if($this->roles()->where('name', $role)->first()){
            return true;
        }
        return false;
    }

    public function campus_advisers(){
        return $this->hasMany(CampusAdviser::class);
    }


    public function campus_directors(){
        return $this->hasMany(CampusDirector::class);
    }
    public function vpas(){
        return $this->hasMany(Vpa::class);
    }


    public function officers(){
        return $this->hasMany(Officer::class);
    }

    public function officer(){
        return $this->hasOne(Officer::class);
    }


}
