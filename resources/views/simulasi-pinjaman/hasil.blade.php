<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Simulasi Pinjaman</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 20px;
            background-color: #f7f9fc;
            color: #333;
        }

        h2 {
            border-bottom: 3px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-size: 1.6em;
            color: #007bff;
        }

        .table-header {
            background-color: #e9ecef;
            border-radius: 4px;
            border-bottom: 3px solid #007bff;
            padding: 12px;
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 1.3em;
            color: #007bff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            border: 1px solid #dee2e6;
            padding: 15px;
            text-align: left;
            vertical-align: middle;
        }

        th {
            background-color: #007bff;
            color: #fff;
            font-size: 1.1em;
        }

        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .alert {
            color: #dc3545;
            font-weight: bold;
            font-size: 1.1em;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            body {
                margin: 10px;
                font-size: 0.9em;
            }

            h2 {
                font-size: 1.4em;
            }

            .table-header {
                font-size: 1.1em;
                padding: 10px;
            }

            th,
            td {
                padding: 10px;
                font-size: 0.9em;
            }

            th {
                font-size: 1em;
            }
        }

        @media (max-width: 576px) {
            body {
                margin: 5px;
                font-size: 0.8em;
            }

            h2 {
                font-size: 1.2em;
            }

            .table-header {
                font-size: 1em;
                padding: 8px;
            }

            th,
            td {
                padding: 8px;
                font-size: 0.8em;
            }

            th {
                font-size: 0.9em;
            }
        }
    </style>
</head>

<body>
    <div class="table-header">Tabel Informasi Pinjaman</div>
    <table>
        <tbody>
            <tr>
                <td>Pokok Pinjaman</td>
                <td>Rp {{ number_format($nilaiPinjaman, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Jangka Waktu Angsuran</td>
                <td>{{ $jangkaWaktu }} x</td>
            </tr>
            <tr>
                <td>Bunga per Tahun</td>
                <td>{{ $bunga }} %</td>
            </tr>
            <tr>
                <td>Flat Rate per Tahun</td>
                <td>{{ number_format($flatRatePerTahun, 1, ',', '.') }}%</td>
            </tr>
            <tr>
                <td>Flat Rate per Bulan</td>
                <td>{{ number_format($flatRatePerBulan, 2, ',', '.') }}%</td>
            </tr>
            <tr>
                <td>Plafon Pinjaman</td>
                @if ($isPlafonMerah)
                    <td class="alert">
                        {{ number_format($plafonPinjaman) }}%
                    </td>
                @else
                    <td>{{ number_format($plafonPinjaman) }}%</td>
                @endif
            </tr>
        </tbody>
    </table>

    @if ($isPlafonMerah)
        <p class="alert">Plafon pinjaman Anda melebihi batas aman 40% dari gaji bersih.</p>
    @endif

    <div class="table-header">Tabel Informasi Angsuran</div>
    <table>
        <tbody>
            <tr>
                <td>Angsuran per Bulan</td>
                <td>Rp {{ number_format($angsuranPerBulan, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Total Periode</td>
                <td>{{ $jangkaWaktu }} x</td>
            </tr>
            <tr>
                <td>Total Bunga</td>
                <td>Rp {{ number_format($totalBunga, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Total Pembayaran</td>
                <td>Rp {{ number_format($totalDibayarkan, 2, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="table-header">Tabel Rincian Angsuran</div>
    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Angsuran Pokok</th>
                <th>Angsuran Bunga</th>
                <th>Total Angsuran</th>
                <th>Saldo Pinjaman Sisa</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rincianAngsuran as $angsuran)
                <tr>
                    <td>{{ $angsuran['bulan'] }}</td>
                    <td>Rp {{ $angsuran['angsuran_pokok'] }}</td>
                    <td>Rp {{ $angsuran['angsuran_bunga'] }}</td>
                    <td>Rp {{ $angsuran['total_angsuran'] }}</td>
                    <td>Rp {{ $angsuran['saldo_pinjaman_sisa'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
