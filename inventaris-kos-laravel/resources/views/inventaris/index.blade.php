@extends('layouts.app')

@section('title', 'Data Inventaris Aset')
@section('breadcrumb', 'Data Inventaris')

@push('styles')
<style>
    .page-header-card {
        background: linear-gradient(135deg, #1a1d23 0%, #2d3250 100%);
        border-radius: 16px;
        padding: 28px;
        color: white;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }
    .page-header-card::after {
        content: '📦';
        position: absolute;
        right: 28px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 4rem;
        opacity: 0.15;
    }
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    .stat-card-item {
        background: white;
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        display: flex;
        align-items: center;
        gap: 14px;
        transition: transform 0.2s;
    }
    .stat-card-item:hover { transform: translateY(-3px); }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }
    .stat-icon.blue   { background: #e8eaff; }
    .stat-icon.green  { background: #d1fae5; }
    .stat-icon.red    { background: #fee2e2; }
    .stat-icon.yellow { background: #fef3c7; }
    .stat-label {
        font-size: 0.78rem;
        color: #6c757d;
        font-weight: 500;
        margin-bottom: 2px;
    }
    .stat-value {
        font-size: 1.6rem;
        font-weight: 800;
        color: #1a1d23;
        line-height: 1;
    }

    .filter-card {
        background: white;
        border-radius: 14px;
        padding: 16px 20px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        margin-bottom: 20px;
    }

    .table-card {
        background: white;
        border-radius: 14px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        overflow: hidden;
    }
    .table-card-header {
        padding: 18px 24px;
        border-bottom: 1px solid #f0f2f8;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .table-card-header h5 {
        font-weight: 700;
        color: #1a1d23;
        margin: 0;
        font-size: 1rem;
    }

    .action-btn {
        padding: 5px 10px;
        font-size: 0.8rem;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.15s;
    }
    .action-btn:hover { transform: translateY(-1px); }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #9ba3b2;
    }
    .empty-state i {
        font-size: 3.5rem;
        display: block;
        margin-bottom: 12px;
        opacity: 0.4;
    }
</style>
@endpush

@section('content')

{{-- ===== HEADER CARD ===== --}}
<div class="page-header-card">
    <p class="mb-1" style="color: #a0a9c0; font-size: 0.85rem; font-weight: 500; text-transform: uppercase; letter-spacing: 1px;">Sistem Manajemen Kos</p>
    <h1 class="fw-bold mb-1" style="font-size: 1.6rem;">Data Inventaris Aset</h1>
    <p style="color: #a0a9c0; margin: 0; font-size: 0.9rem;">Kelola dan pantau seluruh data aset yang tersimpan di database MySQL.</p>
</div>

{{-- ===== STATISTIK ===== --}}
<div class="stat-grid">
    <div class="stat-card-item">
        <div class="stat-icon blue">
            <i class="bi bi-archive-fill" style="color: #3d4afe;"></i>
        </div>
        <div>
            <div class="stat-label">Total Aset</div>
            <div class="stat-value" id="statTotal">{{ $totalData }}</div>
        </div>
    </div>
    <div class="stat-card-item">
        <div class="stat-icon green">
            <i class="bi bi-check-circle-fill" style="color: #065f46;"></i>
        </div>
        <div>
            <div class="stat-label">Kondisi Baik</div>
            <div class="stat-value" style="color: #065f46;">
                {{ $inventaris->where('kondisi', 'Baik')->count() }}
            </div>
        </div>
    </div>
    <div class="stat-card-item">
        <div class="stat-icon red">
            <i class="bi bi-tools" style="color: #991b1b;"></i>
        </div>
        <div>
            <div class="stat-label">Perlu Perbaikan</div>
            <div class="stat-value" style="color: #991b1b;">
                {{ $inventaris->whereIn('kondisi', ['Rusak Ringan', 'Rusak'])->count() }}
            </div>
        </div>
    </div>
</div>

{{-- ===== FILTER & SEARCH ===== --}}
<div class="filter-card">
    <div class="row g-3 align-items-center">
        <div class="col-md-6">
            <label class="form-label small fw-semibold text-muted mb-1">
                <i class="bi bi-search me-1"></i>Cari Aset
            </label>
            <input
                type="text"
                id="searchInput"
                class="form-control"
                placeholder="Cari nama aset, merk, atau lokasi..."
                onkeyup="filterTable()"
            >
        </div>
        <div class="col-md-4">
            <label class="form-label small fw-semibold text-muted mb-1">
                <i class="bi bi-funnel me-1"></i>Filter Kondisi
            </label>
            <select id="conditionFilter" class="form-select" onchange="filterTable()">
                <option value="all">Semua Kondisi</option>
                <option value="Baik">✅ Baik</option>
                <option value="Rusak Ringan">⚠️ Rusak Ringan</option>
                <option value="Rusak">❌ Rusak</option>
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button class="btn btn-outline-secondary w-100" onclick="resetFilter()">
                <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
            </button>
        </div>
    </div>
</div>

{{-- ===== TABEL DATA ===== --}}
<div class="table-card">
    <div class="table-card-header">
        <h5><i class="bi bi-table me-2 text-primary"></i>Daftar Aset Kos</h5>
        <div class="d-flex align-items-center gap-3">
            <span class="badge bg-light text-dark border px-3 py-2">
                Tampil: <strong id="visibleCount" class="text-primary">{{ $totalData }}</strong> aset
            </span>
            <a href="{{ route('inventaris.create') }}" class="btn btn-primary btn-sm px-3" id="btn-tambah-aset">
                <i class="bi bi-plus-circle me-1"></i>+ Tambah Aset
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="inventarisTable">
            <thead style="background: #f8f9ff;">
                <tr>
                    <th class="ps-4" style="width: 50px;">No</th>
                    <th>Nama Aset</th>
                    <th>Kategori</th>
                    <th>Merk</th>
                    <th>Lokasi</th>
                    <th>Kondisi</th>
                    <th>Keterangan</th>
                    <th class="text-center pe-4" style="width: 160px;">Aksi</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @forelse($inventaris as $index => $aset)
                    @php
                        $badgeClass = match($aset->kondisi) {
                            'Baik'         => 'badge-baik',
                            'Rusak Ringan' => 'badge-rusak-ringan',
                            'Rusak'        => 'badge-rusak',
                            default        => 'badge-baik',
                        };
                        $kondisiIcon = match($aset->kondisi) {
                            'Baik'         => '✅',
                            'Rusak Ringan' => '⚠️',
                            'Rusak'        => '❌',
                            default        => '',
                        };
                    @endphp
                    <tr class="table-row" data-kondisi="{{ $aset->kondisi }}">
                        <td class="ps-4 text-muted fw-bold">{{ $index + 1 }}</td>
                        <td>
                            <span class="fw-semibold text-dark">{{ $aset->nama_aset }}</span>
                        </td>
                        <td>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary border fw-normal px-2">
                                {{ $aset->kategori }}
                            </span>
                        </td>
                        <td class="text-muted">{{ $aset->merk }}</td>
                        <td>
                            <i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $aset->lokasi }}
                        </td>
                        <td>
                            <span class="badge {{ $badgeClass }} px-2 py-1 fw-normal">
                                {{ $kondisiIcon }} {{ $aset->kondisi }}
                            </span>
                        </td>
                        <td class="text-muted small" style="max-width: 180px;">
                            {{ $aset->keterangan ?: '-' }}
                        </td>
                        <td class="text-center pe-4">
                            {{-- Tombol Edit --}}
                            <a href="{{ route('inventaris.edit', $aset->id) }}"
                               class="btn btn-warning btn-sm action-btn text-dark me-1"
                               id="btn-edit-{{ $aset->id }}"
                               title="Edit Aset">
                                <i class="bi bi-pencil-square me-1"></i>Edit
                            </a>
                            {{-- Tombol Hapus - Trigger Modal --}}
                            <button
                                class="btn btn-danger btn-sm action-btn"
                                id="btn-hapus-{{ $aset->id }}"
                                onclick="confirmHapus({{ $aset->id }}, '{{ addslashes($aset->nama_aset) }}')"
                                title="Hapus Aset">
                                <i class="bi bi-trash3 me-1"></i>Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr id="emptyDataRow">
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <p class="fw-semibold mb-1">Belum ada data aset.</p>
                                <p class="small">Database kosong. Mulai tambahkan aset pertama Anda!</p>
                                <a href="{{ route('inventaris.create') }}" class="btn btn-primary btn-sm px-4 mt-2">
                                    <i class="bi bi-plus-circle me-1"></i>Tambah Aset Sekarang
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($totalData > 0)
    <div class="px-4 py-3 border-top d-flex justify-content-between align-items-center" style="background: #fafafa;">
        <small class="text-muted">
            <i class="bi bi-clock me-1"></i>Data terakhir diperbarui: {{ now()->format('d M Y, H:i') }} WIB
        </small>
        <small class="text-muted">
            <i class="bi bi-database me-1"></i>Tabel: <code>inventaris</code> — Database: <code>db_inventaris_kos</code>
        </small>
    </div>
    @endif
</div>

{{-- ===== MODAL KONFIRMASI HAPUS ===== --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(135deg, #dc3545, #c02333); border: none;">
                <h5 class="modal-title text-white">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-4 px-4">
                <p class="mb-1">Apakah Anda yakin ingin menghapus aset:</p>
                <p class="fw-bold text-danger fs-5 mb-3" id="deleteAssetName"></p>
                <div class="alert alert-warning py-2 px-3 small mb-0">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    Tindakan ini <strong>permanen</strong> dan data tidak dapat dipulihkan.
                </div>
            </div>
            <div class="modal-footer border-0 px-4 pb-4">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Batal
                </button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4" id="btn-confirm-delete">
                        <i class="bi bi-trash3 me-1"></i>Hapus Permanen
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ===== MODAL HAPUS =====
let deleteModal;
document.addEventListener('DOMContentLoaded', function () {
    deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
});

function confirmHapus(id, nama) {
    document.getElementById('deleteAssetName').textContent = '"' + nama + '"';
    document.getElementById('deleteForm').action = '/inventaris/' + id;
    deleteModal.show();
}

// ===== FILTER & SEARCH =====
function filterTable() {
    const search    = document.getElementById('searchInput').value.toLowerCase();
    const condition = document.getElementById('conditionFilter').value;
    const rows      = document.querySelectorAll('.table-row');
    let visible     = 0;

    rows.forEach(function (row) {
        const text    = row.innerText.toLowerCase();
        const kondisi = row.getAttribute('data-kondisi');

        const matchSearch    = text.includes(search);
        const matchCondition = (condition === 'all' || kondisi === condition);

        if (matchSearch && matchCondition) {
            row.style.display = '';
            visible++;
        } else {
            row.style.display = 'none';
        }
    });

    document.getElementById('visibleCount').textContent = visible;
}

function resetFilter() {
    document.getElementById('searchInput').value = '';
    document.getElementById('conditionFilter').value = 'all';
    filterTable();
}
</script>
@endpush
