<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SimulasiPinjamanController extends Controller
{
    public function index()
    {
        return view('simulasi-pinjaman.index');
    }

    public function process(Request $request)
    {
        $validate = $request->validate([
            'jenis_pinjaman' => 'required',
            'gaji_bersih_struk' => 'required|numeric|min:0',
            'potongan_kki' => 'required|numeric|min:0',
            'nilai_pinjaman' => 'required|numeric|min:0',
            'jangka_waktu' => 'required|numeric|min:1',
        ]);

        // Ambil data dari formulir
        $gajiBersihStruk = $validate['gaji_bersih_struk'];
        $potonganKki = $validate['potongan_kki'];
        $nilaiPinjaman = $validate['nilai_pinjaman'];
        $jangkaWaktu = $validate['jangka_waktu'];
        $jenisPinjaman = $validate['jenis_pinjaman'];

        // Hitung Gaji Bersih
        $gajiBersih = $gajiBersihStruk - $potonganKki;

        // Hitung Bunga
        $bunga = $this->getBungaFromJenisPinjaman($jenisPinjaman);

        if ($bunga == 0) {
            // Tangani kasus khusus jika bunga adalah 0
            $angsuranPerBulan = $nilaiPinjaman / $jangkaWaktu;
            $flatRatePerTahun = 0;
            $flatRatePerBulan = 0;
            $plafonPinjaman = 0;
            $isPlafonMerah = false;

            // Inisialisasi variabel untuk rincian angsuran
            $rincianAngsuran = [];
            $saldoPinjaman = $nilaiPinjaman;

            // Hitung rincian angsuran
            for ($bulan = 1; $bulan <= $jangkaWaktu; $bulan++) {
                $angsuranPokok = $angsuranPerBulan;
                $angsuranBunga = 0; // Tidak ada bunga
                $saldoPinjaman -= $angsuranPokok;

                // Simpan rincian angsuran
                $rincianAngsuran[] = [
                    'bulan' => $bulan,
                    'angsuran_pokok' => number_format($angsuranPokok, 2, ',', '.'),
                    'angsuran_bunga' => number_format($angsuranBunga, 2, ',', '.'),
                    'total_angsuran' => number_format($angsuranPerBulan, 2, ',', '.'),
                    'saldo_pinjaman_sisa' => number_format(max(0, $saldoPinjaman), 2, ',', '.'),
                ];
            }

            $totalBunga = 0;
            $totalDibayarkan = $nilaiPinjaman;

            // Kirim data ke tampilan
            return view('simulasi-pinjaman.hasil', compact('gajiBersih', 'bunga', 'angsuranPerBulan', 'flatRatePerTahun', 'flatRatePerBulan', 'plafonPinjaman', 'isPlafonMerah', 'rincianAngsuran', 'nilaiPinjaman', 'jangkaWaktu', 'totalBunga', 'totalDibayarkan'));
        }

        // Hitung Flat Rate dan Angsuran Per Bulan
        $r = $bunga / 12 / 100; // Bunga Bulanan
        $angsuranPerBulan = $nilaiPinjaman * ($r / (1 - pow(1 + $r, -$jangkaWaktu)));

        // Hitung Flat Rate per Tahun menggunakan rumus baru
        $flatRatePerTahun = (((($angsuranPerBulan * $jangkaWaktu) - $nilaiPinjaman) / $nilaiPinjaman) * (12 / $jangkaWaktu)) * 100;
        $flatRatePerBulan = $flatRatePerTahun / 12;

        // Hitung Plafon Pinjaman
        $plafonPinjaman = (($angsuranPerBulan + $potonganKki) / $gajiBersihStruk) * 100;
        $isPlafonMerah = $plafonPinjaman > 40;

        // Inisialisasi variabel untuk rincian angsuran
        $rincianAngsuran = [];
        $saldoPinjaman = $nilaiPinjaman;
        $totalBunga = 0; // Inisialisasi variabel totalBunga

        // Hitung rincian angsuran
        for ($bulan = 1; $bulan <= $jangkaWaktu; $bulan++) {
            $angsuranBunga = $saldoPinjaman * $r;
            $angsuranPokok = $angsuranPerBulan - $angsuranBunga;
            $saldoPinjaman -= $angsuranPokok;

            // Simpan rincian angsuran
            $rincianAngsuran[] = [
                'bulan' => $bulan,
                'angsuran_pokok' => number_format($angsuranPokok, 2, ',', '.'),
                'angsuran_bunga' => number_format($angsuranBunga, 2, ',', '.'),
                'total_angsuran' => number_format($angsuranPerBulan, 2, ',', '.'),
                'saldo_pinjaman_sisa' => number_format(max(0, $saldoPinjaman), 2, ',', '.'),
            ];

            // Akumulasi total bunga
            $totalBunga += $angsuranBunga;
        }

        $totalDibayarkan = $nilaiPinjaman + $totalBunga;

        // Kirim data ke tampilan
        return view('simulasi-pinjaman.hasil', compact('gajiBersih', 'bunga', 'angsuranPerBulan', 'flatRatePerTahun', 'flatRatePerBulan', 'plafonPinjaman', 'isPlafonMerah', 'rincianAngsuran', 'nilaiPinjaman', 'jangkaWaktu', 'totalBunga', 'totalDibayarkan'));
    }

    private function getBungaFromJenisPinjaman($jenisPinjaman)
    {
        // Implementasikan logika untuk mendapatkan bunga berdasarkan jenis pinjaman
        $bunga = 0;

        switch ($jenisPinjaman) {
            case 'NON REGULER':
                $bunga = 13;
                break;
            case 'REGULER':
                $bunga = 13.25;
                break;
            case 'KPR REKANAN':
                $bunga = 11;
                break;
            case 'KPR NON REKANAN':
                $bunga = 11;
                break;
            case 'MULTI GUNA JAMINAN SERTIFIKAT':
                $bunga = 11.5;
                break;
            case 'MULTI GUNA JAMINAN BPKB':
                $bunga = 11.5;
                break;
            case 'PENDIDIKAN':
                $bunga = 11;
                break;
            case 'MOTOR':
                $bunga = 13;
                break;
            case 'ELECTRONIC':
                $bunga = 13.50;
                break;
            case 'MOBIL':
                $bunga = 12;
                break;
            case 'EMERGENCY':
                $bunga = 0;
                break;
            default:
                $bunga = 0;
                break;
        }

        return $bunga;
    }
}
