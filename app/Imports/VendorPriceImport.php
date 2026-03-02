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

            // Bersihkan input dasar
            $code = trim($row['code'] ?? '');
            $priceRaw = trim($row['price'] ?? '');

            // 🔥 Flexible discount reader
            $discountRaw = trim(
                $row['discount_percent']
                ?? $row['discount']
                ?? $row['diskon']
                ?? $row['discount_']
                ?? ''
            );

            // Validasi wajib
            if ($code === '' || $priceRaw === '') {
                $this->skipped++;

                continue;
            }

            // Bersihkan format angka (hapus titik ribuan, ubah koma jadi titik)
            $priceRaw = str_replace(['.', ','], ['', '.'], $priceRaw);

            if (! is_numeric($priceRaw)) {
                $this->skipped++;

                continue;
            }

            $price = (float) $priceRaw;

            if ($price <= 0) {
                $this->skipped++;

                continue;
            }

            // Default discount 0
            $discountPercent = 0;

            if ($discountRaw !== '') {

                $discountRaw = str_replace(['%', ',', '.'], ['', '.', ''], $discountRaw);

                if (is_numeric($discountRaw)) {
                    $discountPercent = (float) $discountRaw;

                    // Batasi 0 - 100
                    if ($discountPercent < 0 || $discountPercent > 100) {
                        $this->skipped++;

                        continue;
                    }
                }
            }

            $medicine = Medicine::where('code', $code)->first();

            if (! $medicine) {
                $this->skipped++;

                continue;
            }

            // Hitung final price
            $finalPrice = round(
                $price - ($price * $discountPercent / 100),
                2
            );

            VendorMedicinePrice::updateOrCreate(
                [
                    'vendor_id' => $this->vendorId,
                    'medicine_id' => $medicine->id,
                ],
                [
                    'price' => $price,
                    'discount_percent' => $discountPercent,
                    'final_price' => $finalPrice,
                ]
            );

            $this->success++;
        }
    }
}
