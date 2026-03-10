<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FarmasiCompareExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return DB::table('medicines')
            ->leftJoin('vendor_medicine_prices', function ($join) {
                $join->on('medicines.id','=','vendor_medicine_prices.medicine_id');
            })
            ->select(
                'medicines.code',
                'medicines.name',
                DB::raw('MIN(vendor_medicine_prices.final_price) as cheapest_price'),
                DB::raw('MAX(vendor_medicine_prices.updated_at) as last_update')
            )
            ->where('medicines.status',1)
            ->groupBy('medicines.id')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Code',
            'Name',
            'Cheapest Price',
            'Last Update'
        ];
    }
}
