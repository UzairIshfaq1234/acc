<?php

namespace App\Http\Livewire\Admin\ProductCategory;

use App\Models\Product;
use App\Models\ProductCategory as ModelsProductCategory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProductCategory extends Component
{
    public $categories,$name,$description,$category,$is_active = true,$lang;
    /* render the page */
    public function render()
    {
        $this->categories = ModelsProductCategory::latest()->get();
        return view('livewire.admin.product-category.product-category');
    }
    /* process before render */
    public function mount()
    {
        $this->lang = getTranslation();
        if(!Auth::user()->can('categories_list'))
        {
            abort(404);
        }
    }
    /* store category */
    public function create()
    {
        $this->validate([
            'name'  => 'required',
        ]);
        $category = new ModelsProductCategory();
        $category->name = $this->name;
        $category->description = $this->description;
        $category->is_active = $this->is_active;
        $category->save();
        $this->emit('closemodal');
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Category has been created!']);
    }
    /* edit category */
    public function edit(ModelsProductCategory $category)
    {
        $this->resetFields();
        $this->category = $category;
        $this->name = $category->name;
        $this->description = $category->description;
        $this->is_active = $category->is_active;
    }
    /* update category details */
    public function update()
    {
        $this->validate([
            'name'  => 'required',
        ]);
        $category = $this->category;
        $category->name = $this->name;
        $category->description = $this->description;
        $category->is_active = $this->is_active;
        $category->save();
        $this->emit('closemodal');
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Category has been updated!']);
    }
    /* delete category with foreign key delete restriction */
    public function delete(ModelsProductCategory $category)
    {
        if(Product::where('category_id',$category->id)->count() > 0)
        {
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'error',  'message' => 'Category deletion restricted!']);
            return 0;
        }
        $category->delete();
        $this->category = null;
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Category has been deleted!']);
    }
    /* reset fields */
    public function resetFields()
    {
        $this->resetErrorBag();
        $this->name = '';
        $this->description = '';
        $this->is_active = 1;
    }
}
