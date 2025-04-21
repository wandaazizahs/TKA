<?php 
require 'config.php';

// Tambah barang baru
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    
    $conn->query("INSERT INTO barang (nama, harga, stok) VALUES ('$nama', $harga, $stok)");
    $_SESSION['success'] = "Barang berhasil ditambahkan!";
    header("Location: manage.php");
    exit();
}

$barang = $conn->query("SELECT * FROM barang ORDER BY nama");
?>

<!-- Tampilkan daftar barang -->
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Daftar Makanan</h2>
        <button onclick="document.getElementById('modal-tambah').showModal()" 
                class="btn-primary">
            <i class="fas fa-plus mr-2"></i> Tambah Makanan
        </button>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Nama Makanan</th>
                    <th class="p-3 text-left">Harga</th>
                    <th class="p-3 text-left">Stok</th>
                    <th class="p-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $barang->fetch_assoc()): ?>
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3"><?= $row['nama'] ?></td>
                    <td class="p-3">Rp <?= number_format($row['harga']) ?></td>
                    <td class="p-3"><?= $row['stok'] ?></td>
                    <td class="p-3 flex space-x-2">
                        <a href="edit.php?id=<?= $row['id'] ?>" class="btn-edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="delete.php?id=<?= $row['id'] ?>" 
                           class="btn-delete"
                           onclick="return confirm('Hapus barang ini?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Barang -->
<dialog id="modal-tambah" class="p-6 rounded-lg shadow-xl w-full max-w-md">
    <form method="POST">
        <h3 class="text-xl font-bold mb-4">Tambah Makanan Baru</h3>
        
        <div class="mb-4">
            <label class="block mb-2">Nama Makanan</label>
            <input type="text" name="nama" class="w-full p-2 border rounded" required>
        </div>
        
        <div class="mb-4">
            <label class="block mb-2">Harga</label>
            <input type="number" name="harga" class="w-full p-2 border rounded" required>
        </div>
        
        <div class="mb-4">
            <label class="block mb-2">Stok Awal</label>
            <input type="number" name="stok" class="w-full p-2 border rounded" required>
        </div>
        
        <div class="flex justify-end space-x-3">
            <button type="button" onclick="document.getElementById('modal-tambah').close()" 
                    class="btn-secondary">
                Batal
            </button>
            <button type="submit" name="tambah" class="btn-primary">
                Simpan
            </button>
        </div>
    </form>
</dialog>