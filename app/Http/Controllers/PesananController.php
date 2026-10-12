<?php

namespace App\Http\Controllers;

use App\Models\Antrean;
use App\Models\Pesanan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Controller untuk mengelola fitur Pemesanan (Pesanan).
 *
 * Sisi Pelanggan:
 *  - index     : melihat daftar pesanan miliknya sendiri
 *  - create    : menampilkan form pemesanan
 *  - store     : menyimpan pesanan baru
 *  - show      : melihat detail pesanan
 *  - destroy   : menghapus pesanan (hanya jika status masih 'baru')
 *
 * Sisi Admin / Karyawan:
 *  - adminIndex  : melihat semua pesanan
 *  - edit        : mengubah status & nomor antrean
 *  - update      : menyimpan perubahan status
 */
class PesananController extends Controller
{
    /**
     * Daftar jenis layanan yang tersedia.
     */
    public const JENIS_LAYANAN_LIST = [
        'Jahit Baju',
        'Jahit Celana',
        'Jahit Rok',
        'Jahit Gaun',
        'Jahit Jas',
        'Permak',
        'Lainnya',
    ];

    /** Daftar status yang valid untuk pesanan. */
    public const STATUS_LIST = ['baru', 'diproses', 'dijahit', 'selesai', 'diambil'];

    /* ============================================================
     * SISI PELANGGAN
     * ============================================================ */

    /**
     * Daftar pesanan milik pelanggan yang sedang login.
     */
    public function index(): View
    {
        $pelanggan = Auth::user()->pelanggan;

        $pesanan = Pesanan::where('id_pelanggan', $pelanggan->id_pelanggan)
            ->with('antrean')
            ->latest()
            ->get();

        return view('pesanan.pelanggan.index', compact('pesanan'));
    }

    /**
     * Form pemesanan baru.
     */
    public function create(): View
    {
        $jenisLayananList = self::JENIS_LAYANAN_LIST;

        return view('pesanan.pelanggan.create', compact('jenisLayananList'));
    }

    /**
     * Simpan pesanan baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'jenis_layanan' => ['required', 'string', 'in:'.implode(',', self::JENIS_LAYANAN_LIST)],
            'tgl_tenggat'   => ['required', 'date', 'after_or_equal:today'],
            'ukuran'        => ['required', 'string', 'max:50'],
            'model'         => ['required', 'string', 'max:100'],
            'bahan'         => ['required', 'string', 'max:100'],
            'warna'         => ['required', 'string', 'max:50'],
            'rincian'       => ['required', 'string'],
            'foto'          => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ]);

        $pelanggan = Auth::user()->pelanggan;

        // Upload foto acuan (jika ada) ke disk 'public' pada folder pesanan.
        $fotoPath = null;
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $fotoPath = $request->file('foto')->store('pesanan', 'public');
        }

        Pesanan::create([
            'id_pelanggan'  => $pelanggan->id_pelanggan,
            'jenis_layanan' => $validated['jenis_layanan'],
            'tgl_pesan'     => now()->toDateString(),
            'tgl_tenggat'   => $validated['tgl_tenggat'],
            'ukuran'        => $validated['ukuran'],
            'model'         => $validated['model'],
            'bahan'         => $validated['bahan'],
            'warna'         => $validated['warna'],
            'rincian'       => $validated['rincian'],
            'foto'          => $fotoPath,
            'status'        => 'baru', // status default pesanan baru
        ]);

        return redirect()
            ->route('pelanggan.pesanan.index')
            ->with('success', 'Pesanan berhasil dibuat! Silakan tunggu konfirmasi dari admin.');
    }

    /**
     * Detail pesanan milik pelanggan.
     */
    public function show(Pesanan $pesanan): View|RedirectResponse
    {
        // Pastikan pesanan ini benar-benar milik pelanggan yang login.
        $pelangganId = Auth::user()->pelanggan?->id_pelanggan;
        if ($pesanan->id_pelanggan !== $pelangganId && ! Auth::user()->hasRole(['admin', 'karyawan'])) {
            return redirect()
                ->route('pelanggan.pesanan.index')
                ->with('error', 'Anda tidak berhak melihat pesanan ini.');
        }

        $pesanan->load('pelanggan.user', 'antrean', 'pembayaran', 'pesan');

        return view('pesanan.pelanggan.show', compact('pesanan'));
    }

    /**
     * Hapus pesanan oleh pelanggan (hanya jika status masih 'baru').
     */
    public function destroy(Pesanan $pesanan): RedirectResponse
    {
        $pelangganId = Auth::user()->pelanggan?->id_pelanggan;

        if ($pesanan->id_pelanggan !== $pelangganId) {
            return redirect()
                ->route('pelanggan.pesanan.index')
                ->with('error', 'Anda tidak berhak menghapus pesanan ini.');
        }

        if ($pesanan->status !== 'baru') {
            return redirect()
                ->route('pelanggan.pesanan.index')
                ->with('error', 'Pesanan tidak bisa dihapus karena sudah diproses.');
        }

        $pesanan->delete();

        return redirect()
            ->route('pelanggan.pesanan.index')
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }

    /* ============================================================
     * SISI ADMIN / KARYAWAN
     * ============================================================ */

    /**
     * Daftar semua pesanan (untuk admin & karyawan).
     */
    public function adminIndex(Request $request): View
    {
        $status = $request->query('status');
        $cari = $request->query('cari');

        $query = Pesanan::with('pelanggan.user', 'antrean')->latest();

        if ($status && in_array($status, self::STATUS_LIST, true)) {
            $query->where('status', $status);
        }

        if ($cari) {
            $query->where(function ($q) use ($cari) {
                $q->where('model', 'like', "%{$cari}%")
                    ->orWhere('bahan', 'like', "%{$cari}%")
                    ->orWhereHas('pelanggan.user', fn ($sub) => $sub->where('nama', 'like', "%{$cari}%"));
            });
        }

        $pesanan = $query->get();
        $statusList = self::STATUS_LIST;

        return view('pesanan.admin.index', compact('pesanan', 'statusList', 'status', 'cari'));
    }

    /**
     * Detail pesanan untuk admin/karyawan.
     */
    public function adminShow(Pesanan $pesanan): View
    {
        $pesanan->load('pelanggan.user', 'antrean', 'pembayaran', 'pesan');

        return view('pesanan.admin.show', compact('pesanan'));
    }

    /**
     * Form edit status & antrean pesanan (admin/karyawan).
     */
    public function edit(Pesanan $pesanan): View
    {
        $antreanList = Antrean::where('status', '!=', 'selesai')->orderBy('tanggal')->get();
        $statusList = self::STATUS_LIST;

        return view('pesanan.admin.edit', compact('pesanan', 'antreanList', 'statusList'));
    }

    /**
     * Simpan perubahan status & antrean pesanan.
     */
    public function update(Request $request, Pesanan $pesanan): RedirectResponse
    {
        $validated = $request->validate([
            'status'     => ['required', 'string', 'in:'.implode(',', self::STATUS_LIST)],
            'id_antrean' => ['nullable', 'integer', 'exists:antrean,id_antrean'],
            'ukuran'     => ['sometimes', 'string', 'max:50'],
            'model'      => ['sometimes', 'string', 'max:100'],
            'bahan'      => ['sometimes', 'string', 'max:100'],
            'warna'      => ['sometimes', 'string', 'max:50'],
            'rincian'    => ['sometimes', 'string'],
        ]);

        $pesanan->update($validated);

        return redirect()
            ->route('admin.pesanan.show', $pesanan)
            ->with('success', 'Data pesanan berhasil diperbarui.');
    }
}
