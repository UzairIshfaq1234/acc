<?php

namespace App\Http\Livewire\Admin;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Table;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Home extends Component
{
    public $latestorders,$pendingorders,$availablestock,$lowstock,$tables,$lang;
    /* render the page */
    public function render()
    {
        $this->latestorders = Order::whereDate('date',Carbon::today())->get();
        $this->pendingorders = Order::whereStatus(Order::PENDING)->get();
        $this->tables = Table::latest()->limit(10)->get();
        $this->availablestock = Product::latest()->limit(10)->get();
        $query = Product::latest();
        $query = $query->where('quantity', '<', DB::raw('quantity_alert'));
        $this->lowstock = $query->get();
        return view('livewire.admin.home');
    }
    /* process before render */
    public function mount()
    {
        $this->lang = getTranslation();
    }
}
