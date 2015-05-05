<?php
$pageTitle = __('Search Items');
echo head(array('title' => $pageTitle,
           'bodyclass' => 'items advanced-search'));
?>

<?php echo drawFil($this->fil); ?>

<h1><?php echo $pageTitle; ?></h1>
<!--
<nav class="items-nav navigation secondary-nav">
    <?php echo public_nav_items(); ?>
</nav>
-->
<p class="presentation">Le moteur de recherche vous permet d'accéder aux ressources numériques ainsi qu'aux expositions du portail Studens. Deux choix s'offrent à vous : une recherche simple, plein texte, ou une recherche avancée vous permettant de croiser différents critères.</p>

<?php echo $this->partial('items/search-form.php',
    array('formAttributes' =>
        array('id'=>'advanced-search-form'))); ?>

<?php echo foot(); ?>