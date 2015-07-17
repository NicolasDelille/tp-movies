<?php
	include('connexion.php');
	include('functions.php');

	$sql = "SELECT genres
			FROM movies";
			
	$sth = $dbh->prepare($sql);

	$sth->execute();

	$genres = $sth->fetchAll();

	// pr($genres);
	$categories = [];

	foreach ($genres as $genre) {
		$arrayGenre= explode(" / ", $genre['genres']);
		// pr($arrayGenre);
		foreach ($arrayGenre as $category) {
			if(!in_array($category, $categories)){
				$categories[] = $category;
			}
		}
	}

	pr($categories);


	
	
