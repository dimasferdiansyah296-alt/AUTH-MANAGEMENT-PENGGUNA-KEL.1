@extends('layouts.app')

@section('title', 'Dashboard Karyawan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Dashboard Karyawan</h1>
    <span class="badge bg-success fs-6">Role: {{ auth()->user()->role }}</span>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Antrean Aktif</h5>
                <p class="card-text display-6">{{ \App\Models\Antrean::where('status','!=','selesai')->count() }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Pesanan Diproses</h5>
                <p class="card-text display-6">{{ \App\Models\Pesanan::whereIn('status',['baru','diproses','dijahit'])->count() }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Pesanan Selesai</h5>
                <p class="card-text display-6">{{ \App\Models\Pesanan::where('status','selesai')->count() }}</p>
            </div>
        </div>
    </div>
</div>

<div class="alert alert-info">
    👋 Selamat datang <strong>{{ auth()->user()->nama }}</strong>. Halaman ini hanya bisa diakses oleh <strong>karyawan</strong> dan <strong>admin</strong>.
</div>
@endsection
