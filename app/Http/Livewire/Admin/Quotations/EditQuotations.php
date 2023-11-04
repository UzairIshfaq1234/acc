<?php

namespace App\Http\Livewire\Admin\Quotations;

use Carbon\Carbon;
use App\Models\Addon;
use App\Models\Product;
use Livewire\Component;
use App\Models\Lead;
use App\Models\Quotation;
use App\Models\QuotationDetail;
use Illuminate\Support\Facades\Auth;

class EditQuotations extends Component
{
    public $quotation,$customers,$products,$product_id,$product_name,$productPrice,$productQuantity,$total,$select_tax,$sales_tax,$tax=0,$lang,$available,$quantity,$customer,$selected_products=[];
    public $subject,$created_date,$expiry_date,$customer_id,$address,$stage,$discount,$description,$customer_note,$totalTax,$totalDiscount,$totalAmount,$subAmount;
    /* render the page */
    public function render()
    {
        $this->leads = Lead::latest()->get();
        $this->products = Product::latest()->get();
        return view('livewire.admin.quotations.edit-quotations');
    }
    /* process before render */
    public function mount($id)
    {
        $this->lang = getTranslation();
        if(!Auth::user()->can('quotation_list'))
        {
            abort(404);
        }
        
        $this->quotation = Quotation::find($id);
        $this->created_date=$this->quotation->created_date;
        $this->expiry_date=$this->quotation->expiry_date;
        $this->lead_id=$this->quotation->lead_id;
        $this->address=$this->quotation->address;
        $this->stage=$this->quotation->stage;
        $this->sales_tax=$this->quotation->sales_tax;
        $this->discount=$this->quotation->discount;
        $this->subAmount=$this->quotation->sub_total;
        $this->totalDiscount=$this->quotation->discount_amount;
        $this->totalTax=$this->quotation->tax_amount;
        $this->totalAmount=$this->quotation->total_amount;
        $this->description=$this->quotation->description;
        $this->customer_note=$this->quotation->customer_note;
        $selected=$this->quotation->details;
        foreach ($selected as $key => $product) {
            $this->selected_products[] = [
                'product_id' => $product->product_id,
                'name' => $product->product->name,
                'price' => $product->price,
                'quantity' => $product->quantity,
                'description' => $product->description,
                'unit' => $product->unit,
                'tax' => $product->tax,
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
            'lead_id'  => 'required',
            'created_date'  => 'required',
            'address'  => 'required',
            'expiry_date'  => 'required',
            'stage'  => 'required',
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

        $this->quotation->created_date=$this->created_date;
        $this->quotation->expiry_date=$this->expiry_date;
        $this->quotation->lead_id=$this->lead_id;
        $this->quotation->address=$this->address;
        $this->quotation->stage=$this->stage;
        $this->quotation->sales_tax=$this->sales_tax;
        $this->quotation->discount=$this->discount;
        $this->quotation->sub_total=$this->subAmount;
        $this->quotation->discount_amount=$this->totalDiscount;
        $this->quotation->tax_amount=$this->totalTax;
        $this->quotation->total_amount=$this->totalAmount;
        $this->quotation->description=$this->description;
        $this->quotation->customer_note=$this->customer_note;
        $this->quotation->save();

        foreach ($this->selected_products as $key => $item) 
        {
            $quotationDetail = QuotationDetail::where('quotation_id',$this->quotation->id)->first();
            $quotationDetail->product_id = $item['product_id'];
            $quotationDetail->product_name = $item['name'];
            $quotationDetail->price = $item['price'];
            $quotationDetail->tax = $item['tax'];
            $quotationDetail->total = $item['total'];
            $quotationDetail->quantity = $item['quantity'];
            $quotationDetail->unit = $item['unit'];
            $quotationDetail->description = $item['description'];
            $quotationDetail->save();
        }
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success','title' => 'Quotation Updated!',  'message' => 'Quotation #'.$this->quotation->quotation_number.' has been Updated..']);
            return redirect()->route('admin.view_quotations');
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
}
