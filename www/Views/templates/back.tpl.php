<!DOCTYPE html>
<html lang="fr">

<head>
	<base href="Views/dist/">
	<meta charset="UTF-8">
	<meta name="description" content="description de la page de back">
	<title>Template de back</title>
	<link rel="stylesheet" href="back.css">
	<script src="main.js"></script>
</head>

<body class="flex-column">
	<header class="flex flex-between flex-middle bg-light">
		<div class="p-m">
			<img src="" alt=" " class="logo">
		</div>
		<div class="flex flex-middle mx-m bg-gray rounded h-75 crop">
			<div class="bg-white rounded p-s">
				<p class="m-0">Yves S.</p>
			</div>
			<div class="flex flex-middle p-s">
				<img src="" alt=" " class="avatar">
			</div>
		</div>
	</header>

	<main class="flex flex-auto">
		<section id="sidebar" class="bg-dark">
			<ul>
				<li><a href="#">
						<img src="" class="icon" alt=" ">
						<span>Dashboard</span>
					</a>
				</li>
				<li><a href="#">
						<img src="" class="icon" alt=" ">
						<span>Events</span>
					</a>
				</li>
				<li><a href="#">
						<img src="" class="icon" alt=" ">
						<span>Comments</span>
					</a>
				</li>
				<li><a href="#">
						<img src="" class="icon" alt=" ">
						<span>Rooms</span>
					</a>
				</li>
				<li><a href="#">
						<img src="" class="icon" alt=" ">
						<span>Users</span>
					</a>
				</li>
				<li><a href="#">
						<img src="" class="icon" alt=" ">
						<span>Settings</span>
					</a>
				</li>
			</ul>
		</section>
		<section class="flex-auto scroll-y">
			<!-- <?php include $this->view ?> -->
		</section>
	</main>
</body>

</html>