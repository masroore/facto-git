<?php

namespace App\Http\Livewire;

use App\Models\Cat;
use Livewire\Component;
use App\Models\Customer;
use Livewire\WithPagination;
use Illuminate\Support\MessageBag;

class Customers extends Component
{
    use WithPagination;
    // use MessageBag; 
    
    public $ccat_id;
    public $mode, $customer_id, $message, $search;
    public $password, $title, $name, $content  ;

    protected $queryString = [
        'ccat_id',
        'mode',
        'customer_id',
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'name'=> 'required|string|min:3|max:20',
        'password'=> 'required|string|min:3|max:20',
        'title'=> 'required|string|min:3|max:20',
        'content'=> 'required|string|min:6|max:1000',
    ];
    // public function hydrate()
    // {
    //     $this->resetErrorBag();
    //     $this->resetValidation();
    // }

    public function updating($name, $value)
    {
        $this->emit('urlChanged', http_build_query([$name => $value]));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingMode()
    {
        // dd('123');
        $this->resetPage();
    }

    public function render()
    {
        $customers = Customer::where('ccat_id', $this->ccat_id)
                    ->orderBy('created_at', 'desc')
                    ->paginate();
        $customers->withPath('customers');

        $customer = Customer::where('id', $this->customer_id)->first();
        $ccat = Cat::find($this->ccat_id);
        return view('livewire.customers', [
            'ccat'=> $ccat,
            'customer'=> $customer,
            'customers'=>$customers,
        ]);
    }

    function mount( $ccatid){
        // session()->flash('message', 'Post successfully updated.');
        // $this->fill(request()->only('search', 'page'));
        $this->ccat_id = $ccatid;
    }

    function setMode( $mode, $customer_id = null){
        $this->resetPage();
        $this->mode = $mode;
        $this->customer_id = $customer_id ;
    }

    function setPassword( ){
        $this->checkPassword($this->ccat_id, $this->customer_id , $this->password);
    }

    protected function chechkPassword($ccat_id,  $customer_id ,$password){

        $customer = Customer::where('ccat_id', $ccat_id)
                        ->where('id', $customer_id)
                        ->where('password', $password);
        $exists = $customer->exists();
        if( $exists ){
            $this->customer = $customer->first();
        } else {
            $this->errors['customer'] = 'no Data' ;
        }
    }


    function saveMessage(){

        $customer = Customer::create(
            [
                'ccat_id' =>  $this->ccat_id,
                'name' =>  $this->name ,
                'password' =>  $this->password,
                'title' =>  $this->title,
                'content' =>  $this->content,
                'user_ip' => request()->ip(),
            ]
        );

        if( $customer ){
            session()->flash('message', '문의가 입력되었습니다.');
            $this->mode = null;
        }
    }

    function showMe($customer_id ) {
        $this->customer_id = $customer_id ;
        $this->mode ='show';
    }

}
