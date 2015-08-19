

<h1>Company Menu</h1>

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

	<span class="add_link"><a href="<?=site_url('company/admin/add')?>">Add New Company</a></span>

	<?php if( isset($list) ): ?>
		<?php foreach($list as $company): ?>
		
			<div class="item">
				<span class="contents">
					<?=$company['name']?>
				</span>
				<span class="links">
					<a href="<?=site_url('company/admin/edit/id/'.$company['id'])?>" class="edit">EDIT</a>
					<a href="<?=site_url('company/admin/delete/id/'.$company['id'])?>" class="delete">DELETE</a>
				</span>
			</div>
		
		<?php endforeach; ?>
	<?php endif; ?>

</div>

