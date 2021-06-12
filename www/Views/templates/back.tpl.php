<?php

use App\Core\Security;

$user = Security::getCurrentUserShort();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="description" content="description de la page de back">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>BackOffice</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
	<link rel="stylesheet" href="/Views/dist/back.css">
	<script type="module" src="/Views/dist/main.min.js"></script>
</head>

<body class="flex-column">

	<div id="small-screen-error">
		<p>Merci d'utiliser un ordinateur pour accéder au BackOffice.</p>
	</div>

	<?php include 'Views/views/components/header.view.php' ?>

	<main class="flex flex-auto">
		<section id="sidebar" class="bg-dark hidden-s">
			<ul>
				<li>
					<a href="/bo">
						<i class="fas fa-home"></i>
						<span>Dashboard</span>
					</a>
				</li>
				<li>
					<a href="/bo/events">
						<i class="fas fa-calendar-alt"></i>
						<span>Évènements</span>
					</a>
				</li>
				<li>
					<a href="/bo/rooms">
						<i class="fas fa-building"></i>
						<span>Salles</span>
					</a>
				</li>
				<li>
					<a href="/bo/comments">
						<i class="fas fa-comments"></i>
						<span>Commentaires</span>
					</a>
				</li>

				<?php if ($user['role'] === 'ADMIN') : ?>

					<li>
						<a href="/bo/users">
							<i class="fas fa-users"></i>
							<span>Utilisateurs</span>
						</a>
					</li>
					<li class="mt-l">
						<a href="/bo/tools">
							<i class="fas fa-tools"></i>
							<span>Utilitaires</span>
						</a>
					</li>
					<li>
						<a href="/bo/settings">
							<i class="fas fa-cog"></i>
							<span>Paramètres</span>
						</a>
					</li>

				<?php endif ?>

			</ul>
		</section>
		<section id="view" class="flex-auto scroll-y">
			<?php include $this->view ?>
		</section>
	</main>
</body>

</html>