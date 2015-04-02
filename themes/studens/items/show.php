<?php echo head(array('title' => metadata('item', array('Dublin Core', 'Title')),'bodyclass' => 'items show')); ?>

<?php if($item->collection_id): ?>
	<?php $collection = $item->getCollection(); ?>	
	<h1><?php echo metadata($collection, array('Dublin Core', 'Title')); ?></h1>
<?php else: ?>	
	<h1><?php echo metadata('item', array('Dublin Core', 'Title')); ?></h1>
<?php endif; ?>	

<?php if($item->collection_id): ?>
	<?php $hasMap = Omeka_Controller_Action_Helper_Geolocation::hasMap($item->id); ?>
	<div id="collection-page">


	    <div class="left">

	    	<div class="item">
	    		<h2><?php echo metadata($item, array('Dublin Core', 'Title')); ?></h2><span class="top"></span>
	    		<p><?php echo metadata($item, array('Dublin Core', 'Description')); ?></p><span class="bottom"></span>
	    	</div>

	    	<div class="lifeline">
	    		<div class="full begin"></div>
	    		<div class="full subject"><b>Sujets</b><br><a href="">aaaa</a><br><a href="">klklk</a><br>lkllk</div>
	    		<div class="half date"><span>Septembre 1985</span></div>

	    		<div class="full coverage">
	    			<div class="<?php echo $hasMap ? 'with' : 'no' ?>-localization">
	    				<b>Sujets</b><br><a href="">aaaa</a><br><a href="">klklk</a><br>lkllk
	    			</div>	
	    			<?php if ($hasMap): ?>
		    			<div class="localization">
		    				<span>
		    					<?php echo $this->itemGoogleMap($item, '100%', '100%') ?>
		    				</span>
	        			</div>
        			<?php endif; ?>
	    		</div>


	    		<div class="full creator"><b>Creator</b><br><a href="">aaaa</a><br><a href="">klklk</a><br>lkllk</div>
	    		<div class="full infos">
	    			<div>
	    				<span>lieu de <br>conservation</span>
		    			<strong>lieu de conservation</strong>
		    		</div>	
		    		<div>
	    				<span>lieu de conservation</span>
		    			<strong>lieu de conservationlieu de conservati onlieu de onservationlieu de conservation</strong>
		    		</div>	
		    		<div>
	    				<span>lieu de <br>conservation</span>
		    			<strong>lieu de conservation</strong>
		    		</div>	
		    		<div>
	    				<span>lieu de conservation</span>
		    			<strong>lieu de conservationlieu de conservati onlieu de onservationlieu de conservation</strong>
		    		</div>	
	    		</div>
	    		<div class="half clear view"><span><a href="">Consulter la source de cet item</a></span></div>
				<div class="full social">
					<a class="permalink" href="#">http://www.wwW.qmlkljklfjfmlkjmlkjmlkjmlkjkljkljdfkljdldkfldkf.fr</a>
					<div class="networks">
						<a class="facebook" href="#"></a>
						<a class="google" href="#"></a>
						<a class="twitter" href="#"></a>
					</div>	
				</div>

	    	</div>
	    </div>



	    <div class="collection-page right">

	    	<span class="collection-tree">
			    <h3>Collection tree</h3>
			    <ul><?php echo metadata($collection, array('Dublin Core', 'Title')); ?></ul>
				<?php foreach($collection->getItems() as $item): ?>
			    	<li><?php echo metadata($item, array('Dublin Core', 'Title')); ?></li>
			    <?php endforeach; ?>
			</span>
			
			<span class="collection-items">
			    <h3>Items extraits de la collection</h3>
			    <strong>Titre</strong>
			    <p>texte</p>
	    </div>


	</div>
	<br style="clear:both" />
<?php endif; ?>




<!-- CODE & CSS si l'item n'appartient pas à une collection -->

<div id="primary">

    <?php if ((get_theme_option('Item FileGallery') == 0) && metadata('item', 'has files')): ?>
    <?php echo files_for_item(array('imageSize' => 'fullsize')); ?>
    <?php endif; ?>
    <?php echo all_element_texts('item'); ?>
    <?php fire_plugin_hook('public_items_show', array('view' => $this, 'item' => $item)); ?>

</div><!-- end primary -->


<ul class="item-pagination navigation">
    <li id="previous-item" class="previous"><?php echo link_to_previous_item_show(); ?></li>
    <li id="next-item" class="next"><?php echo link_to_next_item_show(); ?></li>
</ul>

<?php echo foot(); ?>
