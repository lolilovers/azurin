<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Welcome to Azurin 2</title>
	<link rel="shortcut icon" href="<?= URL ?>favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="<?= URL ?>assets/css/style.css">
</head>
<body>
	<header>
		<h2><a href="#">Azurin</a></h2>
		<nav>
			<li><a href="#">Home</a></li>
			<li><a href="#">Docs</a></li>
			<li><a href="#">GitHub</a></li>
		</nav>
	</header>
	<section class="hero">
		<div class="background-image" style="background-image: url(<?= URL ?>/assets/img/background.svg)"></div>
		<img height="120px" src="<?= URL ?>assets/img/logo.png" alt="logo">
		<h1>Azurin <?= AZURIN_VERSION ?></h1>
		<h3>Simple PHP Framework.</h3>
		<a href="#" class="btn">Getting Started</a>
	</section>
</body>
</html>
