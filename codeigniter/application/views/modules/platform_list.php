
<div class="list platform-list">

	<?php foreach($list as $platform): ?>

		<a href="<?=site_url('platform/item/id/'.$platform['id'])?>">
		<div>
			<?=$platform['maker']?><br/>
			<img src="<?=base_url()?>assets/images/platform/thumbnail/<?=$platform['thumbnail']?>" height="200" width="160" alt="<?=$platform['name']?>" />
			<br/>
			<?=$platform['name']?><br/>
		</div>
		</a>

	<?php endforeach; ?>

</div>
