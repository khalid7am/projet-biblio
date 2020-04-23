<?php require 'config.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>Gestion du lecteur</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<?php if(!isset($_SESSION["id"])){ ?>

    <div>
        Le lecteur n'est pas reconnu<br>
        Cliquer <a href="login.php">ici</a> pour tenter une nouvelle identification 
    </div>

    <br>
    <?php require 'lecteurForm.php' ?>

<?php } else { ?>

<?php echo "*Le lecteur numero ".$_SESSION['id']." est reconnu "; ?>
<a href="deconnecter.php"> Deconnecter ? </a>
<form method="post" action="">
	<fieldset>
		<legend>Livres disponibles :</legend>
		<table border="5">
            
            <?php
                echo "<tr><td>code livre</td><td>nom auteur</td><td>prenom auteur</td><td>titre</td><td>categorie</td><td>ISBN</td><td>Choix</td></tr>";

                try
                {
                    $result=$con->query("SELECT * FROM `livres` WHERE livdejareserve=0");
                    while($row=$result->fetch()){
                        echo "<tr><td>".$row['livcode']."</td><td>".$row['livnomaut']."</td><td>".$row['livprenomaut']."</td><td>".$row['livtitre']."</td><td>".$row['livcategorie']."</td><td>".$row['livISBN']."</td><td><a href='reserverUnLivre.php?codeLivre=".$row['livcode']."'>reserver</a></td></tr>";
                    }
                }
                catch(PDOException $e){
                    $error=$e->getMessage();
                }
            ?>

		</table>
	</fieldset>
	<fieldset>
		<legend>Livres Réservés :</legend>
		<table border="5">
            <?php 
                echo "<tr><td>code livre</td><td>nom auteur</td><td>prenom auteur</td><td>titre</td><td>catégorie</td><td>ISBN</td></tr>";
                try
                {
                    $id_lecteur=$_SESSION["id"];
                    $codes_livres=$con->query("SELECT empcodelivre FROM `emprunts` WHERE empnumlect='$id_lecteur'");
                    while($row=$codes_livres->fetch()){
                        $livres=$con->query("SELECT * FROM `livres` WHERE livdejareserve=1 and livcode='$row[empcodelivre]'");
                        $row2=$livres->fetch();
                        echo "<tr><td>".$row2['livcode']."</td><td>".$row2['livnomaut']."</td><td>".$row2['livprenomaut']."</td><td>".$row2['livtitre']."</td><td>".$row2['livcategorie']."</td><td>".$row2['livISBN']."</td></tr>";
                    }
                }
                catch(PDOException $e){
                    $error=$e->getMessage();
                }
            ?>
		</table>
	</fieldset>
</form>

<?php } ?>

</body>
</html>