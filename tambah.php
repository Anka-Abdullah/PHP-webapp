<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

if (isset($_POST["submit"])) {

    if (tambah($_POST) > 0) {
        echo "
        <script>
        alert('Data Berhasil ditamahkan');
        document.location.href = 'index.php';
        </script>
        ";
    } else {
        echo "
        <script>
        alert('Data Gagal ditamahkan');
        document.location.href = 'index.php';
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah data</title>
</head>

<body>
    <h1>Tambah Data Mahasiswa</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <ul>
            <li>
                <label for="nim">NIM :</label>
                <input type="text" name="nim" id="nim">
            </li>
            <li>
                <label for="nama">Nama :</label>
                <input type="text" name="nama" id="nama">
            </li>
            <li>
                <label for="email">Email :</label>
                <input type="email" name="email" id="email">
            </li>
            <li>
                <label for="fakultas">Jurusan :</label>
                <input type="text" name="fakultas" id="fakultas">
            </li>
            <li>
                <label for="foto">Gambar :</label>
                <input type="file" name="foto" id="foto">
            </li>
            <li>
                <button type="submit" name="submit">Tambah Data</button>
            </li>
        </ul>
    </form>
</body>

</html>