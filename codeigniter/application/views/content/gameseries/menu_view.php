

<h1>Game Series Menu</h1>

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

	<span class="add_link"><a href="<?=site_url('gameseries/admin/add')?>">Add New Game Series</a></span>
	
	<?php if( isset($list) ): ?>
		<?php foreach($list as $gameseries): ?>
	
			<div class="item">
				<span class="contents">
					<?=$gameseries['name']?>
				</span>
				<span class="links">
					<a href="<?=site_url('gameseries/admin/edit/id/'.$gameseries['id'])?>" class="edit">EDIT</a>
					<a href="<?=site_url('gameseries/admin/delete/id/'.$gameseries['id'])?>" class="delete">DELETE</a>
				</span>
			</div>
		
		<?php endforeach; ?>
	<?php endif; ?>

</div>

