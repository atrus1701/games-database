

<h1>Region Menu</h1>

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

	<span class="add_link"><a href="<?=site_url('region/admin/add')?>">Add New Region</a></span>
	
	<?php if( isset($list) ): ?>
		<?php foreach($list as $region): ?>
		
			<div class="item">
				<span class="contents">
					<img src="<?=base_url()?>assets/images/region/icon/<?=$region['icon']?>" height="16" width="16" />
					<?=$region['name']?>
				</span>
				<span class="links">
					<a href="<?=site_url('region/admin/edit/id/'.$region['id'])?>" class="edit">EDIT</a>
					<a href="<?=site_url('region/admin/delete/id/'.$region['id'])?>" class="delete">DELETE</a>
				</span>
			</div>
		
		<?php endforeach; ?>
	<?php endif; ?>

</div>

