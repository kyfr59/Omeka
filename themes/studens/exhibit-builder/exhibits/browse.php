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


$title = __('Browse Exhibits');
echo head(array('title' => $title, 'bodyclass' => 'exhibits browse'));
?>
<h1><?php echo $title; ?> <?php echo __('(%s total)', $total_results); ?></h1>
<?php if (count($exhibits) > 0): ?>

<!--
<nav class="navigation" id="secondary-nav">
    <?php echo nav(array(
        array(
            'label' => __('Browse All'),
            'uri' => url('exhibits')
        ),
        array(
            'label' => __('Browse by Tag'),
            'uri' => url('exhibits/tags')
        )
    )); ?>
</nav>
-->

<?php echo pagination_links(); ?>

<!-- Sort links -->
<?php
    $sortLinks[__('Title')] = 'title';
    $sortLinks[__('Auteur')] = 'credits';
    $sortLinks[__('Date Added')] = 'added';
?>

<div id="sort-links" style="margin-right:205px;">
    <span class="sort-label"><?php echo __('Sort by: '); ?></span><?php echo browse_sort_links($sortLinks) ; ?>
</div>

<!-- Exhibits list -->
<?php $exhibitCount = 0; ?>
<?php foreach (loop('exhibit') as $exhibit): ?>
    <?php $exhibitCount++; ?>
    <div class="exhibit <?php if ($exhibitCount%2==1) echo ' even'; else echo ' odd'; ?>">
        <?php if ($exhibitImage = record_image($exhibit, 'thumbnail')): ?>
            <?php echo exhibit_builder_link_to_exhibit($exhibit, $exhibitImage, array('class' => 'image')); ?>
        <?php endif; ?>
        <h2><?php echo link_to_exhibit(); ?></h2>
        <?php if ($exhibitDescription = metadata('exhibit', 'description', array('no_escape' => true))): ?>
        <div class="description"><?php echo $exhibitDescription; ?></div>
        <?php endif; ?>
        <?php if ($exhibitTags = tag_string('exhibit', 'exhibits')): ?>
        <!--<p class="tags"><?php echo __('Tags: ') . $exhibitTags; ?></p>-->
        <?php endif; ?>

        <div class="item-infos">
        <?php 
            echo '<div class="creators">';
            $date = metadata('exhibit', 'added');
            //$dateFrench = ltrim(date("d ", strtotime($date)), '0'). strtolower($months[(int)date("m ", strtotime($date))]). date(" Y ", strtotime($date));
            echo '<span>Créateur : </span>'.$exhibit->credits;
            echo '</div>';
            //echo '</div><br style="clear:both; height:1px;">';
        ?>
        </div>
    </div>
    
<?php endforeach; ?>

<?php echo pagination_links(); ?>

<?php else: ?>
<p><?php echo __('There are no exhibits available yet.'); ?></p>
<?php endif; ?>

<?php echo foot(); ?>

