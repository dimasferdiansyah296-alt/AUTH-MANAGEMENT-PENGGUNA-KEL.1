@extends('layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Dashboard Pelanggan</h1>
    <span class="badge bg-warning text-dark fs-6">Role: {{ auth()->user()->role }}</span>
</div>

{{-- CTA (Call To Action) utama --}}
<div class="d-flex flex-wrap gap-2 mb-4">
    <a href="{{ route('pelanggan.pesanan.create') }}" class="btn btn-primary btn-lg">
        <strong>+ Tambah Pesanan</strong>
    </a>
    <a href="{{ route('pelanggan.pesanan.index') }}" class="btn btn-outline-secondary btn-lg">
        Lihat Daftar Pesanan
    </a>
</div>

<div class="card mb-4">
    <div class="card-header">
        <strong>Informasi Akun</strong>
    </div>
    <div class="card-body">
        <p><strong>Nama:</strong> {{ auth()->user()->nama }}</p>
        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
        <p><strong>No. Telepon:</strong> {{ auth()->user()->pelanggan?->no_telepon ?? '-' }}</p>
        <p><strong>Alamat:</strong> {{ auth()->user()->pelanggan?->alamat ?? '-' }}</p>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Pesanan Saya</h5>
                <p class="card-text display-6">
                    {{ auth()->user()->pelanggan?->pesanan()->count() ?? 0 }}
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Pesanan Selesai</h5>
                <p class="card-text display-6">
                    {{ auth()->user()->pelanggan?->pesanan()->where('status','selesai')->count() ?? 0 }}
                </p>
            </div>
        </div>
    </div>
</div>

<div class="alert alert-info">
    👋 Selamat datang <strong>{{ auth()->user()->nama }}</strong>. Halaman ini hanya bisa diakses oleh <strong>pelanggan</strong>.
</div>
@endsection
