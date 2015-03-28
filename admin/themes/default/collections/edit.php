<?php
    $collectionTitle = strip_formatting(metadata('collection', array('Dublin Core', 'Title'), array('no_filter' => true)));
    if ($collectionTitle != '') {
        $collectionTitle = ': &quot;' . $collectionTitle . '&quot; ';
    } else {
        $collectionTitle = '';
    }
    $collectionTitle = __('Edit Collection #%s', metadata('collection', 'id')) . $collectionTitle;
?>

<?php
echo head(array('title' => $collectionTitle, 'bodyclass' => 'collections'));
include 'form-tabs.php';
echo flash();
?>

<?php fire_plugin_hook('admin_items_form_files', array('item' => $item, 'view' => $this)); ?>
<script>
jQuery(document).ready(function() {
    jQuery('#delete-image-button').click(function() {
        if (confirm("Etes-vous sûr de vouloir supprimer l'image représentant cette collection ?")) {
            jQuery('#delete-image').val("yes");
            this.form.submit();
        }
        else    
            return false;
    });
});
</script>

<form method="post" enctype="multipart/form-data">

    <section class="seven columns alpha">
    
        <div class="add-new"><?php echo __("Ajouter l'image représentant la collection"); ?></div>
        <div class="drawer-contents">
            <?php if ($this->collectionThumbmail): ?>
                <img src="<?php echo $this->collectionThumbmail?>" />
                <br /><input type="submit" class="red button delete-confirm" id="delete-image-button" value="Supprimer l'image">&nbsp;&nbsp;(Attention, l'image sera également supprimée du slider)
                <input type="hidden" id="delete-image" name="delete-image">
            <?php endif; ?>
            <p>L'image doit faire moins de 1Mo
            <br />
            L'image doit avoir l'extension .jpg ou .jpeg.
            <br />
            La taille de l'image doit être de 750x500 pixels.
            </p>
            <div class="field two columns alpha" id="file-inputs">
                <label><?php echo __('Find a File'); ?></label>
            </div>

            <div class="files four columns omega">
                <input name="collection-thumbmail" type="file">
            </div>

            <div class="files four columns omega">
                <input type="checkbox" <?php if ($this->isOnSlider) echo " checked "; ?> value="yes" name="collection-image-homepage" style="margin-top:15px;"/>&nbsp;&nbsp;Ajouter l'image au slider de la page d'accueil
            </div>

        </div>
        <br /><br />
        <?php include 'form.php'; ?>
    </section>

    <section class="three columns alpha">
        <div id="save" class="panel">
            <input type="submit" name="submit" class="big green button" id="save-changes" value="<?php echo __('Save Changes'); ?>" />
            <a href="<?php echo html_escape(public_url('collections/show/'.metadata('collection', 'id'))); ?>" class="big blue button" target="_blank"><?php echo __('View Public Page'); ?></a>
            <?php echo link_to_collection(__('Delete'), array('class' => 'big red button delete-confirm'), 'delete-confirm'); ?>
            
            <?php fire_plugin_hook("admin_collections_panel_buttons", array('view' => $this, 'record' => $collection, 'collection' => $collection)); ?>

            <div id="public-featured">
                <div class="public">
                    <?php echo $this->formLabel('public', __('Public')); ?>
                    <?php echo $this->formCheckbox('public', $collection->public, array(), array('1', '0')); ?>
                </div>

                <div class="featured">
                    <?php echo $this->formLabel('featured', __('Featured')); ?>
                    <?php echo $this->formCheckbox('featured', $collection->featured, array(), array('1', '0')); ?>
                </div>
            </div>
            <?php fire_plugin_hook("admin_collections_panel_fields", array('view' => $this, 'record' => $collection)); ?>
        </div>
    </section>
    
</form>

<?php echo foot(); ?>
