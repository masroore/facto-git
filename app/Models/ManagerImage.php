<?php

namespace App\Models;

use App\Models\Manager;
use Illuminate\Database\Eloquent\Model;

class ManagerImage extends Model
{
    protected $fillable = [];
    function manager(){
        return $this->belongsTo( Manager::class);
    }
}
