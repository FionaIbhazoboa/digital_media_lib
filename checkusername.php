<?php

//gets username from database
  include 'includes/library.php';
  $pdo =  & dbconnect();


$username =$_GET['username'];

//sql query
$sql = "SELECT username FROM user_info WHERE username = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$username]);
if($stmt->fetchColumn()){
   echo true;
}else{
   echo false;
}








?>
