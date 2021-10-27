<?php

namespace App\Models;

use App\Models\Reply;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table='customers';
    protected $fillable = [
        'ccat_id', 'ref_id', 'order', 'name', 'password', 'email', 'homepage', 'title', 'content', 'user_ip', 'visits'
    ];

    function ccat(){
        return $this->belongsTo( \App\Models\Ccat::class);
    }

    function replies(){
        return $this->hasMany( Reply::class );
    }

    function comments(){
        return $this->hasMany( Comment::class);
    }
    
}
