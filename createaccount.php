<?php
//create account page
include 'includes/library.php';
session_start();
  if(isset($_POST['naccount'])){
     $errors=array();
     //get and validate the users name, must have length and at least one space
     $name=$_POST['name'];
     if(strlen($name) < 0 || strpos($name, " ")===FALSE)
      $errors[]="<h2>You must enter a valid name</h2>";

     $username=$_POST['username'] ?? null;

     //get and validate the users email
     $email = $_POST['email'];
     if (!filter_var($email, FILTER_VALIDATE_EMAIL))
      $errors[]="<h2>You must enter a valid email</h2>";

     $password=$_POST['psw'];
     $rpassword =$_POST['psw-repeat'];
     if($password == $rpassword){
          //hash function for password
          $passhash = password_hash($password, PASSWORD_DEFAULT);
     } else{
       $errors[]="<h2>Passwords do not match</h2>";
     }
     $remember=$_POST['remember'];


     // No errors...do database work
     if(sizeof($errors)==0)
     {
     //call database connection function
      $pdo = & dbconnect();

      $sql="INSERT INTO user_info (name, username, email, password) values (?,?,?,?)";
      $pdo->prepare($sql)->execute([$name, $username, $email, $passhash]);

      //Use pdo to call the id
      $_SESSION['user_id'] = $pdo->lastInsertId();
      $_SESSION['user'] = $username;


      if(!empty($remember)){ //couldn't test this
       // and password
       $cookie_name = "Vid Collection";
       $cookie_username = $username;
       setcookie($cookie_name, $cookie_username, time() + (86400 * 30), "/"); //one day
     }
     header("Location:index.php");
   }


     foreach ($errors as $error)
       echo $error;


 }



  ?>

<!DOCTYPE html>
<html lang="en">
<head>
 <?php include 'includes/head_include.php'; ?>
</head>
<body>
  <div id='container'>
     <?php $PAGE_TITLE='Create an Account';?>
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
        <form class="center" id ="createaccount" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <div id='center'>
        <div>
        <div class= "left"><label  for="name">Name:</label></div>
        <div class= "right"><input  type="text" placeholder="Enter Name" name="name" id="name"  pattern="[A-Za-z-0-9]+\s[A-Za-z-'0-9]+" required /></div>
        </div>
<div>
        <div class= "left"><label  for="usernme">Username:</label></div>
        <div class= "right"><input  type="text" placeholder="Enter Username" name="username" id="username" required/></div>
        <!-- <span class="noerror">You must enter an valid Username</span> -->
        </div>
<div>
        <div class= "left"><label  for="email">Email:</label></div>
        <div class= "right"><input type="text" placeholder="Enter Email" name="email" id="email" required/></div>
        <span class="noerror">You must enter an valid email</span>
        </div>
<div>
        <div class= "left"><label  for="psw">Password:</label></div>
        <div class= "right"><input  type="password" placeholder="Enter Password" name="psw" id="psw"  required/></div>
        </div>
<div>
        <div class= "left"> <label  for="psw-repeat">Repeat Password:</label> </div>
        <div class= "right"><input  type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" required/> </div>
        </div>
        <div class="remember"><label >
      <input type="checkbox" name="remember" /> Remember me
   </label> </div>
        <div><input type="submit" class="button" name='naccount'  value="Create An Account"/></div>
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
