

<h1>Game Menu</h1>

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

	<span class="add_link"><a href="<?=site_url('game/admin/add')?>">Add New Game</a></span>
	
	<?php if( isset($list) ): ?>
		<?php foreach($list as $game): ?>
		
			<div class="item">
				<span class="contents">
					<?=$game['name']?>
				</span>
				<span class="links">
					<a href="<?=site_url('game/admin/edit/id/'.$game['id'])?>" class="edit">EDIT</a>
					<a href="<?=site_url('game/admin/delete/id/'.$game['id'])?>" class="delete">DELETE</a>
				</span>
			</div>
		
		<?php endforeach; ?>
	<?php endif; ?>

</div>

