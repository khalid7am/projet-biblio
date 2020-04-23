<?php 
	require 'config.php';
	if(!isset($_SESSION["id"]))
		header("location: login.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Réserver un livre</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>


<?php
if(isset($_GET["codeLivre"]))
{
	try
	{
		$result=$con->query("SELECT * FROM livres WHERE livcode = '$_GET[codeLivre]' ");
		$row=$result->fetch();
		$nom=$row["livnomaut"];
		$prenom=$row["livprenomaut"];
		$titre=$row["livtitre"];
		$categorie=$row["livcategorie"];
		$isbn=$row["livISBN"];
	}
	catch(PDOException $e){
		$error=$e->getMessage();
	}

echo "<fieldset>Code Livre :".$_GET["codeLivre"]."<br>Nom Auteur :".$nom."<br>Prenom Auteur :".$prenom."<br>Titre de livre :".$titre."<br>Categorie :".$categorie."<br>ISBN :".$isbn."</fieldset><fieldset><form method='post' action='reserverUnLivre.php?id=".$_GET["codeLivre"]."'><input type='submit' name='get' value='Valider'>&nbsp Ou =><a href='gestionLecture.php'>Annuler ! </a></form></fieldset>"; 
}
elseif(isset($_POST["get"]))
{
	try
	{
		$chars="0123456789POIUYTREZAQSDFGHJKLMNBVCXW";
		$i=0;$num="XXXXXXXXXX";
		for($i=0;$i<10;$i++)
			$num[$i]=$chars[rand(0,35)];
		
		$date1=date("Y-m-d");
		$date2=date('Y-m-d', strtotime($date1. ' + 5 days'));
		$code=$_GET["id"];
		$lecteur=$_SESSION["id"];
		$con->query("INSERT INTO `emprunts`(`empnum`, `empdate`, `empdateret`, `empcodelivre`, `empnumlect`) VALUES ('$num','$date1','$date2','$code','$lecteur')");
		$con->query("UPDATE `livres` SET `livdejareserve`=1 WHERE livcode='$code'");
		echo "Votre Réservaton est confirmé sous le code : $num <br>";
		echo "Date de la réservation&nbsp&nbsp: $date1 <br>";
		echo "Date de Retour du livre : $date2 <br>";
		echo "Vous pouvez retour a la liste des livres disponible a reservé en cliquant <a href='gestionLecture.php'>ici</a>";
	}
	catch(PDOException $e){
		$error=$e->getMessage();
	}
}

?>

</body>
</html>