<?php
	include_once 'php/isLogin.php';
	include_once 'php/functionsFileShare.php';
	
	$ini = "C:/filesShareServer/";
	if(!isset($_SESSION['route']['depth'])){
		$_SESSION['route']['depth'] = 0;
	}

	$depth = $_SESSION['route']['depth'];
	$i = 0;
	
	while($i < $depth){
		$ini = $ini.$_SESSION['route'][$i];
		$i++;
	}
	
	$results = readADir($ini);
	
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>FileShare Web</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="css/normalize.min.css">
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
		<div id="logo-container">
        	<img src="img/logo.png" alt="logo Fileshareweb" height="60px" width="60px" id="logo-small"/>
            <h2>Welcome inside fileshare web!</h2>
        </div>

        
        <div class="tableContent">
            <table>
                <tr>
                    <td>Name</td>
                    <td>Size</td>
                    <td>Action</td>
                </tr>
                <?php
                    writeAsTable($results)
                ?>
            </table>
        </div>
        
        <form action="php/logout.php" method="post" name="logout_form" id="logoutform">
        	<!--<input type="button" value="Logout" onClick="this.form.submit();"/>-->
            <button onClick="this.form.submit();" id="logoutbutton">Logout</button>
        </form>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')</script>

        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>
		<!-- 
        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
        -->
    </body>
</html>