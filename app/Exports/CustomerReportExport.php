<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class CustomerReportExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->transformData($this->data);
    }

    public function headings(): array
    {
        return [
            'Sl',
            'Name',
            'Orders Sum Total',
        ];
    }

    protected function transformData(array $data): Collection
    {
        return collect($data)->map(function ($item, $index) {

            return [
                'Sl' => $index + 1,
                'Name' => $item['name'],
                'Orders Sum Total' => $item['invoices_sum_total_amount'],
            ];
        });
    }
}