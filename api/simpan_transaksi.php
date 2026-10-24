<?php
header('Content-Type: application/json');

include "../koneksi.php";

$total = $_POST['total'] ?? '';
$bayar = $_POST['bayar'] ?? '';
$kembalian = $_POST['kembalian'] ?? '';
$barang_id = $_POST['barang_id'] ?? '';
$jumlah = $_POST['jumlah'] ?? '';
$harga = $_POST['harga'] ?? '';

if ($total == '' || $bayar == '' || $kembalian == '' ||
    $barang_id == '' || $jumlah == '' || $harga == '') {

    echo json_encode([
        "status" => false,
        "pesan" => "Data transaksi belum lengkap"
    ]);
    exit;
}

/* Simpan transaksi */
$query = "INSERT INTO transaksi (total, bayar, kembalian)
          VALUES ('$total', '$bayar', '$kembalian')";

if (mysqli_query($koneksi, $query)) {

    $transaksi_id = mysqli_insert_id($koneksi);

    /* Simpan detail transaksi */
    $query_detail = "INSERT INTO detail_transaksi
        (transaksi_id, barang_id, jumlah, harga, subtotal)
        VALUES (
            '$transaksi_id',
            '$barang_id',
            '$jumlah',
            '$harga',
            '" . ($harga * $jumlah) . "'
        )";

    if (mysqli_query($koneksi, $query_detail)) {

        /* Kurangi stok */
        mysqli_query(
            $koneksi,
            "UPDATE barang
             SET stok = stok - $jumlah
             WHERE id = '$barang_id'"
        );

        echo json_encode([
            "status" => true,
            "pesan" => "Transaksi berhasil disimpan",
            "transaksi_id" => $transaksi_id
        ]);

    } else {

        echo json_encode([
            "status" => false,
            "pesan" => "Detail transaksi gagal disimpan"
        ]);
    }

} else {

    echo json_encode([
        "status" => false,
        "pesan" => "Transaksi gagal disimpan"
    ]);
}
?>