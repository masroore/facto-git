<?php

namespace App\Models;

use App\User;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $guarded = [];

    function user(){
        return $this->belongsTo( User::class);
    }
    
    public function customer()
    {
        return $this->belongsTo( Customer::class );
    }
}
