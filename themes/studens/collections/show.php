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


echo head(array('bodyclass' => 'collections browse'));
?>

<?php
$collectionTitle = strip_formatting(metadata('collection', array('Dublin Core', 'Title')));
?>

<h1><?php echo $collectionTitle; ?> <span><?php echo __('(%s au total)', $this->total_results); ?></span></h1>


<div id="list">

    <?php
    $sortLinks[__('Title')] = 'Dublin Core,Title';
    $sortLinks[__('Auteur')] = 'Dublin Core,Creator';
    $sortLinks[__('Identifier')] = 'Dublin Core,Identifier';
    $sortLinks[__('Date Added')] = 'added';
    ?>
    <div id="sort-links">
        <span class="sort-label"><?php echo __('Sort by: '); ?></span><?php echo browse_sort_links($sortLinks); ?>
    </div>

    <?php if (metadata('collection', 'total_items') > 0): ?>
        <?php foreach (loop('items') as $item): ?>
        <?php $itemTitle = strip_formatting(metadata('item', array('Dublin Core', 'Title'))); ?>
        <div class="collection">

            <?php if (metadata('item', 'has files')): ?>
                <?php echo link_to_item(item_image('thumbnail', array('alt' => $itemTitle)), array("class" => "image")); ?>
            <?php endif; ?>

            <h2><?php echo link_to_item($itemTitle); ?></h2>



            <div class="item-description" style="min-height:40px;">
            <?php if ($text = metadata('item', array('Item Type Metadata', 'Text'), array('snippet'=>250))): ?>
                <?php echo $text; ?>
            <?php elseif ($description = metadata('item', array('Dublin Core', 'Description'), array('snippet'=>250))): ?>
                <?php echo $description; ?>
            <?php endif; ?>
            </div>

            <div class="item-infos">
            <?php $creators = $collection->getElementTexts('Dublin Core','Creator');  
                if(count($creators) >  0) {
                        echo '<div class="creators">';
                        foreach($creators as $creator)
                            echo '<span>Createur : </span>'.$creator->text;
                        echo '</div>';
                    }
                
            ?>
            </div>

        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p><?php echo __("There are currently no items within this collection."); ?></p>
    <?php endif; ?>

    <?php echo pagination_links(); ?>

</div><!-- end collection-items -->


<?php /*



<div id="list">

    <?php echo pagination_links(); ?>
    

    <?php foreach (loop('collections') as $collection): ?>

    <div class="collection">

        <?php
            $helperCollectionImage = new Omeka_Controller_Action_Helper_CollectionImage($collection);
            if($helperCollectionImage->getThumbmail()) {
                $collectionImage = '<img src="'.$helperCollectionImage->getThumbmail().'"/>';
            } 
            echo link_to_collection($collectionImage, array('class' => 'image'));
        ?>

        <h2><?php echo link_to_collection(); ?></h2>

        <?php if (metadata('collection', array('Dublin Core', 'Description'))): ?>
        <div class="collection-description">
            <?php echo text_to_paragraphs(metadata('collection', array('Dublin Core', 'Description'), array('snippet'=>150))); ?>
        </div>
        <?php endif; ?>

        <div class="item-infos">
        <?php $creators = $collection->getElementTexts('Dublin Core','Creator');  
            if(count($creators) >  0) {
                    echo '<div class="creators">';
                    foreach($creators as $creator)
                        echo '<span>Createur : </span>'.$creator->text;
                    echo '</div>';
                }
            
        ?>
        </div>


        <?php fire_plugin_hook('public_collections_browse_each', array('view' => $this, 'collection' => $collection)); ?>

    </div><!-- end class="collection" -->

    <?php endforeach; ?>

    <?php echo pagination_links(); ?>

</div> <!-- end list -->

*/ ?>

