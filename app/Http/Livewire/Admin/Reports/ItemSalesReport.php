<?php

namespace App\Http\Livewire\Admin\Reports;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Product;
use Livewire\Component;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductSaleReportExport;

class ItemSalesReport extends Component
{
    public $start_date,$end_date,$data=[],$product,$product_id="ALL",$product_category,$product_category_id="ALL",$lang;
    /* render the page */
    public function render()
    {
        return view('livewire.admin.reports.item-sales-report');
    }
    /* process before render */
    public function mount()
    {
        $this->start_date = Carbon::today()->startOfMonth()->toDateString();
        $this->end_date = Carbon::today()->toDateString();
        $this->product=Product::latest()->get();
        $this->product_category=ProductCategory::latest()->get();
        $this->getData();
        $this->lang = getTranslation();
        if(!Auth::user()->can('item_wise_sales_report'))
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

        $products = $query->get();
        $productids = $products->pluck('id');

        $query = Invoice::latest();
        $query->whereDate('date','>=',Carbon::parse($this->start_date)->startOfDay()->toDateString());
        $query->whereDate('date','<=',Carbon::parse($this->end_date)->endOfDay()->toDateString());
        $query->whereHas('details', function($query2) use ($productids){
            $query2->whereIn('product_id',$productids);
        });
        $query->with('details');
        $invoices = $query->get();
        
        $data = [];
        foreach ($invoices as $key => $value) {
            foreach ($value->details as $key => $product) {
                if(in_array($product->product_id,$productids->toArray()))
                {
                    if(isset($data[$product->product_id]))
                    {
                        $data[$product->product_id]['qty'] += $product->quantity;
                        $data[$product->product_id]['amount'] += $product->total;
                    }
                    else{
                        $data[$product->product_id] = [
                            'name'  => $product->product_name,
                            'qty'   => $product->quantity,
                            'amount'    => $product->total
                        ];
                    }
                }
            }
        }
        $this->data = $data;
    }   

    public function exportToExcel(){
        return Excel::download(new ProductSaleReportExport($this->data), 'productsale-report.xlsx');
    }

    public function exportToPDF(){
        return Excel::download(new ProductSaleReportExport($this->data), 'productsale-report.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }
}
