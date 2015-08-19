<span class="return-link"><<
<?php if( isset($admin) ): ?>
	<a href="<?=site_url('news/menu')?>">Main Site</a>
<?php else: ?>
	<a href="<?=site_url('news/admin/menu')?>">Admin Site</a>
<?php endif; ?>
</span>

<span class="search-box"><form name="search" class="search_form" action="<?=site_url('search')?>" method="post"><input type="textbox" name="search" value="" /><input type="submit" name="action" value="search" /></form></span>

<?php $link_folder = '' ?>
<?php if( isset($admin) ): ?>
	<?php $link_folder = 'admin/'; ?>
<?php endif; ?>

<ul>
	<li><a href="<?=site_url('company/'.$link_folder.'menu')?>">Company</a></li>
	<li><a href="<?=site_url('game/'.$link_folder.'menu')?>">Game</a></li>
	<li><a href="<?=site_url('gameseries/'.$link_folder.'menu')?>">Game Series</a></li>
	<li><a href="<?=site_url('news/'.$link_folder.'menu')?>">News</a></li>
	<li><a href="<?=site_url('platform/'.$link_folder.'menu')?>">Platform</a></li>

	<?php if( isset($admin) ): ?>
		<li><a href="<?=site_url('region/admin/menu')?>">Region</a></li>
		<li><a href="<?=site_url('file_upload')?>">File Upload</a></li>
	<?php endif; ?>
</ul>

