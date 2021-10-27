<?php

namespace App\Models;

use App\Models\AllImage;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Modules\ClickLog\Entities\ClickLog;

class Post extends Model
{
    protected $table = 'posts';
    // public $timestamps = false;
    
    protected $fillable = [  
        'user_id', 'cat_id', 'photo', 'thumb_path', 'option', 
        'title', 'content', 'iframe_src', 'outlink1', 'outlink2', 'thumb', 'visits'
    ];
    protected $guard = [];

    public function getTitleShortAttribute()
    {
        if( strlen( $this->title ) < 36 ) {
            return str_pad($this->title, 36);  
        } else {
            return Str::limit($this->title, 36, '...');
        }
        
    }
    public function getTitleLongAttribute()
    {
        return  Str::limit($this->title, 46, '...');
    }

    function all_images(){
        return $this->morphMany( AllImage::class, 'all_imagable');
    }

    public function getEmbedAttribute()
    {
        // $url ='http://sendvid.com/v4punwi1' ;
        if( ! Str::contains( $this->outlink1 , '/embed')  ) {
            $tmp = parse_url( $this->outlink1 ) ;
            return $tmp['scheme'] . '://' . $tmp['host'] . '/embed' .  $tmp['path'];
        } 
        return $this->outlink1 ;
    }
    
    function click_logs(){
        return $this->hasMany( ClickLog::class);

    }
    function cat(){
        return $this->belongsTo(\App\Models\Cat::class);
    }
    
    function user(){
        return $this->belongsTo( \App\User::class );
    }

    function comments() {
        return $this->hasMany( \App\Models\Comment::class);
    }
    
    function tags() {
        return $this->belongsToMany( \App\Models\Tag::class);
    }


}
