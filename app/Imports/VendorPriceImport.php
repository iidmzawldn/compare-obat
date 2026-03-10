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

     public function headingRow(): int
    {
        return 4; // karena header ada di row 4
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {

            $rowNumber = $index + 2; // karena heading row

            $this->total++;

            $code = trim($row['code'] ?? '');
            $priceRaw = trim($row['price'] ?? '');

            if ($code === '') {
                throw new \Exception("Kode kosong di baris {$rowNumber}");
            }

            if ($priceRaw === '') {
                throw new \Exception("Harga kosong di baris {$rowNumber}");
            }

            // Bersihkan angka
            $priceRaw = str_replace(['.', ','], ['', '.'], $priceRaw);

            if (! is_numeric($priceRaw)) {
                throw new \Exception("Harga tidak valid di baris {$rowNumber}");
            }

            $price = (float) $priceRaw;

            if ($price <= 0) {
                throw new \Exception("Harga harus lebih dari 0 di baris {$rowNumber}");
            }

            $medicine = Medicine::where('code', $code)->first();

            if (! $medicine) {
                throw new \Exception("Kode obat {$code} tidak ditemukan (baris {$rowNumber})");
            }

            // Optional discount
            $discountPercent = 0;

            $discountRaw = trim(
                $row['discount_percent']
                ?? $row['discount']
                ?? $row['diskon']
                ?? ''
            );

            if ($discountRaw !== '') {

                $discountRaw = str_replace(['%', ',', '.'], ['', '.', ''], $discountRaw);

                if (! is_numeric($discountRaw)) {
                    throw new \Exception("Format diskon salah di baris {$rowNumber}");
                }

                $discountPercent = (float) $discountRaw;

                if ($discountPercent < 0 || $discountPercent > 100) {
                    throw new \Exception("Diskon harus 0-100% di baris {$rowNumber}");
                }
            }

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
