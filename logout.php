<?php
require_once 'includes/config.php';

session_destroy();
setcookie('user_login', '', time() - 3600, '/');
header("Location: index.php");
exit;