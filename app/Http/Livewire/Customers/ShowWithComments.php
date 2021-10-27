<?php

namespace App\Http\Livewire\Customers;

use Livewire\Component;
use App\Models\Customer;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ShowWithComments extends Component
{
    // use WithPagination;
    public $customer_id;
    public $content , $password, $old_password; 
    public $step =1 ;

    public function render()
    {
        $customer = null;
        if( Auth::check() ){
            $user = Auth::user() ;
            if( $user->isAdmin() ){
                $this->step = 2; 
                
            }
        }
        
        
        // dd($this->step);
        if( $this->step == 2 ){
            $customer = Customer::where('id', $this->customer_id)
                    ->with('comments')
                    ->orderBy('created_at', 'desc')
                    ->first();
        }
        return view('livewire.customers.show-with-comments', [
                'customer'=>$customer,
        ]);
    }

    function mount( $customer_id){
        $this->step= 1;
        $this->customer_id = $customer_id;
        $customer = Customer::find( $this->customer_id);
        $this->old_password = $customer->password;

        
    }

    function checkPassword(){
        $customer = Customer::find( $this->customer_id);
        if( $customer->password == $this->password ) {
            $this->step=2;

        } else {
            session()->flash('message','비밀번호가 정확하지 않습니다.');
        }
        // dd( $this->step);
    }
}
