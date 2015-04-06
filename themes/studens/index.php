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



<style>
#last {
    border:none !important;
    float:left !important;
    width:1130px !important;
    padding:0 !important;
    margin:0 !important;
    margin-top:50px !important;
    margin-bottom:50px !important;
    background-color:inherit !important;
}

#last > a {
    display:block;
    margin:0;
    float:left;
    width:355px;
    padding:0px;
    margin-right:32px;
    color:#2d2523;
}

#last > a span {
    width:259px;
    height:192px;
    display:block;
    background-color:orange;
    position:absolute;
}

#last > a.last-archival span {
    background:url(/themes/studens/images/homepage-last-archival.png) top left no-repeat;
}

#last > a.last-exhibit span {
    background:url(/themes/studens/images/homepage-last-exhibit.png) top left no-repeat;
}

#last > a.last-collection span {
    background:url(/themes/studens/images/homepage-last-collection.png) top left no-repeat;
}

#last > a.last-collection {
    margin-right:0px;
}

#last > a img {
    width:355px !important;
    height:192px !important;
    border:none;
}

#last h2 {
    margin:0 !important;
    margin-top:15px !important;
    font-size:22px !important;
    line-height: 24px !important;
}


#last p {
    margin:0 !important;
    margin-top:-5px !important;
    font-size:18px !important;
}

</style>

<div id="last">

    <a href="#" class="last-archival">
        <span></span>
        <img src="http://localhost/wordpress/wp-content/uploads/2015/03/Colchester-Augmented-reality.jpg" />
        <h2><?php echo metadata($this->lastItem, array('Dublin Core', 'Title')); ?></h2>
        <p><?php echo cutString(metadata($this->lastItem, array('Dublin Core', 'Description'))); ?></p>
    </a>    

    <a href="#" class="last-exhibit">
        <span></span>
        <img src="http://localhost/wordpress/wp-content/uploads/2015/03/Colchester-Augmented-reality.jpg" />
        <h2><?php echo $this->lastExhibit->title; ?></h2>
        <p><?php echo cutString($this->lastExhibit->description) ?></p>
    </a>

    <a href="#" class="last-collection">
        <span></span>
        <img src="http://localhost/wordpress/wp-content/uploads/2015/03/Colchester-Augmented-reality.jpg" />
        <h2><?php echo metadata($this->lastCollection, array('Dublin Core', 'Title')); ?></h2>
        <p><?php echo cutString($this->lastCollection->description, 'short'); ?></p>
    </a>
</div>

<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />

<?php echo foot(); ?>
