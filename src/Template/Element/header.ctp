<!doctype html>
<html lang=en>

<head>
	<meta charset=utf-8>
	<meta http-equiv=X-UA-Compatible content="IE=edge">
	<meta name=viewport content="width=device-width, initial-scale=1">
	<title>iDS PRIME</title>

	<?= $this->Html->css('animate.min.css') ?>
	<?= $this->Html->css('font-awesome.min.css') ?>
	<?= $this->Html->css('bootstrap.min.css') ?>
	<?= $this->Html->css('menu.css') ?>
	<?= $this->Html->css('style.css') ?>
	<?= $this->Html->css('validationEngine.jquery.css') ?>
	<?= $this->Html->css('template.css') ?>

	<?= $this->Html->meta(
		'favicon.ico',
		'favicon.ico',
		['type' => 'icon']
	); ?>
	<link rel="icon" type="image/ico" href="favicon.ico">
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

	<!-- loder script link -->
	<script src="https://cdn.jsdelivr.net/gh/AmagiTech/JSLoader/amagiloader.js"></script>


	<?= $this->fetch('meta') ?>
	<?= $this->fetch('css') ?>
	<?= $this->fetch('script') ?>

	<link href="css/responsive.css" rel="stylesheet" type="text/css">
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-PGCGXFNPGN"></script>
	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());

		gtag('config', 'G-PGCGXFNPGN');
	</script>
</head>