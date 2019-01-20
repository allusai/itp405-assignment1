<?php
	// We will use PDO class (PHP Data Objects) that can be of the SQL type if needed
	// A lot of the database library uses PDO's under the hood
  $pdo = new PDO('sqlite:chinook.db');
  $sql = "
    SELECT
      tracks.Name as TrackName,
      albums.Title,
      artists.Name as ArtistName,
      tracks.UnitPrice
    FROM tracks, albums, artists, genres
    WHERE tracks.AlbumId = albums.AlbumId
    AND albums.ArtistId = artists.ArtistId
    AND genres.GenreId = tracks.GenreId
  ";
  
  //Checks the url query parameters for a "Search" field
  if(isset($_GET['genre'])) {
  	if($_GET['genre'] == "")
		$x = "Yummy";
  	else
		$sql = $sql . ' AND genres.Name = ?'; //This is a prepared statement
  	
  }
  
  $statement = $pdo->prepare($sql); //Let's get the sql string to be a sql statement
  
  if(isset($_GET['genre'])) {
  	if($_GET['genre'] == "")
  		$x = "Yummy";
  	else
  		$statement->bindParam(1, $_GET['genre']);
  }
  
  $statement->execute();
  $results = $statement->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Week 2</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
</head>
<body>
  
  <table class="table">
    <tr>
      <th>Track Name</th>
      <th>Album Title</th>
      <th>Artist Name</th>
      <th>Cost</th>
    </tr>
    <?php foreach($results as $result) : ?>
      <tr>
        <td>
          <?php echo $result->TrackName ?>
        </td>
        <td>
          <?php echo $result->Title ?>
        </td>
        <td>
          <?php echo $result->ArtistName ?>
        </td>
        <td>
          <?php echo $result->UnitPrice ?>
        </td>
      </tr>
    <?php endforeach ?>
    
    
  </table>
</body>
</html>