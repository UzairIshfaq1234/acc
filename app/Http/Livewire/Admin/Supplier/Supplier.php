<?php

namespace App\Http\Livewire\Admin\Supplier;

use App\Models\Product;
use App\Models\Supplier as ModelsSupplier;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Supplier extends Component
{
    public $suppliers,$name,$business_name,$supplier,$is_active = true,$lang;
    /* render the page */
    public function render()
    {
        $this->suppliers = ModelsSupplier::latest()->get();
        return view('livewire.admin.supplier.supplier');
    }
    /* process before render */
    public function mount()
    {
        $this->lang = getTranslation();
        if(!Auth::user()->can('suppliers_list'))
        {
            abort(404);
        }
    }
    /* store supplier */
    public function create()
    {
        $this->validate([
            'name'  => 'required',
        ]);
        $supplier = new ModelsSupplier();
        $supplier->name = $this->name;
        $supplier->business_name = $this->business_name;
        
        $supplier->save();
        $this->emit('closemodal');
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'supplier has been created!']);
    }
    /* edit supplier */
    public function edit(ModelsSupplier $supplier)
    {
        $this->resetFields();
        $this->supplier = $supplier;
        $this->name = $supplier->name;
        $this->business_name = $supplier->business_name;
    }
    /* update supplier details */
    public function update()
    {
        $this->validate([
            'name'  => 'required',

        ]);
        $supplier = $this->supplier;
        $supplier->name = $this->name;
        $supplier->business_name = $this->business_name;
        $supplier->save();
        $this->emit('closemodal');
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Brand/Supplier has been updated!']);
    }
    /* delete supplier with foreign key delete restriction */
    public function delete(ModelsSupplier $supplier)
    {
        if(Product::where('supplier_id',$supplier->id)->count() > 0)
        {
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'error',  'message' => 'Brand/supplier deletion restricted!']);
            return 0;
        }
        $supplier->delete();
        $this->supplier = null;
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Brand/supplier has been deleted!']);
    }
    /* reset fields */
    public function resetFields()
    {
        $this->resetErrorBag();
        $this->name = '';
        $this->business_name = '';
    }
}
