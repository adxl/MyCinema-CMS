<?php

use App\Core\Helpers; ?>

<div class="flex flex-middle mb-m mt-s">
    <i class="fas fa-home"></i>
    <h1 class="ml-s"><?= $title; ?></h1>
</div>

<div class="flex-column">
    <!-- FIRST CARD : MOVIES INFORMATIONS -->
    <div class="card w-100 flex-column flex-row@l flex-between mb-l">
        <div class="flex-column col-8">
            <div class="flex-column flex-middle flex-top@m">
                <h3 class="no-break">Nombre de films</h3>
                <h1 class="text-large"><?= $nbMovies ?></h1>
            </div>
            <div class="flex-column flex-middle flex-top@m">
                <h3 class="no-break">Séances à venir</h3>
                <h1 class="text-large"><?= $nbScheduled ?></h1>
            </div>
        </div>
        <div class="flex-column col-4">
            <h3>Derniers ajouts</h3>
            <div class="flex-column flex-row@m flex-middle">
                <?php foreach ($lastMovies as $movie) : ?>
                    <a class="mr-m" href="/bo/events/edit?id=<?= $movie['id']; ?>">
                        <img style="max-width: 130px; height:220px" class="cover rounded" src="<?= $movie['media']; ?>" alt="poster">
                    </a>
                <?php endforeach ?>
            </div>
            <a href="/bo/events" class="flex flex-middle flex-right mt-l">
                <span class="mr-s">Accéder aux événements</span>
                <i class="fas fa-chevron-right"></i>
            </a>
        </div>
    </div>

    <!-- SECOND CARD : ROOMS INFORMATIONS -->
    <div class="card w-100 flex-column flex-row@l flex-between mb-l">
        <div class="flex-column col-8">
            <div class="flex-column flex-middle flex-top@m">
                <h3 class="no-break">Nombre de salles</h3>
                <h1 class="text-large"><?= $nbRooms ?></h1>
            </div>
            <div class="flex-column flex-middle flex-top@m">
                <h3 class="no-break">Salles indisponibles</h3>
                <h1 class="text-large"><?= $nbUnavailableRooms ?></h1>
            </div>
        </div>
        <div class="flex-column col-4">
            <h3>Derniers ajouts</h3>
            <div class="flex-column flex-row@m flex-middle">
                <?php foreach ($lastRooms as $room) : ?>
                    <a class="mr-m" href="/bo/rooms/edit?id=<?= $room['id']; ?>">
                        <img style="max-width: 130px; height:220px" class="cover rounded" src="<?= $room['media']; ?>" alt="poster">
                    </a>
                <?php endforeach ?>
            </div>
            <a href="/bo/rooms" class="flex flex-middle flex-right mt-l">
                <span class="mr-s">Accéder aux salles</span>
                <i class="fas fa-chevron-right"></i>
            </a>
        </div>
    </div>

    <!-- THIRD CARD : COMMENTS INFORMATIONS -->
    <div class="card w-100 flex-column flex-row@l flex-between">
        <div class="flex-column w-100">
            <div class="flex-column flex-middle flex-top@m mb-l">
                <h3 class="no-break">Total des commentaires</h3>
                <h1 class="text-large"><?= $comments['total'] ?></h1>
            </div>
            <div class="flex-column flex-row@l flex-between mt-l">
                <div class="flex-column flex-middle flex-top@m">
                    <h1 class="text-large"><?= $comments['waiting'] ?></h1>
                    <h3 class="no-break">En attente</h3>
                </div>
                <div class="flex-column flex-middle flex-top@m">
                    <h1 class="text-large"><?= $comments['approved'] ?></h1>
                    <h3 class="no-break">Acceptés</h3>
                </div>
                <div class="flex-column flex-middle flex-top@m">
                    <h1 class="text-large"><?= $comments['declined'] ?></h1>
                    <h3 class="no-break">Refusés</h3>
                </div>
            </div>
            <a href="/bo/comments" class="flex flex-middle flex-right mt-l">
                <span class="mr-s">Accéder aux commentaires</span>
                <i class="fas fa-chevron-right"></i>
            </a>
        </div>
    </div>
</div>