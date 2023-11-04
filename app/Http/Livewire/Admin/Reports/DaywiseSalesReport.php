<?php

namespace App\Http\Livewire\Admin\Reports;

use Carbon\Carbon;
use App\Models\Order;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Exports\DaywiseReportExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class DaywiseSalesReport extends Component
{
    public $start_date,$end_date,$data=[],$lang;
    /* render the page */
    public function render()
    {
        return view('livewire.admin.reports.daywise-sales-report');
    }
    /* process before render */
    public function mount()
    {
        $this->start_date = Carbon::today()->startOfMonth()->toDateString();
        $this->end_date = Carbon::today()->toDateString();
        $this->getData();
        $this->lang = getTranslation();
        if(!Auth::user()->can('day_wise_sales_report'))
        {
            abort(404);
        }

    }
    /* feach daily sales report */
    public function getData()
    {
        $this->data = DB::table('invoices')
        ->whereDate('date','<=',Carbon::parse($this->end_date)->endOfDay()->toDateString())
        ->whereDate('date','>=',Carbon::parse($this->start_date)->startOfDay()->toDateString())
        ->select(DB::raw('date(date) as date'), DB::raw('COUNT(id) as count'),DB::raw('SUM(total_amount) AS total') )
        ->groupBy(DB::raw('date(date)'))
        ->get()->toArray();
        $data = [];
        foreach($this->data as $key => $value)
        {
            $data[$key] = json_decode(json_encode($value), true);
        }

        $this->data = $data;
    }   

    public function exportToExcel(){
        return Excel::download(new DaywiseReportExport($this->data), 'daywise-report.xlsx');
    }

    public function exportToPDF(){
        return Excel::download(new DaywiseReportExport($this->data), 'daywise-report.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }
}
