<?php

namespace App\Models;

use App\User;
use App\Models\Region;
use App\Models\Comment;
use App\Models\Manager;
use App\Models\Premium;
use App\Models\AllImage;
use App\Models\UpsoType;
use Illuminate\Database\Eloquent\Model;

class Upso extends Model
{
    public static function boot()
    {
        parent::boot();
        self::deleting(function ($upso) { // before delete() method call this
            $upso->managers()->each( function( $manager){
                $manager->delete();
            });

            $upso->premium()->each( function( $manager){
                $manager->delete();
            });
        });
    }

    public function premium(){
        return $this->hasOne( Premium::class );
    }

    public function upso_type()
    {
        return $this->belongsTo(UpsoType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function managers()
    {
        return $this->hasMany(Manager::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function all_images()
    {
        return $this->morphMany(AllImage::class, 'all_imagable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

}
