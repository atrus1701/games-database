
<h1>Platform</h1>

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
		<img src="<?=base_url()?>assets/images/platform/artwork/<?=$item['artwork']?>" />
	</div>
	
	<div class="item_container">
	
		<h2><?=$item['name']?></h2>
		<div class="description"><?=$item['description']?></div>
			
		<!-- News list -->
		<div class="news">
			<h2>News</h2>
			<?php $this->load->view('modules/news_list', $item['news']); ?>
		</div>
		
		<!-- Games list -->
		<div class="games">
			<h2>Games</h2>
			<?php $this->load->view('modules/game_list', $item['games']); ?>
		</div>
		
	</div>

<?php endif; ?>
