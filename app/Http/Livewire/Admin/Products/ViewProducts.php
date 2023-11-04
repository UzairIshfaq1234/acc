<?php

namespace App\Http\Livewire\Admin\Products;

use App\Models\Addon;
use App\Models\Stock;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ViewProducts extends Component
{
    public $products,$lang,$available,$quantity,$product;
    /* render the page */
    public function render()
    {
        $this->products = Product::latest()->get();
        return view('livewire.admin.products.view-products');
    }
    /* process before render */
    public function mount()
    {
        $this->lang = getTranslation();
        if(!Auth::user()->can('products_list'))
        {
            abort(404);
        }
    }
    /* delete products with foreign key delete restriction */   
    public function delete(Product $product)
    {
        if(Addon::where('product_id',$product->id)->count() > 0)
        {
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'error',  'message' => 'Deletion restricted,Product has addons!']);
            return;
        }
        if($product->image)
        {
            $file= public_path($product->image);
            if(file_exists($file))
            {
                try{
                    unlink(public_path($product->image));
                }
                catch(\Exception $e)
                {

                }
            }
        }
        $product->delete();
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Product has been deleted!']);
    }

    public function addStock(Product $product){
        $this->resetFields();
        $this->product = $product;
        $this->available=$product->quantity;
    }

    public function stock(){
        $this->validate([
            'quantity'  => 'required',
        ]);
        $product = $this->product;
        $product->quantity =  $this->available + $this->quantity;
        $product->save();
        if($this->quantity){
            $stock = new Stock();
            $stock->product_id = $product->id;
            $stock->quantity = $this->quantity;
            $stock->save();
        }
        $this->emit('closemodal');
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Stock has been updated!']);
    }

    public function resetFields()
    {
        $this->resetErrorBag();
        $this->product = '';
        $this->available='';
        $this->quantity='';
    }
}
