<?php

namespace App\Http\Livewire\Admin\Products;

use App\Models\Addon;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Addons extends Component
{
    public $variants,$extras,$name,$price,$item,$item_type=Addon::VARIANT,$product,$addon,$lang;
    /* render the page */
    public function render()
    {
        $this->variants = Addon::where('product_id',$this->product->id)->where('type',Addon::VARIANT)->get();
        $this->extras = Addon::where('product_id',$this->product->id)->where('type',Addon::EXTRAS)->get();
        return view('livewire.admin.products.addons');
    }
    /* process before render */
    public function mount($id)
    {
        $this->product = Product::find($id);
        $this->lang = getTranslation();
        if(!$this->product)
        {
            abort(404);
        }
        if(!Auth::user()->can('add_addon'))
        {
            abort(404);
        }
    }
    /* reset fields */
    public function resetField($type)
    {
        $this->resetErrorBag();
        $this->name = '';
        $this->price = '';
        $this->item_type = $type;
    }
    /* store addons data */
    public function create()
    {
        $this->validate([
            'name'  => 'required',
            'price' => 'required'
        ]);
        $addon = new Addon();
        $addon->name = $this->name;
        $addon->price = $this->price;
        $addon->type = $this->item_type;
        $addon->product_id = $this->product->id;
        $addon->save();
        $this->emit('closemodal');
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Addon has been created!']);
    }
    /* edit addons */
    public function edit(Addon $addon)
    {
        $this->resetField($addon->type);
        $this->addon = $addon;
        $this->name = $addon->name;
        $this->price = $addon->price;
        $this->item_type = $addon->type;
    }
    /* update addons data */
    public function update()
    {
        $this->validate([
            'name'  => 'required',
            'price' => 'required'
        ]);
        $addon = $this->addon;
        $addon->name = $this->name;
        $addon->price = $this->price;
        $addon->type = $this->item_type;
        $addon->product_id = $this->product->id;
        $addon->save();
        $this->emit('closemodal');
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Addon has been updated!']);
    }

    /* delete addons */
    public function delete(Addon $addon)
    {
        $addon->delete();
        $this->addon = null;
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Addon has been deleted!']);
    }
}
