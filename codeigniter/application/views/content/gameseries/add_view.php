
<h1>Add Game Series</h1>

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

	<?php if( $this->input->post() ): ?>
	
		<div class="post_links">
	
		<?php if( !$error ): ?>
			<a class="add_link" href="<?=site_url('gameseries/admin/add')?>">Add another Game Series</a>
		<?php endif; ?>
	
		<?php if( (isset($id)) && (!$error) ): ?>
			<a class="edit_link" href="<?=site_url('gameseries/admin/edit/id/'.$id)?>">Continue to edit this Game Series</a>
		<?php endif; ?>
		
		</div>
	
	<?php endif; ?>
	
<?php endif; ?>



<?php if( (!$this->input->post()) || ($error) ): ?> 

	<form name="add_gameseries" class="add_form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
	
		<input type="hidden" name="id" value="<?=$item['id']?>" />
	
		<?php //=============================================================//
			 // Name
			//=============================================================// ?>
		<div class="db_row">
			<label for="gameseries-name">Name</label>
			<input type="textbox" id="gameseries-name" name="name" value="<?=$item['name']?>" maxlength="64" />
		</div>
		
		<?php //=============================================================//
			 // Synopsis
			//=============================================================// ?>
		<div class="db_row">
			<label for="gameseries-synopsis">Synopsis</label>
			<textarea id="gameseries-synopsis" name="synopsis" maxlength="512"><?=$item['synopsis']?></textarea>
		</div>
		
		<?php //=============================================================//
			 // Thumbnail
			//=============================================================// ?>
		<div class="db_row">
			<label for="gameseries-thumbnail">Thumbnail</label>
			<?php $files = scandir( './assets/images/gameseries/thumbnail' ); ?>
			<select id="gameseries-thumbnail" name="thumbnail" size="5">
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
			<label for="gameseries-artwork">Artwork</label>
			<?php $files = scandir( './assets/images/gameseries/artwork' ); ?>
			<select id="gameseries-artwork" name="artwork" size="18">
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
			<label for="gameseries-tags">Tags</label>
			<div id="gameseries-tags">
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
	
		<input type="submit" name="action" value="Add Game Series" />

	</form>

<?php endif; ?>

