<?php
include '../koneksi.php';

$transaksi_id = intval($_POST['transaksi_id'] ?? 0);

if ($transaksi_id <= 0) {
    echo "ID transaksi belum dipilih";
    exit;
}

mysqli_begin_transaction($koneksi);

try {

    // Hapus detail transaksi terlebih dahulu
    $sql1 = "DELETE FROM detail_transaksi 
             WHERE transaksi_id = $transaksi_id";

    if (!mysqli_query($koneksi, $sql1)) {
        throw new Exception("Gagal menghapus detail transaksi");
    }

    // Hapus transaksi utama
    $sql2 = "DELETE FROM transaksi 
             WHERE id = $transaksi_id";

    if (!mysqli_query($koneksi, $sql2)) {
        throw new Exception("Gagal menghapus transaksi");
    }

    mysqli_commit($koneksi);

    echo "Transaksi berhasil dihapus";

} catch (Exception $e) {

    mysqli_rollback($koneksi);

    echo $e->getMessage();
}
?>