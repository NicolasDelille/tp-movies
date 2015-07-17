<?php
session_start();
include("db.php");
include("functions.php");

$username_error = "";
$password_error = "";

	$sql = "SELECT id, username, password
			FROM users";

	$sth = $dbh->prepare($sql);
	$sth->execute();
	$users= $sth->fetchAll();

	$user=[];
	foreach ($users as $user) {
		pr($user);
	}
	$user;

	// pr($users);
if (!empty($_GET)) {
	// contrôle de username
	// if (condition) {
	// 	# code...
	// }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Page de connexion</title>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="font-awesome/css/font-awesome.css">
	<link rel="stylesheet" href="css/style_form.css">
	<link rel="stylesheet" href="css/style_connexion.css">
</head>
<body>
	

		<header>
			<h1><a href="accueil.php">Movies !</a></h1>

		</header>
	
	<div class="form_container">
		
		<form action="formulaire.php" method="post">
			<legend>Connectez-vous pour accéder à Movies !</legend>
		
			<div class="form-group">
			
				<label for="username">Veuillez indiquer votre pseudo</label>
				<input type="text" name="username" id="username">
				<div class="error">
					<p>
						<?php echo $username_error?>
					</p>
				</div>

			</div>
			
			<div class="form-group">

				<label for="password">Veuillez indiquer votre mot de passe</label>
				<input type="password" name="password" id="password">
				<div class="error">
					<p>
						<?php echo $password_error?>
					</p>
				</div>
			
			</div>

			<div class="form-group">
				<button class="btn" type="submit">Valider</button>
			</div>
		
		</form>

	</div>

</body>
</html>