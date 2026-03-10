<?php

namespace App\Exports;

use App\Models\Medicine;
use App\Models\VendorMedicinePrice;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ComparePriceExport implements 
    FromCollection,
    WithHeadings,
    WithEvents,
    ShouldAutoSize
{

    public function collection()
    {

        return Medicine::query()
            ->where('status',1)

            ->leftJoin('vendor_medicine_prices','medicines.id','=','vendor_medicine_prices.medicine_id')

            ->select(
                'medicines.code',
                'medicines.name',
                'medicines.category',

                DB::raw('
                    (
                        SELECT vendors.name
                        FROM vendor_medicine_prices vmp
                        JOIN vendors ON vendors.id = vmp.vendor_id
                        WHERE vmp.medicine_id = medicines.id
                        ORDER BY vmp.final_price ASC
                        LIMIT 1
                    ) as cheapest_vendor
                '),

                DB::raw('
                    (
                        SELECT final_price
                        FROM vendor_medicine_prices
                        WHERE medicine_id = medicines.id
                        ORDER BY final_price ASC
                        LIMIT 1
                    ) as cheapest_price
                '),

                DB::raw('COUNT(vendor_medicine_prices.id) as total_vendor'),

                DB::raw('MAX(vendor_medicine_prices.updated_at) as last_update')

            )

            ->groupBy(
                'medicines.id',
                'medicines.code',
                'medicines.name',
                'medicines.category'
            )

            ->orderBy('medicines.name')

            ->get();
    }

    public function headings(): array
    {
        return [

            'CODE',
            'NAME',
            'CATEGORY',
            'VENDOR TERMURAH',
            'HARGA TERMURAH',
            'JUMLAH VENDOR',
            'LAST UPDATE'

        ];
    }

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                // insert title
                $sheet->insertNewRowBefore(1, 2);

                $sheet->setCellValue('A1', 'LAPORAN PERBANDINGAN HARGA OBAT');
                $sheet->mergeCells('A1:G1');

                $sheet->setCellValue('A2', 'Tanggal Export : '.now()->format('d-m-Y'));

                // style title
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);

                // header style
                $sheet->getStyle('A3:G3')->applyFromArray([
                    'font'=>[
                        'bold'=>true,
                        'color'=>['rgb'=>'FFFFFF']
                    ],
                    'fill'=>[
                        'fillType'=>Fill::FILL_SOLID,
                        'startColor'=>['rgb'=>'1F4E78']
                    ]
                ]);

                // freeze header
                $sheet->freezePane('A4');

            }

        ];
    }
}