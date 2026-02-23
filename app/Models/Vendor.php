<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'phone',
        'pic',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function medicinePrices()
    {
        return $this->hasMany(VendorMedicinePrice::class);
    }
}
