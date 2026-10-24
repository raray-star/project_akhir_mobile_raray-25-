<?php
include '../koneksi.php';

$barcode = $_POST['barcode'] ?? '';
$nama_barang = $_POST['nama_barang'] ?? '';
$harga = $_POST['harga'] ?? '';
$stok = $_POST['stok'] ?? '';

if ($barcode == '' || $nama_barang == '' || $harga == '' || $stok == '') {
    echo "Data belum lengkap";
    exit;
}

$sql = "UPDATE barang SET
        nama_barang = '$nama_barang',
        harga = '$harga',
        stok = '$stok'
        WHERE barcode = '$barcode'";

if (mysqli_query($koneksi, $sql)) {
    echo "Data barang berhasil diedit";
} else {
    echo "Gagal mengedit data barang";
}
?>
