<?php 
require 'config.php';

// Ambil daftar barang
$barang = $conn->query("SELECT * FROM barang WHERE stok > 0");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $barang_id = $_POST['barang_id'];
    $jumlah = $_POST['jumlah'];
    
    // Validasi stok
    $stok = $conn->query("SELECT stok, harga FROM barang WHERE id = $barang_id")->fetch_assoc();
    
    if ($jumlah > $stok['stok']) {
        $_SESSION['error'] = "Stok tidak mencukupi!";
    } else {
        $subtotal = $stok['harga'] * $jumlah;
        
        // Simpan transaksi
        $conn->query("INSERT INTO transaksi1 (barang_id, jumlah, subtotal) VALUES ($barang_id, $jumlah, $subtotal)");
        
        // Update stok
        $conn->query("UPDATE barang SET stok = stok - $jumlah WHERE id = $barang_id");
        
        $_SESSION['success'] = "Transaksi berhasil!";
        header("Location: index.php");
        exit();
    }
}
?>

<!-- Tampilan Form -->
<div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6">
    <h2 class="text-2xl font-bold mb-6">Transaksi Baru</h2>
    
    <?php if(isset($_SESSION['error'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" id="form-transaksi">
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Pilih Makanan</label>
            <select name="barang_id" id="barang" class="w-full p-2 border rounded" required>
                <option value="">-- Pilih Makanan --</option>
                <?php while($row = $barang->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>" 
                        data-harga="<?= $row['harga'] ?>"
                        data-stok="<?= $row['stok'] ?>">
                    <?= $row['nama'] ?> (Rp <?= number_format($row['harga']) ?>)
                </option>
                <?php endwhile; ?>
            </select>
        </div>
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 mb-2">Harga Satuan</label>
                <input type="text" id="harga" class="w-full p-2 border rounded bg-gray-100" readonly>
            </div>
            <div>
                <label class="block text-gray-700 mb-2">Stok Tersedia</label>
                <input type="text" id="stok" class="w-full p-2 border rounded bg-gray-100" readonly>
            </div>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Jumlah</label>
            <input type="number" name="jumlah" id="jumlah" min="1" class="w-full p-2 border rounded" required>
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 mb-2">Subtotal</label>
            <input type="text" id="subtotal" class="w-full p-2 border rounded bg-gray-100 font-bold text-lg" readonly>
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="index.php" class="btn-secondary">
                <i class="fas fa-times mr-2"></i> Batal
            </a>
            <button type="submit" class="btn-primary">
                <i class="fas fa-check mr-2"></i> Simpan
            </button>
        </div>
    </form>
</div>

<script>
// Script untuk kalkulasi otomatis
document.getElementById('barang').addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    document.getElementById('harga').value = 'Rp ' + parseInt(selected.dataset.harga).toLocaleString('id-ID');
    document.getElementById('stok').value = selected.dataset.stok;
    calculate();
});

document.getElementById('jumlah').addEventListener('input', function() {
    const stok = parseInt(document.getElementById('stok').value);
    if (this.value > stok) {
        this.setCustomValidity('Jumlah melebihi stok!');
    } else {
        this.setCustomValidity('');
    }
    calculate();
});

function calculate() {
    const harga = parseInt(document.getElementById('barang').selectedOptions[0]?.dataset.harga || 0);
    const jumlah = parseInt(document.getElementById('jumlah').value || 0);
    document.getElementById('subtotal').value = 'Rp ' + (harga * jumlah).toLocaleString('id-ID');
}
</script>