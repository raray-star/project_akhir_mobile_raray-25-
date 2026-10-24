<?php

include "../koneksi.php";

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if ($username == '' || $password == '') {
    echo json_encode([
        "status" => false,
        "pesan" => "Username dan password wajib diisi"
    ]);
    exit;
}

$query = "SELECT * FROM users 
          WHERE username = '$username' 
          AND password = '$password'";

$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) > 0) {

    $data = mysqli_fetch_assoc($result);

    echo json_encode([
        "status" => true,
        "pesan" => "Login berhasil",
        "id" => $data['id'],
        "username" => $data['username'],
        "role" => $data['role']
    ]);

} else {

    echo json_encode([
        "status" => false,
        "pesan" => "Username atau password salah"
    ]);
}

?>