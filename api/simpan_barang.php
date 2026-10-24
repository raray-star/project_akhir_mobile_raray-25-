<?php
header('Content-Type: text/plain; charset=utf-8');
require_once '../koneksi.php';

$barcode = trim($_POST['barcode'] ?? '');
$nama_barang = trim($_POST['nama_barang'] ?? '');
$kategori = trim($_POST['kategori'] ?? '');
$harga = $_POST['harga'] ?? '';
$stok = $_POST['stok'] ?? '';

if (
    $barcode === '' ||
    $nama_barang === '' ||
    $kategori === '' ||
    $harga === '' ||
    $stok === ''
) {
    echo "Data belum lengkap";
    exit;
}

if (!is_numeric($harga) || !is_numeric($stok)) {
    echo "Harga dan stok harus berupa angka";
    exit;
}

$harga = (int) $harga;
$stok = (int) $stok;

$sql = "INSERT INTO barang
        (barcode, nama_barang, kategori, harga, stok)
        VALUES (?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($koneksi, $sql);

if (!$stmt) {
    echo "Gagal menyiapkan query";
    exit;
}

mysqli_stmt_bind_param(
    $stmt,
    "sssii",
    $barcode,
    $nama_barang,
    $kategori,
    $harga,
    $stok
);

if (mysqli_stmt_execute($stmt)) {
    echo "Data barang berhasil disimpan";
} elseif (mysqli_errno($koneksi) == 1062) {
    echo "Barcode sudah terdaftar";
} else {
    echo "Gagal menyimpan data barang";
}

mysqli_stmt_close($stmt);
?>