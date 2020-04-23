<?php
	require 'config.php';

	if(isset($_POST['enregistrer-livre']))
	{
		$nom_auteur = $_POST['nom_auteur'];
		$prenom_auteur = $_POST['prenom_auteur'];
		$titre = $_POST['titre'];
		$categorie = $_POST['categorie'];
		$isbn = $_POST['isbn'];

		$test=0;
		do
		{
			$livcode=random_int(1,9999999);
			$result=$con->query("select livcode from livres");
			while($row=$result->fetch())
			{
				if($row["livcode"]==$livcode)
					$test=1;
			}
		}while($test);
		// Insertion en bd
		try{
			$insert = $con->prepare("INSERT INTO livres (`livcode`, `livnomaut`, `livprenomaut`, `livtitre`, `livcategorie`, `livISBN`, `livdejareserve`) VALUES (?,?,?,?,?,?,?)");
			$data=["$livcode","$nom_auteur","$prenom_auteur","$titre","$categorie","$isbn", 0];
			$insert->execute($data);

			header('location: gestionLecture.php');
		}
		catch(PDOException $e){
			$db_err="+".$e->getMessage();
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Formulaire Livre</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<form method="Post" action="livreForm.php">
	<fieldset>
		<h2>Enregistrement d'un livre</h2>
		<span>Nom de l'auteur : </span>
		<input type="text" name="nom_auteur" required>
		<br>
		<span>Prénom de l'auteur : </span>
		<input type="text" name="prenom_auteur" required>
		<br>
		<span>Titre : </span>
		<input type="text" name="titre" name="titre" required>
		<br>
		<span>Catégorie : </span>
		<select name="categorie">
			<option value="Junior">Junior</option>
			<option value="Roman">Roman</option>
			<option value="Science-fiction">Science-fiction</option>
			<option value="Policier">Policier</option>
			<option value="Sport">Sport</option>
			<option value="Autobiographie">Autobiographie</option>
			<option value="Géographie">Géographie</option>
			<option value="Litterature">Litterature</option>
			<option value="Philosophie">Philosophie</option>
			<option value="Mathématiques">Mathématiques</option>
			<option value="Langue">Langue</option>
			<option value="Science">Science</option>
		</select>
		<br>
		<span>Numéro ISBN :</span>
		<input type="text" name="isbn" required>
	</fieldset>
	<fieldset>
		<input type="submit" name="enregistrer-livre" value="Enregistrer">
	</fieldset>
</form>

</body>
</html>