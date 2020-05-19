<?php
require_once $_SERVER['DOCUMENT_ROOT'] . 'php/inc/inc.all.php';

if (isset($_GET['mail'])) {
    $userMail = $_GET['mail'];
}
if (confirmMail($userMail)) {
    header('Location: login.php');
}