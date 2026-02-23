<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\MedicineImport;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Medicine::query();

        if ($request->search) {
            $query->where('name', 'like', '%'.$request->search.'%')
                ->orWhere('code', 'like', '%'.$request->search.'%');
        }

        $medicines = $query->latest()->paginate(10);

        return view('admin.medicines.index', compact('medicines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.medicines.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:medicines',
            'name' => 'required',
            'unit' => 'required',
        ]);

        Medicine::create($request->all());

        return redirect()
            ->route('admin.medicines.index')
            ->with('success', 'Obat berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $medicine = Medicine::findOrFail($id);

        return view('admin.medicines.edit', compact('medicine'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $medicine = Medicine::findOrFail($id);

        $request->validate([
            'code' => 'required',
            'name' => 'required',
            'category' => 'required',
            'unit' => 'required',
        ]);

        $medicine->update([
            'code' => $request->code,
            'name' => $request->name,
            'category' => $request->category,
            'unit' => $request->unit,
            'status' => $request->status ?? 1,
        ]);

        return redirect()
            ->route('admin.medicines.index')
            ->with('success', 'Data obat berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->delete();

        return redirect()
            ->route('admin.medicines.index')
            ->with('success', 'Obat berhasil dihapus');
    }

    public function downloadTemplate()
    {
        $filePath = public_path('templates/template_master_obat.xlsx');

        return response()->download($filePath);
    }

    public function uploadForm()
    {
        return view('admin.medicines.upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new MedicineImport, $request->file('file'));

        return redirect()
            ->route('admin.medicines.index')
            ->with('success', 'Master obat berhasil diupload');
    }
}
