@extends('layouts.app')

@section('title', $mode === 'create' ? 'Tambah Aset Baru' : 'Edit Aset: ' . $aset->nama_aset)
@section('breadcrumb', $mode === 'create' ? 'Tambah Aset Baru' : 'Edit Aset')

@push('styles')
<style>
    .form-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 28px;
    }
    .form-header-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }
    .form-header-icon.create { background: linear-gradient(135deg, #3d4afe, #5c6bff); color: white; }
    .form-header-icon.edit   { background: linear-gradient(135deg, #f59e0b, #fbbf24); color: white; }

    .form-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 16px rgba(0,0,0,0.07);
        overflow: hidden;
    }
    .form-card-header {
        padding: 20px 28px;
        border-bottom: 1px solid #f0f2f8;
        background: #fafbff;
    }
    .form-card-body {
        padding: 28px;
    }

    .form-label {
        font-weight: 600;
        font-size: 0.875rem;
        color: #374151;
        margin-bottom: 6px;
    }

    .form-control,
    .form-select {
        border-radius: 8px;
        border: 1.5px solid #e5e7eb;
        padding: 10px 14px;
        font-size: 0.9rem;
        transition: all 0.2s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #3d4afe;
        box-shadow: 0 0 0 3px rgba(61, 74, 254, 0.12);
    }

    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: #dc3545;
    }

    .invalid-feedback {
        font-size: 0.8rem;
        margin-top: 4px;
    }

    .input-icon-wrapper {
        position: relative;
    }
    .input-icon-wrapper .input-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ba3b2;
        font-size: 1rem;
        pointer-events: none;
    }
    .input-icon-wrapper .form-control,
    .input-icon-wrapper .form-select {
        padding-left: 36px;
    }

    .section-divider {
        border: none;
        border-top: 1px dashed #e5e7eb;
        margin: 24px 0;
    }

    .section-title {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #9ba3b2;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .section-title::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e5e7eb;
    }

    .info-sidebar-card {
        background: white;
        border-radius: 14px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        overflow: hidden;
    }
    .info-sidebar-card .card-header-custom {
        padding: 16px 20px;
        background: linear-gradient(135deg, #f8f9ff, #eef0ff);
        border-bottom: 1px solid #e8ecf0;
    }
    .info-sidebar-card .card-body-custom {
        padding: 20px;
    }

    .info-item {
        display: flex;
        gap: 12px;
        margin-bottom: 14px;
        align-items: flex-start;
    }
    .info-item:last-child { margin-bottom: 0; }
    .info-item .info-bullet {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: #e8eaff;
        color: #3d4afe;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        flex-shrink: 0;
        margin-top: 1px;
    }
    .info-item p {
        font-size: 0.83rem;
        color: #6b7280;
        margin: 0;
        line-height: 1.5;
    }
    .info-item p strong {
        color: #374151;
    }

    .kondisi-preview {
        margin-top: 8px;
    }
    .kondisi-option {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 0.83rem;
        margin-bottom: 4px;
    }
    .kondisi-option.baik   { background: #d1fae5; color: #065f46; }
    .kondisi-option.rusak-ringan { background: #fef3c7; color: #92400e; }
    .kondisi-option.rusak  { background: #fee2e2; color: #991b1b; }

    .btn-submit {
        background: linear-gradient(135deg, #3d4afe, #5c6bff);
        border: none;
        color: white;
        padding: 11px 28px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(61,74,254,0.3);
    }
    .btn-submit:hover {
        background: linear-gradient(135deg, #3038e0, #4d5cf0);
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(61,74,254,0.4);
        color: white;
    }
    .btn-submit.edit {
        background: linear-gradient(135deg, #f59e0b, #fbbf24);
        box-shadow: 0 4px 12px rgba(245,158,11,0.3);
    }
    .btn-submit.edit:hover {
        background: linear-gradient(135deg, #d97706, #f59e0b);
        box-shadow: 0 6px 16px rgba(245,158,11,0.4);
    }
</style>
@endpush

@section('content')

{{-- ===== FORM HEADER ===== --}}
<div class="form-header">
    <div class="form-header-icon {{ $mode }}">
        @if($mode === 'create')
            <i class="bi bi-plus-circle-fill"></i>
        @else
            <i class="bi bi-pencil-square"></i>
        @endif
    </div>
    <div>
        <h1 class="fw-bold mb-0" style="font-size: 1.5rem; color: #1a1d23;">
            {{ $mode === 'create' ? 'Tambah Aset Baru' : 'Edit Aset Inventaris' }}
        </h1>
        <p class="text-muted mb-0 mt-1" style="font-size: 0.88rem;">
            {{ $mode === 'create'
                ? 'Isi formulir di bawah untuk menambahkan aset baru ke database inventaris.'
                : 'Perbarui informasi aset: ' . $aset->nama_aset
            }}
        </p>
    </div>
</div>

<div class="row">
    {{-- ===== KOLOM FORM UTAMA ===== --}}
    <div class="col-lg-8 mb-4">
        <div class="form-card">
            <div class="form-card-header">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-ui-checks text-primary"></i>
                    <span class="fw-semibold" style="font-size: 0.9rem;">
                        {{ $mode === 'create' ? 'Form Tambah Aset' : 'Form Edit Aset' }}
                    </span>
                    <span class="badge bg-light text-muted border ms-auto">
                        Tabel: <code>inventaris</code>
                    </span>
                </div>
            </div>
            <div class="form-card-body">

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show py-3 mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Terdapat {{ $errors->count() }} kesalahan:</strong>
                        <ul class="mb-0 mt-1 ps-3">
                            @foreach ($errors->all() as $error)
                                <li class="small">{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Tentukan action dan method form berdasarkan mode --}}
                @if($mode === 'create')
                    <form action="{{ route('inventaris.store') }}" method="POST" id="inventarisForm">
                    @csrf
                @else
                    <form action="{{ route('inventaris.update', $aset->id) }}" method="POST" id="inventarisForm">
                    @csrf
                    @method('PUT')
                @endif

                    {{-- ===== BAGIAN 1: IDENTITAS ASET ===== --}}
                    <div class="section-title">
                        <i class="bi bi-tag"></i> Identitas Aset
                    </div>

                    <div class="mb-4">
                        <label for="nama_aset" class="form-label">
                            Nama Aset / Barang <span class="text-danger">*</span>
                        </label>
                        <div class="input-icon-wrapper">
                            <i class="bi bi-box input-icon"></i>
                            <input
                                type="text"
                                class="form-control @error('nama_aset') is-invalid @enderror"
                                id="nama_aset"
                                name="nama_aset"
                                value="{{ old('nama_aset', $aset->nama_aset ?? '') }}"
                                placeholder="Contoh: AC Panasonic 1/2 PK, Springbed Queen Size"
                                required
                            >
                        </div>
                        @error('nama_aset')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="kategori" class="form-label">
                                Kategori <span class="text-danger">*</span>
                            </label>
                            <div class="input-icon-wrapper">
                                <i class="bi bi-grid input-icon"></i>
                                <select
                                    class="form-select @error('kategori') is-invalid @enderror"
                                    id="kategori"
                                    name="kategori"
                                    required
                                >
                                    <option value="" disabled {{ old('kategori', $aset->kategori ?? '') === '' ? 'selected' : '' }}>
                                        -- Pilih Kategori --
                                    </option>
                                    @foreach(['Elektronik', 'Furniture', 'Sanitasi / Kamar Mandi', 'Peralatan Kebersihan', 'Perlengkapan Keamanan', 'Lainnya'] as $kat)
                                        <option value="{{ $kat }}"
                                            {{ old('kategori', $aset->kategori ?? '') === $kat ? 'selected' : '' }}>
                                            {{ $kat }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('kategori')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="merk" class="form-label">
                                Merk / Brand <span class="text-danger">*</span>
                            </label>
                            <div class="input-icon-wrapper">
                                <i class="bi bi-award input-icon"></i>
                                <input
                                    type="text"
                                    class="form-control @error('merk') is-invalid @enderror"
                                    id="merk"
                                    name="merk"
                                    value="{{ old('merk', $aset->merk ?? '') }}"
                                    placeholder="Contoh: Samsung, Informa, Panasonic"
                                    required
                                >
                            </div>
                            @error('merk')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="section-divider">

                    {{-- ===== BAGIAN 2: LOKASI & KONDISI ===== --}}
                    <div class="section-title">
                        <i class="bi bi-geo-alt"></i> Lokasi & Kondisi
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="lokasi" class="form-label">
                                Lokasi Penempatan <span class="text-danger">*</span>
                            </label>
                            <div class="input-icon-wrapper">
                                <i class="bi bi-geo-alt-fill input-icon text-danger"></i>
                                <input
                                    type="text"
                                    class="form-control @error('lokasi') is-invalid @enderror"
                                    id="lokasi"
                                    name="lokasi"
                                    value="{{ old('lokasi', $aset->lokasi ?? '') }}"
                                    placeholder="Contoh: Kamar 101, Dapur Bersama, Lobby"
                                    required
                                >
                            </div>
                            @error('lokasi')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="kondisi" class="form-label">
                                Kondisi Aset <span class="text-danger">*</span>
                            </label>
                            <div class="input-icon-wrapper">
                                <i class="bi bi-heart-pulse input-icon"></i>
                                <select
                                    class="form-select @error('kondisi') is-invalid @enderror"
                                    id="kondisi"
                                    name="kondisi"
                                    required
                                    onchange="updateKondisiPreview(this.value)"
                                >
                                    @foreach(['Baik', 'Rusak Ringan', 'Rusak'] as $kond)
                                        <option value="{{ $kond }}"
                                            {{ old('kondisi', $aset->kondisi ?? 'Baik') === $kond ? 'selected' : '' }}>
                                            {{ $kond }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('kondisi')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            {{-- Preview kondisi yang dipilih --}}
                            <div id="kondisiPreview" class="kondisi-preview"></div>
                        </div>
                    </div>

                    <hr class="section-divider">

                    {{-- ===== BAGIAN 3: KETERANGAN ===== --}}
                    <div class="section-title">
                        <i class="bi bi-chat-text"></i> Catatan Tambahan
                    </div>

                    <div class="mb-4">
                        <label for="keterangan" class="form-label">Keterangan / Catatan</label>
                        <textarea
                            class="form-control @error('keterangan') is-invalid @enderror"
                            id="keterangan"
                            name="keterangan"
                            rows="3"
                            placeholder="Contoh: Tanggal pembelian, riwayat servis, nomor seri, atau catatan kondisi khusus..."
                        >{{ old('keterangan', $aset->keterangan ?? '') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted mt-1">
                            <i class="bi bi-info-circle me-1"></i>Opsional — isi jika ada informasi tambahan yang perlu dicatat.
                        </div>
                    </div>

                    {{-- ===== TOMBOL AKSI ===== --}}
                    <div class="d-flex justify-content-between align-items-center pt-2 border-top mt-2">
                        <a href="{{ route('inventaris.index') }}" class="btn btn-outline-secondary px-4" id="btn-kembali">
                            <i class="bi bi-arrow-left me-1"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-submit {{ $mode }}" id="btn-submit-form">
                            @if($mode === 'create')
                                <i class="bi bi-save me-1"></i>Simpan ke Database
                            @else
                                <i class="bi bi-check-circle me-1"></i>Perbarui Data
                            @endif
                        </button>
                    </div>

                </form>
            </div>
        </div>

        {{-- ===== INFO DATA SAAT EDIT ===== --}}
        @if($mode === 'edit')
        <div class="card mt-3" style="border: 1px solid #fef3c7 !important; background: #fffbeb; box-shadow: none;">
            <div class="card-body py-3 px-4">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="bi bi-clock-history text-warning"></i>
                    <span class="fw-semibold small">Informasi Record Database</span>
                </div>
                <div class="row small text-muted g-2">
                    <div class="col-sm-4">
                        <span class="fw-medium">ID:</span> <code>#{{ $aset->id }}</code>
                    </div>
                    <div class="col-sm-4">
                        <span class="fw-medium">Dibuat:</span> {{ $aset->created_at->format('d M Y, H:i') }}
                    </div>
                    <div class="col-sm-4">
                        <span class="fw-medium">Diperbarui:</span> {{ $aset->updated_at->format('d M Y, H:i') }}
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- ===== KOLOM SIDEBAR INFO ===== --}}
    <div class="col-lg-4">
        {{-- Panduan Pengisian --}}
        <div class="info-sidebar-card mb-3">
            <div class="card-header-custom">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-lightbulb-fill text-warning"></i>
                    <span class="fw-semibold" style="font-size: 0.9rem;">Panduan Pengisian</span>
                </div>
            </div>
            <div class="card-body-custom">
                <div class="info-item">
                    <div class="info-bullet"><i class="bi bi-box"></i></div>
                    <p><strong>Nama Aset:</strong> Isi dengan nama barang yang spesifik dan mudah dikenali.</p>
                </div>
                <div class="info-item">
                    <div class="info-bullet"><i class="bi bi-grid"></i></div>
                    <p><strong>Kategori:</strong> Pilih sesuai jenis barang untuk memudahkan audit inventaris.</p>
                </div>
                <div class="info-item">
                    <div class="info-bullet"><i class="bi bi-geo-alt-fill" style="color: #dc3545;"></i></div>
                    <p><strong>Lokasi:</strong> Cantumkan lokasi fisik aset (nomor kamar / area bersama).</p>
                </div>
                <div class="info-item">
                    <div class="info-bullet"><i class="bi bi-heart-pulse"></i></div>
                    <p><strong>Kondisi:</strong> Pilih status terkini aset untuk akurasi laporan statistik.</p>
                </div>
            </div>
        </div>

        {{-- Keterangan Kondisi --}}
        <div class="info-sidebar-card">
            <div class="card-header-custom">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-info-circle-fill text-primary"></i>
                    <span class="fw-semibold" style="font-size: 0.9rem;">Keterangan Kondisi</span>
                </div>
            </div>
            <div class="card-body-custom">
                <div class="kondisi-option baik mb-2">
                    <i class="bi bi-check-circle-fill"></i>
                    <div>
                        <strong>Baik</strong> — Aset berfungsi normal tanpa kerusakan.
                    </div>
                </div>
                <div class="kondisi-option rusak-ringan mb-2">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <div>
                        <strong>Rusak Ringan</strong> — Aset masih bisa digunakan namun perlu perhatian.
                    </div>
                </div>
                <div class="kondisi-option rusak">
                    <i class="bi bi-x-circle-fill"></i>
                    <div>
                        <strong>Rusak</strong> — Aset tidak bisa digunakan, perlu perbaikan segera.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ===== PREVIEW KONDISI REAL-TIME =====
function updateKondisiPreview(value) {
    const preview = document.getElementById('kondisiPreview');
    const map = {
        'Baik':         { cls: 'baik',         icon: 'check-circle-fill', text: 'Aset dalam kondisi prima dan siap pakai.' },
        'Rusak Ringan': { cls: 'rusak-ringan',  icon: 'exclamation-triangle-fill', text: 'Aset masih bisa digunakan, perlu perhatian.' },
        'Rusak':        { cls: 'rusak',         icon: 'x-circle-fill',     text: 'Aset tidak bisa digunakan, segera perbaiki.' },
    };
    const cfg = map[value];
    if (cfg) {
        preview.innerHTML = `
            <div class="kondisi-option ${cfg.cls} mt-2" style="font-size: 0.8rem;">
                <i class="bi bi-${cfg.icon}"></i>
                <span>${cfg.text}</span>
            </div>
        `;
    } else {
        preview.innerHTML = '';
    }
}

// Jalankan saat halaman pertama kali dimuat (untuk halaman edit)
document.addEventListener('DOMContentLoaded', function () {
    const kondisiEl = document.getElementById('kondisi');
    if (kondisiEl) {
        updateKondisiPreview(kondisiEl.value);
    }
});
</script>
@endpush
