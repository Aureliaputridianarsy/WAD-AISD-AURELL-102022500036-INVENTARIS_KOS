<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use Illuminate\Http\Request;

class InventarisController extends Controller
{
    /**
     * READ - Menampilkan semua data inventaris.
     * Route: GET /inventaris
     */
    public function index()
    {
        $inventaris = Inventaris::latest()->get();
        $totalData  = $inventaris->count();

        return view('inventaris.index', compact('inventaris', 'totalData'));
    }

    /**
     * CREATE (form) - Menampilkan form tambah aset baru.
     * Route: GET /inventaris/create
     */
    public function create()
    {
        return view('inventaris.form', [
            'mode'  => 'create',
            'aset'  => null,
        ]);
    }

    /**
     * CREATE (simpan) - Menyimpan data aset baru ke database.
     * Route: POST /inventaris
     */
    public function store(Request $request)
    {
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
     * Route: GET /inventaris/{inventaris}/edit
     */
    public function edit(Inventaris $inventaris)
    {
        return view('inventaris.form', [
            'mode' => 'edit',
            'aset' => $inventaris,
        ]);
    }

    /**
     * UPDATE (simpan) - Memperbarui data aset di database.
     * Route: PUT /inventaris/{inventaris}
     */
    public function update(Request $request, Inventaris $inventaris)
    {
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
     * Route: DELETE /inventaris/{inventaris}
     */
    public function destroy(Inventaris $inventaris)
    {
        $namaAset = $inventaris->nama_aset;
        $inventaris->delete();

        return redirect()->route('inventaris.index')
            ->with('flash_success', 'Data aset "' . $namaAset . '" berhasil dihapus!');
    }
}
