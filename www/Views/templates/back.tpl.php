<!DOCTYPE html>
<html lang="fr">

<head>
	<base href="Views/dist/">
	<meta charset="UTF-8">
	<meta name="description" content="description de la page de back">
	<title>Template de back</title>
	<link rel="stylesheet" href="main.css">
	<link rel="stylesheet" href="back.css">
	<script src="main.js"></script>
</head>

<body>
	<header>
		<h1>Template de back</h1>
	</header>

	<!-- afficher la vue -->
	<?php include $this->view ?>

</body>

</html>