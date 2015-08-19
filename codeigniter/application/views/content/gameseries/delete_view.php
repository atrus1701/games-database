
<h1>Delete Game Series</h1>

<span class="return_menu"><a href="<?=site_url('gameseries/admin/menu')?>">Return to Game Series Menu >></a></span>

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

<?php if( !$this->input->post() && isset($item) ): ?>

	<form name="delete_gameseries" class="delete_form"  action="<?=$_SERVER['PHP_SELF']?>" method="post">
	
		<input type="hidden" name="id" value="<?=$item['id']?>" />
		<input type="hidden" name="name" value="<?=$item['name']?>" />
	
		<div>
			Are you sure you want to delete this game series?<br/>
			<div class="record_name"><?=$item['name']?></div>
			This operation cannot be undone.
		</div>
	
		<input type="submit" name="action" value="Delete" />
		<input type="submit" name="action" value="Cancel" />

	</form>

<?php endif; ?>
