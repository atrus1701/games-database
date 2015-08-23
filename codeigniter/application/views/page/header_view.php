
<?php $link_folder = '' ?>
<?php if( isset($admin) ): ?>
	<?php $link_folder = 'admin/'; ?>
<?php endif; ?>

<div class="logo"></div>
<div class="title"><a href="<?=site_url()?>"><span>Video Game</span><span>Directory</span></a></div>
<div class="menu">
	<ul>
		<li><a href="<?=site_url($link_folder.'games')?>">Games</a></li>
		<li><a href="<?=site_url($link_folder.'gameseries')?>">Game Series</a></li>
		<li><a href="<?=site_url($link_folder.'platforms')?>">Platforms</a></li>
		<li><a href="<?=site_url($link_folder.'companies')?>">Companies</a></li>

		<?php if( isset($admin) ): ?>
			<li><a href="<?=site_url($link_folder.'regions')?>">Region</a></li>
			<li><a href="<?=site_url($link_folder.'file_upload')?>">File Upload</a></li>
		<?php endif; ?>
</div>
<div class="search">
	<form action="<?=site_url('search')?>">
		<input type="text" name="s" value="" placeholder="Search" />
		<input type="submit" value="Search" />
	</form>
</div>
