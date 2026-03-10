<?php

namespace App\Http\Controllers\Farmasi;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\Vendor;
use App\Models\VendorMedicinePrice;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ComparePriceExport;

class ComparePriceController extends Controller
{
    public function index(Request $request)
    {
        $query = Medicine::query()
            ->where('status', 1);

        // SEARCH
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                    ->orWhere('code', 'like', '%'.$request->search.'%');
            });
        }

        // FILTER CATEGORY
        if ($request->category) {
            $query->where('category', $request->category);
        }

        // HARGA TERMURAH
        $query->addSelect([

            'cheapest_price' => VendorMedicinePrice::select('final_price')
                ->whereColumn('medicine_id', 'medicines.id')
                ->orderBy('final_price')
                ->limit(1),

            'cheapest_vendor_id' => VendorMedicinePrice::select('vendor_id')
                ->whereColumn('medicine_id', 'medicines.id')
                ->orderBy('final_price')
                ->limit(1),

            'last_update' => VendorMedicinePrice::select('updated_at')
                ->whereColumn('medicine_id', 'medicines.id')
                ->orderBy('updated_at','desc')
                ->limit(1),
        ]);

        // HITUNG VENDOR
        $query->withCount('vendorPrices');

        $medicines = $query
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        // LIST KATEGORI
        $categories = Medicine::where('status', 1)
            ->distinct()
            ->pluck('category');

        return view('farmasi.compare.index', compact(
            'medicines',
            'categories'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL VENDOR PER OBAT
    |--------------------------------------------------------------------------
    */

    public function show(Medicine $medicine)
    {
        $prices = VendorMedicinePrice::with('vendor')
            ->where('medicine_id', $medicine->id)
            ->orderBy('final_price', 'asc')
            ->get();

        return view('farmasi.compare.show', compact(
            'medicine',
            'prices'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT EXCEL COMPARE
    |--------------------------------------------------------------------------
    */

    public function export(Request $request)
    {
        return Excel::download(
            new ComparePriceExport($request),
            'compare_harga_obat.xlsx'
        );
    }
}