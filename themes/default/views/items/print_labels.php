<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?= $page_title.' | '.$Settings->site_name; ?></title>
	<link rel="shortcut icon" href="<?= $assets ?>img/icon.png"/>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link href="<?= $assets ?>css/bootstrap.css" rel="stylesheet" type="text/css" />
	<style>
		body { text-align:center; }
		td { text-align: center; }
		h4 { margin:5px; padding:0; }
		.price { font-size:0.8em; font-weight:bold; }
		@media print
		{
			.container { width: auto !important; }
			.container h4, .container p,
			.btn-group, .pagination { display: none; }
			.labels { text-align:center;font-size:10pt;page-break-after:always;padding:1px; }
		}
	</style>
</head>
<body>
	<div class="container">
		<h4><?=$Settings->site_name.'<br>'.$page_title?></h4>
		<div class="btn-group">
			<a class="btn btn-primary" href="<?=site_url('settings');?>"><i class="glyphicon glyphicon-dashboard"></i> <?= lang('dashboard'); ?></a>
			<a class="btn btn-default" href="javascript:void();" onclick="window.print();"><i class="glyphicon glyphicon-print"></i> <?= lang('print'); ?></a>
		</div>
		<p>Each image will be printed on separate page.</p>
		<div class="text-center"><?php echo $this->pagination->create_links(); ?></div>
		<?=$html?>
		<div  class="text-center"><?php echo $this->pagination->create_links(); ?></div>
	</div>

</body>
</html> 