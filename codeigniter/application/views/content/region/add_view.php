
<h1>Add Region</h1>

<span class="return_menu"><a href="<?=site_url('region/admin/menu')?>">Return to Region Menu >></a></span>

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

	<?php if( $this->input->post() ): ?>
	
		<div class="post_links">
	
		<?php if( !$error ): ?>
			<a class="add_link" href="<?=site_url('region/admin/add')?>">Add another Region</a>
		<?php endif; ?>
	
		<?php if( (isset($id)) && (!$error) ): ?>
			<a class="edit_link" href="<?=site_url('region/admin/edit/id/'.$id)?>">Continue to edit this Region</a>
		<?php endif; ?>
		
		</div>
	
	<?php endif; ?>
	
<?php endif; ?>



<?php if( (!$this->input->post()) || ($error) ): ?> 

	<form name="add_region" class="add_form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
	
		<input type="hidden" name="id" value="<?=$item['id']?>" />
	
		<?php //=============================================================//
			 // Name
			//=============================================================// ?>
		<div class="db_row">
			<label for="region-name">Name</label>
			<input type="textbox" id="region-name" name="name" value="<?=$item['name']?>" maxlength="64" />
		</div>
	
		<?php //=============================================================//
			 // Thumbnail
			//=============================================================// ?>
		<div class="db_row">
			<label for="region-icon">Thumbnail</label>
			<?php $files = scandir( './assets/images/region/icon' ); ?>
			<select id="region-icon" name="icon" size="5">
				<?php foreach($files as $file): ?>
					<?php if( $file === '.' || $file === '..' ) continue; ?>
					<?php if( $file === $item['icon'] ): ?>
						<option selected="selected" value="<?=$file?>"><?=$file?></option>
					<?php else: ?>
						<option value="<?=$file?>"><?=$file?></option>
					<?php endif; ?>
				<?php endforeach; ?>
			</select>
		</div>

	
		<input type="submit" name="action" value="Add Region" />

	</form>

<?php endif; ?>

