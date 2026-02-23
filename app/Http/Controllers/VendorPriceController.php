<?php

namespace App\Http\Controllers;

use App\Exports\VendorTemplateExport;
use App\Imports\VendorPriceImport;
use App\Models\VendorMedicinePrice;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class VendorPriceController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST HARGA VENDOR
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $vendor = auth()->user()->vendor;

        $query = VendorMedicinePrice::with('medicine')
            ->where('vendor_id', $vendor->id);

        if ($request->search) {
            $query->whereHas('medicine', function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                    ->orWhere('code', 'like', '%'.$request->search.'%');
            });
        }

        $prices = $query
            ->orderByDesc('updated_at')
            ->paginate(20)
            ->withQueryString();

        return view('vendor.prices.index', compact('prices'));
    }

    /*
    |--------------------------------------------------------------------------
    | FORM UPLOAD
    |--------------------------------------------------------------------------
    */

    public function uploadForm()
    {
        return view('vendor.prices.upload');
    }

    /*
    |--------------------------------------------------------------------------
    | PROSES UPLOAD HARGA
    |--------------------------------------------------------------------------
    */

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $vendor = auth()->user()->vendor;

        try {

            $import = new VendorPriceImport($vendor->id);

            Excel::import($import, $request->file('file'));

            return redirect()
                ->route('vendor.prices.index')
                ->with('success',
                    "Upload selesai. Total: {$import->total} | Berhasil: {$import->success} | Dilewati: {$import->skipped}"
                );

        } catch (\Exception $e) {

            return back()
                ->with('error', 'Upload gagal. Periksa format file.');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD TEMPLATE HARGA
    |--------------------------------------------------------------------------
    */

    public function downloadTemplate()
    {
        return Excel::download(
            new VendorTemplateExport,
            'template_harga_obat.xlsx'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS HARGA (OPSIONAL)
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $vendor = auth()->user()->vendor;

        $price = VendorMedicinePrice::where('vendor_id', $vendor->id)
            ->where('id', $id)
            ->firstOrFail();

        $price->delete();

        return back()->with('success', 'Data harga berhasil dihapus.');
    }
}
