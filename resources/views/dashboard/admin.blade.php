@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Dashboard Admin</h1>
    <span class="badge bg-primary fs-6">Role: {{ auth()->user()->role }}</span>
</div>

{{-- CTA utama --}}
<div class="d-flex flex-wrap gap-2 mb-4">
    <a href="{{ route('admin.pesanan.index') }}" class="btn btn-primary btn-lg">
        <strong>Kelola Pesanan</strong>
    </a>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Pelanggan</h5>
                <p class="card-text display-6">{{ \App\Models\Pelanggan::count() }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Pesanan</h5>
                <p class="card-text display-6">{{ \App\Models\Pesanan::count() }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Karyawan</h5>
                <p class="card-text display-6">{{ \App\Models\Karyawan::count() }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <h5 class="card-title">Pendapatan</h5>
                <p class="card-text">Rp {{ number_format(\App\Models\Pembayaran::where('status','lunas')->sum('jumlah'), 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
</div>

<div class="alert alert-info">
    👋 Selamat datang <strong>{{ auth()->user()->nama }}</strong>. Halaman ini hanya bisa diakses oleh <strong>admin</strong>.
</div>
@endsection
