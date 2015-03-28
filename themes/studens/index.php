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

<style>
.studens #slider a.wrapper {
    display:block;
}
</style>

<div id="slider">
    <?php $i = 1; ?>
    <?php foreach($this->collections as $collection): ?>
        <a id="slide-<?php echo $i; ?>" class="wrapper" href="<?php echo html_escape(url('collections/show/'.$collection->id)); ?>">
            <img src="<?php echo $collection['image_url'] ?>" />        
            <span></span>
            <p>
                <i><?php echo metadata($collection, array('Dublin Core', 'Description')); ?></i>
                <strong><?php echo metadata($collection, array('Dublin Core', 'Title')); ?></strong>
                <u><?php echo metadata($collection, array('Dublin Core', 'Subject')); ?></u>
            </p>
            <a class="prev" href="#">Précédent</a>
            <a class="next" href="#">Suivant</a>
        </a>
        <?php $i++; ?>
    <?php endforeach; ?>
</div>


<?php echo foot(); ?>
