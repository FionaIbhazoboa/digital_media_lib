<?php
//search and display info in the page
include 'includes/library.php';

session_start();
if(!isset($_SESSION['user_id'])){ //after getting id
  header("Location:login.php");
  exit();
}
if(isset($_POST['search'])){

       if(preg_match("/^[a-zA-Z]+/", $_POST['sname'])){
      $search = $_POST['sname'];
      //$search= mysql_real_escape_string($search);

      $pdo = & dbconnect();

      $userid = $_SESSION['user_id'];
      //$movie_id=$_GET['movie_id'];

      $sql = "SELECT * FROM movie_dets Where user_id=? AND Title LIKE  '%" .$search."%'";//prepare and execute she saidSELECT  ID, FirstName, LastName FROM Contacts WHERE FirstName LIKE '%" . $name .  "%' OR LastName LIKE '%" . $name ."%'";
      $stmt=$pdo->prepare($sql);
      $stmt->execute([$userid]);

      if(!$stmt)
      {
         die("Database pull did not return data");
      }

      // $row=$stmt->fetch();
      $row= array();
      $row= $stmt;
      //print_r($row);
   }


   }
   else{
      echo "Enter a search word or sum";
   }



?>


<!DOCTYPE html>
<html lang="en">

<head>
<?php include 'includes/head_include.php'; ?>
</head>

<body>
  <div id='container'>
      <?php $PAGE_TITLE="Search For Movie"; ?>
      <?php include 'includes/header.php';?>

     <aside>
        <nav>
         <ul>
             <li><a href="index.php">Home</a></li>
         </ul>
     </nav>
  </aside>

     <main>
        <!-- form to process: selfprocessing  -->
        <form class="center"  action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <div id='centerdisplay'>
           <div>
              <label for="srchterm"><b>Search Term:</b></label>
              <input type="text" placeholder="Enter Search Term " name="sname" id= 'srchterm' />
                <input type="submit" name="search" value="Search" class="submitbtn"/>
        </div>
         </div>
         </form>

         <div class="center">
        <!--<div id='centerdisplay'> -->
           <div class="row">
             <?php
              $loop = 0;
              foreach ($stmt as $row):   //loop through result set ?>

         <div class="column">
         <div>
             <figure>
             <img src="<?php echo "/~omonyemeibhazoboa/".$row['Cover'] ?>" alt="<?php echo $row['Title']; ?> cover" />
             <figcaption>
              <div> <?php echo $row['Title']; ?> </div>
              <div><a href="displaypage.php?movie_id=<?php echo $row['movie_id']; ?>" > <i class="fas fa-info"></i></a>
                <a href="editaddpage.php?movie_id=<?php echo $row['movie_id']; ?>" > <i class="fas fa-pencil-alt"></i>
                <a class="deletevid" data-title="Are you sure?" href="deletevid.php?movie_id=<?php echo $row['movie_id']; ?>" > <i class="fas fa-trash-alt"></i></a> </div>
              </figcaption>
             </figure>
         </div>
      </div> <!-- end column div-->

             <?php
                 $loop++;
                     if ($loop % 4 ==0) //to display four results then wrap.
                   {
                      echo "</div> <div class='row'>";

                   }
                 ?>
             <?php endforeach ?>
        </div>
     </div> <!-- end center div-->

     </main>
     <footer>
        <span>&copy; 3420 Web Dev Inc.</span>
   </footer>

</div>

</body>


</html>
