
<div class="list company-list">

	<?php foreach($list as $company): ?>

		<a href="<?=site_url('company/item/id/'.$company['id'])?>">
			<div class="item">
				<span class="name"><?=$company['name']?></span>
				<span class="address"><?=$company['address']?></span>
			</div>
		</a>

	<?php endforeach; ?>

</div>
