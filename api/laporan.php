<?php
include '../koneksi.php';

header('Content-Type: application/json');

$query = mysqli_query($koneksi, "
    SELECT 
        COUNT(*) AS jumlah_transaksi,
        COALESCE(SUM(total), 0) AS total_pendapatan
    FROM transaksi
");

$data = mysqli_fetch_assoc($query);

$detail = mysqli_query($koneksi, "
    SELECT id, tanggal, total, bayar, kembalian
    FROM transaksi
    ORDER BY id DESC
");

$list = [];

while ($row = mysqli_fetch_assoc($detail)) {
    $list[] = $row;
}

echo json_encode([
    "status" => true,
    "jumlah_transaksi" => $data['jumlah_transaksi'],
    "total_pendapatan" => $data['total_pendapatan'],
    "data" => $list
]);
?>