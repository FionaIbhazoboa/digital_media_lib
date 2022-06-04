<?php
//edits account
include 'includes/library.php';
session_start();
if(!isset($_SESSION['user_id'])){ //after getting id
  header("Location:login.php");
  exit();
}
$pdo = & dbconnect();

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM user_info WHERE user_id=?";//prepare and execute she said
$stmt=$pdo->prepare($sql);
$stmt->execute([$user_id]);

if(!$stmt)
 die("Database pull did not return data");

$row=$stmt->fetch();

  if(isset($_POST['edit'])){
      $user_id = $_SESSION['user_id'];
     $errors=array();
     //get and validate the users name, must have length and at least one space
     $name=$_POST['name'];
     if(strlen($name) < 0 || strpos($name, " ")===FALSE)
      $errors['name']="<h2>You must enter a valid name</h2>";

     $username=$_POST['username'] ?? null;

     //get and validate the users email
     $email = $_POST['email'];
     if (!filter_var($email, FILTER_VALIDATE_EMAIL))
      $errors[]="<h2>You must enter a valid email</h2>";

     $password=$_POST['psw'];
     $rpassword =$_POST['psw-repeat'];
     if($password == $rpassword && $password != null){
          // password_hash ( string $password , int $algo [, array $options ] ) : string
          //md5(mysqli_real_escape_string($connect, $_POST["member_password"]));
          $passhash = password_hash($password, PASSWORD_DEFAULT);
          $sql="UPDATE user_info set name=?, username=?, email=?, password=? WHERE user_id=?"; //id???
          $pdo->prepare($sql)->execute([$name, $username, $email, $passhash, $user_id]);
           header("Location:logout.php");
     }
     elseif ($password == null) {

        $sql="UPDATE user_info set name=?, username=?, email=? WHERE user_id=?"; //id???
        $pdo->prepare($sql)->execute([$name, $username, $email, $user_id]);

         header("Location:logout.php");
        // code...
     }
   }


  ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'includes/head_include.php'; ?>
</head>
<body>
  <div id='container'>
     <?php $PAGE_TITLE='Edit Account';?>
      <?php include 'includes/header.php';?>

     <aside>
        <nav>
         <ul>
             <li><a href="index.php">Home</a></li>
             <li><a href="editaccount.php">Edit Account</a></li>
             <li><a class="delete" data-title="Are you sure?" href="deleteaccount.php">Delete Account</a></li>
         </ul>
     </nav>
  </aside>
     <main>
        <!-- form to process: selfprocessing  -->
        <form class="center" id="editaccount" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <div id='center'>
        <div>
        <div class= "left"><label  for="name">Name:</label></div>
        <div class= "right"><input  type="text" placeholder="Enter Name" name="name" id="name"  pattern="[A-Za-z-0-9]+\s[A-Za-z-'0-9]+" value= "<?php echo $row['name']  //output prof name ?>" /></div>
        </div>
<div>
        <div class= "left"><label  for="username">Username:</label></div>
        <div class= "right"><input  type="text" placeholder="Enter Username" name="username" id="username" value= "<?php echo $row['username']  //output prof name ?>" /></div>
        </div>
<div>
        <div class= "left"><label  for="email">Email:</label></div>
        <div class= "right"><input type="text" placeholder="Enter Email" name="email" id="email" value= "<?php echo $row['email']  //output prof name ?>" /></div>
        <span class="noerror">You must enter an valid email</span>

        </div>
<div>
        <div class= "left"><label  for="psw">Password:</label></div>
        <div class= "right"><input  type="password" placeholder="Enter Password" name="psw" id="psw" /></div>
        </div>
<div>
        <div class= "left"> <label  for="psw-repeat">Repeat Password:</label> </div>
        <div class= "right"><input  type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" /> </div>
        </div>
        <div class="remember"><label >
      <input type="checkbox" name="remember" /> Remember me
   </label> </div>
        <div><input type="submit" class="button" name='edit'  value="Confirm"/></div>
        </div>
     </form>
     </main>
     <footer>
        <span>&copy; 3420 Web Dev Inc.</span>
   </footer>
</div>

<div>Icons made by <a href="https://www.flaticon.com/authors/good-ware"
   title="Good Ware">Good Ware</a> from <a href="https://www.flaticon.com/"
   title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/"
   title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
</body>
</html>
