<?php 
	if(isset($_SESSION["id"]))
		header("location: gestionLecture.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Formulaire Lecteur</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<?php require "validateLecteur.php"; ?>

<form method="Post" action="lecteurForm.php">
	<fieldset>
		<legend>Enregistrement d'un lecteur</legend>
		<span>Nom : </span>
		<input type="text" name="nom" value="<?php if(!empty($nom)) echo $nom; ?>" required>
		<span> <?php if(!empty($nom_err)) echo $nom_err; ?> </span><br>
		<br>

		<span>Prénom : </span>
		<input type="text" name="prenom" value="<?php if(!empty($prenom)) echo $prenom; ?>" required>
		<span> <?php if(!empty($prenom_err)) echo $prenom_err; ?> </span><br>
		<br>

		<span>Adresse : </span>
		<input type="text" name="adresse" value="<?php if(!empty($adresse)) echo $adresse; ?>" required>
		<span> <?php if(!empty($adresse_err)) echo $adresse_err; ?> </span><br>
		<br>

		<span>Ville : </span>
		<input type="text" name="ville" value="<?php if(!empty($ville)) echo $ville; ?>" required">
		<span> <?php if(!empty($ville_err)) echo $ville_err; ?> </span><br>
		<br>

		<span>Code postal : </span>
		<input type="text" name="postal" value="<?php if(!empty($postal)) echo $postal; ?>" required>
		<span> <?php if(!empty($postal_err)) echo $postal_err; ?> </span><br>
		<br>
		
		<span>Mot de passe : </span>
		<input type="password" name="pswd" value="" required><br>
		<span> <?php if(!empty($pswd_err)) echo $pswd_err; ?>  </span>
	</fieldset>
	<fieldset>
		<input type="submit" name="enregistrer-lecteur" value="Enregistrer">
		<?php if(!empty($db_err)) echo $db_err; ?>
	</fieldset>
</form>

</body>
</html>