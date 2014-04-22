<?php

// Récupération des données de l'utilisateur
$username = $_POST["usernamesignup"];
$email = $_POST["emailsignup"];
$password = $_POST["passwordsignup"];

// Connexion à la base de données
include_once("../Connexion_BD/connexpdo.php");
if($cnx=connexpdo("cloud","../Connexion_BD/myparam"))
{
	// Insertion dans la table user
	$sql = "SELECT count(*) FROM user WHERE LOGIN='$username'";
	$result = $cnx->query($sql);
	$row = $result->fetch(PDO::FETCH_NUM);
	$nrows = $row[0];
	if ($nrows>0)
		die(header("location:../index.php?Logexist=true#toregister"));

	$sql = " INSERT INTO user (`login`, `email`, `password`) VALUES ('$username', '$email', '$password') ";
	$cnx->query($sql);
	
	// Création des dossiers pour chaque serveur
	$sql = "SELECT * FROM user WHERE LOGIN='$username'";
	$result = $cnx->query($sql);
	$row = $result->fetch(PDO::FETCH_NUM);
	$id = $row[0];
	
	for($i=1;$i<4; $i++) 
	{
		$foldername = $username."_".$i;
		$sql = " INSERT INTO folder(`id_server`, `id_user`, `folder_name`) VALUES('$i','$id','$foldername') ";
		$cnx->query($sql);
		mkdir("../Servers/Server".$i."/".md5($foldername));
	}
	// Redirection vers l'index
	header('location:../index.php');
}
?>