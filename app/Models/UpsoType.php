<?php

namespace App\Models;

use App\Models\Upso;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UpsoType extends Model
{
    use SoftDeletes;

    public function upsos()
    {
        return $this->hasMany(Upso::class);
    }
}
