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

$pageTitle = __('Browse Items');
echo head(array('title'=>$pageTitle,'bodyclass' => 'items browse'));
?>

<h1><?php echo $pageTitle;?> <?php echo __('(%s total)', $total_results); ?></h1>

<div id="list">
    <?php  echo item_search_filters(); ?>

    <?php echo pagination_links(); ?>

    <?php if ($total_results > 0): ?>

    <?php
    $sortLinks[__('Title')] = 'Dublin Core,Title';
    $sortLinks[__('Creator')] = 'Dublin Core,Creator';
    $sortLinks[__('Date Added')] = 'added';
   ?>

    <div id="sort-links">
        <span class="sort-label"><?php echo __('Sort by: '); ?></span><?php echo browse_sort_links($sortLinks) ; ?>
    </div>

    <?php endif; ?>

    <?php foreach (loop('items') as $item): ?>

    <div class="item hentry">

        <div class="item-img">
        <?php if (metadata('item', 'has files')) {
            echo link_to_item(item_image('square_thumbnail'));
        } else {
            echo link_to_item('<img src="'.OMEKA_ROOT.'/themes/studens/images/fallback.png" width="63" height="63" />');
        }
        ?>

        </div>    

        <h2><?php echo link_to_item(metadata('item', array('Dublin Core', 'Title')), array('class'=>'permalink')); ?></h2>
        <div class="item-meta">

            <?php if ($description = metadata('item', array('Dublin Core', 'Description'), array('snippet'=>250))): ?>
            <div class="item-description">
                <?php echo $description; ?>
            </div>
            <?php endif; ?>

            <?php if (metadata('item', 'has tags')): ?>
            <div class="tags"><p><strong><?php echo __('Tags'); ?> : </strong>
                <?php echo tag_string('items'); ?></p>
            </div>
            <?php endif; ?>

            <div class="item-infos">
            <?php 

            $creators = $item->getElementTexts('Dublin Core','Creator'); 
            if(count($creators) >  0) {
                echo '<div class="creators">';
                foreach($creators as $creator)
                    echo '<span>Createur : </span>'.$creator->text;
                echo '</div>';
            }

            echo '<div class="date">';
            $date = metadata('item', 'added');
            $dateFrench = ltrim(date("d ", strtotime($date)), '0'). strtolower($months[(int)date("m ", strtotime($date))]). date(" Y ", strtotime($date));
            echo '<span>Date : </span>'.$dateFrench;
            echo '</div><br style="clear:both;">';

            ?>
            </div>

            <?php fire_plugin_hook('public_items_browse_each', array('view' => $this, 'item' =>$item)); ?>



        </div><!-- end class="item-meta" -->
        <br style="clear:both" />
    </div><!-- end class="item hentry" -->
    <?php endforeach; ?>

    <?php echo pagination_links(); ?>
    

</div> <!-- end list -->

<?php fire_plugin_hook('public_items_browse', array('items'=>$items, 'view' => $this)); ?>

<?php echo foot(); ?>
