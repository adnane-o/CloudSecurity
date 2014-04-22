<?php
function connexpdo ($base, $param)
{
	include_once ($param.".inc.php");
	$dsn="mysql:host=".MYHOST."; dbname=".$base;
	$user=MYUSER;
	$pass=MYPASS;
	try
	{
		$idcom = new PDO ($dsn, $user, $pass);
		return $idcom;
	}
	catch (PDOException $except)
	{
		echo "Echec de la connexion ";
		$except->getMessage();
		return FALSE;
		exit ();
	}
}
?>