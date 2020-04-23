<?php

	require 'config.php';

	// Fonctions :
	// Verification de la taille :
	function taille($valeur,$taille)
	{
		if(strlen($valeur)  > $taille)
			return "La taille doit être au max : $taille ";
		else
			return "";
	}
	// Verification des caracteres specials :
	function caracteres($valeur,$caracteres)
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
	
	// Verifier les donnees entree :
	if(isset($_POST['connect']))
	{
		$nom=$_POST["nom"];
		$pswd=$_POST['pswd'];
		$bd_err="";
		$acces=0;
		$nom_err=taille($nom,16);
		$nom_err.=caracteres($nom,"&²'\"\\/()[]{}=-+*_$^!:;,.§?%£¨@0123456789 ");
		$pswd_err=taille($pswd,80);
		if($nom_err.$pswd_err=="")
		{
			try{
				$result=$con->query("Select lecnum, lecnom, lecmotdepasse from lecteurs");
				while($row=$result->fetch())
				{
					if($row["lecnom"]==$nom && $row["lecmotdepasse"]==$pswd)
					{
						$_SESSION["id"]=$row["lecnum"];
						$acces=1;
						break;
					}
				}
				if($acces)
					header("location: gestionLecture.php");
				else
					$bd_err.="les donnés sont incorrectes !";
			}
			catch(PDOException $e){
				$bd_err.="+ ".$e->getMessage();
			}
		}
	}

?>