<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class InventarisController extends Controller
{
    /**
     * READ - Menampilkan semua data inventaris.
     * Dapat diakses oleh Admin, Staff, dan Penyewa.
     * Route: GET /inventaris
     */
    public function index()
    {
        Gate::authorize('viewAny', Inventaris::class);

        $inventaris = Inventaris::latest()->get();
        $totalData  = $inventaris->count();

        return view('inventaris.index', compact('inventaris', 'totalData'));
    }

    /**
     * CREATE (form) - Menampilkan form tambah aset baru.
     * Hanya Admin dan Staff.
     * Route: GET /inventaris/create
     */
    public function create()
    {
        Gate::authorize('create', Inventaris::class);

        return view('inventaris.form', [
            'mode'  => 'create',
            'aset'  => null,
        ]);
    }

    /**
     * CREATE (simpan) - Menyimpan data aset baru ke database.
     * Hanya Admin dan Staff.
     * Route: POST /inventaris
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Inventaris::class);

        $validated = $request->validate([
            'nama_aset'  => 'required|string|max:100',
            'kategori'   => 'required|string|max:50',
            'merk'       => 'required|string|max:50',
            'lokasi'     => 'required|string|max:50',
            'kondisi'    => 'required|in:Baik,Rusak Ringan,Rusak',
            'keterangan' => 'nullable|string',
        ], [
            'nama_aset.required'  => 'Nama aset wajib diisi.',
            'kategori.required'   => 'Kategori wajib dipilih.',
            'merk.required'       => 'Merk / brand wajib diisi.',
            'lokasi.required'     => 'Lokasi penempatan wajib diisi.',
            'kondisi.required'    => 'Kondisi aset wajib dipilih.',
            'kondisi.in'          => 'Pilihan kondisi tidak valid.',
        ]);

        Inventaris::create($validated);

        return redirect()->route('inventaris.index')
            ->with('flash_success', 'Data aset "' . $validated['nama_aset'] . '" berhasil ditambahkan!');
    }

    /**
     * UPDATE (form) - Menampilkan form edit aset berdasarkan ID.
     * Hanya Admin dan Staff.
     * Route: GET /inventaris/{inventaris}/edit
     */
    public function edit(Inventaris $inventaris)
    {
        Gate::authorize('update', $inventaris);

        return view('inventaris.form', [
            'mode' => 'edit',
            'aset' => $inventaris,
        ]);
    }

    /**
     * UPDATE (simpan) - Memperbarui data aset di database.
     * Hanya Admin dan Staff.
     * Route: PUT /inventaris/{inventaris}
     */
    public function update(Request $request, Inventaris $inventaris)
    {
        Gate::authorize('update', $inventaris);

        $validated = $request->validate([
            'nama_aset'  => 'required|string|max:100',
            'kategori'   => 'required|string|max:50',
            'merk'       => 'required|string|max:50',
            'lokasi'     => 'required|string|max:50',
            'kondisi'    => 'required|in:Baik,Rusak Ringan,Rusak',
            'keterangan' => 'nullable|string',
        ], [
            'nama_aset.required'  => 'Nama aset wajib diisi.',
            'kategori.required'   => 'Kategori wajib dipilih.',
            'merk.required'       => 'Merk / brand wajib diisi.',
            'lokasi.required'     => 'Lokasi penempatan wajib diisi.',
            'kondisi.required'    => 'Kondisi aset wajib dipilih.',
            'kondisi.in'          => 'Pilihan kondisi tidak valid.',
        ]);

        $inventaris->update($validated);

        return redirect()->route('inventaris.index')
            ->with('flash_success', 'Data aset "' . $validated['nama_aset'] . '" berhasil diperbarui!');
    }

    /**
     * DELETE - Menghapus data aset dari database.
     * HANYA BISA DILAKUKAN OLEH ADMIN.
     * Route: DELETE /inventaris/{inventaris}
     */
    public function destroy(Inventaris $inventaris)
    {
        Gate::authorize('delete', $inventaris);

        $namaAset = $inventaris->nama_aset;
        $inventaris->delete();

        return redirect()->route('inventaris.index')
            ->with('flash_success', 'Data aset "' . $namaAset . '" berhasil dihapus!');
    }
}
