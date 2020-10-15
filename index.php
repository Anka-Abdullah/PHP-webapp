<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
require 'functions.php';

//pagination
$jumlahDataPerhalaman = 2;
$result = mysqli_query($conn, "SELECT * FROM mahasiswa");
$jumlahData  = mysqli_num_rows($result); //menhitung jumlah baris(data) pada $result

$jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman); //ceil membulatkan desimal ke atas => 1,2 >> 2

$halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1; //menggunakan operator ternary pengganti if else

$awalData = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;

$mahasiswa = query("SELECT * FROM mahasiswa LIMIT $awalData, $jumlahDataPerhalaman");



//tombol cari ditekan
if (isset($_POST["cari"])) {
    $mahasiswa = cari($_POST["keyword"]);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @media print {

            .logout,
            .tambah,
            .cari,
            .aksi {
                display: none;
            }
        }
    </style>
    <title>kelas 21</title>
</head>

<body>
    <a href="logout.php" class="logout">logout</a> | <a href="cetak.php" target="_blank">cetak</a>
    
    <h2 style="margin: 0;">Daftar Mahasiswa</h2>
    <form action="" method="post" class="tambah">
        <input type="text" name="keyword" size="40" autofocus placeholder="masukan keyword pencarian... " autocomplete="off">
        <button type="submit" name="cari">Cari!</button>
    </form>

    <!-- navigasi halaman -->
    <?php if ($halamanAktif > 1) : ?>
        <a href="?page=<?= $halamanAktif - 1; ?>">&laquo;</a>
    <?php endif; ?>
    <!--  -->
    <?php for ($i = 1; $i <= $jumlahHalaman; $i++) : ?>
        <?php if ($i == $halamanAktif) : ?>
            <a href="?page=<?= $i; ?>" style="background-color: red;"><?= $i; ?></a>
        <?php else : ?>
            <a href="?page=<?= $i; ?>"><?= $i; ?></a>
        <?php endif; ?>
    <?php endfor; ?>
    <!--  -->
    <?php if ($halamanAktif < $jumlahHalaman) : ?>
        <a href="?page=<?= $halamanAktif + 1; ?>">&raquo;</a>
    <?php endif; ?>


    <br>
    <a href="tambah.php">Tambah data mahasiswa</a><br><br>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <td>No. </td>
            <td class="aksi">Aksi</td>
            <td>Gambar</td>
            <td>NIM</td>
            <td>Nama</td>
            <td>Email</td>
            <td>Jurusan</td>
        </tr>
        <?php $i = 1; ?>
        <?php foreach ($mahasiswa as $row) : ?>
            <tr>
                <td><?= $i; ?></td>
                <td class="aksi">
                    <a href="ubah.php?id=<?= $row["id"] ?>">ubah</a>
                    <a href="hapus.php?id=<?= $row["id"] ?>" onclick="return confirm('yakin..?');">hapus</a>
                </td>
                <td><img src="img/<?= $row["foto"]; ?>" width="50"></td>
                <td><?= $row["nim"]; ?></td>
                <td><?= $row["nama"]; ?></td>
                <td><?= $row["email"]; ?></td>
                <td><?= $row["fakultas"]; ?></td>
            </tr>
            <?php $i++; ?>
        <?php endforeach; ?>

    </table>

</body>

</html>