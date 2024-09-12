<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulasi Pinjaman</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #4A90E2;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
            font-weight: 600;
            color: #4A4A4A;
        }

        input,
        select {
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        input:focus,
        select:focus {
            border-color: #4A90E2;
            box-shadow: 0 0 8px rgba(74, 144, 226, 0.3);
        }

        button {
            padding: 12px;
            background-color: #4A90E2;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #357ABD;
        }

        @media (max-width: 768px) {
            .container {
                margin: 30px auto;
                padding: 15px;
            }

            input,
            select {
                margin-bottom: 15px;
            }
        }

        @media (max-width: 480px) {
            body {
                background-color: #eef1f4;
            }

            .container {
                padding: 15px;
                margin: 20px;
                box-shadow: none;
            }

            h1 {
                font-size: 1.5em;
                margin-bottom: 15px;
            }

            input,
            select {
                padding: 10px;
                font-size: 14px;
                margin-bottom: 10px;
            }

            label {
                font-size: 14px;
                margin-bottom: 5px;
            }

            button {
                padding: 10px;
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Simulasi Pinjaman</h1>
        <form id="loanForm" action="/simulasi/process" method="POST">
            @csrf
            <label for="jenis_pinjaman">Jenis Pinjaman:</label>
            <select name="jenis_pinjaman" id="jenis_pinjaman" required>
                <option value="NON REGULER">NON REGULER</option>
                <option value="REGULER">REGULER</option>
                <option value="KPR REKANAN">KPR REKANAN</option>
                <option value="KPR NON REKANAN">KPR NON REKANAN</option>
                <option value="MULTI GUNA JAMINAN SERTIFIKAT">MULTI GUNA JAMINAN SERTIFIKAT</option>
                <option value="MULTI GUNA JAMINAN BPKB">MULTI GUNA JAMINAN BPKB</option>
                <option value="PENDIDIKAN">PENDIDIKAN</option>
                <option value="MOTOR">MOTOR</option>
                <option value="ELECTRONIC">ELECTRONIC</option>
                <option value="MOBIL">MOBIL</option>
                <option value="EMERGENCY">EMERGENCY</option>
            </select>

            <label for="gaji_bersih_struk">Gaji Bersih di Struk Gaji:</label>
            <input type="text" name="gaji_bersih_struk" id="gaji_bersih_struk" required oninput="formatRupiah(this)">

            <label for="potongan_kki">Potongan KKI:</label>
            <input type="text" name="potongan_kki" id="potongan_kki" required oninput="formatRupiah(this)">

            <label for="nilai_pinjaman">Nilai Pinjaman:</label>
            <input type="text" name="nilai_pinjaman" id="nilai_pinjaman" required oninput="formatRupiah(this)">

            <label for="jangka_waktu">Jangka Waktu (bulan):</label>
            <input type="number" name="jangka_waktu" id="jangka_waktu" required>

            <button type="submit">Hitung</button>
        </form>
    </div>

    <script>
        function formatRupiah(input) {
            let value = input.value.replace(/\D/g, '');
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            input.value = value;
        }

        document.getElementById('loanForm').addEventListener('submit', function() {
            let inputs = document.querySelectorAll('#gaji_bersih_struk, #potongan_kki, #nilai_pinjaman');
            inputs.forEach(function(input) {
                input.value = input.value.replace(/\D/g, '');
            });
        });
    </script>
</body>

</html>
