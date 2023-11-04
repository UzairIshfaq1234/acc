<?php

namespace App\Http\Livewire\Admin\Reports;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CustomerReportExport;

class CustomerReport extends Component
{
    public $start_date,$end_date,$data=[],$search='',$lang;
    /* render the page */
    public function render()
    {
        return view('livewire.admin.reports.customer-report');
    }
    /* process before render */
    public function mount()
    {
        $this->start_date = Carbon::today()->toDateString();
        $this->end_date = Carbon::today()->toDateString();
        $this->getData();
        $this->lang = getTranslation();
        if(!Auth::user()->can('customer_report'))
        {
            abort(404);
        }
    }
    /* feach customer sales report*/
    public function getData()
    {
        $query = Customer::latest();
        if($this->search != '')
        {
            $query = $query->where('name','like','%'.$this->search.'%');
        }
        $query->withSum('invoices','total_amount');
        $this->data = $query->get()->toArray();
    }

    public function exportToExcel(){
        return Excel::download(new CustomerReportExport($this->data), 'customer-report.xlsx');
    }

    public function exportToPDF(){
        return Excel::download(new CustomerReportExport($this->data), 'customer-report.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }
}
