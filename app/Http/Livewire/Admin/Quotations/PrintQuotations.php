<?php

namespace App\Http\Livewire\Admin\Quotations;

use App\Models\MasterSetting;
use App\Models\Quotation;
use Livewire\Component;

class PrintQuotations extends Component
{
    public $printer,$quotation,$store_name,$store_email,$store_phone,$address,$lang;
    /* render the page */
    public function render()
    {
        $printer =$this->printer;
        return view('livewire.admin.quotations.print-quotations')->layout('layouts.print_layout',['printer' => $printer]);
    }
    /* process before render */
    public function mount($quotation,$printer)
    {
        $this->printer = $printer;
        $this->quotation =Quotation::find($quotation);
        if(!$this->quotation)
        {
            abort(404);
        }

        $settings = new MasterSetting();
        $site = $settings->siteData();
        $this->store_name = $site['store_name'] ?? 'B2B';
        $this->store_email = $site['store_email'] ?? 'b2b@store.com';
        $this->store_phone = $site['store_phone'] ?? '123456';
        $this->address = $site['address'] ?? '-';
        $this->lang = getTranslation();
    }
}
