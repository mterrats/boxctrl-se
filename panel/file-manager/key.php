<?php
session_start();
if(!file_exists('../../users/' . $_SESSION['username'] . '.xml') || empty($_SESSION['username'])){
    header('Location: ../login.php');
    die;
}
?>