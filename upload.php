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
        <link rel="stylesheet" type="text/css" href="css/demo.css" />
        <link rel="stylesheet" type="text/css" href="css/style2.css" />
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
                         <form  method="post" action="operations.php" autocomplete="on" enctype="multipart/form-data"> 
                                <h1>upload a file</h1> 
                            <?php
                            if (isset($_GET['Selfile'])&&$_GET['Selfile'])
                            {  
                             echo '<center><FONT COLOR="#A90D0D"><font size="2.5"><B>Choose a file to upload !</B></font></font></center>';
                            }   
                            if (isset($_GET['SelServ'])&&$_GET["SelServ"])
                            {  
                             echo '<center><FONT COLOR="#A90D0D"><font size="2.5"><B>Select at least one server !</B></font></font></center>';
                            }                  
                             ?>
                             </br>
                                <label for="userfile" class="ufile"> <B>Your file</B> </label>
                                    <input type="File" name="user_file">
                                </br></br>
                                <B>Select Servers</B>
                                </br></br>
                                    <p>
                                    <input type="checkbox" name="servers[]" value="1">&nbsp;Server 1<br>
                                    <input type="checkbox" name="servers[]" value="2">&nbsp;Server 2<br>
                                    <input type="checkbox" name="servers[]" value="3">&nbsp;Server 3<br>
                                    </p>
                                </br>
                                <B>Security level</B>
                                </br></br>
                                    <p>Low <input type="radio" name="security_level" value="1" checked="checked" ></p>
                                    <p>High<input type="radio" name="security_level" value="2" ></p>
                                <p class="login button"> 
                                    <input type="submit" value="Upload" name="Upload"/> 
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