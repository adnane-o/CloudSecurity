<?php
         session_start();
		 
$user=$_POST['username'];
$pass=$_POST['password'];


include_once("../Connexion_BD/connexpdo.php");
if($cnx=connexpdo("cloud","../Connexion_BD/myparam"))
{

	$req="SELECT count(*) from user where login = '".addslashes($user)."' and password = '".addslashes($pass)."'  ";
	$result = $cnx->query($req);
	$row = $result->fetch(PDO::FETCH_NUM);
		if ($row[0]==0)
		{
die(header("location:../index.php?loginFailed=true"));
		}
		else{			
					$_SESSION["login"]=$user;
					$_SESSION["password"]=$pass;
					header('Location: ../interface.php');
			}	
			
}
?>
