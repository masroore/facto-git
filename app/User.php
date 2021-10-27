<?php

namespace App;

use App\HasRoles;
use App\Models\Role;
use App\Models\Upso;
use Modules\Upsos\Models\UpsoImage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    // use HasRoles;

    protected $fillable = [
        'name', 'uid', 'nick', 'email', 'password','password1', 'role_id',
    ];

    protected $hidden = [
        'password', 'password1', 'remember_token',
    ];
 
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    function upso_images(){
        return $this->morphMany( UpsoImage::class, 'upso_imagable');
    }
    public function isAdmin()
    {
        return $this->role->is_admin ; 
    }

    function role(){
        return $this->belongsTo( Role::class);
    }

    function upso(){
        return $this->hasOne( Upso::class  );
    }
    
}
