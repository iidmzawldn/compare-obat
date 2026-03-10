<?php

namespace App\Exports;

use App\Models\Medicine;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Protection;

class VendorTemplateExport implements 
    FromCollection, 
    WithHeadings, 
    WithEvents,
    ShouldAutoSize
{
    protected $vendorId;
    protected $rowCount;

    public function __construct($vendorId)
    {
        $this->vendorId = $vendorId;
    }

    public function collection()
    {
        $data = Medicine::leftJoin('vendor_medicine_prices', function ($join) {
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
                DB::raw('COALESCE(vendor_medicine_prices.discount_percent, "") as discount')
            )
            ->get();

        $this->rowCount = $data->count() + 4; // + heading offset

        return $data;
    }

    public function headings(): array
    {
        return [
            'CODE',
            'NAME',
            'CATEGORY',
            'UNIT',
            'PRICE',
            'DISCOUNT',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                // ====== JUDUL ======
                $sheet->insertNewRowBefore(1, 3);

                $sheet->setCellValue('A1', 'TEMPLATE UPLOAD HARGA OBAT VENDOR');
                $sheet->mergeCells('A1:F1');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

                $sheet->setCellValue('A2', 'Isi hanya kolom PRICE dan DISCOUNT (%)');
                $sheet->mergeCells('A2:F2');

                $sheet->setCellValue('A3', 'Kolom CODE, NAME, CATEGORY, UNIT tidak boleh diubah.');
                $sheet->mergeCells('A3:F3');

                // ====== HEADER STYLE ======
                $sheet->getStyle('A4:F4')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '1F4E78'],
                    ],
                ]);

                // Freeze header
                $sheet->freezePane('A5');

                // ====== PROTEKSI TANPA PASSWORD ======
                $sheet->getProtection()->setSheet(true);

                // Lock semua dulu
                $sheet->getStyle('A1:F'.$this->rowCount)
                    ->getProtection()
                    ->setLocked(Protection::PROTECTION_PROTECTED);

                // Unlock hanya kolom price & discount
                $sheet->getStyle('E5:F'.$this->rowCount)
                    ->getProtection()
                    ->setLocked(Protection::PROTECTION_UNPROTECTED);
            }
        ];
    }
}