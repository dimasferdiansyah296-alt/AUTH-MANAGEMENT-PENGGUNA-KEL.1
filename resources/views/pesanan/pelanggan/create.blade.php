@extends('layouts.app')

@section('title', 'Buat Pesanan Baru')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Buat Pesanan Baru</h1>
    <a href="{{ route('pelanggan.pesanan.index') }}" class="btn btn-outline-secondary">Kembali</a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <strong>Form Pemesanan Jasa Jahit</strong>
            </div>
            <div class="card-body">
                <form action="{{ route('pelanggan.pesanan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Jenis Layanan & Tanggal Tenggat --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="jenis_layanan" class="form-label">Jenis Layanan <span class="text-danger">*</span></label>
                            <select class="form-select @error('jenis_layanan') is-invalid @enderror"
                                    id="jenis_layanan" name="jenis_layanan">
                                <option value="" selected disabled>-- Pilih Jenis Layanan --</option>
                                @foreach($jenisLayananList as $layanan)
                                    <option value="{{ $layanan }}" {{ old('jenis_layanan') === $layanan ? 'selected' : '' }}>
                                        {{ $layanan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jenis_layanan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="tgl_tenggat" class="form-label">Tanggal Kebutuhan Selesai <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tgl_tenggat') is-invalid @enderror"
                                   id="tgl_tenggat" name="tgl_tenggat" value="{{ old('tgl_tenggat') }}" min="{{ date('Y-m-d') }}">
                            @error('tgl_tenggat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="model" class="form-label">Model Pakaian <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('model') is-invalid @enderror"
                                   id="model" name="model" value="{{ old('model') }}"
                                   placeholder="Contoh: Kemeja, Celana, Gaun, Jaket">
                            @error('model')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="ukuran" class="form-label">Ukuran <span class="text-danger">*</span></label>
                            <select class="form-select @error('ukuran') is-invalid @enderror" id="ukuran" name="ukuran">
                                <option value="" selected disabled>-- Pilih Ukuran --</option>
                                <option value="S" {{ old('ukuran') === 'S' ? 'selected' : '' }}>S</option>
                                <option value="M" {{ old('ukuran') === 'M' ? 'selected' : '' }}>M</option>
                                <option value="L" {{ old('ukuran') === 'L' ? 'selected' : '' }}>L</option>
                                <option value="XL" {{ old('ukuran') === 'XL' ? 'selected' : '' }}>XL</option>
                                <option value="XXL" {{ old('ukuran') === 'XXL' ? 'selected' : '' }}>XXL</option>
                            </select>
                            @error('ukuran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="bahan" class="form-label">Bahan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('bahan') is-invalid @enderror"
                                   id="bahan" name="bahan" value="{{ old('bahan') }}"
                                   placeholder="Contoh: Katun, Sutra, Denim, Wol">
                            @error('bahan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="warna" class="form-label">Warna <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('warna') is-invalid @enderror"
                                   id="warna" name="warna" value="{{ old('warna') }}"
                                   placeholder="Contoh: Hitam, Biru, Merah">
                            @error('warna')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="rincian" class="form-label">Rincian / Catatan <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('rincian') is-invalid @enderror"
                                  id="rincian" name="rincian" rows="5"
                                  placeholder="Tuliskan detail pesanan Anda, misalnya: lengan panjang, kerah V, saku di dada, dll.">{{ old('rincian') }}</textarea>
                        @error('rincian')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto Acuan / Desain <small class="text-muted">(opsional)</small></label>
                        <input type="file" class="form-control @error('foto') is-invalid @enderror"
                               id="foto" name="foto" accept="image/jpeg,image/png,image/webp">
                        <div class="form-text">Format: JPG, PNG, atau WebP. Maksimal 2 MB.</div>
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('pelanggan.pesanan.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Kirim Pesanan</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="alert alert-info mt-3">
            <small>
                <strong>Catatan:</strong> Setelah pesanan dikirim, status akan menjadi <em>Baru</em>.
                Admin akan memproses dan memberikan nomor antrean. Anda bisa memantau status pesanan di halaman ini.
            </small>
        </div>
    </div>
</div>
@endsection
