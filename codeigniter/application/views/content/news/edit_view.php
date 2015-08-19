
<h1>Edit News/Review Story</h1>

<span class="return_menu"><a href="<?=site_url('news/admin/menu')?>">Return to News Menu >></a></span>

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
			<a class="edit_link" href="<?=site_url('news/admin/edit/id/'.$id)?>">Continue to edit this News Story</a>
		<?php endif; ?>
		
		</div>
	
	<?php endif; ?>
	
<?php endif; ?>




<?php if( (!$this->input->post()) || ($error) ): ?> 

	<form name="edit_news" class="add_form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
	
		<input type="hidden" name="id" value="<?=$item['id']?>" />

		<?php //=============================================================//
			 // Date
			//=============================================================// ?>
		<div class="db_row">
			<label for="news-date">Date</label>
			<input type="textbox" id="news-date" name="date" value="<?=$item['date']?>" maxlength="64" />
		</div>
		
		<?php //=============================================================//
			 // Author
			//=============================================================// ?>
		<div class="db_row">
			<label for="news-author">Author</label>
			<input type="textbox" id="news-author" name="author" value="<?=$item['author']?>" maxlength="64" />
		</div>

		<?php //=============================================================//
			 // Title
			//=============================================================// ?>
		<div class="db_row">
			<label for="news-title">Title</label>
			<input type="textbox" id="news-title" name="title" value="<?=$item['title']?>" maxlength="64" />
		</div>
		
		<?php //=============================================================//
			 // Synopsis
			//=============================================================// ?>
		<div class="db_row">
			<label for="news-synopsis">Synopsis</label>
			<textarea id="news-synopsis" name="synopsis" maxlength="512"><?=$item['synopsis']?></textarea>
		</div>

		<?php //=============================================================//
			 // Text
			//=============================================================// ?>
		<div class="db_row">
			<label for="news-text">Text</label>
			<textarea id="news-text" name="text"><?=$item['text']?></textarea>
		</div>

		<?php //=============================================================//
			 // [ is review ] Rating
			//=============================================================// ?>
		<div class="db_row">
			<label>Rating</label>
			<?php if( $item['rating'] !== NULL ): ?>
				<input type="checkbox" name="is_review" value="1" checked="checked" />
			<?php else: ?>
				<input type="checkbox" name="is_review" value="1" />
			<?php endif; ?>
			is review
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="textbox" name="rating" value="<?=$item['rating']?>" />			
		</div>
	
		<?php //=============================================================//
			 // News Tags
			//=============================================================// ?>
		<div class="db_row">
			<label for="news-tag-selector">News Tags</label>
			<div id="news-tag-selector">

				<div table="game"><b>Game</b>
					<?php foreach( $item['entries']['game'] as $row ): ?>
						<div table-id="<?=$row['id']?>"><?=$row['name']?></div>
					<?php endforeach; ?>
				</div>
					
				<div table="gameseries"><b>Game Series</b>
					<?php foreach( $item['entries']['gameseries'] as $row ): ?>
						<div table-id="<?=$row['id']?>"><?=$row['name']?></div>
					<?php endforeach; ?>
				</div>

				<div table="company"><b>Company</b>
					<?php foreach( $item['entries']['company'] as $row ): ?>
						<div table-id="<?=$row['id']?>"><?=$row['name']?></div>
					<?php endforeach; ?>
				</div>

				<div table="platform"><b>Platforms</b>
					<?php foreach( $item['entries']['platform'] as $row ): ?>
						<div table-id="<?=$row['id']?>"><?=$row['name']?></div>
					<?php endforeach; ?>
				</div>
				
				<span name="db">
					<?php if(isset($item['newstag'])): ?>
						<?php foreach( $item['newstag'] as $newstag ): ?>
							<?php if( isset($newstag['action']) ): ?>
								<span table="<?=$newstag['table']?>" table-id="<?=$newstag['table-id']?>" action="<?=$newstag['action']?>"></span>
							<?php else: ?>
								<span table="<?=$newstag['table']?>" table-id="<?=$newstag['table-id']?>" action="update"></span>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</span>
			
			</div>
		</div>

		<input type="submit" name="action" value="Update News Story" />

	</form>

<?php endif; ?>
