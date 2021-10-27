<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class AllImage extends Model
{
    public function all_imagable()
    {
        return $this->morphTo();
    }
}
