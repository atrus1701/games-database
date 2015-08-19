
<div id="results_container">
	<?php foreach( $results as $result ): ?>
	
		<?php if( $result['success'] ): ?>
			<div class="success_message"><?=$result['message']?></div>
		<?php else: ?>
			<div class="error_message"><?=$result['message']?></div>
		<?php endif; ?>
	
	<?php endforeach; ?>
</div><!-- results_container -->
