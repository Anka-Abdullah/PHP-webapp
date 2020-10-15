<?php
//koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "phpdasar");

function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data) {
    global $conn;
    $nim = htmlspecialchars($data["nim"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $fakultas = htmlspecialchars($data["fakultas"]);

    //upload foto/gambar
    $foto = upload();
    if( !$foto ) {
        return false;
    }
    
    //query insert data
    $query = "INSERT INTO mahasiswa VALUES
            ('', '$nim', '$nama', '$email', '$fakultas', '$foto')";
    mysqli_query($conn, $query);
    //cek apakah create data berhasil atau tidak
    return mysqli_affected_rows($conn);  //jika berhasil 1 jika gagal -1   
}

function upload() {
    
    $namaFile = $_FILES['foto']['name'];
    $ukuranFile = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmpName = $_FILES['foto']['tmp_name'];
    
    //cek apakah tidak ada gambar yang di upload
    if( $error === 4) {
        echo "<script>
        alert('Pilih Gambar terlebih dahulu!');
    </script>";
    return false;
    }
     
    //cek apakah yang di upload gambar atau bukan
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
     //explode untuk memecah string menjadi array
    $ekstensiGambar = strtolower(end($ekstensiGambar)); //end untuk mengambil array urutan akhir
    // mencari $ekstensiGambar di dalam $ekstensiGambarValid
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "
    <script>
        alert('Yang anda upload bukan gambar!');
    </script>";
        return false;
    }
    //lolos pengecekan, gambar siap diupload
    //generate nama file baru untuk foto
    $namaFileBaru = uniqid();
    $namaFileBaru .= $ekstensiGambar;
    
    move_uploaded_file($tmpName, 'img/'. $namaFileBaru);
    return $namaFileBaru ;
}

function hapus($id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");
    
    return mysqli_affected_rows($conn);
}

function ubah($data)
{
    global $conn;
    
    $id = $data["id"];
    $nim = htmlspecialchars($data["nim"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $fakultas = htmlspecialchars($data["fakultas"]);
    $fotoLama = $data["fotoLama"];
    
    //cek apakah user memilih gambar baru atau tidak
    if($_FILES["foto"]["error"] === 4) {
        $foto = $fotoLama;
    }else{
        $foto = upload();
        
    }

    $query = "UPDATE mahasiswa SET
                nim = '$nim',
                nama = '$nama',
                email = '$email',
                fakultas = '$fakultas',
                foto = '$foto'
                WHERE id = $id";
    mysqli_query($conn, $query);
    
    return mysqli_affected_rows($conn); 
}

function cari($keyword) {
    $query = "SELECT * FROM mahasiswa WHERE 
    nama LIKE '%$keyword%' OR 
    nim LIKE '%$keyword%' OR 
    email LIKE '%$keyword%' OR 
    fakultas LIKE '%$keyword%'";
    return query($query);
}

function registrasi($data){
    global $conn;

    // stripslashes menghilangkan karakter simbol
    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    //mysqli_real_escape_string memungkinkan user memasukan kutip ' "
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);
    
    //cek username sama dengan yang sudah ada atau tidak
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    
    if( mysqli_fetch_assoc($result) ) {
        echo "<script>
                alert('username sudah terdaftar');
            </script>";
        return false;
    }
    
    //cek konfirmasi password
    if ( $password !== $password2 ) {
        echo "<script>
                alert('Konfirmasi Password tidak sesuai!');
            </script>";
            return false;
    }
    //enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    //tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$password')");
    
    return mysqli_affected_rows($conn);
}
?>