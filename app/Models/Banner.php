<?php

namespace App\Models;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    protected $table ='banners';
    protected $fillable = ['file_name', 'division', 'link', 'status', 'visits'];

    public static function saveBanner() {
      $banners = Banner::where('status', 'A')->get();
      $fb = 'banners.json';
      return Storage::put( $fb, $banners->toJson());
    }

    
}
