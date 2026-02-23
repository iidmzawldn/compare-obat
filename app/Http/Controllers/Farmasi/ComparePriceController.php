<?php

namespace App\Http\Controllers\Farmasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\VendorMedicinePrice;

class ComparePriceController extends Controller
{
    public function index(Request $request)
    {
        $query = Medicine::where('status',1);

        if ($request->search) {
            $query->where(function($q) use ($request){
                $q->where('name','like','%'.$request->search.'%')
                  ->orWhere('code','like','%'.$request->search.'%');
            });
        }

        $medicines = $query
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('farmasi.compare.index', compact('medicines'));
    }

    public function show(Medicine $medicine)
    {
        $prices = VendorMedicinePrice::with('vendor')
            ->where('medicine_id', $medicine->id)
            ->orderBy('price','asc')
            ->get();

        return view('farmasi.compare.show', compact('medicine','prices'));
    }
}
