<?php echo head(array('title' => metadata('item', array('Dublin Core', 'Title')),'bodyclass' => 'items show')); ?>

<!--<h1><?php echo metadata('item', array('Dublin Core', 'Title')); ?></h1>-->

<?php echo drawFil($this->fil);?>

<?php $hasMap = Omeka_Controller_Action_Helper_Geolocation::hasMap($item->id); ?>
<div id="item-without-collection">

  	<div class="item">
		<h2><?php echo (metadata($item, array('Dublin Core', 'Title'))); ?></h2><span class="top"></span>
    	<?php 
    		if (metadata($item, 'has files')) { 
    			echo files_for_item(array('imageSize' => 'fullsize'));
    		}
    	?>
		<p><!-- Texte ici --></p><span class="bottom"></span>
	</div>

	<div class="lifeline">
		<div class="begin"></div>

		<!-- About & subjects -->
    	<?php $about = metadata($item, array('Dublin Core', 'Description')); ?>
		<div class="row">
			<?php if (strlen(trim($about)) > 0):?>
				<div class="left about shift" >
					<u>A propos</u>
					<span><?php echo cutString($about, 'long'); ?></span>
				</div>
			<?php endif; ?>	
			<?php if ( hasSubjects($item) ): ?>
				<div class="right has-about subject">
					<b>Sujets</b><br />
					<?php echo getSubjectsLinks($item, 'subjects'); ?><br />
				</div>
			<?php endif; ?>	
		</div>

		<?php $dates = $this->item->getElementTexts('Dublin Core','Date'); ?>
		<?php if (count($dates) > 0 ): ?>
			<div class="row" style="text-align:center;">
				<strong class="date"><span><i>
   					<?php echo $dates[0]; ?><br />
    			</i></span></strong>
			</div>
		<?php endif; ?>	

		
		<!-- Coverage -->
   		<?php $coverages = $this->item->getElementTexts('Dublin Core','Coverage'); ?>
		<?php if($hasMap || count($coverages)>0): ?>
			<div class="row">
				<div class="left shift <?php if(strlen(trim($coverages))==0) echo "no-"?>coverage <?php echo $hasMap ? 'with' : 'no-coverage' ?>">
					<?php if (strlen(trim($coverages)) > 0): ?>
						<span>
							<?php if (count($coverages) > 0 ): ?>
		    				<b>Couverture<?php echo count($coverages) > 1 ? 's' : '';?></b><br />
		    				<?php foreach($coverages as $coverage): ?>
		    					<?php echo $coverage->text; ?><br />
		    				<?php endforeach; ?>	
		    				<?php endif; ?>							
						</span>
    				<?php endif; ?>							
				</div>
				<?php if ($hasMap): ?>
	    			<div class="right localization">
	    				<span>
	    					<?php echo $this->itemGoogleMap($item, '100%', '100%') ?>
	    				</span>
        			</div>
    			<?php endif; ?>
			</div>
		<?php endif; ?>



		<?php $creators = $this->item->getElementTexts('Dublin Core','Creator'); ?>
		<?php $contributors = $this->item->getElementTexts('Dublin Core','Contributor'); ?>		
		<?php if (count($creators) && count($contributors) ): ?>
		<div class="row persons">

			<!-- Creators -->
    		<?php if (count($creators) > 0 ): ?>
    			<div class="creators">
    				<i>
	    				<b>Créateur<?php echo count($creators) > 1 ? 's' : '';?></b><br />
	    				<?php foreach($creators as $creator): ?>
	    					<span><?php echo $creator->text; ?></span><br />
	    				<?php endforeach; ?>	
	    			</i>	
    			</div>
    		<?php endif; ?>	

			<!-- Contributors -->
    		<?php if (count($contributors) > 0 ): ?>
    			<div class="contributors">
    				<i>
	    				<b>Contributeur<?php echo count($contributors) > 1 ? 's' : '';?></b><br />
	    				<?php foreach($contributors as $contributor): ?>
	    					<span><?php echo $contributor->text; ?></span><br />
	    				<?php endforeach; ?>	
	    			</i>	
    			</div>
    		<?php endif; ?>	

		</div>
		<?php endif; ?>

		<!-- Item Type Metadata -->
		<?php $itemTypeMetadata = item_type_elements($item); ?>
		<?php $formats = $this->item->getElementTexts('Dublin Core', 'Format'); ?>
		<?php $getLevelOfDescriptionTag = $this->item->getLevelOfDescriptionTag() ?>
		<?php if (count($itemTypeMetadata) > 0 || count($formats) > 0 || $getLevelOfDescriptionTag): ?>
    		<div class="row infos">
    			<?php if (count($formats)>0 || $getLevelOfDescriptionTag): ?>
    				<div class="left"><span><u>
					<?php foreach($formats as $format): ?>
    				<?php if ($format && strlen(trim($format, '<br>')) > 0): ?>
		    			<i>Format</i>
						<strong>
							<?php echo $format ?><br />
						</strong>
    				<?php endif; ?>
    				<?php endforeach; ?>
		    		
		    		<?php if ($getLevelOfDescriptionTag): ?>
		    			<i>Unité de description</i>
		    			<strong><?php echo $getLevelOfDescriptionTag ?></strong>
		    		<?php endif; ?>
					</u></span></div>
		    	<?php endif; ?>
		    		
		    	<?php if (count($itemTypeMetadata)>0): ?>	
		    		<div class="right"><span><u>
	    			<?php foreach($itemTypeMetadata as $key => $value): ?>
	    				<?php if($value && strlen(trim($value, '<br>')) > 0): ?>
		    				<i><?php echo __($key) ?></i>
			    			<strong><?php echo $value ?></strong>
	    				<?php endif; ?>
		    		<?php endforeach; ?>
		    		</u></span></div>
		    	<?php endif; ?>	



		    	
    		</div>
		<?php endif; ?>

		<!-- View -->
    	<?php $relations = $this->item->getElementTexts('Dublin Core', 'Relation'); ?>
		<div class="row">
			<div class="left"></div>
			<?php if ($relations[0]): ?>
			<div class="right view">
				<a target="_new" href="<?php echo $relations[0] ?>"><span>Consulter la source de cet item</span></a>
			</div>
			<?php endif; ?>	
		</div>	
		
		<!-- Exhibit -->
		<?php if($hasExhibits): ?>
			<div class="row exhibit">
				<span>Exposition<br/><strong>dddd hhhhh kjkjkjkj dddd hhhhh kjkjkjkj dddd hhhhh kjkjkjkj dddd hhhhh kjkjkjkj dddd hhhhh kjkjkjkj </strong></span>
			</div>	
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
		<div class="row social">
			<span class="permalink">permalink</span>
			<a class="permalink" href="<?php echo $url ?>"><?php echo $url ?>mlklmkml klmk lmklmj kljkl jklj kl</a>
			<div class="networks">
				<a class="facebook" href="http://www.facebook.com/sharer/sharer.php?u=<?php echo $url ?>"></a>
				<a class="google" 	href="https://plus.google.com/share?url=<?php echo $url ?>"></a>
				<a class="twitter" 	href="http://twitter.com/intent/tweet/?url=<?php echo $url ?>&text=<?php echo $tweet ?>"></a>
			</div>
		</div>	

		<div class="row comments">
			<span>
				<?php 
					$comments = new CommentingPlugin(); 
					$nbComments = $comments->countComments($item);
				?>
				<?php echo $nbComments == 0 ? 'Aucun' : $nbComments ?> Commentaire<?php if($nbComments>1) echo 's' ?>
			</span>	
		</div>
	</div>
</div>
<br style="clear:both" />

<!--
<ul class="item-pagination navigation">
    <li id="previous-item" class="previous"><?php echo link_to_previous_item_show(); ?></li>
    <li id="next-item" class="next"><?php echo link_to_next_item_show(); ?></li>
</ul>
-->


<?php echo fire_plugin_hook('public_items_show', array('view' => $this, 'class' => 'item-without-collection')); ?>

<?php echo foot(); ?>
