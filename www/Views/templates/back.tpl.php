<!DOCTYPE html>
<html lang="fr">

<head>
	<!-- <base href="/Views/dist/"> -->
	<meta charset="UTF-8">
	<meta name="description" content="description de la page de back">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Template de back</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
	<link rel="stylesheet" href="/Views/dist/back.css">
	<script type="module" src="/Views/dist/main.min.js"></script>
</head>

<body class="flex-column">
	<header class="flex flex-between flex-middle bg-soft-white">
		<div class="p-m">
			<!-- <img src="" alt="" class="logo"> -->
		</div>
		<div id="user-profile-button" class="flex flex-middle mr-m bg-gray rounded crop">
			<div class="flex flex-middle flex-self-stretch bg-white pr-m pl-m">
				<p>Yves S.</p>
			</div>
			<div class="flex flex-middle p-s">
				<i class="fas fa-user"></i>
			</div>
		</div>
		<div id="user-profile-menu" class="card p-0 flex-column crop hidden">
			<a href="#">Account</a>
			<a href="#">Reservations</a>
			<a href="#">Preferences</a>
			<a href="#">Log out</a>
		</div>
	</header>

	<main class="flex flex-auto">
		<section id="sidebar" class="bg-dark hidden-s">
			<ul>
				<li><a href="/">
						<i class="fas fa-home"></i>
						<span>Dashboard</span>
					</a>
				</li>
				<li><a href="/events">
						<i class="fas fa-calendar-alt"></i>
						<span>Events</span>
					</a>
				</li>
				<li><a href="/comments">
						<i class="fas fa-comments"></i>
						<span>Comments</span>
					</a>
				</li>
				<li><a href="/rooms">
						<i class="fas fa-building"></i>
						<span>Rooms</span>
					</a>
				</li>
				<li><a href="/users">
						<i class="fas fa-users"></i>
						<span>Users</span>
					</a>
				</li>
				<li><a href="/settings">
						<i class="fas fa-cog"></i>
						<span>Settings</span>
					</a>
				</li>
			</ul>
		</section>
		<section id="view" class="flex-auto scroll-y">
			<?php include $this->view ?>
		</section>
	</main>
</body>

</html>