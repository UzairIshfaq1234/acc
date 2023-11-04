<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class DaywiseReportExport implements FromCollection, WithHeadings
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
            'Date',
            'No of Orders',
            'Sales Total',
        ];
    }

    protected function transformData(array $data): Collection
    {
        return collect($data)->map(function ($item, $index) {

            return [
                'Sl' => $index + 1,
                'Date' => Carbon::parse($item['date'])->format('d/m/Y'),
                'No of Orders' => $item['count'],
                'Sales Total' => $item['total'],
            ];
        });
    }
}