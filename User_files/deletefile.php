<?php
session_start();

$username=$_SESSION["login"]; // on récupère le login
$id_file = $_GET['id']; // on récupère l'id du fichier à effacer


include_once("../Connexion_BD/connexpdo.php");
if($cnx=connexpdo("cloud","../Connexion_BD/myparam"))
{
	// récupération de l'id de l'utilisateur
	$sql = "SELECT * FROM user WHERE LOGIN='$username'";
    $result = $cnx->query($sql);
    $row = $result->fetch(PDO::FETCH_NUM);
    $id_user = $row[0];

    // récupération du nom du fichier
    $sql = "SELECT * FROM file WHERE id_file=$id_file";
	$result = $cnx->query($sql);
	$row = $result->fetch(PDO::FETCH_NUM);
	$filename = $row[2];
    $level = $row[5];

    // Suppression des segments de leurs emplacements physiques
    $sql = "SELECT * FROM segment WHERE id_file=$id_file";
    $result = $cnx->query($sql);   
    $i = 0;
    while($row = $result->fetch(PDO::FETCH_NUM)) {
    	$id_server = $row[1]; // on récupère le serveur où est stocké chaque segment
    	$req = " SELECT * FROM folder WHERE id_user=$id_user AND id_server=$id_server";
        $resultat = $cnx->query($req);
        $ligne = $resultat->fetch(PDO::FETCH_NUM);
        $folder = md5($ligne[2]);
        if ($level==1)
        $fileToDelete = "../Servers/Server".$id_server."/".$folder."/".$filename."_part".$i;
        else $fileToDelete = "../Servers/Server".$id_server."/".$folder."/".md5($filename."_part".$i);
        unlink($fileToDelete);
        $i++;
    }

    $req1 = " DELETE FROM segment WHERE id_file =$id_file ";
    $req2 = " DELETE FROM file WHERE id_file = $id_file " ;
    $cnx->exec($req1);
    $cnx->exec($req2);

    header('location:../interface.php');
}


?>