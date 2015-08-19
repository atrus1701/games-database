
<h1>Add Company</h1>

<span class="return_menu"><a href="<?=site_url('company/admin/menu')?>">Return to Company Menu >></a></span>

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
			<a class="add_link" href="<?=site_url('company/admin/add')?>">Add another Company</a>
		<?php endif; ?>
	
		<?php if( (isset($id)) && (!$error) ): ?>
			<a class="edit_link" href="<?=site_url('company/admin/edit/id/'.$id)?>">Continue to edit this Company</a>
		<?php endif; ?>
		
		</div>
	
	<?php endif; ?>
	
<?php endif; ?>



<?php if( (!$this->input->post()) || ($error) ): ?> 

	<form name="add_company" class="add_form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
	
		<input type="hidden" name="id" value="<?=$item['id']?>" />
	
		<?php //=============================================================//
			 // Name
			//=============================================================// ?>
		<div class="db_row">
			<label for="company-name">Name</label>
			<input type="textbox" id="company-name" name="name" value="<?=$item['name']?>" maxlength="64" />
		</div>
	
		<?php //=============================================================//
			 // Address
			//=============================================================// ?>
		<div class="db_row">
			<label for="company-address">Address</label>
			<input type="textbox" id="company-address" name="address" value="<?=$item['address']?>" maxlength="64" />
		</div>
		
		<?php //=============================================================//
			 // Description
			//=============================================================// ?>
		<div class="db_row">
			<label for="company-description">Synopsis</label>
			<textarea id="company-description" name="description" maxlength="512"><?=$item['description']?></textarea>
		</div>

		<?php //=============================================================//
			 // Artwork
			//=============================================================// ?>
		<div class="db_row">
			<label for="company-artwork">Artwork</label>
			<?php $files = scandir( './assets/images/company/artwork' ); ?>
			<select id="company-artwork" name="artwork" size="18">
				<?php foreach($files as $file): ?>
					<?php if( $file[0] === '.' ) continue; ?>
					<?php if( $file === $item['artwork'] ): ?>
						<option selected="selected" value="<?=$file?>"><?=$file?></option>
					<?php else: ?>
						<option value="<?=$file?>"><?=$file?></option>
					<?php endif; ?>
				<?php endforeach; ?>
			</select>	
		</div>

		<?php //=============================================================//
			 // Tags
			//=============================================================// ?>	
		<div class="db_row">
			<label for="company-tags">Tags</label>
			<div id="company-tags">
				<span name="db">
					<?php if(isset($item['tag'])): ?>
						<?php foreach($item['tag'] as $tag): ?>
							<?php if( isset($tag['action']) ): ?>
								<span tag-id="<?=$tag['id']?>" tag-name="<?=$tag['name']?>" tag-action="<?=$tag['action']?>"></span>
							<?php else: ?>
								<span tag-id="<?=$tag['id']?>" tag-name="<?=$tag['name']?>" tag-action="update"></span>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</span>			
			</div>		
		</div>
	
		<input type="submit" name="action" value="Add Company" />

	</form>

<?php endif; ?>

