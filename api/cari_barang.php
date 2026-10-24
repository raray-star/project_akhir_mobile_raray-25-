<?php

include "../koneksi.php";

$barcode = $_POST['barcode'] ?? '';

if ($barcode == '') {
    echo json_encode([
        "status" => false,
        "pesan" => "Barcode kosong"
    ]);
    exit;
}

$query = "SELECT * FROM barang WHERE barcode = '$barcode'";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) > 0) {

    $data = mysqli_fetch_assoc($result);

    echo json_encode([
        "status" => true,
        "id" => $data['id'],
        "barcode" => $data['barcode'],
        "nama_barang" => $data['nama_barang'],
        "harga" => $data['harga'],
        "stok" => $data['stok']
    ]);

} else {

    echo json_encode([
        "status" => false,
        "pesan" => "Barang tidak ditemukan"
    ]);
}

?>