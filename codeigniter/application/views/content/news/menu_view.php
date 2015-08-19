
<h1>News/Review Menu</h1>

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

<div class="list">

	<span class="add_link"><a href="<?=site_url('news/admin/add')?>">Add New News/Review Story</a></span>
	
	<?php if( isset($list) ): ?>
		<?php foreach($list as $story): ?>
		
		<div class="item">
			<span class="contents">
				<?=$story['date']?> | <?=$story['title']?> by <?=$story['author']?>
			</span>
			<span class="links">
				<a href="<?=site_url('news/admin/edit/id/'.$story['id'])?>" class="edit">EDIT</a>
				<a href="<?=site_url('news/admin/delete/id/'.$story['id'])?>" class="delete">DELETE</a>
			</span>
		</div>
		
		<?php endforeach; ?>
	<?php endif; ?>

</div>

