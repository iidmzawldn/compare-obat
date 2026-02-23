<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'category',
        'unit',
        'status',
    ];
    
    public function vendorPrices()
    {
        return $this->hasMany(VendorMedicinePrice::class);
    }
}
