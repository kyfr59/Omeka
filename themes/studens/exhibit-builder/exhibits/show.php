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

<?php if (count(exhibit_builder_child_pages()) > 0): ?>
<nav id="exhibit-child-pages" class="secondary-nav">
    <?php echo exhibit_builder_child_page_nav(); ?>
</nav>
<?php endif; ?>

<div role="main">
<?php exhibit_builder_render_exhibit_page(); ?>

<div id="exhibit-page-navigation">
    <?php if ($prevLink = exhibit_builder_link_to_previous_page()): ?>
    <div id="exhibit-nav-prev">
    <?php echo $prevLink; ?>
    </div>
    <?php endif; ?>
    <div id="exhibit-nav-up">
    <?php echo exhibit_builder_page_trail(); ?>
    </div>
    <?php if ($nextLink = exhibit_builder_link_to_next_page()): ?>
    <div id="exhibit-nav-next">
    <?php echo $nextLink; ?>
    </div>
    <?php endif; ?>    
</div>
</div>



<?php echo foot(); ?>
