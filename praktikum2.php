<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Praktikum 2 - Static Method | Matematika Class</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .card {
            max-width: 500px;
            width: 100%;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header {
            background: #2c3e50;
            color: white;
            padding: 25px;
            text-align: center;
        }

        .card-header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .card-header p {
            font-size: 14px;
            opacity: 0.8;
        }

        .card-body {
            padding: 25px;
        }

        .section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #3498db;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #555;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .button-group {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-top: 10px;
        }

        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #3498db;
            color: white;
        }

        .btn-primary:hover {
            background: #2980b9;
            transform: translateY(-2px);
        }

        .btn-success {
            background: #27ae60;
            color: white;
        }

        .btn-success:hover {
            background: #219a52;
            transform: translateY(-2px);
        }

        .btn-warning {
            background: #e67e22;
            color: white;
        }

        .btn-warning:hover {
            background: #d35400;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background: #c0392b;
            transform: translateY(-2px);
        }

        .btn-info {
            background: #1abc9c;
            color: white;
        }

        .btn-info:hover {
            background: #16a085;
            transform: translateY(-2px);
        }

        .result {
            background: #ecf0f1;
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
            text-align: center;
            border-left: 4px solid #3498db;
        }

        .result-label {
            font-size: 12px;
            color: #7f8c8d;
            margin-bottom: 5px;
        }

        .result-value {
            font-size: 22px;
            font-weight: bold;
            color: #2c3e50;
            word-break: break-word;
        }

        .result-value.error {
            color: #e74c3c;
        }

        .card-footer {
            background: #ecf0f1;
            padding: 12px;
            text-align: center;
            font-size: 12px;
            color: #7f8c8d;
        }

        @media (max-width: 480px) {
            .card-body {
                padding: 20px;
            }
            .button-group {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<div class="card">
    <div class="card-header">
        <h1>🧮 Kelas Matematika</h1>
        <p>Static Method | PHP Object Oriented Programming</p>
    </div>

    <div class="card-body">
        <form method="post">
            <!-- Bagian Operasi Matematika -->
            <div class="section">
                <div class="section-title">📊 Operasi Dua Angka</div>
                <div class="form-group">
                    <label>Angka Pertama</label>
                    <input type="number" name="angka1" step="any" placeholder="Masukkan angka pertama" 
                           value="<?php echo isset($_POST['angka1']) ? htmlspecialchars($_POST['angka1']) : ''; ?>">
                </div>
                <div class="form-group">
                    <label>Angka Kedua</label>
                    <input type="number" name="angka2" step="any" placeholder="Masukkan angka kedua" 
                           value="<?php echo isset($_POST['angka2']) ? htmlspecialchars($_POST['angka2']) : ''; ?>">
                </div>
                <div class="button-group">
                    <button type="submit" name="operasi" value="tambah" class="btn btn-primary">➕ Tambah</button>
                    <button type="submit" name="operasi" value="kurang" class="btn btn-warning">➖ Kurang</button>
                    <button type="submit" name="operasi" value="kali" class="btn btn-success">✖️ Kali</button>
                    <button type="submit" name="operasi" value="bagi" class="btn btn-danger">➗ Bagi</button>
                </div>
            </div>

            <!-- Bagian Luas Persegi -->
            <div class="section">
                <div class="section-title">📐 Luas Persegi</div>
                <div class="form-group">
                    <label>Panjang Sisi</label>
                    <input type="number" name="sisi" step="any" placeholder="Masukkan panjang sisi" 
                           value="<?php echo isset($_POST['sisi']) ? htmlspecialchars($_POST['sisi']) : ''; ?>">
                </div>
                <button type="submit" name="operasi" value="luas" class="btn btn-info" style="width: 100%;">◻️ Hitung Luas Persegi</button>
            </div>
        </form>

        <?php
        // ========== CLASS MATEMATIKA DENGAN STATIC METHOD ==========
        class Matematika {
            // Method Tambah (sesuai tugas)
            public static function Tambah($a, $b) {
                return $a + $b;
            }

            // Method Kurang (sesuai tugas)
            public static function Kurang($a, $b) {
                return $a - $b;
            }

            // Method Kali (dari kode awal)
            public static function Kali($a, $b) {
                return $a * $b;
            }

            // Method Bagi (dari kode awal)
            public static function Bagi($a, $b) {
                if ($b == 0) {
                    return "Tidak bisa membagi dengan nol!";
                }
                return $a / $b;
            }

            // Method Luas Persegi (sisi * sisi)
            public static function LuasPersegi($sisi) {
                return $sisi * $sisi;
            }
        }

        // ========== PROSES FORM ==========
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["operasi"])) {
            $operasi = $_POST["operasi"];
            $hasil = "";
            $isError = false;

            if ($operasi == "luas") {
                // Proses Luas Persegi
                if (isset($_POST["sisi"]) && is_numeric($_POST["sisi"]) && $_POST["sisi"] !== "") {
                    $sisi = (float)$_POST["sisi"];
                    $hasil = Matematika::LuasPersegi($sisi);
                    $detail = "sisi = " . $sisi;
                } else {
                    $hasil = "Masukkan panjang sisi yang valid!";
                    $isError = true;
                }
            } else {
                // Proses Operasi Tambah, Kurang, Kali, Bagi
                if (isset($_POST["angka1"]) && isset($_POST["angka2"]) && 
                    is_numeric($_POST["angka1"]) && is_numeric($_POST["angka2"]) &&
                    $_POST["angka1"] !== "" && $_POST["angka2"] !== "") {
                    
                    $a = (float)$_POST["angka1"];
                    $b = (float)$_POST["angka2"];
                    
                    switch ($operasi) {
                        case "tambah":
                            $hasil = Matematika::Tambah($a, $b);
                            $simbol = "+";
                            break;
                        case "kurang":
                            $hasil = Matematika::Kurang($a, $b);
                            $simbol = "-";
                            break;
                        case "kali":
                            $hasil = Matematika::Kali($a, $b);
                            $simbol = "×";
                            break;
                        case "bagi":
                            $hasil = Matematika::Bagi($a, $b);
                            $simbol = "÷";
                            break;
                        default:
                            $hasil = "Operasi tidak dikenal!";
                            $isError = true;
                    }
                    
                    if (!$isError && $operasi != "luas") {
                        $detail = "$a $simbol $b";
                    }
                } else {
                    $hasil = "Masukkan kedua angka dengan benar!";
                    $isError = true;
                }
            }

            // Tampilkan hasil
            echo '<div class="result">';
            echo '<div class="result-label">HASIL PERHITUNGAN</div>';
            echo '<div class="result-value ' . ($isError ? 'error' : '') . '">';
            if (isset($detail) && !$isError) {
                echo $detail . " = ";
            }
            echo $hasil;
            echo '</div></div>';
        }
        ?>
    </div>

    <div class="card-footer">
        <span>📌 Praktikum 2 - Static Method | Class Matematika</span>
    </div>
</div>

</body>
</html>