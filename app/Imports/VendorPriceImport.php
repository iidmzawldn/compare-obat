<?php

namespace App\Imports;

use App\Models\Medicine;
use App\Models\VendorMedicinePrice;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VendorPriceImport implements ToCollection, WithHeadingRow
{
    protected $vendorId;

    public $success = 0;

    public $skipped = 0;

    public $total = 0;

    public function __construct($vendorId)
    {
        $this->vendorId = $vendorId;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $this->total++;

            if (empty($row['code']) || empty($row['price'])) {
                $this->skipped++;

                continue;
            }

            $medicine = Medicine::where('code', trim($row['code']))->first();

            if (! $medicine) {
                $this->skipped++;

                continue;
            }

            VendorMedicinePrice::updateOrCreate(
                [
                    'vendor_id' => $this->vendorId,
                    'medicine_id' => $medicine->id,
                ],
                [
                    'price' => $row['price'],
                    'discount' => $row['discount'] ?? null,
                    'stock' => $row['stock'] ?? null,
                ]
            );

            $this->success++;
        }
    }
}
