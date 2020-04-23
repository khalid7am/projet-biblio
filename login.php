<?php 
	require "connexion.php";

	if(isset($_SESSION["id"]))
		header("location: gestionLecture.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Connecter</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

	<form method="Post" action="login.php">
		<fieldset>
			<legend>Connecter vous :</legend>
			<span>Nom de lecteur : </span>
			<input type="text" name="nom" value="<?php if(!empty($nom)) echo $nom; ?>" required>
			<span> <?php if(!empty($nom_err)) echo $nom_err; ?> </span>
			<br>
			<span>Mot de passe : </span>
			<input type="password" name="pswd" required>
			<span> <?php if(!empty($pswd_err)) echo $pswd_err; ?> </span>
		</fieldset>
		<fieldset>
			<input type="submit" name="connect" value="Login">
			<?php if(!empty($bd_err)) echo $bd_err; ?>
		</fieldset>
	</form>

</body>
</html>