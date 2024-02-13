<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Budget App</title>
		<link rel="stylesheet" href="/public/style.css">
	</head>

	<body>
		<section class="main-window">
			
			<div class="window">

				<div class="logo-section">
					<img src="/img/logo.png" alt="">
					<h2>Budget App</h2>
				</div>
				
				<?php
					require_once("templates/pages/unLogged/$page.php")
				?>

			</div>
		</section>
	</body>
</html>