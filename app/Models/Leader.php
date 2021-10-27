<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Leader extends User
{
    protected $table = 'users';

    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted)
                        ->where('is_leader', true);
    }
}
