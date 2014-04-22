<?php
	session_start();

    function rd($var){
                        $x = rand(1,99);
                        for($j=0;$j<$var;$j++)
                        {
                            $tab[$j] = ($j+$x)%$var;
                        }
                        return $tab;
                    }

	if(isset($_POST['Upload']))
    {

        // Récupération des données
        $file=$_FILES['user_file'];
        $name=$file['name'];
        $size=$file['size'];
        $user=$_SESSION["login"];
        $tmp_name = $file['tmp_name'];
        $checkboxes = $_POST['servers'];
        $no_parts = count($checkboxes);
        $Table = rd($no_parts);
        $level = $_POST['security_level'];
        
        if ($name=="") 
        {
            die(header("location:upload.php?Selfile=true"));
        }
        if (!isset($_POST['servers'])) 
        {
            die(header("location:upload.php?SelServ=true"));
        }
        
        // Upload du fchier dans un dossier temporaire
        if(is_uploaded_file($tmp_name))
        {
            move_uploaded_file($tmp_name, "Operations/Temp/$name"); 
        }


        // Cryptage du fichier
        include_once("Operations/Crypt/crypt.php");
        $key = crypt_file("Operations/Temp/$name");
        
        // Connexion à la base
        include_once("Connexion_BD/connexpdo.php");
        if($cnx=connexpdo("cloud","Connexion_BD/myparam")) {

        	// Alimentation de la table FILE
        	$sql = "SELECT * FROM user WHERE LOGIN='$user'";
			$result = $cnx->query($sql);
			$row = $result->fetch(PDO::FETCH_NUM);
			$id = $row[0];
        	$req = " INSERT INTO `file` (`id_user`, `file_name`, `no_parts`, `crypt_key`, `security_level`) VALUES ('$id', '$name', '$no_parts', '$key', '$level') ";
        	$result = $cnx->query($req);
        	$id_file = $cnx->lastInsertId();


			// Segmentation du fichier
			require_once('Operations/Segment/split_merge.php');
            $obj = new split_merge();
            $name_cr = "Operations/Temp/".$name.".cr";
            $obj->split_file($name_cr,$name_cr,$no_parts) or die('Error spliting file');

            for($i=0;$i<$no_parts;$i++)
                {
                	
                    $server = $checkboxes[$Table[$i]];
                	$sql = " SELECT * FROM folder WHERE id_user=$id AND id_server=$server";
                	$result = $cnx->query($sql);
                	if(!$result)
					{
						$mes_erreur=$cnx->errorInfo();
						echo "Lecture impossible, code", $cnx->errorCode(),$mes_erreur[2];
					}
					$row = $result->fetch(PDO::FETCH_NUM);
					$folder = md5($row[2]);
					
					// Déplacement des segments aux dossiers convenables

                    $segment_name = $name."_part".$i;
                    if ($level==1)
                    rename($name_cr."_splited_".$i, "Servers/Server".$server."/".$folder."/".$segment_name);
                    else rename($name_cr."_splited_".$i, "Servers/Server".$server."/".$folder."/".md5($segment_name));

                    // Alimentation de la table SEGMENT 
					$req = " INSERT INTO `segment` (`id_server`, `id_file`, `segment_name`) VALUES ('$server', '$id_file', '$segment_name') ";
					$cnx->query($req);
                }

            // Supression du fichier crypté temporaire
            unlink($name_cr);

            header('location:interface.php');
    	}	

	}
?>