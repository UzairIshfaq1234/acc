<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class SaleReportExport implements FromCollection, WithHeadings
{
    protected $export;

    public function __construct($export)
    {
        $this->export = $export;
    }

    public function collection()
    {
        return $this->transformData($this->export);
    }

    public function headings(): array
    {
        return [
            'Sl',
            'Invoice Date',
            'Invoice No',
            'Customer Name',
            'Amount',
        ];
    }

    protected function transformData(array $export): Collection
    {
        return collect($export)->map(function ($invoice, $index) {

            return [
                'Sl' => $index + 1,
                'Invoice Date' => \Carbon\Carbon::parse($invoice['date'])->format('d/m/Y'),
                'Invoice No' => $invoice['invoice'],
                'Customer Name' => $invoice['customer'],
                'payment Detail'=>'Total : '.$invoice['total'],
            ];
        });
    }
}