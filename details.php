<?php
	include("db.php");
	include("functions.php");

	$id = $_GET["id"];
	if(!empty($id)){

		// echo $id;

		$sql = "SELECT id, imdb_id, title, year, cast, directors, writers, genres, plot, rating, votes, runtime, trailer_url, date_created, date_modified
				FROM movies
				WHERE title = :title";

		$sth = $dbh->prepare($sql);

		$sth -> bindValue(":title", $id);

		$sth->execute();

		$movie = $sth->fetch();

		$img = str_replace("tt","", $movie["imdb_id"]).".jpg";
		
		// echo $movie['cast'];
		$cast = explode("/", $movie['cast']);
		// pr($cast);

		

		// pr($movie);

	}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/style_details.css">
	<title>Détail du film</title>
</head>
<body>
	<div class="container">
		<div class="image">
			<img class="poster" src="posters/<?php echo $img ?>" alt="<?php echo $movie['title'] ?>">
		</div>
		<div class="content">		
			<h2><?php echo $movie['title']?> (<small><?php echo $movie['year']?></small>)</h1>
				
			<p><a href="#"><?php echo $movie['genres']?></a> | <?php echo $movie['runtime']?></p>

			<div class="rating"><img class="logo" src="images/etoile.jpg" alt=""><span class="rate"><?php echo $movie['rating']?></span></div>

			<p><em><?php echo $movie['plot']?></em></p>
			
			<p><span>Directors :</span> <?php echo $movie['directors']?></p>
			<p><span>Writers :</span> <?php echo $movie['writers']?></p>
			<p><span>Cast :</span> 
				
				<?php 
				
				$i=0;
				$actor = "";
				while ($i<6 && $i<count($cast)) {
					$actor .= $cast[$i] . ", ";
					$i++;
				}
				$actor .= '<em>' . '<a class="hide" href="#">' ."voir plus d'acteurs..." .'</a>'. '</em>';
				echo $actor;

				?>
				<span class="hidden">
				<?php 
					foreach ($cast as $key) {
						echo $key;
					}
				?>
				</span>

			</p>
			
			<p><a href="<?php echo $movie['trailer_url']?>"><em>See the trailer</em></a></p>
			
			
		</div>
	
	</div>
	<script type="text/javascript">
		$('.hide').on("click",function(){
			// alert('cliqué');
			$('.hide').fadeOut(100);
			$('.hidden').fadeIn(100);
		});
	</script>
</body>
</html>