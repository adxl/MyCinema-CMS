<!DOCTYPE html>
<html lang="fr">

<head>
	<base href="Views/dist/">
	<meta charset="UTF-8">
	<meta name="description" content="description de la page de front">
	<title>Template de front</title>
	<link rel="stylesheet" href="/Views/dist/front.css">
	<script type="module" src="/Views/dist/main.min.js"></script>
</head>

<body>
	<header>
		<h1>Template de front</h1>
	</header>

	<!-- afficher la vue -->
	<?php include $this->view ?>



</body>

</html>