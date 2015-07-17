<?php

	//Mes fonctions

	// convertit une date du format MySQL, vers le français

	function convertDateToFrench($dateMysql)
	{
		$unix = strtotime($dateMysql);

		$frenchDate = date("d-m-Y à H:i:s", $unix);

		return $frenchDate;
	}

	// crée un print_r entre balises <pre> pour afficher un tableau
	
	function pr($table) //pour "typer" l'argument, on peut indiquer function pr(array $table){}
	{

		echo '<pre style="background-color : #000 ; color : #35F21A">';
		print_r($table);
		echo "</pre>";

	}

	// compte les lignes de BDD ayant la même caractéristique

	function countDb($id, $value)
	{
		global $dbh;
		$sql = "SELECT COUNT(*) AS vote_count
					FROM votes
					WHERE idea_id = :id 
					AND liked = $value";

		$sth = $dbh->prepare($sql);
		$sth -> bindValue(":id", $id);
		
		$sth->execute();
		$votesResult = $sth->fetchColumn();

		return $votesResult;

	}
