<?php
    require_once '../core/init.php';
    unset($_SESSION['SBUser']);
    header('Location: login.php');
?>
