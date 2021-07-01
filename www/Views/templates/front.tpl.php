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

	<header class="flex flex-between flex-middle bg-soft-white">
		<div class="p-m">
			<a href="/">
				<h1 id="cms-logo" class="pl-m"><?= WEBSITE_NAME; ?></h1>
			</a>
		</div>

		<?php if (!empty($user)) : ?>
			<div id="user-profile-button" class="flex flex-middle mr-m bg-gray rounded crop">
				<div class="flex flex-middle flex-self-stretch bg-white pr-m pl-m">
					<p><?= $user['firstname'] . " " . mb_strtoupper($user['lastname'][0]) . '.'; ?></p>
				</div>
				<div class="flex flex-middle p-s">
					<i class="fas fa-user"></i>
				</div>
			</div>
			<div id="user-profile-menu" class="card p-0 flex-column crop hidden">
				<a href="/bo/account">Compte</a>
				<a href="/bo">BackOffice</a>
				<a href="/bo/logout">Se déconnecter</a>
			</div>
		<?php endif ?>

	</header>

	<main>
		<?php include $this->view ?>
		<?php include 'Views/views/components/f_footer.view.php' ?>
	</main>

</body>

</html>