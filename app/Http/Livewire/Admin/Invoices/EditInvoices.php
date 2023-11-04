<?php

namespace App\Http\Livewire\Admin\Invoices;

use Carbon\Carbon;
use App\Models\Addon;
use App\Models\Product;
use Livewire\Component;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use Illuminate\Support\Facades\Auth;

class EditInvoices extends Component
{
    public $invoice,$customers,$products,$product_id,$product_name,$productPrice,$productQuantity,$total,$select_tax,$sales_tax,$tax=0,$lang,$available,$quantity,$customer,$selected_products=[];
    public $subject,$date,$customer_id,$address,$stage,$discount,$description,$customer_note,$totalTax,$totalDiscount,$totalAmount,$subAmount;
    public $quotations,$quotation_id,$maintenance_date,$first_invoice,$first_invoice_amount,$first_due_date,$second_invoice,$second_invoice_amount,$second_due_date,$productdescription,$productUnit,$type;
    /* render the page */
    public function render()
    {
        $this->customers = Customer::latest()->get();
        $this->products = Product::latest()->get();
        return view('livewire.admin.invoices.edit-invoices');
    }
    /* process before render */
    public function mount($id)
    {
        $this->lang = getTranslation();
        if(!Auth::user()->can('invoice_list'))
        {
            abort(404);
        }
        
        $this->invoice = Invoice::find($id);
        $this->type=$this->invoice->type;
        $this->date=$this->invoice->date;
        $this->customer_id=$this->invoice->customer_id;
        $this->address=$this->invoice->address;
        $this->sales_tax=$this->invoice->sales_tax;
        $this->discount=$this->invoice->discount;
        $this->maintenance_date=$this->invoice->maintenance_date;
        $this->first_invoice=$this->invoice->first_invoice;
        $this->first_due_date=$this->invoice->first_due_date;
        $this->second_invoice=$this->invoice->second_invoice;
        $this->second_due_date=$this->invoice->second_due_date;
        $this->subAmount=$this->invoice->sub_total;
        $this->totalDiscount=$this->invoice->discount_amount;
        $this->totalTax=$this->invoice->tax_amount;
        $this->totalAmount=$this->invoice->total_amount;
        $this->description=$this->invoice->description;
        $this->customer_note=$this->invoice->customer_note;
        $selected=$this->invoice->details;
        foreach ($selected as $key => $product) {
            $this->selected_products[] = [
                'product_id' => $product->product_id,
                'name' => $product->product->name,
                'price' => $product->price,
                'quantity' => $product->quantity,
                'tax' => $product->tax,
                'description' => $product->description,
                'unit' => $product->unit,
                'total' => $product->total,
            ];
        }
    }
    /* delete products with foreign key delete restriction */   

    public function selectProduct(){
        if($this->product_id){
            $product=Product::where('id',$this->product_id)->first();
            $this->productPrice=$product->price;
            $this->productUnit=$product->unit;
            if($this->productQuantity==null){
                $this->productQuantity=1;
            }
            if($this->select_tax=="Yes"){
                if($this->sales_tax!=null){
                    $tax=$this->sales_tax*(($this->productPrice*$this->productQuantity)/100);
                    $this->tax=$tax;
                    $this->total=($this->productPrice*$this->productQuantity) + $tax;
                }else{
                    $this->select_tax="No";
                    $this->tax=0;
                    $this->total=($this->productPrice*$this->productQuantity);
                    $this->dispatchBrowserEvent(
                        'alert', ['type' => 'error',  'message' => 'Please Enter Sales Tax First!']);
                    return;
                }
            }else{
                $this->tax=0;
                $this->total=($this->productPrice*$this->productQuantity);
            }
        }
    }

