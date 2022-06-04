<?php include 'includes/library.php';
session_start();
if(!isset($_SESSION['user_id']))
{ //after getting id
  header("Location:login.php");
  exit();
}
//index page
$pdo = & dbconnect();

$userid = $_SESSION['user_id'];

$sql = "SELECT * FROM movie_dets Where user_id = ?";//prepare and execute she said
$stmt=$pdo->prepare($sql);
$stmt->execute([$userid]);

if(!$stmt)
{
   die("Database pull did not return data");
}

// $row=$stmt->fetch();

$row= array();
$row= $stmt;



// //use the for each row thingggg to let it output all the data in the database
?>


<!DOCTYPE html>
<html lang="en">

<head>
 <?php include 'includes/head_include.php'; ?>
</head>

<body>
  <div id='container'>

     <?php $PAGE_TITLE='An Individual Vid Library';?>
      <?php include 'includes/header.php';?>



     <aside>
        <nav>
         <ul>
             <li><a href="index.php">Home</a></li>
             <li><a href="addpage.php">Add Video</a></li>
             <li><a href="search.php">Search</a></li>
              <li><a href="editaccount.php">Edit Account</a></li>
             <li><a href="logout.php">Logout</a></li>
         </ul>
     </nav>
  </aside>

     <main>
     <div class="center">
    <!--<div id='centerdisplay'> -->
        <div class="row">
     <?php $loop = 0;
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
   <?php $loop++;
        if ($loop % 4 ==0)
      {
         echo "</div> <div class='row'>";

      }
    ?>
<?php endforeach ?>

</div>         <div class="pre">
               <a href="#"> Previous </a>
            </div>
            <div class="next">
               <a href="#"> Next </a>
            </div>
       
    </div> <!-- end center div-->
     </main>
     <footer>
        <span>&copy; 3420 Web Dev Inc.</span>
   </footer>
</div>

</body>

</html>
