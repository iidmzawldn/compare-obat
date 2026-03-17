<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Vendor;
use App\Models\VendorMedicinePrice;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function redirect()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('farmasi')) {
            return redirect()->route('farmasi.dashboard');
        }

        if ($user->hasRole('vendor')) {
            return redirect()->route('vendor.dashboard');
        }

        abort(403);
    }

    public function admin()
    {

        $totalMedicines = Medicine::count();
        $totalVendors = Vendor::count();
        $totalPrices = VendorMedicinePrice::count();

        $priceDifferences = VendorMedicinePrice::select(
            'medicine_id',
            DB::raw('MAX(final_price) as max_price'),
            DB::raw('MIN(final_price) as min_price'),
            DB::raw('(MAX(final_price) - MIN(final_price)) as selisih')
        )
            ->with('medicine')
            ->groupBy('medicine_id')
            ->orderByDesc('selisih')
            ->take(5)
            ->get();

        $vendorRanking = VendorMedicinePrice::select(
            'vendor_id',
            DB::raw('AVG(final_price) as avg_price')
        )
            ->with('vendor')
            ->groupBy('vendor_id')
            ->orderBy('avg_price')
            ->take(5)
            ->get();

        $chartData = VendorMedicinePrice::select(
            'vendor_id',
            DB::raw('COUNT(medicine_id) as total_obat')
        )
            ->with('vendor')
            ->groupBy('vendor_id')
            ->get();

        return view('admin.dashboard', compact(
            'totalMedicines',
            'totalVendors',
            'totalPrices',
            'priceDifferences',
            'vendorRanking',
            'chartData'
        ));
    }

    public function farmasi()
    {
        $totalMedicines = Medicine::where('status', 1)->count();

        $totalVendors = Vendor::where('status', 1)->count();

        $totalPrices = VendorMedicinePrice::count();

        // obat yang belum ada harga vendor
        $medicineNoPrice = Medicine::where('status', 1)
            ->whereDoesntHave('vendorPrices')
            ->count();

        // harga yang terakhir diupdate
        $recentPrices = VendorMedicinePrice::with(['medicine', 'vendor'])
            ->latest('updated_at')
            ->limit(10)
            ->get();

        return view('farmasi.dashboard', compact(
            'totalMedicines',
            'totalVendors',
            'totalPrices',
            'medicineNoPrice',
            'recentPrices'
        ));
    }

    public function vendor()
    {
        $vendor = auth()->user()->vendor;

        $totalMedicines = Medicine::count();

        $totalPrices = VendorMedicinePrice::where('vendor_id', $vendor->id)->count();

        $lastUpload = VendorMedicinePrice::where('vendor_id', $vendor->id)
            ->latest()
            ->first();

        $notFilled = $totalMedicines - $totalPrices;

        return view('vendor.dashboard', compact(
            'totalMedicines',
            'totalPrices',
            'notFilled',
            'lastUpload'
        ));
    }
}