    public function calculate(){
        if($this->productQuantity==0){
            $this->productQuantity=1;
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'error',  'message' => 'Quantity can not be 0!']);
        }
        if($this->tax=="Yes"){
            if($this->sales_tax!=null){
                $tax=$this->sales_tax*(($this->productPrice*$this->productQuantity)/100);
                $this->total_tax=$tax;
                $this->total=($this->productPrice*$this->productQuantity) + $tax;
            }else{
                $this->tax="No";
                $this->total_tax=0;
                $this->total=($this->productPrice*$this->productQuantity);
                $this->dispatchBrowserEvent(
                    'alert', ['type' => 'error',  'message' => 'Please Enter Sales Tax First!']);
                return;
            }
        }else{
            $this->total_tax=0;
            $this->total=($this->productPrice*$this->productQuantity);
        }
    }

    public function addProduct(){
        $productFound = false;
        foreach ($this->selected_products as $key => $product) {
            if ($product['product_id'] == $this->product_id) {
                $this->selected_products[$key]['quantity'] += $this->productQuantity;
                $this->selected_products[$key]['total'] += $this->total;
                $this->selected_products[$key]['tax'] += $this->tax;
                $productFound = true;
                break;
            }
        }
        if (!$productFound) {
            $product=Product::where('id',$this->product_id)->first();
            if($product){
                $this->selected_products[] = [
                    'product_id' => $this->product_id,
                    'name' => $product->name,
                    'price' => $this->productPrice,
                    'quantity' => $this->productQuantity,
                    'tax' => $this->tax,
                    'total' => $this->total,
                    'description' => $this->productdescription,
                    'unit' => $this->productUnit,
                ];
            }
        }
        $this->resetFields();
    }

    public function removeProduct($index)
    {
        unset($this->selected_products[$index]);
        $this->selected_products = array_values($this->selected_products);
    }

    public function resetFields()
    {
        $this->resetErrorBag();
        $this->product_id = '';
        $this->productPrice='';
        $this->productQuantity='';
        $this->productdescription='';
        $this->productUnit='';
        $this->tax='';
        $this->total='';
    }

    public function update(){
        $this->validate([
            'type'  => 'required',
            'customer_id'  => 'required',
            'date'  => 'required',
            'address'  => 'required',
            'first_invoice'=>'required'
        ]);
        if(count($this->selected_products) == 0)
        {
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'error','title' => 'Order Failed!',  'message' => 'Select some products!']);
            return;
        }
        if(($this->totalAmount) <= 0)
        {
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'error','title' => 'Order Failed!',  'message' => 'Total cannot be less than 0!']);
            return;
        }

        $this->invoice->type=$this->type;
        $this->invoice->date=$this->date;
        $this->invoice->customer_id=$this->customer_id;
        $this->invoice->address=$this->address;
        $this->invoice->sales_tax=$this->sales_tax;
        $this->invoice->discount=$this->discount;
        $this->invoice->maintenance_date=$this->maintenance_date;
        $this->invoice->first_invoice=$this->first_invoice;
        $this->invoice->first_due_date=$this->first_due_date;
        $this->invoice->second_invoice=$this->second_invoice;
        $this->invoice->second_due_date=$this->second_due_date;
        $this->invoice->sub_total=$this->subAmount;
        $this->invoice->discount_amount=$this->totalDiscount;
        $this->invoice->tax_amount=$this->totalTax;
        $this->invoice->total_amount=$this->totalAmount;
        $this->invoice->description=$this->description;
        $this->invoice->customer_note=$this->customer_note;
        $this->invoice->save();

        foreach ($this->selected_products as $key => $item) 
        {
            $invoiceDetail = InvoiceDetail::where('invoice_id',$this->invoice->id)->first();
            $invoiceDetail->product_id = $item['product_id'];
            $invoiceDetail->product_name = $item['name'];
            $invoiceDetail->price = $item['price'];
            $invoiceDetail->tax = $item['tax'];
            $invoiceDetail->total = $item['total'];
            $invoiceDetail->quantity = $item['quantity'];
            $invoiceDetail->unit = $item['unit'];
            $invoiceDetail->description = $item['description'];
            $invoiceDetail->save();
        }
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success','title' => 'invoice Updated!',  'message' => 'invoice #'.$this->invoice->invoice_number.' has been Updated..']);
            return redirect()->route('admin.view_invoices');
    }

    public function calculateTotalTax()
    {
        $totalTax = 0;
        foreach ($this->selected_products as $product) {
            $totalTax += $product['tax'];
        }
        $this->totalTax=$totalTax;
        return $this->totalTax;
    }

    public function calculatesubAmount()
    {
        $subAmount = 0;
        foreach ($this->selected_products as $product) {
            $subAmount += $product['total'];
        }
        $this->subAmount=$subAmount;
        return $this->subAmount;
    }

    public function calculateTotalDiscount()
    {
        $totalDiscount = 0;
        if($this->discount){
            $totalAmount = 0;
            foreach ($this->selected_products as $product) {
                $totalAmount += $product['total'];
            }
            $totalDiscount= ($totalAmount/100)*$this->discount;
        }
        $this->totalDiscount=$totalDiscount;
        return $this->totalDiscount;
    }

    public function calculateTotalAmount()
    {
        $totalAmount = 0;
        foreach ($this->selected_products as $product) {
            $totalAmount += $product['total'];
        }
        $this->totalAmount=$totalAmount-$this->totalDiscount;
        return $this->totalAmount;
    }

    public function checkper(){
        if($this->first_invoice<0 || $this->first_invoice>100){
            $this->first_invoice=0;
            $this->second_invoice=0;
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'error','title' => 'Invalid!',  'message' => 'Invoice Percentage can not be less than 0 or greater than 100!']);
            return;
        }else{
            $this->second_invoice=100-$this->first_invoice;
        }
    }
}
