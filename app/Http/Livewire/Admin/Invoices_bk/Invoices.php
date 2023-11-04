<?php

namespace App\Http\Livewire\Admin\Invoices;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Table;
use Livewire\Component;
use App\Models\Customer;
use App\Models\OrderPayment;
use Illuminate\Support\Facades\Auth;

class Invoices extends Component
{
    public $orders,$lang,$order,$paid_amount,$payment_type = 1,$search='',$search_order='';
    /* render the page */
    public function render()
    {
        // $query = Order::with('payments')->latest(); 
        // $this->orders = $query->get();
        return view('livewire.admin.invoices.invoices');
    }
    /* process before render */
    public function mount()
    {
        $this->start_date = Carbon::today()->startOfMonth()->toDateString();
        $this->end_date = Carbon::today()->toDateString();
        $this->getData();
        $this->lang = getTranslation();
        if(!Auth::user()->can('invoices_list'))
        {
            abort(404);
        }
    }
    /* get data*/ 
    public function getData()
    {
        $query = Customer::latest();
        if($this->search != '')
        {
            $query = $query->where('name','like','%'.$this->search.'%');
        }

        $customer = $query->get();
        $customer_ids = $customer->pluck('id');

        $query = Order::latest();
        $query->whereDate('date','>=',Carbon::parse($this->start_date)->startOfDay()->toDateString());
        $query->whereDate('date','<=',Carbon::parse($this->end_date)->endOfDay()->toDateString());
        if($customer_ids){
            $query->whereIn('customer_id',$customer_ids);
        }
        if($this->search_order != '')
        {
            $query = $query->where('order_number',$this->search_order);
        }
        $query->with('payments');
        $this->orders = $query->get();
    }
    /* change order status */
    public function changeStatus(Order $order)
    {
        if($order->status < 3)
        {
            $order->status ++;
            $order->save();
        }
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Order status has been changed.']);
    }
    /* show payment */
    public function viewPayment($id)
    {
        $this->order = Order::find($id);
        $this->paid_amount = $this->order->total - $this->order->payments->sum('amount');
        $this->payment_type = 1;
        $this->resetErrorBag();
    }
    /* store payment */
    public function savePayment()
    {
        $this->validate([
            'paid_amount'   => 'numeric'
        ]);
        $max = $this->order->total - $this->order->payments->sum('amount');
        if($this->paid_amount > $max)
        {
            $this->addError('paid_amount','Amount cannot be greater than balance!');
            return;
        }
        $payment = new OrderPayment();
        $payment->order_id = $this->order->id;
        $payment->created_by = Auth::user()->id;
        $payment->amount = $this->paid_amount;
        $payment->order_id = $this->order->id;
        $payment->customer_name = $this->order->customer->name;
        $payment->customer_phone = $this->order->customer->phone;
        $payment->customer_id = $this->order->customer->id;
        $payment->type = $this->payment_type;
        $payment->save();

        $table = Table::find($this->order->table_id);
        $table->is_active=1;
        $table->save();
        
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Payment Saved.']);
        $this->order = [];
        $this->resetErrorBag();
        $this->emit('closemodal');
    }
}
