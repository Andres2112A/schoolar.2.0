<?php
// filepath: c:\xampp\htdocs\schoolar.2.0\src\backend\logout.php
session_start();
session_unset();
session_destroy();
header('Location: ../login.html');
exit();