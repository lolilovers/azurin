<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Welcome to Azurin 2</title>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<style>
		*{
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}
		html{
			font: normal 16px sans-serif;
			color: #555;
		}
		ul, nav{
			list-style: none;
		}
		a{
			text-decoration: none;
			color: inherit;
			cursor: pointer;
			opacity: 0.9;
		}
		a:hover{
			opacity: 1;
		}
		a.btn{
			color: #fff;
			border-radius: 4px;
			text-transform: uppercase;
			background-color: #2196F3;
			font-weight: 800;
			text-align: center;
		}
		hr{
			width: 150px;
			height: 2px;
			background-color: #2196F3;
			border: 0;
			margin-bottom: 80px;
		}
		section{
			display: flex;
			flex-direction: column;
			align-items: center;
			padding: 125px 100px;
		}
		@media (max-width: 1000px){
			section{
				padding: 100px 50px;
			}
		}
		@media (max-width: 600px){
			section{
				padding: 80px 30px;
			}
		}
		section h3.title{
			color: #414a4f;
			text-transform: capitalize; 
			font: bold 32px 'Open Sans', sans-serif;
			margin-bottom: 35px;
			text-align: center;
		}
		section p{
			max-width: 800px;
			text-align: center;
			margin-bottom: 35px;
			padding: 0 20px;
			line-height: 2;
		}
		ul.grid{
			width: 100%;
			display: flex;
			flex-wrap: wrap;
			justify-content: center;
		}
		header{
			position: absolute;
			top: 0;
			left: 0;
			z-index: 10;
			width: 100%;
			display: flex;
			justify-content: space-between;
			align-items: center;
			color: #fff;
			padding: 35px 100px 0;
		}
		header h2{
			font-family: 'Quicksand', sans-serif;
		}
		header nav{
			display: flex;
		}
		header nav li{
			margin: 0 15px;
		}
		header nav li:first-child{
			margin-left: 0;	
		}
		header nav li:last-child{
			margin-right: 0;	
		}
		@media (max-width: 1000px){
			header{
				padding: 20px 50px;
			}
		}
		@media (max-width: 700px){
			header{
				flex-direction: column;		
			}
			header h2{
				margin-bottom: 15px;
			}
		}
		.hero{
			position: auto;
			justify-content: center;
			min-height: 100vh;
			color: #fff;
			text-align: center;
		}
		.hero .background-image{
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-color: #0b304e;
			z-index: -1;
		}
		.hero h1{
			font: bold 60px 'Open Sans', sans-serif;
			margin-bottom: 15px;
		}
		.hero h3{
			font: normal 28px 'Open Sans', sans-serif;
			margin-bottom: 40px;
		}
		.hero a.btn{
			padding: 20px 46px;
		}
		@media (max-width: 800px){
			.hero{
				min-height: 600px;
			}
			.hero h1{
				font-size: 48px;
			}
			.hero h3{
				font-size: 24px;
			}
			.hero a.btn{
				padding: 15px 40px;
			}
		}
	</style>
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
		<div class="background-image"></div>
		<h1>Azurin <?= AZURIN_VERSION ?></h1>
		<h3>Simple PHP Framework.</h3>
		<a href="#" class="btn">Getting Started</a>
	</section>
</body>
</html>
