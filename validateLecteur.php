<?php

	require 'config.php';

	// Fonctions :
	// Verification de la taille :
	function verifierLaTaille($valeur,$taille)
	{
		if(strlen($valeur)  > $taille)
			return "La taille doit être au max : $taille ";
		else
			return "";
	}

	// Verification des caracteres specials :
	function verifierCaracteres($valeur,$caracteres)
	{
		$i=0;$j=0;
		for($i=0;$i<strlen($valeur);$i++)
		{
			$test=true;
			for($j=0;$j<strlen($caracteres);$j++)
				if($valeur[$i]==$caracteres[$j])
					$test=false;
			if(!$test)
				return "Certains caractères ne sont pas autorisés !";
		}
		return "";
	}

	// insertion de lecteur en base de donnee
	function insererLecteur($nom,$prenom,$adresse,$ville,$postal,$pswd, $con)
	{
		// creation du numero de lecteur
		$test=0;
		do
		{
			$num=random_int(1,9999999999999999);
			$result=$con->query("select lecnum from lecteurs");
			while($row=$result->fetch())
			{
				if($row["lecnum"]==$num)
					$test=1;
			}
		}while($test);
		// Insertion en bd
		try{
			$insert = $con->prepare("INSERT INTO lecteurs (`lecnum`, `lecnom`, `lecprenom`, `lecadresse`, `lecville`, `leccodepostal`, `lecmotdepasse`) VALUES (?,?,?,?,?,?,?)");
			$data=["$num","$nom","$prenom","$adresse","$ville","$postal","$pswd"];
			$insert->execute($data);
			return $num;
		}
		catch(PDOException $e){
			$db_err="+".$e->getMessage();
		}
	}

	// Affichage du lecteur inseré
	function afficherLecteur($nom,$prenom,$adresse,$ville,$postal,$pswd, $num)
	{
		echo "==========> Affichage de lecteur crée :<br>";
		echo "Nom: ".$nom."<br>Prénom: ".$prenom."<br>Adresse: ".$adresse."<br>Ville: ".$ville."<br>code Postal: ".$postal."<br>Mot de passe: ".$pswd."<br>Numéro: ".$num;
		echo "<br>==========> Enregistrer un autre Lecteur ? ou <a href='login.php'> Retour et authentifier ? </a>";
	}

	// Verifier les donnees entree :
	if(isset($_POST['enregistrer-lecteur']))
	{
		$nom=$_POST['nom'];
		$prenom=$_POST['prenom'];
		$adresse=$_POST['adresse'];
		$ville=$_POST['ville'];
		$postal=$_POST['postal'];
		$pswd=$_POST['pswd'];
		$db_err="";
		$nom_err=verifierLaTaille($nom,16);
		$nom_err.=verifierCaracteres($nom,"&²'\"\\/()[]{}=-+*_$^!:;,.§?%£¨@0123456789 ");
		$prenom_err=verifierLaTaille($prenom,16);
		$prenom_err.=verifierCaracteres($prenom,"&²'\"\\/()[]{}=-+*_$^!:;,.§?%£¨@0123456789 ");
		$adresse_err=verifierLaTaille($adresse,80);
		$adresse_err.=verifierCaracteres($adresse,"&²'\"\\/()[]{}=-+*$^!:;§?%£¨@");
		$ville_err=verifierLaTaille($ville,16);
		$ville_err.=verifierCaracteres($ville,"&²'\"\\/()[]{}=+*$^!:;,.§?%£¨@0123456789");
		$postal_err=verifierLaTaille($postal,10);
		$postal_err.=verifierCaracteres($postal,"&²'\"\\/()[]{}=+*$^!:;,.§?%£¨@azertyuiopqsdfghjklmwxcvbn AZERTYUIOPQSDFGHJKLMWXCVBN");
		$pswd_err=verifierLaTaille($pswd,80);
		if($nom_err.$prenom_err.$adresse_err.$ville_err.$postal_err.$pswd_err=="")
		{
			// verification si le nom.prenom existe deja puis l'insertion et l'affichage:
			if(empty($db_err)){
				try{
					$query="Select lecnom from lecteurs";
					$result=$con->query($query);
					$test=0;
					while($row=$result->fetch())
					{
						if($row["lecnom"]==$nom){
							$db_err="Le nom a été déjà utilisé !";
							$test=1;
							break;
						}
					}
					if(!$test){
						$num = insererLecteur($nom,$prenom,$adresse,$ville,$postal,$pswd, $con);
						afficherLecteur($nom,$prenom,$adresse,$ville,$postal,$pswd, $num);
					}
				}
				catch(PDOException $e){
					$db_err="+".$e->getMessage();
				}
			}
		}
	}

?>