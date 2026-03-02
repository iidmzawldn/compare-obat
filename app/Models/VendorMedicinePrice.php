<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorMedicinePrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'medicine_id',
        'price',
        'discount_percent',
        'final_price',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
