<?php //this works
include 'includes/library.php';
//deletes user's movie from database then the account.
session_start();
if(isset($_SESSION['user_id'])){ //after getting id


$pdo =  & dbconnect();

//$movie_id =$_GET['movie_id'];
 $user_id = $_SESSION['user_id'];

//sql query
$sql = "DELETE FROM movie_dets WHERE user_id=?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);

$sql = "DELETE FROM user_info WHERE user_id=?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);

$_SESSION = array();
session_destroy();
header("Location:createaccount.php");

}
else{
   header("Location:login.php");
   exit();
}








 ?>
