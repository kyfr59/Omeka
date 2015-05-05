<?php

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


$pageTitle = $this->pageTitle ? $this->pageTitle : __('Liste des fonds');
echo head(array('title'=>$pageTitle, 'bodyclass' => 'collections browse'));
?>

<?php echo drawFil($this->fil);?>

<h1 class="without-subtitle"><?php echo $pageTitle; ?> <?php // echo __('(%s au total)', $total_results); ?></h1>

<div id="list">

    <?php echo pagination_links(); ?>

    <?php
    $sortLinks[__('Title')] = 'Dublin Core,Title';
    $sortLinks[__('Auteur')] = 'Dublin Core,Creator';
    $sortLinks[__('Identifiant')] = 'Dublin Core,Identifier';    
    $sortLinks[__('Date Added')] = 'added';
    ?>

    <?php if (count($items) > 0): ?>
        <div id="sort-links">
            <span class="sort-label"><?php echo __('Sort by: '); ?></span><?php echo browse_sort_links($sortLinks); ?>
        </div>
    <?php endif; ?>

    <?php if (count($items)==0) echo "Vérifiez l’orthographe des termes de recherche. Essayez d'autres combinaisons de filtres." ?>

    <?php foreach (loop('items') as $collection): ?>

    <div class="collection">

        <?php if (metadata('item', 'has files')) {
            echo link_to_item(item_image('thumbnail'),  array('class' => 'image'));
        } else {
            echo link_to_item('<img src="'.OMEKA_ROOT.'/themes/studens/images/fallback.png" width="63" height="63"/>', array('class' => 'image'));
        }
        ?>

        <h2>
            <?php if (metadata('item', array('Dublin Core', 'Identifier'))): ?>
                <span class="identifier"><?php echo metadata('item', array('Dublin Core', 'Identifier')) ?> - </span> 
            <?php endif; ?>    
            <?php echo link_to_item(); ?>
        </h2>

        <div class="collection-description" style="min-height:40px;">
        <?php if (metadata('item', array('Dublin Core', 'Description'))): ?>
            <?php echo text_to_paragraphs(metadata('item', array('Dublin Core', 'Description'))); ?>
        <?php endif; ?>
        </div>

        <div class="item-infos">
        <?php $creators = $collection->getElementTexts('Dublin Core','Creator');  
            if(count($creators) >  0) {
                    echo '<div class="creators">';
                    foreach($creators as $creator)
                        echo '<span>Créateur : </span>'.$creator->text;
                    echo '</div>';
                }
        ?>
        </div>

        <?php fire_plugin_hook('public_items_browse_each', array('view' => $this, 'collection' => $collection)); ?>

    </div><!-- end class="collection" -->

    <?php endforeach; ?>

    <?php echo pagination_links(); ?>

</div> <!-- end list -->

<?php fire_plugin_hook('public_items_browse', array('collections'=>$collections, 'view' => $this)); ?>

<?php echo foot(); ?>

