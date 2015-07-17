<?php
include("db.php");
include("functions.php");
session_start();

if(!empty($_GET['searchByKey'])){
	$keyWord = ($_GET['searchByKey']);
	
	$keySearch = '%' . $keyWord . '%';

	$sql = "SELECT id, imdb_id, title, genres
			FROM movies
			WHERE title LIKE :keySearch
			OR cast LIKE :keySearch
			OR directors LIKE :keySearch
			OR writers LIKE :keySearch
			OR genres LIKE :keySearch
			ORDER BY RAND()
			LIMIT 18";

	$sth = $dbh->prepare($sql);
	$sth->bindValue(":keySearch", $keySearch);
	$sth->execute();

	$movies= $sth->fetchAll();
	// pr($movies);

}
else{




	if(!empty($_GET['categories'])){

		$category = ($_GET['categories']);
		// pr($genre);
		// echo $genre;
		$genre = '%' . $category . '%';

		$sql = "SELECT id, imdb_id, title, genres
				FROM movies
				WHERE genres LIKE :genre
				ORDER BY RAND()
				LIMIT 18";

		$sth = $dbh->prepare($sql);
		$sth->bindValue(":genre", $genre);
		$sth->execute();

		$movies= $sth->fetchAll();
		// pr($moviesByGenre);
	}
	else{
		
		
	$sql = "SELECT id, imdb_id, title
			FROM movies
			ORDER BY RAND()
			LIMIT 18";

			$sth = $dbh->prepare($sql);

			$sth->execute();
			$movies = $sth->fetchAll();
	}
			// pr($movies);
}
	// tri par catégories
	
	// $sql = "SELECT genres
	// 		FROM movies";
			
	// $sth = $dbh->prepare($sql);

	// $sth->execute();

	// $genres = $sth->fetchAll();

	// pr($genres);
	// $categories = [];

	$categories = ["Action", "Adventure", "Thriller", "Animation", "Comedy", "Drama", "Family", "Crime", "Mystery", "Horror", "Fantasy", "Romance", "Music", "Biography", "History", "War", "Sport", "Western", "Musical"];
	sort($categories);
	// foreach ($genres as $genre) {
	// 	$arrayGenre= explode(" / "", "$genre['genres']);
	// 	// pr($arrayGenre);
	// 	foreach ($arrayGenre as $category) {
	// 		if(!in_array($category", "$categories)){
	// 			$categories[] = $category;
	// 		}
	// 	}
	// }

	// pr($categories);


	


	
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="font-awesome/css/font-awesome.css">
	<link rel="stylesheet" href="css/style.css">
	<title>Movies</title>
</head>
<body>
	<div class="container">
		<header>
			
		<h1>Movies !</h1>

		<?php 
			if(isset($_SESSION['flash'])){
				echo'<div class="welcome">';
				echo $_SESSION['flash'];
				echo'</div>';
				unset($_SESSION['flash']);
			}
		?>

		<form id="myForm" action="accueil.php" method="GET" name="categories">
							
			<label for="categories">Veuillez choisir une catégorie de film</label>
			<select name="categories" id="categories">
				<?php foreach ($categories as $category) {
					echo '<option class="validate" value=' . $category . '>' . $category . '</option>';
				}
				
				?>
			</select>
			
			
			<!-- <button class="btn" type="submit"><i class="fa fa-search"></i></button> -->
			
			
				

			

		</form>
		
		<form action="accueil.php" method="GET">
			
			<label for="searchByKey">Veuillez indiquer un mot clé</label>
			<input type="text" name="searchByKey" id="searchByKey">
			<button class="btn" type="submit"><i class="fa fa-search"></i></button>
		</form>
		
		<a class="btn-creation" href="formulaire.php">Créer un compte</a>
		<a class="btn-connexion" href="connexion.php">Se connecter</a>

		</header>
		<?php
		foreach ($movies as $movie) :
			$img = str_replace("tt","", $movie["imdb_id"]).".jpg";
			$title = $movie["title"];
			$id = $movie["id"];
		?>

		<div class="movie">

			<a href="details.php?id=<?php echo $title ?>" title="<?php echo $title ?>">
			<figure>
					
				<img src="posters/<?php	echo $img ?>" alt="<?php echo $title ?>">

				<figcaption>
				<?php
					echo $title
				?>				
				</figcaption>

			</figure>
			</a>

		</div>
		
		<?php
		endforeach;
		?>
		<a href="accueil.php" title="Charger de nouveaux films">
			<div class="movie grey">

			+

			</div>
		</a>

	</div>
	
</body>
<script type="text/javascript">
	$('.validate').on("click",function(){
		$("#myForm").submit();
		// alert("cliqué");
	});
</script>
</html>