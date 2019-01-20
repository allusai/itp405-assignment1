<?php
	// We will use PDO class (PHP Data Objects) that can be of the SQL type if needed
	// A lot of the database library uses PDO's under the hood
  $pdo = new PDO('sqlite:chinook.db');
  $sql = "
    SELECT
      genres.Name
    FROM genres
  ";
  
  
  $statement = $pdo->prepare($sql); //Let's get the sql string to be a sql statement
  
  
  $statement->execute();
  $genres = $statement->fetchAll(PDO::FETCH_OBJ);
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
      <th>Genre</th>
    </tr>
    <?php foreach($genres as $genre) : ?>
      <tr>
        <td>
          <?php 
          		//This is the redirect link for the a tag
          		$url = "tracks.php?genre=";
          		$final_url = $url . urlencode($genre->Name);
          		$tag_stuff = "<a href=\"" . $final_url . "\"> " . $genre->Name . " </a> ";
          		echo $tag_stuff;
          ?>
        </td>
      </tr>
    <?php endforeach ?>
    
    <?php if(count($genres) === 0) : ?>
    	<tr>
    		<td colspan="4"> No genres found </td>
    	</tr>
    <?php endif ?>
  </table>
</body>
</html>