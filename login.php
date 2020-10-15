<?php
session_start();
require 'functions.php';

//cek cookie
if ( isset($_COOKIE['greateworld']) && isset($_COOKIE['narnia']) ) {
    $id = $_COOKIE['greateworld'];
    $key = $_COOKIE['narnia'];
    
    //ambil userame berdasarkan id
    $result = mysqli_query($conn, "SELECT username FROM user WHERE id = $id");
    $row =  mysqli_fetch_assoc($result);
    
    //cek cookie dan username
    if($key === hash('sha256', $row['username'])){
        $_SESSION['login'] = true;
    }
}

if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST["login"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    //cek username
    if (mysqli_num_rows($result) === 1) {

        //cek password
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            //sett session
            $_SESSION["login"] = true;

            //cek remember me
            if( isset($_POST["remember"]) ) {
                // buat cookie
                //membuat cookie untuk id(greateworld) & username(narnia)
                setcookie('greateworld', $row['id'], time() + 60*60);
                setcookie('narnia', hash('sha256', $row['username']), time() + 60 * 3);
            }
            
            header("Location: index.php");
            exit;
        }
    }
    $error = true;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        label {
            display: block;
        }
    </style>
    <title>Halaman Login</title>
</head>

<body>
    <h1>Halaman Login</h1>

    <?php if (isset($error)) : ?>
        <p style="color: red;">Username/Password salah!</p>
    <?php endif; ?>

    <form action="" method="post">
        <ul>
            <li>
                <label for="username">Username :</label>
                <input type="text" name="username" id="username">
            </li>
            <li>
                <label for="password">Password :</label>
                <input type="password" name="password" id="password">
            </li>
            <li>
                <input type="checkbox" name="remember" id="remember">
                <table for="remember">Remember me</table>
            </li>
            <li>
                <button type="submit" name="login">Login</button>
            </li>
        </ul>
    </form>
</body>

</html>