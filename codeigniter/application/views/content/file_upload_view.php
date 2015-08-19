<h1>File Upload</h1>

<?php if( isset($results) ): ?>
	<?php $this->load->view('modules/results_container', $results) ?>
<?php endif; ?>

<?php if( $this->input->post() ): ?>

	<pre>
	<?php print_r($_FILES['files']['name']); ?>
	</pre>

	<div class="post_links">

	<a class="add_link" href="<?=site_url('file_upload')?>">Upload more images</a>
	
	</div>

<?php else: ?>
<form name="create_folder" class="create_folder_form" action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">

	<?php //=============================================================//
		 // Upload and Gallery Folder
		//=============================================================// ?>
	<div class="db_row">
		<label for="upload-folder">Upload Folder</label>
		<select id="upload-folder" name="upload-folder">
			<option value="game-gallery">Game Gallery</option>
			<option value="game-thumbnail">Game Thumbnail</option>
			<option value="game-artwork">Game Artwork</option>
			<option value="gameseries-thumbnail">Game Series Thumbnail</option>
			<option value="gameseries-artwork">Game Series Artwork</option>
			<option value="platform-icon">Platform Icon</option>
			<option value="platform-thumbnail">Platform Thumbnail</option>
			<option value="platform-artwork">Platform Artwork</option>
			<option value="region-icon">Region Icon</option>
			<option value="company-artwork">Company Artwork</option>
		</select>
	</div>
	<div class="db_row">
		<label for="gallery-folder">Gallery Folder</label>
		<?php $files = scandir( './assets/images/game/gallery' ); ?>
		<select id="gallery-folder" name="gallery-folder">
			<?php foreach($files as $file): ?>
				<?php if( $file[0] === '.' ) continue; ?>
				<option value="<?=$file?>"><?=$file?></option>
			<?php endforeach; ?>
		</select>
	</div>

	<?php //=============================================================//
		 // File Upload
		//=============================================================// ?>
	<div class="db_row">
		<label for="files" class="files-label">Name</label>
		<input type="file" id="files" name="files[]" multiple="multiple" accept='image/*' /><br/>
		<div class="file-list">
			<b>File List</b>
			<div class="file-list"></div>
		</div>
	</div>

	<input type="submit" name="action" value="Upload Files" />

</form>

<?php endif; ?>


