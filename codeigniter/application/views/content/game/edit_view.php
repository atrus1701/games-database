
<h1>Edit Game</h1>

<span class="return_menu"><a href="<?=site_url('game/admin/menu')?>">Return to Game Menu >></a></span>

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
	
		<?php if( (isset($id)) && (!$error) ): ?>
			<a class="edit_link" href="<?=site_url('game/admin/edit/id/'.$id)?>">Continue to edit this Game</a>
		<?php endif; ?>
		
		</div>
	
	<?php endif; ?>
	
<?php endif; ?>




<?php if( (!$this->input->post()) || ($error) ): ?> 

	<form name="edit_game" class="add_form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
		
		<input type="hidden" name="id" value="<?=$item['id']?>" />
	
		<?php //=============================================================//
			 // Name
			//=============================================================// ?>
		<div class="db_row">
			<label for="game-name">Name</label>
			<input type="textbox" id="game-name" name="name" value="<?=$item['name']?>" maxlength="64" />
		</div>
	
	
		<?php //=============================================================//
			 // Game Series
			//=============================================================// ?>
		<div class="db_row">
			<label for="gameseries-id">Game Series</label>
			<select name="gameseries-id" id="gameseries-id">

				<?php if( $item['gameseries-id'] === NULL ): ?>
					<option value="NULL" selected="selected"></option>
				<?php else: ?>
					<option value="NULL"></option>
				<?php endif; ?>

				<?php foreach( $gameseries as $series ): ?>
					<?php if( $item['gameseries-id'] === $series['id'] ): ?>
						<option value="<?=$series['id']?>" selected="selected"><?=$series['name']?></option>
					<?php else: ?>
						<option value="<?=$series['id']?>"><?=$series['name']?></option>
					<?php endif; ?>
				<?php endforeach; ?>
				
			</select>
		</div>
		
		
		<?php //=============================================================//
			 // Genre
			//=============================================================// ?>
		<div class="db_row">
			<label for="game-genre">Genre</label>
			<select name="genre" id="game-genre">
				<?php foreach( $genres as $id => $genre ): ?>
					<?php if( $item['genre'] === $id ): ?>
						<option value="<?=$id?>" selected="selected"><?=$genre?></option>
					<?php else: ?>
						<option value="<?=$id?>"><?=$genre?></option>
					<?php endif; ?>
				<?php endforeach; ?>
			</select>
		</div>
		
		
		<?php //=============================================================//
			 // Game Synopsis
			//=============================================================// ?>
		<div class="db_row">
			<label for="game-synopsis">Synopsis</label>
			<textarea id="game-synopsis" name="synopsis" maxlength="512"><?=$item['synopsis']?></textarea>
		</div>
	

		<?php //=============================================================//
			 // Developers
			//=============================================================// ?>
		<div class="db_row">
			<label>Developers</label>
			<div id="game-developer">
	
				<select input-id="company-id">
					<?php foreach( $companies as $publisher ): ?>
						<option value="<?=$publisher['id']?>"><?=$publisher['name']?></option>
					<?php endforeach; ?>
				</select>
			
				<span name="db">
					<?php foreach($item['developer'] as $developer): ?>
						<?php if( isset($developer['action']) ): ?>
							<span company-id="<?=$developer['company-id']?>" db-action="<?=$developer['action']?>"></span>
						<?php else: ?>
							<span company-id="<?=$developer['company-id']?>" db-action="update"></span>
						<?php endif; ?>
					<?php endforeach; ?>
				</span>
			
			</div>
		</div>
	
	
		<?php //=============================================================//
			 // Releases
			//=============================================================// ?>
		<div class="db_row">
			<label for="game-release">Releases</label>
			<div id="game-release">
			
				<select input-id="platform-id">
					<?php foreach( $platforms as $platform ): ?>
						<option value="<?=$platform['id']?>"><?=$platform['name']?></option>
					<?php endforeach; ?>
				</select>
				
				<select input-id="region-id">
					<?php foreach( $regions as $region ): ?>
						<option value="<?=$region['id']?>"><?=$region['name']?></option>
					<?php endforeach; ?>
				</select>

				<select input-id="company-id">
					<?php foreach( $companies as $publisher ): ?>
						<option value="<?=$publisher['id']?>"><?=$publisher['name']?></option>
					<?php endforeach; ?>
				</select>
								
				<input type="textbox" value="" input-id="release-date" />
			
				<span name="db">
					<?php foreach($item['release'] as $release): ?>
						<?php if( isset($release['action']) ): ?>
							<span platform-id="<?=$release['platform-id']?>" region-id="<?=$release['region-id']?>" company-id="<?=$release['company-id']?>" release-date="<?=$release['release-date']?>" db-action="<?=$release['action']?>"></span>
						<?php else: ?>
							<span platform-id="<?=$release['platform-id']?>" region-id="<?=$release['region-id']?>" company-id="<?=$release['company-id']?>" release-date="<?=$release['release-date']?>" db-action="update"></span>
						<?php endif; ?>
					<?php endforeach; ?>
				</span>
			
			</div>
		</div>
	
	
		<?php //=============================================================//
			 // Thumbnail
			//=============================================================// ?>
		<div class="db_row">
			<label for="game-thumbnail">Thumbnail</label>
			<?php $files = scandir( './assets/images/game/thumbnail' ); ?>
			<select id="game-thumbnail" name="thumbnail" size="5">
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
			<label for="game-artwork">Artwork</label>
			<?php $files = scandir( './assets/images/game/artwork' ); ?>
			<select id="game-artwork" name="artwork" size="18">
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
			 // Gallery Folder
			//=============================================================// ?>
		<div class="db_row">
			<label for="game-gallery-folder">Gallery</label>
			<input type="textbox" id="game-gallery-folder" name="gallery-folder" value="<?=$item['gallery-folder']?>" maxlength="64" />
		</div>
	
	
		<?php //=============================================================//
			 // Tags
			//=============================================================// ?>	
		<div class="db_row">
			<label for="game-tags">Tags</label>
			<div id="game-tags">
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
		
		<input type="submit" name="action" value="Update Game" />
		
	</form>

<?php endif; ?>
