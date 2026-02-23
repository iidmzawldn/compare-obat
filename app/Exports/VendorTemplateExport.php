<?php

namespace App\Exports;

use App\Models\Medicine;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VendorTemplateExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Medicine::where('status',1)
            ->get(['code','name','category','unit'])
            ->map(function($item){
                return [
                    'code' => $item->code,
                    'name' => $item->name,
                    'category' => $item->category,
                    'unit' => $item->unit,
                    'price' => '',
                    'discount' => '',
                    'stock' => '',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'code',
            'name',
            'category',
            'unit',
            'price',
            'discount',
            'stock',
        ];
    }
}