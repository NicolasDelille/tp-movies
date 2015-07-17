<?php

	include("connexion.php");

	$posterDirectory = 'posters/';

	$posters = array_diff(scandir($posterDirectory), array('..', '.'));

	if (file_exists($posterDirectory."not-found.jpg")){
		unlink($posterDirectory."not-found.jpg");
	}

	$toDeletes = [];
	foreach($posters as $p){

		$infos = getimagesize($posterDirectory.$p);
		$w = $infos[0];
		$h = $infos[1];

		if ($w < 300 || $w > $h){
			$toDeletes[] = $p;
		}

	}

	$sql = "DELETE FROM movies WHERE imdb_id IN ('";
	$imdb_ids = [];
	foreach($toDeletes as $toDelete){
		$imdb_id = "tt" . str_replace(".jpg", "", $toDelete);
		$imdb_ids[] = $imdb_id;
		if (file_exists($posterDirectory.$toDelete)){
			echo 'Deleting ' . $posterDirectory.$toDelete . '<br />';
			unlink($posterDirectory.$toDelete);
		}
	}

	$sql .= implode("','", $imdb_ids) . "')";

	$dbh->query($sql);
	echo "Deleted " . count($imdb_ids) . " movies from db !";