<?php

namespace App\Models;

use App\Models\Upso;
use App\Models\UpsoType;
use Illuminate\Database\Eloquent\Model;

class Premium extends Model
{
    protected $table ='premia';

    function upso_type(){
        return $this->belongsTo( UpsoType::class);
    }

    function upso(){
        return $this->belongsTo( Upso::class);
    }

}
