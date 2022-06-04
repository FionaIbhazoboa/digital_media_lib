<?php
//lets user log in and saves their user_id
 include 'includes/library.php';
 if(isset($_POST['login'])){

 $pdo = & dbconnect();
  $error=false;

//do a validation then create userid
$username=$_POST['username'] ?? null;
$password=$_POST['psw'];
$rpassword=$_POST['psw-repeat'];

if ($password == $rpassword)
   {
      $sql= "SELECT * FROM user_info WHERE username=?";
      $stmt=$pdo->prepare($sql);
      $stmt->execute([$username]);
      $row=$stmt->fetch();

      if(empty($row)){
         header("Location: createaccount.php");
         exit();
      }
      elseif(!empty($row) && $row && password_verify($password, $row['password'])){
         session_start();
         $_SESSION['user_id'] = $row['user_id'];
            //$_SESSION['user'] = $row['username'];

         header("Location: index.php");
         exit();
      }
      else
      {
        $error=true;
        echo "There is an issue on our end";
      }

   }
else
   {
      $error=true;
      echo "Password does not match.";
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
     <?php $PAGE_TITLE='Login';?>
      <?php include 'includes/header.php';?>


     <aside>
        <nav>
         <ul>

             <li><a href="createaccount.php">Create Account</a></li>
         </ul>
     </nav>
  </aside>
     <main>
        <!-- form to process: selfprocessing  -->
        <form class="center" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">

        <div id='center'>

<div>
        <div class= "left"><label  for="username">Username:</label></div>
        <div class= "right"><input  type="text" placeholder="Enter Username" name="username" id="username" required/></div>
        </div>

<div>
        <div class= "left"><label  for="psw">Password:</label></div>
        <div class= "right"><input  type="password" placeholder="Enter Password" name="psw" id="psw" required/></div>
        </div>
<div>
        <div class= "left"> <label  for="psw-repeat">Repeat Password:</label> </div>
        <div class= "right"><input  type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat"  required/> </div>
        </div>
        <div class="remember"><label>
      <input type="checkbox" name="remember" /> Remember me </label> </div>
        <div><input type="submit" id="login" class="button button-block" name='login' value="Login"/></div>
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
