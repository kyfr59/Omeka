<?php
echo head(array(
    'title' => metadata('exhibit_page', 'title') . ' &middot; ' . metadata('exhibit', 'title'),
    'bodyclass' => 'exhibits show'));
?>

<h1 style="padding-top:42px; height:53px"><?php echo metadata('exhibit', 'title'); ?></h1>

<nav id="exhibit-nav">
    <p class="nav-title" style="padding-left:3px;"><?php echo exhibit_builder_link_to_exhibit(null, 'Accueil exposition'); ?></p> 
    <?php echo exhibit_builder_page_nav(); ?>
</nav>

<div role="main">
<?php exhibit_builder_render_exhibit_page(); ?>

<div id="exhibit-page-navigation">
    
</div>

</div>



<?php echo foot(); ?>
