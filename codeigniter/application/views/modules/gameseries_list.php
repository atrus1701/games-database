
<div class="list gameseries-list">

	<?php foreach($list as $gameseries): ?>

		<a href="<?=site_url('gameseries/item/id/'.$gameseries['id'])?>">
		<div class="item">
			<?=$gameseries['name']?><br/>
			<img src="<?=base_url()?>assets/images/gameseries/thumbnail/<?=$gameseries['thumbnail']?>" height="200" width="160" alt="<?=$gameseries['name']?>" />
			<br/>
			<?=$gameseries['game_count']?> games
		</div>
		</a>

	<?php endforeach; ?>

</div>
