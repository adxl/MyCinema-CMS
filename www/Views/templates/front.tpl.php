<?php

use App\Core\Security;

$user = Security::getCurrentUserShort();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="description" content="description de la page de front">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Template de front</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
	<link rel="stylesheet" href="/Views/dist/front.css">

	<link rel="stylesheet" href="/Views/dist/themes/default.css">

	<script type="module" src="/Views/dist/main.min.js"></script>
</head>

<body>

	<?php include 'Views/views/components/f_nav.view.php' ?>
	<?php include 'Views/views/components/header.view.php' ?>

	<main>
		<?php include $this->view ?>
	</main>

</body>

</html>