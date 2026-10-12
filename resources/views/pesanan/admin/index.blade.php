@extends('layouts.app')

@section('title', 'Manajemen Pesanan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Manajemen Pesanan</h1>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Kembali ke Dashboard</a>
</div>

{{-- Filter & Pencarian --}}
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.pesanan.index') }}" class="row g-3">
            <div class="col-md-4">
                <label for="status" class="form-label">Filter Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">-- Semua Status --</option>
                    @foreach($statusList as $s)
                        <option value="{{ $s }}" {{ $status === $s ? 'selected' : '' }}>
                            {{ ucfirst($s) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="cari" class="form-label">Cari (Model / Bahan / Nama Pelanggan)</label>
                <input type="text" class="form-control" id="cari" name="cari" value="{{ $cari ?? '' }}"
                       placeholder="Kata kunci...">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>
    </div>
</div>

{{-- Tabel Daftar Pesanan --}}
<div class="card">
    <div class="card-body">
        @if($pesanan->isEmpty())
            <div class="alert alert-secondary text-center py-5 mb-0">
                Tidak ada pesanan.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No.</th>
                            <th>Pelanggan</th>
                            <th>Jenis Layanan</th>
                            <th>Model</th>
                            <th>Tgl. Pesan</th>
                            <th>Tenggat</th>
                            <th>Antrean</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pesanan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $item->pelanggan?->user?->nama ?? '-' }}</strong>
                                <br>
                                <small class="text-muted">{{ $item->pelanggan?->no_telepon ?? '' }}</small>
                            </td>
                            <td>{{ $item->jenis_layanan ?? '-' }}</td>
                            <td>{{ $item->model }}</td>
                            <td>{{ optional($item->tgl_pesan)->format('d M Y') ?? $item->created_at->format('d M Y') }}</td>
                            <td>{{ optional($item->tgl_tenggat)->format('d M Y') ?? '-' }}</td>
                            <td>
                                @if($item->antrean)
                                    <span class="badge bg-secondary">{{ $item->antrean->nomor_antrean }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                @switch($item->status)
                                    @case('baru')
                                        <span class="badge bg-info">Baru</span>
                                        @break
                                    @case('diproses')
                                        <span class="badge bg-warning text-dark">Diproses</span>
                                        @break
                                    @case('dijahit')
                                        <span class="badge bg-primary">Dijahit</span>
                                        @break
                                    @case('selesai')
                                        <span class="badge bg-success">Selesai</span>
                                        @break
                                    @case('diambil')
                                        <span class="badge bg-secondary">Diambil</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                <a href="{{ route('admin.pesanan.show', $item) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                                <a href="{{ route('admin.pesanan.edit', $item) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
