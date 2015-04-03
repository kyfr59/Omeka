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
		    	<?php 
		    		if (metadata($item, 'has files')) { 
		    			echo files_for_item(array('imageSize' => 'fullsize'));
		    		}
		    	?>
	    		<p><?php echo metadata($item, array('Dublin Core', 'Description')); ?></p><span class="bottom"></span>
	    	</div>

	    	<div class="lifeline">
	    		<div class="full begin"></div>

	    		<!-- Subjects -->
	    		<?php $subjects = $this->item->getElementTexts('Dublin Core','Subject'); ?>
	    		<?php if (count($subjects) > 0 ): ?>
	    			<div class="full subject">
	    				<b>Sujet<?php echo count($subjects) > 1 ? 's' : '';?></b><br />
	    				<?php foreach($subjects as $subject): ?>
	    					<span><?php echo $subject->text; ?></span>
	    				<?php endforeach; ?>	
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
	    		<?php if (count($itemTypeMetadata) > 0 || count($format) > 0): ?>
		    		<div class="full infos">
		    			<?php foreach($formats as $format): ?>
		    				<?php if($format): ?>
				    			<div>
				    				<span>Format</span>
					    			<strong><?php echo $format ?></strong>
					    		</div>	
		    				<?php endif; ?>
			    		<?php endforeach; ?>
		    			<?php foreach($itemTypeMetadata as $key => $value): ?>
		    				<?php if($value): ?>
				    			<div>
				    				<span><?php echo __($key) ?></span>
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
	    		<?php $url = absolute_url('items/show/'.$item->id); ?>
				<div class="full social">
					<a class="permalink" href="<?php echo $url ?>"><?php echo $url ?></a>
					<div class="networks">
						<a class="facebook" target="_new" href="http://www.facebook.com/"></a>
						<a class="google" target="_new" href="http://plus.google.com/"></a>
						<a class="twitter" target="_new" href="http://www.twitter.com/"></a>
					</div>	
				</div>

	    	</div>
	    </div>

	    <div class="right">

    	    <?php fire_plugin_hook('public_items_show_collection_tree', array('collection' => $collection)); ?>

			

			<span class="recent-items">
			    <h2>Items extraits de la collection</h2>
			    <?php $i = 0; ?>
			    <?php
			    
			    /*
				$mime_types = explode(',', Omeka_Validate_File_MimeType::DEFAULT_WHITELIST);
				foreach($mime_types as $type)
				{
					$t = explode('/', $type);
					if($t[0]!='audio' && $t[0]!='video' && $t[0]!='image' && $t[0]!='text')
						echo $type.'<br>';
				}
				*/
				    			

	    		$files = $item->getFiles();
	    		foreach($files as $file) {
					echo Omeka_View_Helper_FileIcon::getIcon($file->mime_type);
	    			

	    		}
			    ?>

			    <style>
			#collection-page .recent-items strong {
				padding-left:50px;
			}

			#collection-page .recent-items p {
				padding-bottom:30px;
				margin-left:50px;
				border-bottom:1px solid #ccc;

			}

			#collection-page .recent-items > div {
				position:absolute;
				float:left;
				margin-left:10px;
			}
			</style>

			    
			    

			    <?php foreach(get_recent_items() as $i): ?>

			    	<?php if(metadata($i, array('Dublin Core', 'Description'))): ?>

			    		<div>
			    			<img src="/themes/studens/images/files-types/video.png"><br />
			    			<img src="/themes/studens/images/files-types/video.png"><br />
			    		</div>
			    		<strong><?php echo metadata($i, array('Dublin Core', 'Title')); ?></strong>
			    		<p><?php echo metadata($i, array('Dublin Core', 'Description')); ?></p>	
			    		<?php $i++; ?>
			    	<?php endif; ?>		
			    	<?php if($i > 5) {break;} ?>
			    <?php endforeach; ?>
			</span>    
	    </div>

	</div>
	<br style="clear:both" />

<?php endif; ?>




<!-- CODE & CSS si l'item n'appartient pas à une collection -->

<div id="primary">

    <?php if ((get_theme_option('Item FileGallery') == 0) && metadata('item', 'has files')): ?>
    
    <?php endif; ?>
    <?php echo all_element_texts('item'); ?>
    <?php fire_plugin_hook('public_items_show', array('view' => $this, 'item' => $item)); ?>

</div><!-- end primary -->


<ul class="item-pagination navigation">
    <li id="previous-item" class="previous"><?php echo link_to_previous_item_show(); ?></li>
    <li id="next-item" class="next"><?php echo link_to_next_item_show(); ?></li>
</ul>

<?php echo foot(); ?>
