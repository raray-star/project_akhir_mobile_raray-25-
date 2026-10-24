<?php
include '../koneksi.php';

$barcode = $_POST['barcode'] ?? '';

if ($barcode == '') {
    echo "Barcode belum diisi";
    exit;
}

$sql = "DELETE FROM barang WHERE barcode = '$barcode'";

if (mysqli_query($koneksi, $sql)) {
    echo "Data barang berhasil dihapus";
} else {
    echo "Gagal menghapus data barang";
}
?>
