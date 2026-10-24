<?php
include '../koneksi.php';

header('Content-Type: application/json');

$query = mysqli_query($koneksi, "
    SELECT * FROM transaksi
    ORDER BY id DESC
");

$data = [];

while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
}

echo json_encode([
    "status" => true,
    "data" => $data
]);
?>