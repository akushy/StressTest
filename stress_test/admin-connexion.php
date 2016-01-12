<?php
	include_once('include/initialization.php');

	define('USERNAME', 'admin');
	define('PASSWORD', 'admin');

	$name 	   	 = cleaner($_POST['name']);
	$flag 	   	 = false;
	// $admin_login = cleaner($_POST['admin_login']);
	// $admin_pass  = cleaner($_POST['admin_pass']);
	$responses 	 = [
		'error' 	 => "Ton adresse mail ne semble pas juste...",
		'pass-error' => "Login ou mot de passe invalide !",
		'success' 	 => "Ta demande d'inscription à bien été envoyée, tu vas recevoir un email de validation."
	];

	if( !empty($_POST['name']) ){
		die();
	}

	if( $_SERVER['REQUEST_METHOD'] == 'POST'){
		$username = $_POST['USERNAME'];
		$password = $_POST['PASSWORD'];

		if( $username === 'admin' && $password === 'admin' ){
			// $_SESSION['username'] = $username;
			header('Location: admin.php');
			echo "C'est coul";
		} else {
			$status = "C'est pas juste khey !";
			echo "NON!";
		}
		print_r($_POST);
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Stress Test | Jérémie Rindone</title>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,200,300,600,700,900' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
</head>

<body>
	<div class="container">
		<h1 class="title">Administrateur(s) zone !</h1>
		<p class="description">Si t'es un administrateur, connecte-toi en mettant tes identifiants...</p>	
		<form class="home--form" action="" method="post">
			<label class="name home--label" for="name">Ton nom</label>
			<input class="name home--input" id="name" type="text" name="name">

			<label class="home--label admin--label" for="admin_login">Ton identifiant</label> <br>
			<input class="home--input admin--input" id="admin_login" type="mail" name="admin_login" placeholder="admin" value="<?php echo $admin_login; ?>"> <br>

			<label class="home--label admin--label" for="admin_password">Ton mot de passe</label> <br>
			<input class="home--input admin--input" id="admin_password" type="password" name="admin_password" placeholder="1234" value="<?php echo $admin_pass; ?>"> <br>
			<?php 
				if( $_SERVER['REQUEST_METHOD'] == 'POST' && $flag == false ){
					echo '<p class="alert">' . $responses['pass-error'] . '<p>';
				} 
			?>
			<button class="home--submit " type="submit">Envoyer !</button>
		</form>
	</div> <!-- CONTAINER -->	

	<!-- SCRIPT -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/jquery-2.1.1.min.js"><\/script>')</script>
	<script src="js/main.js"></script>
	<!-- SCRIPT END -->
</body> 
</html>