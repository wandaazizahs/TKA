<?php
session_start();

$db_host = "localhost";
$db_username = "root";
$db_password = "wanda";
$db_name = "cloud";

$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Inisialisasi tabel jika belum ada

initialize_database($conn);
function initialize_database($conn) {
    $conn->query("CREATE TABLE IF NOT EXISTS barang (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nama VARCHAR(100) NOT NULL,
        harga INT NOT NULL,
        stok INT NOT NULL,
        gambar VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    $conn->query("CREATE TABLE IF NOT EXISTS transaksi1 (
        id INT AUTO_INCREMENT PRIMARY KEY,
        barang_id INT NOT NULL,
        jumlah INT NOT NULL,
        subtotal INT NOT NULL,
        FOREIGN KEY (barang_id) REFERENCES barang(id),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
}

function sanitize($data) {
    global $conn;
    return $conn->real_escape_string(htmlspecialchars(trim($data)));
}
?>