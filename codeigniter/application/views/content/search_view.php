<h1>Search Results</h1>

<?php if( isset($results) ): ?>
	<?php $this->load->view('modules/results_container', $results) ?>
<?php endif; ?>

<?php if( (isset($search_results)) && (count($search_results) > 0) ): ?>

	<div class="count"><?=count($search_results)?> results were found.</div>

	<div class="search-list">

	<?php foreach( $search_results as $result ): ?>
		
		<div class="item">
		
			<span class="type"><?=$result['table']?></span>

			<span class="name">
				<a href="<?=site_url($result['table'].'/item/id/'.$result['table-id'])?>">
				<?=$result['name']?>
				</a>
			</span>
		
		</div>		

	<?php endforeach; ?>
	
	</div>

<?php else: ?>

<div class="count">No results were found.</div>

<?php endif; ?>




