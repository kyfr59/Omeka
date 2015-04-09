<?php echo head(array('title' => metadata('item', array('Dublin Core', 'Title')),'bodyclass' => 'items show')); ?>

<?php if($item->collection_id): ?>
	<?php $collection = $item->getCollection(); ?>	
	<h1><?php echo metadata($collection, array('Dublin Core', 'Title')); ?></h1>
<?php else: ?>	
	<h1><?php echo metadata('item', array('Dublin Core', 'Title')); ?></h1>
<?php endif; ?>	

<div id="item-without-collection">
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

</div><!-- /lifeline -->
<br style="clear:both" />

<ul class="item-pagination navigation">
    <li id="previous-item" class="previous"><?php echo link_to_previous_item_show(); ?></li>
    <li id="next-item" class="next"><?php echo link_to_next_item_show(); ?></li>
</ul>


<?php echo foot(); ?>
