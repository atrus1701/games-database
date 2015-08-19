
<h1>Games</h1>

<?php if( isset($results) ): ?>
	<?php $this->load->view('modules/results_container', $results) ?>
<?php endif; ?>

<?php if( isset($list) ): ?>
<div class="list">

	<?php foreach($list as $game): ?>

		<div class="item">
			<span class="name"><a href="<?=site_url('game/item/id/'.$game['id'])?>"><?=$game['name']?></a></span>
			<span class="platforms">
				<?php foreach($game['platforms'] as $platform): ?>
				
					<a href="<?=site_url('platform/item/id/'.$platform['id'])?>">
					<img src="<?=base_url()?>assets/images/platform/icon/<?=$platform['icon']?>" height="16" width="16" />
					</a>
				
				<?php endforeach; ?>
			</span>
			<span class="release">
				<?=$game['release-date']?>
			</span>
		</div>

	<?php endforeach; ?>

</div>
<?php endif; ?>
