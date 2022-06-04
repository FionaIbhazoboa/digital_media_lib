<?php include 'includes/library.php';  //adds movies to the database

session_start();
if(!isset($_SESSION['user_id']))
{ //after getting id
  header("Location:login.php");
  exit();
}

 if(isset($_POST['addvideo']))
 {


    $errors=array();
    $title=$_POST['title']?? null;
    $rating=$_POST['rating']?? null;
     $genre = $_POST['genre']?? array("empty");
     $genres =join (" ", $genre);
    //how to save genre
     $MPAA = $_POST['MPAA_Rating'] ?? array("empty");
     $MPAAr =join (" ", $MPAA);

    $year=$_POST['year'];
    if(filter_var($year, FILTER_VALIDATE_INT) == True)
    {
      $error[]= "This isn't a valid year";
   }
    $runtime=$_POST['runtime']?? null;
    $dvdr=$_POST['dvdr']?? null;
    $theatre=$_POST['theatre']?? null;
    $actor=$_POST['actor']?? null;
    //file upload
    $studio=$_POST['studio'] ?? null;
    $summary=$_POST['summary'] ?? null;
    $vidtype = $_POST['vidtype'] ?? array("empty");
    $videtype =join (" ", $vidtype);

    //call database connection function
    $pdo = & dbconnect();

    $userid = $_SESSION['user_id'];
    $sql="INSERT INTO movie_dets (Title, Rating, Genre, MPAA, Year, Runtime, theatreRelease, dvdRelease, Actors, Studio, plotSummary, videoType, user_id) values (?,?,?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?)"; //movie details field
    $pdo->prepare($sql)->execute([$title, $rating, $genres, $MPAAr, $year, $runtime, $theatre, $dvdr, $actor, $studio, $summary, $videtype, $userid]); //edit this


    $movie_id = $pdo->lastInsertId();
      $newname = createFilename('filetoProcess', 'www_data/covers/', 'cover', $movie_id);
      //file upload is limited to 1MB, WEBROOT is a const defined in the library file
      checkAndMoveFile('filetoProcess', 10240000, WEBROOT.$newname);

      $sql = "UPDATE movie_dets SET Cover = ? WHERE movie_id = $movie_id ";
      $pdo->prepare($sql)->execute([$newname]);

      header("Location:index.php");

}

 ?>


<!DOCTYPE html>
<html lang="en">
<head>
   <?php include 'includes/head_include.php'; ?>

</head>
<body>
   <div id='container'>
       <?php $PAGE_TITLE='Upload Video';?>
       <?php include 'includes/header.php';?>
   <aside>
     <nav>
      <ul>
           <li><a href="index.php">Home</a></li>
           <li><a href="search.php">Search</a></li>

      </ul>
   </nav>
</aside>
   <main>
      <!-- form to process: selfprocessing  -->
      <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
      <div id= "addvid">
      <div>
     <div class= "left"><label  for="title">Title:</label></div>
     <div class= "right"><input  type="text"  name="title" id="title" required /></div>
  </div>
  <div>
     <div class= "left"><label for="movie">Rating:</label></div>
    <div class= "right"><select name="rating" id="movie">
        <option value="0">Select One</option>
        <option value="1">One Star</option>
        <option value="2">Two Star</option>
        <option value="3">Three Star</option>
        <option value="4">Four Star</option>
    </select>
  </div>
</div>
    <div>
      <div class= "left"><label  for="genre">Genre:</label></div>
   <div class= "right"> <select name="genre[]" multiple="multiple" id="genre" >
      <option value="romance">Romance</option>
      <option value="action">Action</option>
      <option value="comedy">Comedy</option> </select></div>
 </div>
 <div class= "fieldset">
 <fieldset>
  <legend>MPAA Rating</legend>
   <input type="radio" name="MPAA_Rating[]" id="G" value="G" />
    <label for="G">G</label>
    <input type="radio" name="MPAA_Rating[]" id="PG" value="PG" />
    <label for="PG">PG</label>
    <input type="radio" name="MPAA_Rating[]" id="PG-13" value="PG-13" />
  <label for="PG-13">PG-13</label>
  <input type="radio" name="MPAA_Rating[]" id="R" value="R" />
<label for="R">R</label>
<input type="radio" name="MPAA_Rating[]" id="NC-17" value="NC-17" />
<label for="NC-17">NC-17</label>
</fieldset> </div>
   <div>
        <div class= "left"><label  for="year">Year:</label></div>
        <div class= "right"><input type="text"  name="year" id="year"/><span class="info"> yyyy</span></div>
  </div>
  <div>
       <div class= "left"><label  for="runtme">Runtime:</label></div>
       <div class= "right"><input type="text"  name="runtime" id="runtme" /> <span class="info"> ?hr ?min</span></div>
    </div>
    <div>
      <div class= "left"><label  for="Theatre">Theatre Release:</label></div>
      <div class= "right"><input type="text" class = "datepicker" id="Theatre" name="theatre" /></div>
   </div>
   <div>
     <div class= "left"><label  for="dvd">DvD Release:</label></div>
     <div class= "right"><input type="text" class = "datepicker" id="dvd" name="dvdr" /></div>
  </div>
  <div>
    <div class= "left"><label  for="actor">Actor:</label></div>
    <div class= "right"><input type="text"  name="actor" id="actor" /></div>
 </div>
 <div>
    <input type="hidden" name="MAX_FILE_SIZE" value ="10240000" />
    <div class= "left"><label  for="cover">Cover:</label></div>
    <div class= "right"><input type="file" name="filetoProcess" id="cover"/></div>
 </div>
 <div>
   <div class= "left"><label  for="studio">Studio:</label></div>
   <div class= "right"><input type="text"  name="studio" id="studio" /></div>
</div>
<div>
   <div class= "left"><label  for="summary">Plot Summary:</label></div>
   <div class= "right"><textarea name="summary" id= "summary" rows="5" cols="50"></textarea><span id="rchars">2500</span> Character(s) Remaining</div>
</div>
<div class= "fieldset">
<fieldset>
 <legend>Video Type</legend>
  <input type="radio" name="vidtype[]" id="DVD" value="DVD" />
   <label for="DVD">DVD</label>
   <input type="radio" name="vidtype[]" id="blue" value="Blu-Ray" />
   <label for="blue">Blu-Ray</label>
   <input type="radio" name="vidtype[]" id="SD" value="DigitalSD" />
   <label for="SD">Digital SD</label>
   <input type="radio" name="vidtype[]" id="HD" value="DigitalHD" />
   <label for="HD">Digital HD</label>
</fieldset> </div>

<div>
   <input class = "fieldset" type="submit" name='addvideo' value="Add Video"/>
   <input type="submit" name= 'reset'   value="Reset"/>
</div>

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
