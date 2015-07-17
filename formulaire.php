<?php
session_start();
include("db.php");
include("functions.php");

$username_error = "";
$email_error = "";
$password_error = "";
$password_again_error = "";

// 


	// pr($existing_username);
	// pr($existing_email);


if(!empty($_POST)){
	// pr($_POST);
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$password_again = $_POST['password_again'];

	// récupération des données existantes pour mise en conformité avec nouvelle entrée
	$sql = "SELECT username, email
			FROM users";

	$sth = $dbh->prepare($sql);
	$sth->execute();
	$users= $sth->fetchAll();

	// pr($users);

	$existing_username = [];
	$existing_email = [];

	foreach ($users as $user) {
		// pr($user);
		// foreach ($user as $username) {
			$existing_username[] = ($user['username']);
			$existing_email[] = ($user['email']);
		// }
	}

	//vérification du username
	if (empty($username)){
		$username_error = "Veuillez indiquer un mot de passe";
	}
	elseif (strlen($username)<=3) {
		$username_error = "Votre nom d'utilisateur est trop court (min 3 caractères)";
	}
	elseif (strlen($username)>255){
		$username_error = "Votre nom d'utilisateur trop long (max 255 caractères)";
	}
	elseif (in_array($username, $existing_username)) {
		$username_error = "Le nom d'utilisateur que vous avez choisi existe déjà...";
	}

	$username = strip_tags($username);

	
	// vérification de email
	if (empty($email)){
		$email_error = "Veuillez indiquer une adresse email";
	}
	elseif (strlen($email)<=4) {
		$email_error = "L'adresse email est trop courte (min 4 caractères)";
	}
	elseif (strlen($email)>255) {
		$email_error = "L'adresse email est trop longue (max 255 caractères)";
	}
	elseif (in_array($email, $existing_email)) {
		$email_error = "L'adresse email que vous avez indiqué a déjà été utilisée...";
	}

	$email = strip_tags($email);


	// vérification  de password
	if (empty($password)){
		$password_error = "Veuillez indiquer un mot de passe";
	}
	
	elseif (strlen($password) < 4) {
		$password_error = "Le mot de passe est trop court (min 4 caractères)";
	}

	$password = strip_tags($password);


	// vérification  de password_again
	if (empty($password_again)){
		$password_again_error = "Veuillez confirmer le mot de passe";
	}

	elseif ($password_again != $password) {
		$password_again_error = "Vous n'avez pas indiqué le même mot de passe";
	}

	$password_again = strip_tags($password_again);

	if($username_error == "" && $email_error == "" && $password_error == "" && $password_again_error == ""){
	$sql = "INSERT INTO users(username, email, password) 
	VALUES (:username, :email, :password)";

	$sth = $dbh->prepare($sql);
	$sth->bindValue(":username", $username);
	$sth->bindValue(":email", $email);
	$sth->bindValue(":password", $password);
	$sth->execute();
	}
	
	$_SESSION['flash'] = "Bienvenue sur notre site $username !";
	header("Location: accueil.php");
	die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Formulaire d'inscription</title>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="font-awesome/css/font-awesome.css">
	<link rel="stylesheet" href="css/style_form.css">
</head>
<body>
	

		<header>
			<h1><a href="accueil.php">Movies !</a></h1>

		</header>
	
	<div class="form_container">
		
		<form action="formulaire.php" method="post">
			<legend>Formulaire d'inscription</legend>
		
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

				<label for="email">Veuillez indiquer votre email</label>
				<input type="email" name="email" id="email">
				<div class="error">
					<p>
						<?php echo $email_error?>
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

				<label for="password">Veuillez confirmer votre mot de passe</label>
				<input type="password" name="password_again" id="password_again">
				<div class="error">
					<p>
						<?php echo $password_again_error?>
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