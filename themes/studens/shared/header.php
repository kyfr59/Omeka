<?php
	if ($_SERVER['HTTP_HOST'] == 'localhost')
		define('OMEKA_ROOT', 'http://localhost');
	else if($_SERVER['HTTP_HOST'] == '192.168.0.18')
		define('OMEKA_ROOT', 'http://192.168.0.18');
	else
		define('OMEKA_ROOT', 'http://documents.studens.info');
?>

<?php

// Retrieving last articles from OMEKA API
$months[01] = 'Janvier';
$months[02] = 'Février';
$months[03] = 'Mars';
$months[04] = 'Avril';
$months[05] = 'Mai';
$months[06] = 'Juin';
$months[07] = 'Juillet';
$months[08] = 'Août';
$months[09] = 'Septembre';
$months[10] = 'Octobre';
$months[11] = 'Novembre';
$months[12] = 'Décembre';

$url = 'http://documents.studens.info/api/items';
$headerArray = get_headers($url, 1);
$howMany = ceil($headerArray['Omeka-Total-Results'] / 50);
$json_string = "http://documents.studens.info/api/items?page=" . $howMany;
$jsondata = file_get_contents($json_string);

$articles = array_reverse(json_decode($jsondata));
$articles = array_slice($articles, 0, 3); // Keep only the 3 last articles
foreach ($articles as $article) {
	$date = $articles[0]->added;
	echo $dateFrench = date("d ", strtotime($date)). strtolower($months[(int)date("m ", strtotime($date))]). date(" Y ", strtotime($date));
	echo $title =  $article->element_texts[1]->text;
	echo $content = $article->element_texts[0]->text;
}

?>
<link href="<?php echo OMEKA_ROOT ?>/themes/studens/shared/header.css" media="screen" rel="stylesheet" type="text/css" >
<div id="header-studens">
	<div id="header-content">

		<a title="Retour à l'accueil" class="logo-studens" href="/">Accueil</a>

		<div class="social">
			<a href="#"><img src="<?php echo OMEKA_ROOT ?>/themes/studens/images/menu-facebook.png" /></a>
			<a href="#"><img src="<?php echo OMEKA_ROOT ?>/themes/studens/images/menu-twitter.png" /></a>
			<a href="#"><img src="<?php echo OMEKA_ROOT ?>/themes/studens/images/menu-google.png" /></a>
			<a href="#"><img src="<?php echo OMEKA_ROOT ?>/themes/studens/images/menu-vimeo.png" /></a>
			<a href="#"><img src="<?php echo OMEKA_ROOT ?>/themes/studens/images/menu-flickr.png" /></a>
			<a href="#"><img src="<?php echo OMEKA_ROOT ?>/themes/studens/images/menu-rss.png" /></a>
		</div>

		<form>
        	<input style="height:32px !important" type="text" placeholder="Rehercher" required>
        	<button type="submit">Search</button>
    	</form>
		
		<div class="menu">
			<ul style="clear:both;">
				<li><a href="#">accueil</a></li><!--
	  	     --><li class="selected"><a href="#">ressources numériques</a></li><!--
	  		 --><li><a href="#">inventaires d'archives</a></li>
			</ul>
			<ul class="submenu">
				<li><a href="#">accueil</a></li><!--
	  	     --><li><a href="#">expositions</a></li><!--
	  		 --><li><a href="#">collections</a></li><!--
	  		 --><li><a href="#">contribuer</a></li><!--
	  		 --><li><a href="#">recherche avancée</a></li>
			</ul>
		</div>
	</div>
</div>


