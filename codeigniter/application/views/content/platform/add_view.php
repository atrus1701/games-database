
<h1>Add Platform</h1>

<span class="return_menu"><a href="<?=site_url('platform/admin/menu')?>">Return to Platform Menu >></a></span>

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
			<a class="add_link" href="<?=site_url('platform/admin/add')?>">Add another Platform</a>
		<?php endif; ?>
	
		<?php if( (isset($id)) && (!$error) ): ?>
			<a class="edit_link" href="<?=site_url('platform/admin/edit/id/'.$id)?>">Continue to edit this Platform</a>
		<?php endif; ?>
		
		</div>
	
	<?php endif; ?>
	
<?php endif; ?>



<?php if( (!$this->input->post()) || ($error) ): ?> 

	<form name="add_platform" class="add_form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
	
		<input type="hidden" name="id" value="<?=$item['id']?>" />
	
		<?php //=============================================================//
			 // Name
			//=============================================================// ?>
		<div class="db_row">
			<label for="platform-name">Name</label>
			<input type="textbox" id="platform-name" name="name" value="<?=$item['name']?>" maxlength="64" />
		</div>
		
		<?php //=============================================================//
			 // Maker
			//=============================================================// ?>
		<div class="db_row">
			<label for="platform-maker">Maker</label>
			<input type="textbox" id="platform-maker" name="maker" value="<?=$item['maker']?>" maxlength="64" />
		</div>
		
		<?php //=============================================================//
			 // Description
			//=============================================================// ?>
		<div class="db_row">
			<label for="platform-description">Description</label>
			<textarea id="platform-description" name="description" maxlength="512"><?=$item['description']?></textarea>
		</div>
		
		<?php //=============================================================//
			 // Icon
			//=============================================================// ?>
		<div class="db_row">
			<label for="platform-icon">Icon</label>
			<?php $files = scandir( './assets/images/platform/icon' ); ?>
			<select id="platform-icon" name="icon" size="5">
				<?php foreach($files as $file): ?>
					<?php if( $file[0] === '.' ) continue; ?>
					<?php if( $file === $item['icon'] ): ?>
						<option selected="selected" value="<?=$file?>"><?=$file?></option>
					<?php else: ?>
						<option value="<?=$file?>"><?=$file?></option>
					<?php endif; ?>
				<?php endforeach; ?>
			</select>
		</div>
		
		<?php //=============================================================//
			 // Thumbnail
			//=============================================================// ?>
		<div class="db_row">
			<label for="platform-thumbnail">Thumbnail</label>
			<?php $files = scandir( './assets/images/platform/thumbnail' ); ?>
			<select id="platform-thumbnail" name="thumbnail" size="5">
				<?php foreach($files as $file): ?>
					<?php if( $file[0] === '.' ) continue; ?>
					<?php if( $file === $item['thumbnail'] ): ?>
						<option selected="selected" value="<?=$file?>"><?=$file?></option>
					<?php else: ?>
						<option value="<?=$file?>"><?=$file?></option>
					<?php endif; ?>
				<?php endforeach; ?>
			</select>
		</div>

		<?php //=============================================================//
			 // Artwork
			//=============================================================// ?>
		<div class="db_row">
			<label for="platform-artwork">Artwork</label>
			<?php $files = scandir( './assets/images/platform/artwork' ); ?>
			<select id="platform-artwork" name="artwork" size="18">
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
			<label for="platform-tags">Tags</label>
			<div id="platform-tags">
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
	
		<input type="submit" name="action" value="Add Platform" />

	</form>

<?php endif; ?>

