
<h1>Country List</h1>

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



<?php if( isset($list) ): ?>

<div class="list">

	<?php foreach($list as $country): ?>

		<a href="<?=site_url('country/item/id/'.$country['id'])?>">
		<div class="item">
			<img src="<?=base_url()?>assets/images/country/icons/<?=$country['icon']?>" height="16" width="16" />
			<?=$country['name']?>
		</div>
		</a>

	<?php endforeach; ?>

</div>

<?php endif; ?>

