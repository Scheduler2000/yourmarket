<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../controller/navigation.php');

Navigation::init_navigation();

session_destroy();
session_unset();

$home_page = Navigation::home_page();

echo "<script>alert('successfully disconnected !')</script>";
echo "<script>window.location = '{$home_page}';</script>";
