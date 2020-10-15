<?php
session_start();

if ( !isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';
// ambil data di URL
$id = $_GET["id"];
//query data mahasiswa berdasarkan id
$mhs = query("SELECT * FROM mahasiswa WHERE id = $id")[0];

if (isset($_POST["submit"])) {
    if (ubah($_POST) > 0) {
        echo "
        <script>
        alert('Data Berhasil diubah');
        document.location.href = 'index.php';
        </script>
        ";
    } else {
        echo "
        <script>
        alert('Data Gagal diubah');
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
        <input type="hidden" name="id" value="<?= $mhs["id"]; ?>">
        <input type="hidden" name="fotoLama" value="<?= $mhs["foto"]; ?>">
        <ul>
            <li>
                <label for="nim">NIM :</label>
                <input type="text" name="nim" id="nim" required value="<?= $mhs["nim"]; ?>">
            </li>
            <li>
                <label for="nama">Nama :</label>
                <input type="text" name="nama" id="nama" required value="<?= $mhs["nama"]; ?>">
            </li>
            <li>
                <label for="email">Email :</label>
                <input type="email" name="email" id="email" required value="<?= $mhs["email"]; ?>">
            </li>
            <li>
                <label for="fakultas">Jurusan :</label>
                <input type="text" name="fakultas" id="fakultas" required value="<?= $mhs["fakultas"]; ?>">
            </li>
            <li>
                <label for="foto">Gambar :</label><br>
                <img src="img/<?= $mhs["foto"]; ?>" width="40"><br>
                <input type="file" name="foto" id="foto">
            </li>
            <li>
                <button type="submit" name="submit">Ubah Data</button>
            </li>
        </ul>
    </form>
</body>

</html>