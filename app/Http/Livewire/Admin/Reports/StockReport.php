<?php

namespace App\Http\Livewire\Admin\Reports;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use Livewire\Component;
use App\Models\ProductCategory;
use App\Exports\StockReportExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class StockReport extends Component
{
    public $data=[],$product_id="ALL",$product_category,$product_category_id="ALL",$lang;
    /* render the page */
    public function render()
    {
        return view('livewire.admin.reports.stock-report');
    }
    /* process before render */
    public function mount()
    {
        $this->product=Product::latest()->get();
        $this->product_category=ProductCategory::latest()->get();
        $this->getData();
        $this->lang = getTranslation();
        if(!Auth::user()->can('stock_report'))
        {
            abort(404);
        }
    }
    /* feach Item wise sales report*/
    public function getData()
    {
        $query = Product::latest();
        if($this->product_id != 'ALL')
        {
            $query = $query->where('id',$this->product_id);
        }
        if($this->product_category_id != 'ALL'){
            $query = $query->where('category_id',$this->product_category_id);
        }

        $products = $query->get()->toArray();
        $this->data = $products;
    }   

    public function exportToExcel(){
        return Excel::download(new StockReportExport($this->data), 'low-stock-report.xlsx');
    }

    public function exportToPDF(){
        return Excel::download(new StockReportExport($this->data), 'low-stock-report.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }
}
