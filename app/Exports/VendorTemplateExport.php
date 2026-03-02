<?php

namespace App\Exports;

use App\Models\Medicine;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VendorTemplateExport implements FromCollection, WithHeadings
{
    protected $vendorId;

    public function __construct($vendorId)
    {
        $this->vendorId = $vendorId;
    }

    public function collection()
    {
        return Medicine::leftJoin('vendor_medicine_prices', function ($join) {
                $join->on('medicines.id', '=', 'vendor_medicine_prices.medicine_id')
                     ->where('vendor_medicine_prices.vendor_id', $this->vendorId);
            })
            ->where('medicines.status', 1)
            ->orderBy('medicines.name')
            ->select(
                'medicines.code',
                'medicines.name',
                'medicines.category',
                'medicines.unit',
                DB::raw('COALESCE(vendor_medicine_prices.price, "") as price'),
                DB::raw('COALESCE(vendor_medicine_prices.discount_percent, "") as discount'),
            )
            ->get();
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
        ];
    }
}