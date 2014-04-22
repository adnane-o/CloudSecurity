<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6 lt8"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7 lt8"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8 lt8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="UTF-8" />
        <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">  -->
        <title>ENSAT CLOUD</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="ENSAT CLOUD" />
        <meta name="keywords" content="html5, css3, form, switch, animation, :target, pseudo-class" />
        <meta name="author" content="Codrops" />
        <link rel="shortcut icon" href="../favicon.ico"> 
        <link rel="stylesheet" type="text/css" href="css/style2.css" />
        <link rel="stylesheet" type="text/css" href="css/demo.css" />
		<link rel="stylesheet" type="text/css" href="css/animate-custom.css" />
    </head>
    <body>
        <div class="container">
            <!-- Codrops top bar -->
            <div class="codrops-top">

<?php include('hello_user.php'); ?>

                <div class="clr"></div>
            </div><!--/ Codrops top bar -->
            <header>
                <h1>&nbsp;</h1>
                <h1>ENSAT <span>CLOUD</span></h1>
            </header>
            <section>				
                <div id="container_demo" >
                    <!-- hidden anchor to stop jump http://www.css3create.com/Astuce-Empecher-le-scroll-avec-l-utilisation-de-target#wrap4  -->
                    <div id="wrapper">
                        <div id="login" class="animate form">

    <?php
    $username = $_SESSION['login'];
    include_once("Connexion_BD/connexpdo.php");
    if($cnx=connexpdo("cloud","Connexion_BD/myparam"))
    {
        $sql = "SELECT * FROM user WHERE LOGIN='$username'";
        $result = $cnx->query($sql);
        $row = $result->fetch(PDO::FETCH_NUM);
        $id = $row[0];
        $sql = "SELECT * FROM FILE WHERE id_user=$id";
        $result = $cnx->query($sql);

?>
        <table cellspacing="0" class="interface">
     <tbody>
       <tr>
         <td class="head">File</td>
         <td class="head">Download</td>
         <td class="head">Delete</td>
       </tr>
       
       <?php
        echo '</tr>';
        while ($row = $result->fetch(PDO::FETCH_NUM))
        {
        echo '<tr>';
        echo '<td>'.$row[2].'</td>';
        echo '<td><a href="User_files/recuperer.php?id='.$row[0].'"><img src="images/download.png" width="20" height="20"></td>';
        echo '<td><a href="User_files/deletefile.php?id='.$row[0].'"><img src="images/delete.png" width="20" height="20"></a></td>';
        echo'</tr>';
        }
/*
       <tr>
        <td><a class="folder" href="https://github.com/northerli/localhost-directory-gui">_github/</a></td>
        <td> Folder </td>
        <td>0.88 Mb</td>
       </tr>
*/
       ?>
      </tbody>
  </table>


<?php

    }
   
    ?>
</br></br></br></br>
<div id="upload" class="animate form">
    <form  method="post" action="upload.php"> 
        <p class="login button"> 
            <input type="submit" name ="Upload" value="Upload a file" /> 
        </p>
    </form>
</div>




                        </div>
						
                    </div>
                </div>  
            </section>
        </div>
    </body>
</html>