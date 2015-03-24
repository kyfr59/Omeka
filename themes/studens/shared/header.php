<?php
    if ($_SERVER['HTTP_HOST'] == 'localhost')
        define('OMEKA_ROOT', 'http://localhost');
    else if($_SERVER['HTTP_HOST'] == '192.168.0.18')
        define('OMEKA_ROOT', 'http://192.168.0.18');
    else
        define('OMEKA_ROOT', 'http://documents.studens.info');
?>

<link href="<?php echo OMEKA_ROOT ?>/themes/studens/shared/shared.css" media="screen" rel="stylesheet" type="text/css" >
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


