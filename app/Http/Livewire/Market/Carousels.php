<?php

namespace App\Http\Livewire\Market;

use App\Models\Manager;
use Livewire\Component;

class Carousels extends Component
{
    public $manager_id  ;
    public $open, $image_id, $image_ids = [];
    public function render()
    {
        $manager = Manager::where('id', $this->manager_id)
                    ->with('all_images')
                    ->first();
        $images = $manager->all_images->pluck( 'org_path')->all();
        
        $all_images = $manager->all_images;
        $all_images = $all_images->pluck('org_path', 'id')->toArray() ;

        $path = config('filesystems.disks.public.url');
        $selected_img = $manager->all_images()->where('id', $this->image_id)->first();
        // dd($selected_image);

        return view('livewire.market.carousels', [
            'manager'=>$manager,
            'images' => $images,
            'all_images'=> $all_images,
            'path'=> $path,
            'selected_img'=>$selected_img,
        ]);
    }

    function mount( $manager_id){
        $this->manager_id = $manager_id;
    }

    function setOpen( $image_id){
        $this->image_id = $image_id;
        $this->open = true;
        $this->emit('CarouselOpen', $image_id);

    }
    function dadatedImageId($value){
        dd($value);
    }
    function setClose(){
        $this->open = false;
        $this->image_id = null;
    }
    function goNext(){

    }
    function goPrev(){

    }
    
}
