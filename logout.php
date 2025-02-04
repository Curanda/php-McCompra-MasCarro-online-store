<?php
session_start();
setcookie('mccompracookie', '', time() - 3600, "/");
session_destroy();
header("Location: index.php");
exit();
?>
