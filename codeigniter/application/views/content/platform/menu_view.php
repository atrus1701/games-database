

<h1>Platform Menu</h1>

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

	<span class="add_link"><a href="<?=site_url('platform/admin/add')?>">Add New Platform</a></span>
	
	<?php if( isset($list) ): ?>
		<?php foreach($list as $platform): ?>
		
			<div class="item">
				<span class="contents">
					<img src="<?=base_url()?>assets/images/platform/icon/<?=$platform['icon']?>" height="16" width="16" />
					<?=$platform['maker']?> <?=$platform['name']?>
				</span>
				<span class="links">
					<a href="<?=site_url('platform/admin/edit/id/'.$platform['id'])?>" class="edit">EDIT</a>
					<a href="<?=site_url('platform/admin/delete/id/'.$platform['id'])?>" class="delete">DELETE</a>
				</span>
			</div>
		
		<?php endforeach; ?>
	<?php endif; ?>

</div>

