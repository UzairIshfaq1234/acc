<?php

namespace App\Http\Livewire\Admin\Services;

use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Services extends Component
{
    public $services,$name,$description,$charges,$is_active = true,$lang;
    public $service;
    /* render the page */
    public function render()
    {
        $this->services = Service::latest()->get();
        return view('livewire.admin.services.services');
    }
    /* process before render */
    public function mount()
    {
        $this->lang = getTranslation();
        if(!Auth::user()->can('services_list'))
        {
            abort(404);
        }
    }
    /* store service data */
    public function create()
    {
        $this->validate([
            'name'  => 'required',
            'description'  => 'required',
            'charges'=>'required'
            
        ]);
        $service = new Service();
        $service->name = $this->name;
        $service->description = $this->description;
        $service->charges = $this->charges;
        $service->save();
        $this->emit('closemodal');
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Services has been created!']);
    }

    /* reset service data */
    public function edit(Service $service)
    {
        $this->resetFields();
        $this->customer = $service;
        $this->name = $service->name;
        $this->phone = $service->phone;
        $this->email = $service->email;
        $this->address = $service->address;
    }
    /* update service data */
    public function update()
    {
        $this->validate([
            'name'  => 'required',
            'description'  => 'required',
            'charges'=>'required'
          
        ]);
        $service = $this->service;
        $service->name = $this->name;
        $service->description = $this->description;
        $service->charges = $this->charges;
        $service->save();
        $this->emit('closemodal');
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Services has been updated!']);
    }
    /* delete service data */
    public function delete(Service $service)
    {
        $service->delete();
        $this->service = null;
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Services has been deleted!']);
    }
    /* reset service data */
    public function resetFields()
    {
        $this->name = '';
        $this->phone = '';
        $this->email = '';
        $this->address = '';
        $this->resetErrorBag();
    }
}
