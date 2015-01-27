<?php
	//recuperer le nom de l'utilisateur
	require_once((dirname(dirname(dirname(dirname(__FILE__))))).'/config.php');
	Global $USER;
	$username=$USER->username;
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	
	<title>Création de pages synchronisées sur des vidéos</title>
	
	<link rel='stylesheet' type='text/css' href='css/styleDyn.css' />
	
	<!--[if IE]>
      <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	
	<script src="build/jquery-1.11.1.min.js"></script>
    <script type='text/javascript' src='js/dynamicpage.js'></script>
	
</head>

<body>

	<div id="page-wrap">

        <header>
		  <h1>Bienvenue sur Learnphony <?php echo $username?></h1>
		
		  <nav>
		      <ul class="group">
		          <li><a href="index.php">Accueil</a></li>
		          <li><a href="pages.php">Pages créées</a></li>
				  <li><a href="videoList.php">Vidéos</a></li>
		      </ul>
		  </nav>
		</header>
		
		<section id="main-content">
		<div id="guts">
		  <iframe src="uploadVideo.html" width=100% height=700px>
			<p>Your browser does not support iframes.</p>
		</iframe>
		</div>
		</section>
		
		<footer>
		  &copy;Polytech
		</footer>
			
	</div>
	

</body>

</html>