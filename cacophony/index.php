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
    <script type='text/javascript' src='js/jquery.ba-hashchange.min.js'></script>
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
		
		  <h2>Accueil</h2>
		<p>Ce site permet de créer des pages avec des vidéos interactives.</p>
			<p><u>Comment faire ?</u><br><br>
			1) Rendez-vous dans la section Vidéos qui listera les vidéos que vous aurez importées. Vous pourrez alors choisir d'importer une vidéo.<br>
			Attention, il faudra fournir 3 fichiers vidéos aux formats mp4, ogv et webM pour une seule vidéo.<br><br>
			2) Une fois la vidéo (3 fichiers) importée, il suffit de cliquer sur le bouton Éditer la vidéo à coté d'un des fichiers pour accéder à la page d'édition.
			Vous pourrez ajouter divers effets à la vidéo et cliquer sur Envoyer pour constater le résultat.<br><br>
			3) Le lien vers les pages contenant les vidéos que vous aurez éditées sera disponible dans la section Pages créées.<br>
			Vous pourrez alors utiliser ce lien pour importer ces pages comme ressources via le module URL par exemple.</p>
		
		</div>
		</section>
		
	</div>
	
	<footer>
	  &copy;Polytech
	</footer>


</body>

</html>