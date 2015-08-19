<div class="list news-list">

	<?php if( (isset($list)) && (count($list) > 0) ): ?>

		<?php foreach($list as $story): ?>
	
			<a href="<?=site_url('news/item/id/'.$story['id'])?>">
			<div class="item">
				<div>
					<?=$story['date']?></span>&nbsp;&nbsp;|&nbsp;&nbsp;<?=$story['title']?> by <?=$story['author']?>
					<?php if(isset($story['rating']) && ($story['rating'] !== NULL)): ?>
					<span class="rating"><?=number_format($story['rating'],1)?></span>
					<?php endif; ?>
				</div>
				<?=$story['synopsis']?>
			</div>
			</a>
	
		<?php endforeach; ?>
		
	<?php else: ?>
	
		<div class="item">NONE</div>
		
	<?php endif; ?>
	
</div>