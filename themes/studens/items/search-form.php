<script>
jQuery(document).ready(function() {
    
    jQuery('.small-submit').click(function() {
        var val = jQuery('#keyword-search').val();
        if (val == 'Saisissez votre recherche ici') {
            jQuery('#keyword-search').val('');
        } 
    });
    jQuery('#submit_search_advanced').click(function() {
        var val = jQuery('#keyword-search').val();
        if (val == 'Saisissez votre recherche ici') {
            jQuery('#keyword-search').val('');
        } 
    });
    jQuery('#keyword-search').click(function() {
        var val = jQuery('#keyword-search').val();
        if (val == 'Saisissez votre recherche ici') {
            jQuery('#keyword-search').val('');
        } 
    });
    
});
</script>

<?php
if (!empty($formActionUri)):
    $formAttributes['action'] = $formActionUri;
else:
    $formAttributes['action'] = url(array('controller'=>'items',
                                          'action'=>'browse'));
endif;
$formAttributes['method'] = 'GET';
?>

<form <?php echo tag_attributes($formAttributes); ?>>
    <div id="search-keywords" class="field">
        <div id="inputs">
            <input type="submit" class="small-submit">
            <?php
                $default = @$_REQUEST['search'] ? @$_REQUEST['search'] : "Saisissez votre recherche ici";
            ?>
            <?php
                echo $this->formText(
                    'search',
                    $default,
                    array('id' => 'keyword-search', 'size' => '40')
                );
            ?>
        </div>
    </div>

    <div id="search-narrow-by-fields" class="field">
        <div class="label"><?php echo __('Narrow by Specific Fields'); ?></div>
        <div class="inputs">
        <?php
        // If the form has been submitted, retain the number of search
        // fields used and rebuild the form
        if (!empty($_GET['advanced'])) {
            $search = $_GET['advanced'];
        } else {
            $search = array(array('field'=>'','type'=>'','value'=>''));
        }

        //Here is where we actually build the search form
        foreach ($search as $i => $rows): ?>
            <div class="search-entry">
                <?php
                //The POST looks like =>
                // advanced[0] =>
                //[field] = 'description'
                //[type] = 'contains'
                //[terms] = 'foobar'
                //etc

                $elements = get_db()->getTable('Element')->findBy(array('element_set_id' => '3')); 
                $elementsRes[null] = "Faites votre choix";
                foreach ($elements as $e) {
                    //$element = get_record_by_id('Element', $c->id);    
                    $names = array("Title", "Subject", "Creator", "Date", "Type", "Publisher");
                    if(in_array($e->name, $names))
                        if($e->name == 'Publisher')
                            $elementsRes[$e->id] = 'Institution de conservation';
                        else
                            $elementsRes[$e->id] = __($e->name);
                }
                $elementRes = array();
                

                echo $this->formSelect(
                    "advanced[$i][element_id]",
                    @$rows['element_id'],
                    array(
                        'title' => __("Search Field"),
                        'id' => null,
                        'class' => 'advanced-search-element'
                    ),
                    $elementsRes
                );


                echo $this->formSelect(
                    "advanced[$i][type]",
                    @$rows['type'],
                    array(
                        'title' => __("Search Type"),
                        'id' => null,
                        'class' => 'advanced-search-type'
                    ),
                    label_table_options(array(
                        'contains' => __('contains'),
                        'does not contain' => __('does not contain'),
                        'is exactly' => __('is exactly'),
                        'is empty' => __('is empty'),
                        'is not empty' => __('is not empty'))
                    )
                );


                echo $this->formText(
                    "advanced[$i][terms]",
                    @$rows['terms'],
                    array(
                        'size' => '20',
                        'title' => __("Search Terms"),
                        'id' => null,
                        'class' => 'advanced-search-terms'
                    )
                );
                ?>
                <button type="button" class="remove_search" disabled="disabled" style="display: none;"><?php echo __('Remove field'); ?></button>
            </div>
        <?php endforeach; ?>
        </div>
        <button type="button" class="add_search"><?php echo __('Add a Field'); ?></button>
    </div>

    
    <div class="field">
        <?php echo $this->formLabel('collection-search', __('Search By Collection')); ?>
        <div class="inputs">
        <?php 
            $collections = get_db()->getTable('Collection')->findBy(array('public' => 1));
            $collectionsRes[null] = "Faites votre choix";
            foreach ($collections as $c) {
                $collection = get_record_by_id('Collection', $c->id);    
                $collectionsRes[$collection->id] = metadata($collection, array('Dublin Core', 'Title'));
            }
        ?>
        <?php
            echo $this->formSelect(
                'collection',
                @$_REQUEST['collection'],
                array('id' => 'collection-search'),
                $collectionsRes
            );
        ?>
        </div>
    </div>

    <div class="field">
        <?php echo $this->formLabel('item-type-search', __('Search By Type')); ?>
        <div class="inputs">
        <?php 
            $fonds = get_db()->getTable('Item')->findBy(array('public' => 1, 'item_type_id' => 18));
            $fondsRes[null] = "Faites votre choix";
            foreach ($fonds as $f) {
                $fondsRes[$f->id] = $f->getElementTexts('Dublin Core', 'Title')[0]->text;
            }
        ?>
        <?php
            echo $this->formSelect(
                'item_relations_object_id',
                @$_REQUEST['item_relations_object_id'],
                array('id' => 'item-type-search'),
                $fondsRes
            );
        ?>
        </div>
    </div>

    <div class="field">
        <?php echo $this->formLabel('tag-search', __('Search By Tags')); ?>
        <div class="inputs">
        <?php
            $tags = get_db()->getTable('Tag')->findAll(); //->filterByPublic($select, (bool) $params['public']);
            $res[null] = "Faites votre choix";
            foreach ($tags as $tag) {
                if (substr($tag, 0, strlen(OaipmhHarvester_Harvest_Abstract::SUBJECT_TAG_PREFIX)) == OaipmhHarvester_Harvest_Abstract::SUBJECT_TAG_PREFIX)
                    $res[$tag->name] = ltrim($tag->name, OaipmhHarvester_Harvest_Abstract::SUBJECT_TAG_PREFIX) ;
            }
        ?>

        <?php
            echo $this->formSelect(
                'tags',
                @$_REQUEST['tags'],
                array('id' => 'tags-search'),
                $res
            );
        ?>

        <?php /*
            echo $this->formText('tags', @$_REQUEST['tags'],
                array('size' => '40', 'id' => 'tag-search')
            ); */
        ?>
        </div>
    </div>

   

    <?php fire_plugin_hook('public_items_search', array('view' => $this)); ?>
    <div>
        <?php if (!isset($buttonText)) $buttonText = 'Rechercher'; ?>
        <input type="submit" class="submit" name="submit_search" id="submit_search_advanced" value="<?php echo $buttonText ?>">
    </div>
</form>

<?php echo js_tag('items-search'); ?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        Omeka.Search.activateSearchButtons();
    });
</script>
