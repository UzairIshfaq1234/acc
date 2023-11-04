<?php

namespace App\Http\Livewire\Admin\Quotations;

use App\Models\Addon;
use App\Models\Quotation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Lead;

class ViewQuotations extends Component
{
    public $quotations,$lang,$available,$quantity,$product;
    /* render the page */
    public function render()
    {
        $this->quotations = Quotation::latest()->get();
        return view('livewire.admin.quotations.view-quotations');
    }
    /* process before render */
    public function mount()
    {
        $this->lang = getTranslation();
        if(!Auth::user()->can('quotation_list'))
        {
            abort(404);
        }
    }
    /* delete products with foreign key delete restriction */   
    public function delete(Quotation $qoutation)
    {
        $qoutation->delete();
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Quotation has been deleted!']);
    }
}
