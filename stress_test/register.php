<?php 
	include_once('include/initialization.php');
	ob_start(); //Help for redirection with header

	$name 	   	= cleaner($_POST['name']);
	$email 	   	= cleaner($_POST['email']);
	$flag 	   	= false; //Shows errors and success
	$responses 	= [
		'error' 	=> "Ton adresse mail ne semble pas juste...",
		'success' 	=> "Ta demande d'inscription à bien été envoyée, tu vas recevoir un email de validation."
	];

	if( !empty($_POST['name']) ){
		die();
	}

	if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
		if ( filter_var($email, FILTER_VALIDATE_EMAIL) === false ) {
			$flag = false;
		} else{
			$content = $email . " s'est inscrit a la newsletter !";

			$flag = true;
			if ( ! mail('jeremie.rindone@gmail.com', 'Mailinglist !', $content) ){
				$flag = false;
				die('email pas envoyé :(');
			}

			// Data base sent informations
			$uniqid = uniqid();
            $date = date( "Y-m-d H:i:s");
            
            $sql = "INSERT INTO users(email, subscribed,register_date, role, confirmed, uniqid) 
            VALUES(:email, :subscribed, :register_date, :role, :confirmed, :uniqid)";

            $preparedStatement = $connexion->prepare( $sql );
            
            $preparedStatement->bindValue( 'email', $email );
            $preparedStatement->bindValue( 'register_date', $date );
            $preparedStatement->bindValue( 'role', 'reader' );
            $preparedStatement->bindValue( 'confirmed', 0 );
            $preparedStatement->bindValue( 'subscribed', 'no' );
            $preparedStatement->bindValue( 'uniqid', $uniqid );
            
            $result = $preparedStatement->execute();
            $link = "http://jeremierindone.be/stress_test/subscribed-complete.php?id=".$uniqid;
            mail( $email,
              'Merci pour ton inscription',
              'Clique sur ce lien: ' . $link . ' pour confirmer ton inscription à la newsletter');
		}
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
		<a class="home--btn" href="admin-connexion.php"><i class="fa fa-cog"></i></a>
		<h1 class="title">Viens, on est bien !</h1>
		<p class="description">Dans le cadre du Stress Test du cour de PHP, j’ai décidé de créer une newsletter qui va permettre aux élèves de recevoir un email lorsqu’une sortie est prévue. En effet, quand on sera au bar, prêt à boire nos chopes, un email sera automatiquement envoyé via la mailinglist !</p>	
		<form class="home--form" action="" method="post">
			<label class="name home--label" for="name">Ton nom</label>
			<input class="name home--input" id="name" type="text" name="name">

			<label class="home--label" for="email">Sois prévenu de nos sorties, ajoute ton adresse mail !</label> <br>
			<?php 
				if( $_SERVER['REQUEST_METHOD'] == 'POST' && $flag == false ){
					echo '<p class="alert">' . $responses['error'] . '<p>';
				} 
				if( $_SERVER['REQUEST_METHOD'] == 'POST' && $flag == true ){
					header('Location: subscribed.php');
					exit;
				}
			?>
			<input class="home--input" id="email" type="mail" name="email" placeholder="super-student@etud.infographie-sup.eu" value="<?php echo $email; ?>"> <br>
			<button class="home--submit" type="submit">Envoyer !</button>
		</form>
	</div> <!-- CONTAINER -->	

	<!-- SCRIPT -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/jquery-2.1.1.min.js"><\/script>')</script>
	<script src="js/main.js"></script>
	<!-- SCRIPT END -->
</body> 
</html>