<?php

session_start();

// untuk memastikan session hilang
$_SESSION = [];
session_unset();

session_destroy();

setcookie('greateworld', '', time() - 3600);
setcookie('narnia', '', time() - 3600);

header("Location: login.php");
exit;

?>