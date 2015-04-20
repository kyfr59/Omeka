<?php echo head(array('bodyid'=>'home')); ?>

<script>
jQuery(document).ready(function() {

    var total = jQuery('#slider a.wrapper').length;

    var current = '';

    displaySlide = function(id) {

        // Set default value of 'id'
        id = id || 1;

        // Reinit the slide number at the end of the slider
        if (id > total) id = 1;

        // Reinit the slide number at the begining of the slider
        if (id == 0) id = total;

        // Hide all slides
        jQuery('#slider a.wrapper').hide();

        // Display the slide
        jQuery('#slide-' + id).show();

        // Set the current id
        current = id;

        // console.log(current); // Debug

    };

    jQuery('#slider a.next').click(function() {
        displaySlide(current + 1);        
        return false;
    });

    jQuery('#slider a.prev').click(function() {
        displaySlide(current + 1);        
        return false;
    });

    // Start the slider
    displaySlide();            
});
</script>

<div id="slider">
    <?php $i = 1; ?>
    <?php foreach($this->collections as $collection): ?>
        <a id="slide-<?php echo $i; ?>" class="wrapper" href="<?php echo html_escape(url('collections/show/'.$collection->id)); ?>">
            <img src="<?php echo $collection['image_url'] ?>" />        
            <span></span>
            <p>
                <i><?php echo metadata($collection, array('Dublin Core', 'Description')); ?></i>
                <strong>
                    <?php 
                        $title = metadata($collection, array('Dublin Core', 'Title')); 
                        echo rtrim(mb_strimwidth($title, 0, 60))."...";
                    ?>
                </strong>
                <u>
                    <?php 
                        $subject = metadata($collection, array('Dublin Core', 'Subject')); 
                        echo rtrim(mb_strimwidth($subject, 0, 220))."...";
                    ?>
                </u>
            </p>
            <a class="prev" href="#">Précédent</a>
            <a class="next" href="#">Suivant</a>
        </a>
        <?php $i++; ?>
    <?php endforeach; ?>
</div>

<p id="text-homepage">
    <?php echo get_theme_option('Homepage Text'); ?>
</p>

<?php if($this->lastItem): ?>

    <div id="last">

        <a href="<?php echo html_escape(url('items/show/'.$this->lastItem->id)); ?>" class="last-archival">
            <span></span>
            <?php $image = record_image($this->lastItem, 'fullsize'); ?>
            <?php if($image): ?>
                <?php echo $image; ?>
            <?php else: ?>
                <img src="/" />        
            <?php endif; ?>    
            <h2><?php echo metadata($this->lastItem, array('Dublin Core', 'Title')); ?></h2>
            <p><?php echo cutString(metadata($this->lastItem, array('Dublin Core', 'Description'))); ?></p>
        </a>    

        <a href="<?php echo url(array('slug'=>$this->lastExhibit->slug), 'exhibitSimple'); ?>" class="last-exhibit">
            <span></span>
            <?php $image = record_image($this->lastExhibit, 'fullsize'); ?>
            <?php if($image): ?>
                <?php echo $image; ?>
            <?php else: ?>
                <img src="/" />
            <?php endif; ?>    
            <h2><?php echo $this->lastExhibit->title; ?></h2>
            <p><?php echo cutString($this->lastExhibit->description) ?></p>
        </a>

        <?php if($this->lastCollection): ?>
            <a href="<?php echo html_escape(url('collections/show/'.$this->lastCollection->id)); ?>" class="last-collection">
                <span></span>
                <img src="<?php echo $this->lastCollectionImage ?>" />
                <h2><?php echo metadata($this->lastCollection, array('Dublin Core', 'Title')); ?></h2>
                <p><?php echo cutString($this->lastCollection->description, 'short'); ?></p>
            </a>
        <?php endif; ?>
    </div>
<?php endif; ?>

<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />

<?php echo foot(); ?>
