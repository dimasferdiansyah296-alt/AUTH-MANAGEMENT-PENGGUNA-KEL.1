@extends('layouts.app')

@section('title', 'Daftar Pesanan Saya')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Pesanan Saya</h1>
    <a href="{{ route('pelanggan.pesanan.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Buat Pesanan Baru
    </a>
</div>

@if($pesanan->isEmpty())
    <div class="alert alert-secondary text-center py-5">
        <p class="mb-3">Belum ada pesanan.</p>
        <a href="{{ route('pelanggan.pesanan.create') }}" class="btn btn-primary">Buat Pesanan Pertama</a>
    </div>
@else
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No.</th>
                    <th>Jenis Layanan</th>
                    <th>Model</th>
                    <th>Bahan</th>
                    <th>Ukuran</th>
                    <th>Warna</th>
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
                    <td>{{ $item->jenis_layanan ?? '-' }}</td>
                    <td>{{ $item->model }}</td>
                    <td>{{ $item->bahan }}</td>
                    <td>{{ $item->ukuran }}</td>
                    <td>{{ $item->warna }}</td>
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
                        <a href="{{ route('pelanggan.pesanan.show', $item) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                        @if($item->status === 'baru')
                        <form action="{{ route('pelanggan.pesanan.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Batalkan</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
