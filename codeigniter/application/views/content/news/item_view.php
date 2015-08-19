<?php if( $item['rating'] !== NULL ): ?>
	<h1>Review</h1>
<?php else: ?>
	<h1>News</h1>
<?php endif; ?>

<?php if( isset($results) ): ?>

	<div id="results_container">
		<?php foreach( $results as $result ): ?>
		
			<?php if( $result['success'] ): ?>
				<div class="success_message"><?=$result['message']?></div>
			<?php else: ?>
				<div class="error_message"><?=$result['message']?></div>
			<?php endif; ?>
		
		<?php endforeach; ?>
	</div><!-- results_container -->

<?php endif; ?>

<?php if( isset($item) ): ?>

	<div style="clear:both"></div>
	
	<div class="sidebar">
		<?php if( $item['rating'] !== NULL ): ?>
			<div class="rating">
				<h3>Rating</h3>
				<h1><?=number_format($item['rating'],1)?></h1>
			</div>
		<?php endif; ?>
		
		<?php if( $item['tags'] ): ?>
			<div class="tags">
				<h3>Tags</h3>
				<?php foreach($item['tags'] as $tag): ?>

					<div class="item">
					<span class="type"><?=$tag['table']?></span>
		
					<span class="name">
						<a href="<?=site_url($tag['table'].'/item/id/'.$tag['table-id'])?>">
						<?=$tag['name']?>
						</a>
					</span>
					</div>

				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
	
	<div class="item_container">
	
		<h2><?=$item['title']?></h2>
				
		<div class="author">by <?=$item['author']?></div>
		
		<div class="date"><?=$item['date']?></div>
	
		<div class="text"><?=$item['text']?></div>
		
	</div>

<?php endif; ?>
