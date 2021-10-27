<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TagController extends Controller
{
    function index( $tag,  Request $request){
        dd($tag);
    }
}
