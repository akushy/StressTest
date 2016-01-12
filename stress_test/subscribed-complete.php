<?php 
	include_once( 'include/initialization.php' );

	$reponse = $connexion->query('SELECT id, email FROM users ORDER BY ID');
	// while ($donnees = $reponse->fetch()){
	// 	echo '<p><strong>' . htmlspecialchars($donnees['id']) . '</strong> : ' . htmlspecialchars($donnees['email']). '</p>';
	// }
	$reponse->closeCursor();

   if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {

       $uniqid = $_GET["id"];

       //SELECT * FROM `users` WHERE `uniqid`='569521e85153e
       $sql = 'SELECT * FROM users WHERE uniqid = :uniqid';
       $preparedStatement = $connexion->prepare( $sql );
       $preparedStatement->bindValue( 'uniqid', $uniqid );
       $preparedStatement->execute();
       $user = $preparedStatement->fetch();

       if ( $user ) {
           $sql = 'UPDATE users SET subscribed = :subscribed, confirmed = :confirmed WHERE uniqid = :uniqid';
           $preparedStatement = $connexion->prepare( $sql );
           $preparedStatement->bindValue( 'subscribed', 1 );
           $preparedStatement->bindValue( 'confirmed', 1 );
           $preparedStatement->bindValue( 'uniqid', $user["uniqid"] );
           $preparedStatement->execute();

           $message = "Tout est OK !";

       } else {
           $message = "MERDE !";
       }
       // echo "<div class='alert alert-dismissible alert-success'><p><strong>" . $message . "</strong></p></div>";
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
		<h1 class="title"><?php echo $message; ?></h1>
		<p class="description">Reste plus qu'a attendre wesh !</p>
		<p class="description">Pendant ce temps, occupe toi de ta famille,</p>
		<p class="description">de tes amis, des gens que tu aimes !</p><br>
		<p class="description">Ou bien tu continues à apprendre PHP ;)</p>
	</div> <!-- CONTAINER -->	

	<!-- SCRIPT -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/jquery-2.1.1.min.js"><\/script>')</script>
	<script src="js/main.js"></script>
	<!-- SCRIPT END -->
</body> 
</html>