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


$pageTitle = __('Liste des collections');
echo head(array('title'=>$pageTitle,'bodyclass' => 'collections browse'));
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
    <div id="sort-links">
        <span class="sort-label"><?php echo __('Sort by: '); ?></span><?php echo browse_sort_links($sortLinks); ?>
    </div>

    <?php foreach (loop('collections') as $collection): ?>

    <div class="collection">

        <?php
            $collectionImage = null;
            $helperCollectionImage = new Omeka_Controller_Action_Helper_CollectionImage($collection);
            if($helperCollectionImage->getThumbmail()) {
                $collectionImage = '<img src="'.$helperCollectionImage->getThumbmail().'"/>';
            } 
            if($collectionImage)
                echo link_to_collection($collectionImage, array('class' => 'image'));
            else
                echo link_to_collection('<img src="'.OMEKA_ROOT.'/themes/studens/images/fallback.png" width="63" height="63"/>', array('class' => 'image'));
        ?>

        <h2>
            <?php if (metadata('collection', array('Dublin Core', 'Identifier'))): ?>
                <span class="identifier"><?php echo metadata('collection', array('Dublin Core', 'Identifier')) ?> - </span> 
            <?php endif; ?>    
            <?php echo link_to_collection(); ?>
        </h2>

        
        <div class="collection-description">
            <?php echo text_to_paragraphs(metadata('collection', array('Dublin Core', 'Description'))); ?>
        </div>
        

        <div class="item-infos">
        <?php $creators = $collection->getElementTexts('Dublin Core','Creator');  
            if(count($creators) >  0) {
                    echo '<div class="creators">';
                    foreach($creators as $creator)
                        echo '<span>Créateur : </span>'.$creator->text;
                    echo '</div>';
                }
            /*
            echo '<div class="date">';
            $date = metadata('collection', 'added');
            $dateFrench = ltrim(date("d ", strtotime($date)), '0'). strtolower($months[(int)date("m ", strtotime($date))]). date(" Y ", strtotime($date));
            echo '<span>Date : </span>'.$dateFrench;
            echo '</div><br style="clear:both;">';
            */
        ?>
        </div>

        <?php /*
        <?php if ($collection->hasContributor()): ?>
        <div class="collection-contributors">
            <p>
            <strong><?php echo __('Contributors'); ?>:</strong>
            <?php echo metadata('collection', array('Dublin Core', 'Contributor'), array('all'=>true, 'delimiter'=>', ')); ?>
            </p>
        </div>
        <?php endif; ?>

        <p class="view-items-link"><?php echo link_to_items_browse(__('View the items in %s', metadata('collection', array('Dublin Core', 'Title'))), array('collection' => metadata('collection', 'id'))); ?></p>
        */ ?>

        <?php fire_plugin_hook('public_collections_browse_each', array('view' => $this, 'collection' => $collection)); ?>

    </div><!-- end class="collection" -->

    <?php endforeach; ?>

    <?php echo pagination_links(); ?>

</div> <!-- end list -->

<?php fire_plugin_hook('public_collections_browse', array('collections'=>$collections, 'view' => $this)); ?>

<?php echo foot(); ?>

