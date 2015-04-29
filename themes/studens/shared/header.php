<?php
    if ($_SERVER['HTTP_HOST'] == 'localhost') {
        define('WORDPRESS_ROOT', 'http://localhost/wordpress');
        define('OMEKA_ROOT', 'http://localhost');
        define('ATOM_ROOT', 'http://localhost/atom');
    }
    else if($_SERVER['HTTP_HOST'] == '192.168.0.18') {
        define('WORDPRESS_ROOT', 'http://192.168.0.18/wordpress');
        define('OMEKA_ROOT', 'http://192.168.0.18');
        define('ATOM_ROOT', 'http://192.168.0.18/atom');
    }
    else {
        define('WORDPRESS_ROOT', 'http://www.studens.info');
        define('OMEKA_ROOT', 'http://documents.studens.info');
        define('ATOM_ROOT', 'http://inventaires.studens.info');
    }

?>

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
        <!--
        <form>
            <input type="text" placeholder="Rehercher" required>
            <button type="submit">Search</button>
        </form>
        -->
        <div class="menu">
            <ul style="clear:both;">
                <li class="<?php echo !$this->isOmeka ? 'selected' : ''; ?>"><a href="<?php echo WORDPRESS_ROOT ?>">accueil</a></li><!--
             --><li class="<?php echo $this->isOmeka ? 'selected' : ''; ?>"><a href="<?php echo OMEKA_ROOT ?>">ressources numériques</a></li><!--
             --><li><a href="<?php echo ATOM_ROOT ?>">inventaires d'archives</a></li>
            </ul>
            <?php if($this->isOmeka): ?>
                <ul class="submenu">
                    <li><a href="/">accueil</a></li><!--
                 --><li><a href="/exhibits">expositions</a></li><!--
                 --><li><a href="/collections">collections</a></li><!--
                 --><li><a href="/fonds">fonds</a></li><!--
                 --><li><a href="/">contribuer</a></li><!--
                 --><li><a href="/items/search">recherche avancée</a></li>
                </ul>
            <?php else: ?>
                <ul class="submenu">
                    <li><a href="/">accueil</a></li>
                    <li><a href="/actualite">actualité</a></li>
                    <li><a href="/contact">contact</a></li>
                </ul>
            <?php endif; ?>   
        </div>
    </div>
</div>


