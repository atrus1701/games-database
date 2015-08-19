
<div class="list game-list">

	<?php if( (isset($list)) && (count($list) > 0) ): ?>
	
		<?php foreach($list as $game): ?>
	
			<div class="item">
				<span class="name"><a href="<?=site_url('game/item/id/'.$game['id'])?>"><?=$game['name']?></a></span>
				<span class="release">
					<?=$game['release-date']?>
				</span>
			</div>
	
		<?php endforeach; ?>
	
	<?php else: ?>
	
		<div class="item">NONE</div>
			
	<?php endif; ?>

</div>
