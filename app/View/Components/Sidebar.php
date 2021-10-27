<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Sidebar extends Component
{
    public $title , $info ;
    public function __construct( $title, $info)
    {
        $this->title = $title ;
        $this->info = $info ;
    }

    public function render()
    {
        return view('components.sidebar');
    }

    function lists(){
        return [
            'a', 
            'b'
        ];
    }
}
