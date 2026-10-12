@extends('layouts.app')

@section('title', 'Edit Pesanan #'.$pesanan->id_pesanan)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Edit Pesanan #{{ $pesanan->id_pesanan }}</h1>
    <a href="{{ route('admin.pesanan.show', $pesanan) }}" class="btn btn-outline-secondary">Kembali</a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <strong>Ubah Status & Nomor Antrean</strong>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pesanan.update', $pesanan) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Ringkasan Pesanan (read-only) --}}
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h6 class="card-title">Ringkasan Pesanan</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Pelanggan:</strong> {{ $pesanan->pelanggan?->user?->nama ?? '-' }}</p>
                                    <p class="mb-1"><strong>Jenis Layanan:</strong> {{ $pesanan->jenis_layanan ?? '-' }}</p>
                                    <p class="mb-1"><strong>Model:</strong> {{ $pesanan->model }}</p>
                                    <p class="mb-1"><strong>Ukuran:</strong> {{ $pesanan->ukuran }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Bahan:</strong> {{ $pesanan->bahan }}</p>
                                    <p class="mb-1"><strong>Warna:</strong> {{ $pesanan->warna }}</p>
                                    <p class="mb-1"><strong>Tgl. Pesan:</strong> {{ optional($pesanan->tgl_pesan)->format('d M Y') ?? $pesanan->created_at->format('d M Y') }}</p>
                                    <p class="mb-1"><strong>Tenggat:</strong> {{ optional($pesanan->tgl_tenggat)->format('d M Y') ?? '-' }}</p>
                                </div>
                            </div>
                            <hr>
                            <p class="mb-0"><strong>Rincian:</strong> {{ $pesanan->rincian }}</p>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label for="status" class="form-label">Status Pesanan <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                            @foreach($statusList as $s)
                                <option value="{{ $s }}" {{ old('status', $pesanan->status) === $s ? 'selected' : '' }}>
                                    {{ ucfirst($s) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nomor Antrean --}}
                    <div class="mb-3">
                        <label for="id_antrean" class="form-label">Nomor Antrean <small class="text-muted">(opsional)</small></label>
                        <select class="form-select @error('id_antrean') is-invalid @enderror" id="id_antrean" name="id_antrean">
                            <option value="">-- Tanpa Antrean --</option>
                            @foreach($antreanList as $antrean)
                                <option value="{{ $antrean->id_antrean }}" {{ old('id_antrean', $pesanan->id_antrean) == $antrean->id_antrean ? 'selected' : '' }}>
                                    {{ $antrean->nomor_antrean }} - {{ optional($antrean->tanggal)->format('d M Y') }} ({{ $antrean->status }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_antrean')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Hanya antrean yang belum selesai yang ditampilkan.</div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.pesanan.show', $pesanan) }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
