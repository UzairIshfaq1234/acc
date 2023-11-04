<?php

namespace App\Http\Livewire\Admin\Reports;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Invoice;
use Livewire\Component;
use App\Models\Customer;
use App\Exports\SaleReportExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class SalesReport extends Component
{
    public $start_date,$end_date,$export=[],$invoices=[],$order_type="ALL",$lang,$staff,$staff_id="ALL",$customer,$customer_id="ALL";
    /* render the page */
    public function render()
    {
        return view('livewire.admin.reports.sales-report'); 
    }
    /* process before render */
    public function mount()
    {
        $this->start_date = Carbon::today()->toDateString();
        $this->end_date = Carbon::today()->toDateString();
        $this->staff=User::latest()->get();
        $this->customer=Customer::latest()->get();
        $this->getData();
        $this->lang = getTranslation();
        if(!Auth::user()->can('sales_report'))
        {
            abort(404);
        }
    }
    /* feach sales report */
    public function getData()
    {
        $query = Invoice::latest();
        $query->whereDate('date','>=',Carbon::parse($this->start_date)->startOfDay()->toDateString());
        $query->whereDate('date','<=',Carbon::parse($this->end_date)->endOfDay()->toDateString());
        if($this->staff_id != "ALL")
        {
            $query->where('created_by',$this->staff_id);
        }
        if($this->customer_id != "ALL")
        {
            $query->where('customer_id',$this->customer_id);
        }
        $this->invoices = $query->get();
    }

    public function exportdata(){
        foreach($this->invoices as $invoice){
            $this->export[]=[
                'date'=>$invoice->date,
                'invoice'=>$invoice->invoice_number,
                'customer'=>$invoice->customer->name,
                'total'=>getCurrency().number_format($invoice->total_amount,2),
            ];
        }
    }

    public function exportToExcel(){
        $this->exportdata();
        return Excel::download(new SaleReportExport($this->export), 'sale-report.xlsx');
    }

    public function exportToPDF(){
        $this->exportdata();
        return Excel::download(new SaleReportExport($this->export), 'sale-report.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }
}
