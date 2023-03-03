<?php 
session_start();
session_unset();
session_destroy();

if (isset($_COOKIE['debug'])) {
    unset($_COOKIE['debug']);
    setcookie('debug', '', time() - 3600, '/');
}

header("Location: /index.php");
exit();