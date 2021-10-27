<?php

namespace App\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $table = 'replies';

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
