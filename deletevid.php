<?php //this works
include 'includes/library.php';
//deletes movie info from database
session_start();
if(isset($_SESSION['user_id'])){ //after getting id


$pdo =  & dbconnect();

$movie_id =$_GET['movie_id'];
 $user_id = $_SESSION['user_id'];

//sql query
$sql = "DELETE FROM movie_dets WHERE movie_id=? and user_id=?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$movie_id, $user_id]);
header("Location:index.php");

}
else{
   header("Location:login.php");
   exit();
}


 ?>
