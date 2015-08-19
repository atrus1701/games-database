<h1>Game</h1>

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

<?php if( isset($item) ): ?>

	<div style="clear:both"></div>
	
	<div class="sidebar">

		<img src="<?=base_url()?>assets/images/game/artwork/<?=$item['artwork']?>" />

		<div class="section rating">
			<h3>Average Rating</h3>
			<h1><?php if($item['average_rating'] > 0): ?><?=number_format($item['average_rating'],1)?><?php else: ?>N / A<?php endif; ?></h1>
		</div>
		
		<div class="section developers">
			<h4>Developers</h4>
			<?php foreach($item['developer'] as $developer): ?>
				<div class="item">
				<a href="<?=site_url('company/item/id/'.$developer['company-id'])?>"><?=$developer['company-name']?></a>
				</div>
			<?php endforeach; ?>
		</div>
		
		<div class="section releases">
			<h4>Releases</h4>
			<?php foreach($item['release'] as $release): ?>

				<div class="release">
					<div class="item">
					<span class="platform">
					<a href="<?=site_url('platform/item/id/'.$release['platform-id'])?>">
						<img src="<?=base_url()?>/assets/images/platform/icon/<?=$release['platform-icon']?>" HEIGHT="16" WIDTH="16" />
					</a>
					</span>
					<span class="region">
					<a href="<?=site_url('region/item/id/'.$release['region-id'])?>">
						<img src="<?=base_url()?>/assets/images/region/icon/<?=$release['region-icon']?>" HEIGHT="16" WIDTH="16" />
					</a>
					</span>
					<span class="company">
					<a href="<?=site_url('company/item/id/'.$release['company-id'])?>">
						<?=$release['company-name']?>
					</a>
					</span>
					<span class="date">
					<?=$release['release-date']?>
					</span>
					</div>
				</div>
				
			<?php endforeach; ?>
		</div>

	</div>
	
	<div class="item_container">
		<h2><?=$item['name']?></h2>
		<span class="synopsis"><?=$item['synopsis']?></span>
		
		<!-- News list -->
		<div class="news">
			<h2>News</h2>
			<?php $this->load->view('modules/news_list', $item['news']); ?>
		</div>
		
		<div class="gallery">
			<h2>Gallery</h2>

			<?php if( ($item['gallery-folder'] !== '') && file_exists('./assets/images/game/gallery/'.$item['gallery-folder']) ): ?>
			
				<?php $files = scandir( './assets/images/game/gallery/'.$item['gallery-folder'] ); ?>
			
				<?php $count = 0; ?>
				<?php foreach($files as $file): ?>
					<?php if( $file[0] === '.' ) continue; ?>
				
					<?php $filename = urlencode($file); ?>
				
					<a href="<?=base_url()?>assets/images/game/gallery/<?=$item['gallery-folder']?>/<?=$file?>">
					<img src="<?=base_url()?>assets/images/game/gallery/<?=$item['gallery-folder']?>/<?=$file?>" WIDTH="200" />
					</a>
					<?php $count++; ?>
				
				<?php endforeach; ?>
			
				<?php if( $count == 0 ): ?>
					Gallery is empty.
				<?php endif; ?>
			
			<?php else: ?>
			
				No gallery.
			
			<?php endif; ?>

		</div>
		
	</div>

<?php endif; ?>