<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin()
    {
        return view('dashboard.admin');
    }

    public function karyawan()
    {
        return view('dashboard.karyawan');
    }

    public function pelanggan()
    {
        return view('dashboard.pelanggan');
    }
}