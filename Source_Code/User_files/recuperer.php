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
    $no_parts = $row[3];
    $key = $row[4];
    $level= $row[5];

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
        $fileToDownload = "../Servers/Server".$id_server."/".$folder."/".$filename."_part".$i;
        else $fileToDownload = "../Servers/Server".$id_server."/".$folder."/".md5($filename."_part".$i);
        $mergedfile = "../Operations/Temp/".$filename."_part".$i;
        copy($fileToDownload,$mergedfile);
        $i++;
    }

include_once("../Operations/Crypt/decrypt.php");

require_once('../Operations/Segment/split_merge.php');
$obj = new split_merge();
$merged = "../Operations/Temp/".$filename;
$obj->merge_file($merged,$no_parts) or die('Error spliting file');

decrypt_file($merged,$key);
for($i=0;$i<$no_parts;$i++)
    {
        unlink($merged."_part".$i);
    }

$full_path = "../Operations/Temp/".$filename; // chemin système (local) vers le fichier
$file_name = basename($full_path);
 
ini_set('zlib.output_compression', 0);
$date = gmdate(DATE_RFC1123);
header('Pragma: public');
header('Cache-Control: must-revalidate, pre-check=0, post-check=0, max-age=0');
header('Content-Tranfer-Encoding: none');
header('Content-Length: '.filesize($full_path));
header('Content-MD5: '.base64_encode(md5_file($full_path)));
header('Content-Type: application/octetstream; name="'.$file_name.'"');
header('Content-Disposition: attachment; filename="'.$file_name.'"');
header('Date: '.$date);
header('Expires: '.gmdate(DATE_RFC1123, time()+1));
header('Last-Modified: '.gmdate(DATE_RFC1123, filemtime($full_path)));
 
readfile($full_path);
unlink($full_path);

}
?>