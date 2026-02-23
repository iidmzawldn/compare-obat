<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST VENDOR
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $vendors = Vendor::latest()->paginate(10);

        return view('admin.vendors.index', compact('vendors'));
    }

    /*
    |--------------------------------------------------------------------------
    | FORM CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $users = User::role('vendor')->get();

        return view('admin.vendors.create', compact('users'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'pic' => 'required',
            'status' => 'required',
        ]);

        Vendor::create($request->all());

        return redirect()
            ->route('admin.vendors.index')
            ->with('success', 'Vendor berhasil ditambahkan');
    }

    /*
    |--------------------------------------------------------------------------
    | FORM EDIT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $vendor = Vendor::findOrFail($id);
        $users = User::role('vendor')->get();

        return view('admin.vendors.edit', compact('vendor', 'users'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required',
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'pic' => 'required',
            'status' => 'required',
        ]);

        $vendor = Vendor::findOrFail($id);
        $vendor->update($request->all());

        return redirect()
            ->route('admin.vendors.index')
            ->with('success', 'Vendor berhasil diperbarui');
    }

    /*
    |--------------------------------------------------------------------------
    | NONAKTIFKAN VENDOR (GANTI DELETE)
    |--------------------------------------------------------------------------
    */
    public function nonaktif($id)
    {
        Vendor::findOrFail($id)->update(['status' => 0]);

        return back()->with('warning', 'Vendor dinonaktifkan');
    }

    /*
    |--------------------------------------------------------------------------
    | AKTIFKAN KEMBALI
    |--------------------------------------------------------------------------
    */
    public function aktifkan($id)
    {
        Vendor::findOrFail($id)->update(['status' => 1]);

        return back()->with('success', 'Vendor diaktifkan kembali');
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        try {
            $vendor = Vendor::findOrFail($id);

            $vendor->delete();

            return redirect()
                ->route('admin.vendors.index')
                ->with('success', 'Vendor berhasil dihapus');
        } catch (\Exception $e) {

            return redirect()
                ->route('admin.vendors.index')
                ->with('error', 'Vendor gagal dihapus');
        }
    }
}
