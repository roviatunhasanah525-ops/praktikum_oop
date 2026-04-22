<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Praktikum 3 - Sistem Produk Sederhana</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        .container { max-width: 800px; margin: auto; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #2c3e50; color: white; }
        .produk-item { background: #f8f9fa; margin: 10px 0; padding: 10px; border-radius: 5px; }
        .total { background: #27ae60; color: white; padding: 10px; border-radius: 5px; margin: 15px 0; }
        .transaksi { background: #ecf0f1; padding: 15px; border-radius: 5px; margin-top: 20px; }
        button, .btn-beli { background: #3498db; color: white; padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer; }
        .btn-transaksi { background: #27ae60; font-size: 16px; padding: 10px 20px; }
        input { padding: 8px; margin: 5px 0; width: 100px; }
        .alert { padding: 10px; border-radius: 5px; margin: 10px 0; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-warning { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
    </style>
</head>
<body>
<div class="container">
    <h1>🛒 Sistem Produk Sederhana</h1>

    <?php
    // ========== CLASS PRODUK ==========
    class Produk {
        public static $jumlahProduk = 0;
        private $daftarProduk = [];
        
        public function tambahProduk($nama, $harga) {
            self::$jumlahProduk++;
            $this->daftarProduk[] = [
                'id' => self::$jumlahProduk,
                'nama' => $nama,
                'harga' => $harga
            ];
        }
        
        public function getDaftarProduk() {
            return $this->daftarProduk;
        }
        
        public static function getTotalProduk() {
            return self::$jumlahProduk;
        }
    }

    // ========== CLASS TRANSAKSI ==========
    class Transaksi {
        final public function prosesTransaksi($items, $total) {
            echo "<div class='alert alert-success'>";
            echo "<strong>✅ Transaksi Berhasil Diproses!</strong><br>";
            echo "📅 Waktu: " . date('d-m-Y H:i:s') . "<br>";
            echo "🛍️ Total Item: " . count($items) . " produk<br>";
            echo "💰 Total Pembayaran: Rp " . number_format($total, 0, ',', '.') . "<br>";
            echo "<hr>";
            echo "<strong>📋 Detail Pembelian:</strong><br>";
            foreach ($items as $item) {
                echo "- " . $item['nama'] . " : Rp " . number_format($item['harga'], 0, ',', '.') . "<br>";
            }
            echo "</div>";
        }
    }

    // ========== MEMBUAT PRODUK (Minimal 3 Produk) ==========
    $produkManager = new Produk();

    // Membuat 3 produk sesuai tugas
    $produkManager->tambahProduk("Laptop Gaming", 15000000);
    $produkManager->tambahProduk("Smartphone Flagship", 8000000);
    $produkManager->tambahProduk("Headphone Wireless", 750000);

    $daftarProduk = $produkManager->getDaftarProduk();
    $totalProduk = Produk::getTotalProduk();
    ?>

    <!-- TAMPILAN TOTAL PRODUK -->
    <div class="total">
        <strong>📊 Total Produk Tersedia: <?php echo $totalProduk; ?> produk</strong>
    </div>

    <!-- TAMPILAN DAFTAR PRODUK -->
    <h2>📦 Daftar Produk</h2>
    <table>
        <thead>
            <tr><th>ID</th><th>Nama Produk</th><th>Harga</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            <?php foreach ($daftarProduk as $produk): ?>
            <tr>
                <td><?php echo $produk['id']; ?></td>
                <td><?php echo $produk['nama']; ?></td>
                <td>Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></td>
                <td>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="produk_id" value="<?php echo $produk['id']; ?>">
                        <input type="hidden" name="produk_nama" value="<?php echo $produk['nama']; ?>">
                        <input type="hidden" name="produk_harga" value="<?php echo $produk['harga']; ?>">
                        <button type="submit" name="action" value="tambah_keranjang" class="btn-beli">🛒 Tambah ke Keranjang</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php
    // ========== PROSES KERANJANG (SESSION) ==========
    session_start();
    
    // Inisialisasi keranjang jika belum ada
    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = [];
    }
    
    // Tambah ke keranjang
    if (isset($_POST['action']) && $_POST['action'] == 'tambah_keranjang') {
        $id = $_POST['produk_id'];
        $nama = $_POST['produk_nama'];
        $harga = $_POST['produk_harga'];
        
        if (isset($_SESSION['keranjang'][$id])) {
            $_SESSION['keranjang'][$id]['qty']++;
        } else {
            $_SESSION['keranjang'][$id] = [
                'nama' => $nama,
                'harga' => $harga,
                'qty' => 1
            ];
        }
        echo "<div class='alert alert-success'>✅ $nama berhasil ditambahkan ke keranjang!</div>";
    }
    
    // Hapus dari keranjang
    if (isset($_POST['action']) && $_POST['action'] == 'hapus_keranjang') {
        $id = $_POST['produk_id'];
        $nama = $_SESSION['keranjang'][$id]['nama'];
        unset($_SESSION['keranjang'][$id]);
        echo "<div class='alert alert-warning'>🗑️ $nama dihapus dari keranjang!</div>";
    }
    
    // Update quantity
    if (isset($_POST['action']) && $_POST['action'] == 'update_qty') {
        $id = $_POST['produk_id'];
        $qty = $_POST['qty'];
        if ($qty > 0) {
            $_SESSION['keranjang'][$id]['qty'] = $qty;
        } else {
            unset($_SESSION['keranjang'][$id]);
        }
    }
    
    // Proses transaksi
    if (isset($_POST['action']) && $_POST['action'] == 'proses_transaksi') {
        if (count($_SESSION['keranjang']) > 0) {
            $items = [];
            $total = 0;
            
            foreach ($_SESSION['keranjang'] as $item) {
                $subtotal = $item['harga'] * $item['qty'];
                $total += $subtotal;
                $items[] = [
                    'nama' => $item['nama'] . " ({$item['qty']}x)",
                    'harga' => $subtotal
                ];
            }
            
            $transaksi = new Transaksi();
            $transaksi->prosesTransaksi($items, $total);
            
            // Kosongkan keranjang setelah transaksi
            $_SESSION['keranjang'] = [];
        } else {
            echo "<div class='alert alert-warning'>⚠️ Keranjang masih kosong! Silakan pilih produk terlebih dahulu.</div>";
        }
    }
    ?>

    <!-- TAMPILAN KERANJANG -->
    <h2>🛍️ Keranjang Belanja</h2>
    <?php if (count($_SESSION['keranjang']) > 0): ?>
        <table>
            <thead>
                <tr><th>Produk</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                <?php 
                $grandTotal = 0;
                foreach ($_SESSION['keranjang'] as $id => $item): 
                    $subtotal = $item['harga'] * $item['qty'];
                    $grandTotal += $subtotal;
                ?>
                <tr>
                    <td><?php echo $item['nama']; ?></td>
                    <td>Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
                    <td>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="produk_id" value="<?php echo $id; ?>">
                            <input type="number" name="qty" value="<?php echo $item['qty']; ?>" min="1" style="width: 60px;">
                            <button type="submit" name="action" value="update_qty">Update</button>
                        </form>
                    </td>
                    <td>Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                    <td>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="produk_id" value="<?php echo $id; ?>">
                            <button type="submit" name="action" value="hapus_keranjang" style="background: #dc3545;">Hapus</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                <tr style="background: #f8f9fa; font-weight: bold;">
                    <td colspan="3" align="right">TOTAL</td>
                    <td colspan="2">Rp <?php echo number_format($grandTotal, 0, ',', '.'); ?></td>
                </tr>
            </tbody>
        </table>
        
        <form method="post">
            <button type="submit" name="action" value="proses_transaksi" class="btn-transaksi">✅ Proses Transaksi</button>
        </form>
    <?php else: ?>
        <div class="alert alert-warning">Keranjang masih kosong. Silakan pilih produk terlebih dahulu.</div>
    <?php endif; ?>
    
</div>
</body>
</html>