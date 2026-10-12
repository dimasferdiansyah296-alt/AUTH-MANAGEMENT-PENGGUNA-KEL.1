@extends('layouts.app')

@section('title', 'Detail Pesanan #'.$pesanan->id_pesanan)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Detail Pesanan #{{ $pesanan->id_pesanan }}</h1>
    <a href="{{ route('pelanggan.pesanan.index') }}" class="btn btn-outline-secondary">Kembali</a>
</div>

<div class="row">
    {{-- Kiri: Informasi Pesanan --}}
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <strong>Informasi Pesanan</strong>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Jenis Layanan:</strong></p>
                        <p class="text-muted">{{ $pesanan->jenis_layanan ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Status:</strong></p>
                        @switch($pesanan->status)
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
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Model Pakaian:</strong></p>
                        <p class="text-muted">{{ $pesanan->model }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Ukuran:</strong></p>
                        <p class="text-muted">{{ $pesanan->ukuran }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Bahan:</strong></p>
                        <p class="text-muted">{{ $pesanan->bahan }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Warna:</strong></p>
                        <p class="text-muted">{{ $pesanan->warna }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Tanggal Pesan:</strong></p>
                        <p class="text-muted">{{ optional($pesanan->tgl_pesan)->format('d M Y') ?? $pesanan->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Tanggal Kebutuhan Selesai:</strong></p>
                        <p class="text-muted">{{ optional($pesanan->tgl_tenggat)->format('d M Y') ?? '-' }}</p>
                    </div>
                </div>

                <div class="mb-3">
                    <p class="mb-1"><strong>Rincian / Catatan:</strong></p>
                    <p class="text-muted">{{ $pesanan->rincian }}</p>
                </div>

                @if($pesanan->foto)
                <div class="mb-3">
                    <p class="mb-1"><strong>Foto Acuan / Desain:</strong></p>
                    <img src="{{ $pesanan->foto_url }}" alt="Foto Acuan" class="img-fluid rounded" style="max-height: 300px;">
                </div>
                @endif
            </div>
        </div>

        {{-- Riwayat Pesan --}}
        <div class="card mb-4">
            <div class="card-header">
                <strong>Riwayat Pesan</strong>
            </div>
            <div class="card-body">
                @if($pesanan->pesan->isEmpty())
                    <p class="text-muted mb-0">Belum ada pesan.</p>
                @else
                    <div class="list-group">
                        @foreach($pesanan->pesan as $msg)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $msg->pengirim }}</strong>
                                    <small class="text-muted">{{ optional($msg->waktu)->format('d M Y H:i') }}</small>
                                </div>
                                <p class="mb-0 mt-1">{{ $msg->isi_pesan }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Kanan: Antrean & Pembayaran --}}
    <div class="col-lg-4">
        {{-- Informasi Antrean --}}
        <div class="card mb-4">
            <div class="card-header">
                <strong>Informasi Antrean</strong>
            </div>
            <div class="card-body">
                @if($pesanan->antrean)
                    <p class="mb-1"><strong>Nomor Antrean:</strong></p>
                    <p class="text-muted">{{ $pesanan->antrean->nomor_antrean }}</p>
                    <p class="mb-1"><strong>Tanggal Antrean:</strong></p>
                    <p class="text-muted">{{ optional($pesanan->antrean->tanggal)->format('d M Y') ?? '-' }}</p>
                    <p class="mb-1"><strong>Status Antrean:</strong></p>
                    <span class="badge bg-secondary">{{ ucfirst($pesanan->antrean->status) }}</span>
                @else
                    <p class="text-muted mb-0">Belum ada nomor antrean. Silakan tunggu konfirmasi admin.</p>
                @endif
            </div>
        </div>

        {{-- Informasi Pembayaran --}}
        <div class="card mb-4">
            <div class="card-header">
                <strong>Informasi Pembayaran</strong>
            </div>
            <div class="card-body">
                @if($pesanan->pembayaran->isEmpty())
                    <p class="text-muted mb-0">Belum ada data pembayaran.</p>
                @else
                    @foreach($pesanan->pembayaran as $bayar)
                        <p class="mb-1"><strong>Jumlah:</strong></p>
                        <p class="text-muted">Rp {{ number_format($bayar->jumlah, 0, ',', '.') }}</p>
                        <p class="mb-1"><strong>Status:</strong></p>
                        @if($bayar->status === 'lunas')
                            <span class="badge bg-success">Lunas</span>
                        @else
                            <span class="badge bg-warning text-dark">Belum Lunas</span>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>

        {{-- Aksi --}}
        @if($pesanan->status === 'baru')
        <div class="card border-danger">
            <div class="card-body text-center">
                <p class="text-muted small mb-3">Pesanan masih berstatus "Baru", Anda dapat membatalkannya.</p>
                <form action="{{ route('pelanggan.pesanan.destroy', $pesanan) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100">Batalkan Pesanan</button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
