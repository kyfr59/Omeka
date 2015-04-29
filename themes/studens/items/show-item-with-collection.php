<?php echo head(array('title' => metadata('item', array('Dublin Core', 'Title')),'bodyclass' => 'items show', 'wrapperclass' => 'no-background')); ?>

<?php if($item->collection_id): ?>
	<?php $collection = $item->getCollection(); ?>	
	<h1><?php echo metadata($collection, array('Dublin Core', 'Title')); ?></h1>
<?php else: ?>	
	<h1><?php echo metadata('item', array('Dublin Core', 'Title')); ?></h1>
<?php endif; ?>	

<?php $hasMap = Omeka_Controller_Action_Helper_Geolocation::hasMap($item->id); ?>
<div id="item-with-collection">

<?php 
$b = new Zend_View_Helper_Navigation_Breadcrumbs;
echo $b->getPartial();
?>

    <div class="left">
      	<div class="item">
    		<h2><?php echo metadata($item, array('Dublin Core', 'Title')); ?></h2><span class="top"></span>
	    	<?php 
	    		if (metadata($item, 'has files')) { 
	    			echo files_for_item(array('imageSize' => 'fullsize'));
	    		}
	    	?>
	    	<?php if(metadata($item, array('Dublin Core', 'Description'))): ?>
    			<p><?php echo metadata($item, array('Dublin Core', 'Description')); ?></p><span class="bottom"></span>
    		<?php else:?>	
    			<p style="padding:0; margin-top:-20px;"></p><span class="bottom"></span>
    		<?php endif;?>
    	</div>

    	<div class="lifeline">
    		<div class="full begin"></div>

    		<!-- Subjects -->

    		<?php if ( hasSubjects($item) ): ?>
    			<div class="full subject">
    				<b>Sujets</b><br />
    				<span><?php echo getSubjectsLinks($item, 'subjects') ?></span>
    			</div>
    		<?php endif; ?>		

    		<!-- Date -->
    		<?php $dates = $this->item->getElementTexts('Dublin Core','Date'); ?>
    		<?php if (count($dates) > 0 ): ?>
    			<div class="half date">
    				<span>
	    				<?php foreach($dates as $date): ?>
	    					<?php echo $date->text; ?><br />
	    				<?php endforeach; ?>	
	    			</span>	
    			</div>
    		<?php endif; ?>		

   			<!-- Coverage -->
   			<?php $coverages = $this->item->getElementTexts('Dublin Core','Coverage'); ?>
   			<?php if($hasMap || count($coverages)>0): ?>
	    		<div class="full coverage">
	    			<div class="<?php echo $hasMap ? 'with' : 'no' ?>-localization">
	    				<?php if (count($coverages) > 0 ): ?>
		    				<b>Couverture<?php echo count($coverages) > 1 ? 's' : '';?></b><br />
		    				<?php foreach($coverages as $coverage): ?>
		    					<?php echo $coverage->text; ?><br />
		    				<?php endforeach; ?>	
	    				<?php endif; ?>		
						<?php if ($hasMap): ?>
							<b>Localisation</b><br />
							<?php echo $hasMap[0]->address ?>
						<?php endif; ?>	
	    			</div>	
	    			<?php if ($hasMap): ?>
		    			<div class="localization">
		    				<span>
		    					<?php echo $this->itemGoogleMap($item, '100%', '100%') ?>
		    				</span>
	        			</div>
        			<?php endif; ?>
	    		</div>
			<?php endif; ?>

    		<!-- Creators -->
    		<?php $creators = $this->item->getElementTexts('Dublin Core','Creator'); ?>
    		<?php if (count($creators) > 0 ): ?>
    			<div class="full creator">
    				<b>Créateur<?php echo count($creators) > 1 ? 's' : '';?></b><br />
    				<?php foreach($creators as $creator): ?>
    					<span><?php echo $creator->text; ?></span><br />
    				<?php endforeach; ?>	
    			</div>
    		<?php endif; ?>		

    		<!-- Item Type Metadata -->
    		<?php $itemTypeMetadata = item_type_elements($item); ?>
    		<?php $formats = $this->item->getElementTexts('Dublin Core', 'Format'); ?>
    		<?php $identifiants = $this->item->getElementTexts('Dublin Core', 'Identifier'); ?>
    		<?php $languages = $this->item->getElementTexts('Dublin Core', 'Language'); ?>
    		<?php $types = $this->item->getElementTexts('Dublin Core', 'Type'); ?>
    		<?php if (count($itemTypeMetadata) || count($format) || count($identifiants) ): ?>
	    		<div class="full infos">

	    			<?php foreach($identifiants as $identifiant): ?>
	    				<?php if(strlen(trim($identifiant))>0): ?>
			    			<div>
			    				<span>Référence</span>
				    			<strong><?php echo $identifiant ?></strong>
				    		</div>	
	    				<?php endif; ?>
		    		<?php endforeach; ?>

		    		<?php foreach($languages as $language): ?>
	    				<?php if(strlen(trim($language))>0): ?>
			    			<div>
			    				<span>Language</span>
				    			<strong><?php echo $language ?></strong>
				    		</div>	
	    				<?php endif; ?>
		    		<?php endforeach; ?>

		    		<?php foreach($types as $type): ?>
	    				<?php if(strlen(trim($type))>0): ?>
			    			<div>
			    				<span>Type</span>
				    			<strong><?php echo $type ?></strong>
				    		</div>	
	    				<?php endif; ?>
		    		<?php endforeach; ?>	

		    		<?php foreach($formats as $format): ?>
	    				<?php if(strlen(trim($format))>0): ?>
			    			<div>
			    				<span>Format</span>
				    			<strong><?php echo $format ?></strong>
				    		</div>	
	    				<?php endif; ?>
		    		<?php endforeach; ?>

		    		<?php foreach($formats as $format): ?>
	    				<?php if(strlen(trim($format))>0): ?>
			    			<div>
			    				<span>Support</span>
				    			<strong><?php echo $format ?></strong>
				    		</div>	
	    				<?php endif; ?>
		    		<?php endforeach; ?>	    		

	    			<?php foreach($itemTypeMetadata as $key => $value): ?>
	    				<?php if($value): ?>
			    			<div>
			    				<?php if($key == 'Original Format'): ?>
			    					<span>Extent & medium</span>
			    				<?php else: ?>	
			    					<span><?php echo __($key) ?></span>
			    				<?php endif; ?>	
				    			<strong><?php echo $value ?></strong>

				    		</div>	
	    				<?php endif; ?>
		    		<?php endforeach; ?>
	    		</div>
    		<?php endif; ?>

    		<!-- View -->
    		<?php $relations = $this->item->getElementTexts('Dublin Core', 'Relation'); ?>
    		<?php if ($relations[0]): ?>
    			<div class="half clear view"><span><a target="_new" href="<?php echo $relations[0] ?>">Consulter la source de cet item</a></span></div>
    		<?php else: ?>		
    			<div class="clear"></div>
    		<?php endif; ?>	


    		<!-- Social -->
    		<script>
			jQuery(document).ready(function() {
				jQuery('.networks > a').click(function() {
					var href = jQuery(this).attr('href');
					window.open(href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');
					return false;
				});
			});
			</script>
    		<?php $url = absolute_url('items/show/'.$item->id); ?>
    		<?php $tweet = cutString(metadata($item, array('Dublin Core', 'Title')), 140); ?>
			<div class="full social">
				<span class="permalink">permalink</span>
				<a class="permalink" href="<?php echo $url ?>"><?php echo $url ?></a>
				<div class="networks">
					<a class="facebook" href="http://www.facebook.com/sharer/sharer.php?u=<?php echo $url ?>"></a>
					<a class="google" 	href="https://plus.google.com/share?url=<?php echo $url ?>"></a>
					<a class="twitter" 	href="http://twitter.com/intent/tweet/?url=<?php echo $url ?>&text=<?php echo $tweet ?>"></a>
				</div>	
			</div>

    	</div>
    </div>

    <div class="right">

	    <?php fire_plugin_hook('public_items_show_collection_tree', array('collection' => $collection)); ?>

		<span class="recent-items">
		    <h2>Items extraits de la collection</h2>
		    
			<?php $j = 0; ?>
		    <?php foreach($this->recent_items as $i): ?>
				<?php $files = $item->getFiles(); ?>
				<?php if(count($files) > 0 ): ?>
					<div>
						<?php foreach($files as $file): ?>
							<span class="fa <?php echo Omeka_View_Helper_FileIcon::getIcon($file->mime_type) ?>"></span>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>	
		    	<?php if($i->id != $item->id): ?>
	    		<span style="position:relative; display:block; margin-bottom:15px; padding-bottom:10px;">
					
		    		<a class="title" href="<?php echo absolute_url('items/show/'.$i->id); ?>"><?php echo metadata($i, array('Dublin Core', 'Title')); ?></a>
		    		<?php if(metadata($i, array('Dublin Core', 'Description'))): ?>
		    			<a class="description" href="<?php echo absolute_url('items/show/'.$i->id); ?>"><?php echo cutString(metadata($i, array('Dublin Core', 'Description'))); ?></a>	
		    		<?php endif; ?>	

		    		<?php $editors = $this->item->getElementTexts('Dublin Core', 'Publisher'); ?>

	    			<?php foreach($editors as $editor): ?>
	    				<?php if(strlen(trim($editor))>0): ?>
			    			<div>
			    				<span style="padding-left:50px;color:#999;font-size:14px;">Lieu de conservation : <?php echo $editor ?></span><br />
				    		</div>	
	    				<?php endif; ?>
		    		<?php endforeach; ?>
		    		<span class="hr"></span>
		    	</span>	
		    	<?php $j++; ?>
		    	<?php endif; ?>	
		    	<?php if($j > 5) {break;} ?>
		    <?php endforeach; ?>

			<?php echo link_to_collection('Voir tous les items de la collection', array("class"=>"view-all-items"), 'show', $collection); ?>
		</span>    
    </div>

</div>
<br style="clear:both" />

<?php echo foot(); ?>
