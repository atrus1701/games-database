<!DOCTYPE html>

<html>

	<head>
	
		<title><?=$title?></title>

		<script type="text/javascript">
			var base_url = "<?=base_url()?>";
		</script>

		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
		<?php foreach($scripts as $script): ?>
			<script type="text/javascript" src="<?=base_url()?>assets/scripts/<?=$script?>.js"></script>
		<?php endforeach; ?>

		<?php foreach($styles as $style): ?>
			<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/styles/<?=$style?>.css" />
		<?php endforeach; ?>
		
	</head>

	<body>

		<?php //var_dump($header); ?>

		<div id="header">
			<div class="container">
				<?php $this->load->view('page/header_view', $header); ?>
			</div>
		</div>

		<div id="content">
			<div class="container">
				
				<?php /*
				<?php if( isset($content['item']) ): ?>
				<pre>
					<?php print_r($content['item']); ?>
				</pre>
				<?php endif; ?>
				<?php if( isset($content['list']) ): ?>
				<pre>
					<?php print_r($content['list']); ?>
				</pre>
				<?php endif; ?>
				*/ ?>

				<?php $this->load->view('content/'.$page.'_view', $content); ?>
			</div>
		</div>

		<div id="footer">
			<div class="container">
				<?php $this->load->view('page/footer_view', $footer); ?>
			</div>
		</div>
		
	</body>

</html>
