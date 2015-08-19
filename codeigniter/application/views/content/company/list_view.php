
<h1>Companies</h1>

<?php if( isset($results) ): ?>
	<?php $this->load->view('modules/results_container', $results) ?>
<?php endif; ?>

<?php if( isset($list) ): ?>
	<?php $this->load->view('modules/company_list', $list); ?>
<?php endif; ?>
