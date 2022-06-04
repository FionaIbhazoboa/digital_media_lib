<?php //displays movie in database

session_start();
if(!isset($_SESSION['user_id'])){ //after getting id
  header("Location:login.php");
  exit();
}
else
{
   include 'includes/library.php';
   $pdo = & dbconnect();
   $user_id = $_SESSION['user_id'];
   $movie_id=$_GET['movie_id']; //get id from url
   $sql = "SELECT * FROM movie_dets where movie_id=? and user_id=?";//prepare and execute she said
   $stmt=$pdo->prepare($sql);
   $stmt->execute([$movie_id, $user_id]);

   if(!$stmt)
     die("Database pull did not return data");

    $row=$stmt->fetch();

    // print_r($row);

   // $stmt2=$pdo->query("select sum(nomCount) as total from oscar_ReportingResults");  <?php foreach ($stmt as $row):   //loop through result set
   //


}

?>


<!DOCTYPE html>
<html lang="en">
<head>
<?php include 'includes/head_include.php'; ?>
</head>
<body>
   <div id='container'>
      <?php $PAGE_TITLE="Movie Details"; ?>
      <?php include 'includes/header.php';?>

   <aside>
     <nav>
      <ul>
           <li><a href="index.php">Home</a></li>
           <li><a href="addpage.php">Add Video</a></li>
           <li><a href="editaddpage.php?movie_id=<?php echo $row['movie_id']; ?>">Edit Video</a></li>
           <li><a class="deletevid" data-title="Are you sure?" href="deletevid.php?movie_id=<?php echo $row['movie_id']; ?>" > Delete Video</a></li>
           <li><a href="search.php">Search</a></li>
           <li><a href="logout.php">Logout</a></li>
      </ul>
   </nav>
</aside>
   <main>
      <div class="center">
          <div id='centerdisplay'>
<!-- calls row of data from database  -->
             <div>
                  <img src="<?php echo "/~omonyemeibhazoboa/".$row['Cover'] ?>" alt="<?php echo $row['Title']; ?> cover"  height="200" /> <!-- For cover image. How to get it from database  -->
             </div>
             <h2><?php echo $row['Title']  //output prof name ?></h2>
             <div>
                <ul class="list">
                   <li><i class="fas fa-check-circle"></i> DVD</li>
                   <li><i class="fas fa-check-circle"></i> BluRay </li>
                   <li><i class="fas fa-times-circle"></i> Digital SD</li>
                   <li><i class="fas fa-check-circle"></i> Digital HD</li>
                </ul>
             </div>

             <table>
                <tr>
                   <td><span>MPAA:</span> <?php echo $row['MPAA']  //output prof name ?></td>
                   <td>  &nbsp;</td>
                   <td>  &nbsp;</td>
                   <td>  &nbsp;</td>
                   <td>  &nbsp;</td>
                   <td><span>Year:</span> <?php echo $row['Year']  //output prof name ?></td>
                </tr>
                <tr>
                   <td colspan="3"><span>Studio:</span> <?php echo $row['Studio']  //output prof name ?> </td>
                   <!-- <td>  &nbsp</td>
                   <td>  &nbsp</td> -->
                   <td>  &nbsp;</td>
                   <td>  &nbsp;</td>
                   <td>&nbsp; </td>
                </tr>
                <tr>
                 <td colspan="3"><span>Theatrical Release:</span> <?php echo $row['theatreRelease']  //output prof name ?></td>
                 <!-- <td>  &nbsp</td> -->
                 <!-- <td>  &nbsp</td> -->
                 <td colspan="3"><span> DVD Release:</span> <?php echo $row['dvdRelease']  //output prof name ?></td>
                 <!-- <td>  &nbsp</td>
                 <td> </td> -->
              </tr>
              <tr>
                 <td colspan="6"><span>Actors:</span> <?php echo $row['Actors']  //output prof name ?></td>
                 <!-- <td>  &nbsp</td>
                 <td>  &nbsp</td> -->
                 <!-- <td>  &nbsp</td> -->
                 <!-- <td>  &nbsp</td> -->
                 <!-- <td>&nbsp </td> -->
              </tr>
              <tr>
                 <td colspan="5"><span> Genre: </span> <?php echo $row['Genre']  //output prof name ?>  </td>
                 <!-- <td>  &nbsp</td>
                 <td>  &nbsp</td> -->
                 <!-- <td>  &nbsp</td> -->
                 <!-- <td>  &nbsp</td> -->
                 <td>&nbsp; </td>
              </tr>
             </table>
             <div class= "synopsis"><p>  <?php echo $row['plotSummary']  //output prof name ?></p></div>

          </div>
      </div>

   </main>
   <footer>
     <span>&copy; 3420 Web Dev Inc.</span>
 </footer>
</div>
</body>
</html>
