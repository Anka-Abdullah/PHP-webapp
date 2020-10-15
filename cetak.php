<?php
require_once __DIR__ . '/vendor/autoload.php';

require 'functions.php';
$mahasiswa = query("SELECT * FROM mahasiswa");

$mpdf = new \Mpdf\Mpdf();

$html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/print.css">
    <title></title>
</head>
<body>
    
<h2 style="margin: 0;">Daftar Mahasiswa</h2>
<br><br>
    <table border="1" cellpadding="10" cellspacing="0">
    
        <tr>
            <td>No. </td>
            <td>Gambar</td>
            <td>NIM</td>
            <td>Nama</td>
            <td>Email</td>
            <td>Jurusan</td>
        </tr>';
        
        $i = 1;
        foreach ($mahasiswa as $row) {
            $html .= '<tr>
                        <td>'. $i++ . '</td>
                        <td><img src="img/'. $row["foto"] . '" width="50"></td>
                        <td>'. $row["nim"]. '</td>
                        <td>' . $row["nama"] . '</td>
                        <td>' . $row["email"] . '</td>
                        <td>' . $row["fakultas"] . '</td>
                    </tr>';
        }
        
$html .= '</table>
</body>
</html>';

$mpdf->WriteHTML($html);
$mpdf->Output('daftar-mahasiswa.pdf', "I"); //lihat foto keyword_mpdf
//hT!9mJ_y_+kGDbv
?>
