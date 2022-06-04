<?php
//should delete session. 
include 'includes/library.php';
session_start();

$_SESSION = array();
session_destroy();

header("Location: login.php");

 ?>
