<?php

namespace App\Http\Livewire\Admin\Reports;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Stock;
use App\Models\Product;
use Livewire\Component;
use App\Exports\StockReportExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DateWiseStockReportExport;

class StockReportDateWise extends Component
{
    public $data=[],$product,$product_id="ALL",$lang;
    /* render the page */
    public function render()
    {
        return view('livewire.admin.reports.stock-report-datewise');
    }
    /* process before render */
    public function mount()
    {
        $this->product=Product::latest()->get();
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
        $query = Stock::latest();
        if($this->product_id != 'ALL')
        {
            $query = $query->where('product_id',$this->product_id);
        }

        $products = $query->get();
        $this->data = $products;
    }   

    public function exportToExcel(){
        return Excel::download(new DateWiseStockReportExport($this->data), 'datewise-stock-report.xlsx');
    }

    public function exportToPDF(){
        return Excel::download(new DateWiseStockReportExport($this->data), 'datewise-stock-report.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }
}
