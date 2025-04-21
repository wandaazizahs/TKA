<?php 
require 'config.php';

if (!isset($_GET['id'])) {
    header("Location: manage.php");
    exit();
}

$id = $_GET['id'];
$barang = $conn->query("SELECT * FROM barang WHERE id = $id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    
    $conn->query("UPDATE barang SET nama='$nama', harga=$harga, stok=$stok WHERE id=$id");
    $_SESSION['success'] = "Barang berhasil diupdate!";
    header("Location: manage.php");
    exit();
}
?>

<!-- Form Edit -->
<div class="max-w-md mx-auto bg-white rounded-lg shadow p-6">
    <h2 class="text-2xl font-bold mb-6">Edit Makanan</h2>
    
    <form method="POST">
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Nama Makanan</label>
            <input type="text" name="nama" value="<?= $barang['nama'] ?>" class="w-full p-2 border rounded" required>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Harga</label>
            <input type="number" name="harga" value="<?= $barang['harga'] ?>" class="w-full p-2 border rounded" required>
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 mb-2">Stok</label>
            <input type="number" name="stok" value="<?= $barang['stok'] ?>" class="w-full p-2 border rounded" required>
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="manage.php" class="btn-secondary">
                Batal
            </a>
            <button type="submit" class="btn-primary">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>