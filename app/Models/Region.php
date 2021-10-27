<?php

namespace App\Models;

use App\Models\Upso;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{
    use SoftDeletes;
    protected $fillable = [];

    function upsos(){
        return $this->hasMany( Upso::class );
    }
    
    
    function children(){
        return $this->hasMany( Region::class, 'parent_id');
    }

    function parent(){
        return $this->belongsTo( Region::class, 'parent_id');
    }

    function count_upsos( $upso_type_id){
        if( $upso_type_id ){
            return $this->upsos()->where('upso_type_id', $upso_type_id)->count();
        } else {
            return $this->upsos->count();
        }
    }

    public function managers()
    {
        return $this->hasManyThrough( Manager::class, Upso::class );
    }

    function count_managers( $upso_type_id){

        // $upso_type_id = 1;
        // $upsos = Upso::where('upso_type_id', $upso_type_id)
                        // ->
        if( $upso_type_id ){
            return $this->managers()->where('upso_type_id', $upso_type_id)->count();
            // return $this->upsos->managers()->where('upso_type_id', $upso_type_id)->count();
        } else {
            return $this->managers()->count();
            // return $this->upsos->managers()->count();
        }
    }


}
