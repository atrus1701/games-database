
<h1>Game Series</h1>

<?php if( isset($results) ): ?>
	<?php $this->load->view('modules/results_container', $results) ?>
<?php endif; ?>

<?php if( isset($list) ): ?>
	<?php $this->load->view('modules/gameseries_list', $list); ?>
<?php endif; ?>
