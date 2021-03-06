<?php

namespace App\Models;

use App\Models\Manager;
use Illuminate\Database\Eloquent\Model;

class ManagerImage extends Model
{
    protected $fillable = [];

    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }
}
