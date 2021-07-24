<div class="flex flex-middle mb-m mt-s">
    <i class="fas fa-home"></i>
    <h1 class="ml-s"><?= $title; ?></h1>
</div>

<div class="flex-column">
    <!-- FIRST CARD : MOVIES INFORMATIONS -->
    <div class="card w-100 flex-column flex-row@l flex-between mb-l pt-xl">
        <div class="flex-column col-8 mb-l">
            <div class="flex-column flex-middle flex-top@m mb-l">
                <h1 class="no-break">Nombre de films</h1>
                <p class="text-large"><?= $nbMovies ?></p>
            </div>
            <div class="flex-column flex-middle flex-top@m">
                <h1 class="no-break">Séances à venir</h1>
                <p class="text-large"><?= $nbScheduled ?></p>
            </div>
        </div>

        <?php if (!empty($lastMovies)) : ?>
            <div class="flex-column col-4">
                <div class="flex-column flex-middle flex-top@m">
                    <h1>Derniers ajouts</h1>
                </div>
                <div class="flex-column flex-row@m flex-middle mb-l">
                    <?php foreach ($lastMovies as $movie) : ?>
                        <a class="mr-m" href="/bo/events/edit?id=<?= $movie['id']; ?>">
                            <img id="dashboard-event-img" class="cover rounded" src="<?= $movie['media']; ?>" alt="poster">
                        </a>
                    <?php endforeach ?>
                </div>
                <a href="/bo/events" class="flex flex-middle flex-center flex-right@l mt-l mb-l">
                    <span class="mr-s">Accéder aux événements</span>
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        <?php endif ?>
    </div>

    <!-- SECOND CARD : ROOMS INFORMATIONS -->
    <div class="card w-100 flex-column flex-row@l flex-between mb-l pt-xl">
        <div class="flex-column col-8">
            <div class="flex-column flex-middle flex-top@m mb-l">
                <h1 class="no-break">Nombre de salles</h1>
                <p class="text-large"><?= $nbRooms ?></p>
            </div>
            <div class="flex-column flex-middle flex-top@m mb-l">
                <h1 class="no-break">Salles indisponibles</h1>
                <p class="text-large"><?= $nbUnavailableRooms ?></p>
            </div>
        </div>

        <?php if (!empty($lastRooms)) : ?>
            <div class="flex-column col-4">
                <div class="flex-column flex-middle flex-top@m">
                    <h1>Derniers ajouts</h1>
                </div>
                <div class="flex-column flex-middle flex-top@m mb-l">
                    <?php foreach ($lastRooms as $room) : ?>
                        <a class="mb-s" href="/bo/rooms/edit?id=<?= $room['id']; ?>">
                            <img id="dashboard-room-img" class="cover rounded" src="<?= $room['media']; ?>" alt="poster">
                        </a>
                    <?php endforeach ?>
                </div>
                <a href="/bo/rooms" class="flex flex-middle flex-center flex-right@l mt-l mb-l">
                    <span class="mr-s">Accéder aux salles</span>
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        <?php endif ?>

    </div>

    <!-- THIRD CARD : COMMENTS INFORMATIONS -->
    <div class="card w-100 flex-column pt-xl">
        <div class="flex-column flex-middle flex-top@l mb-l">
            <h1 class="no-break">Total des commentaires</h1>
            <p class="text-large"><?= $comments['total'] ?></p>
        </div>
        <div class="flex-column flex-row@l flex-around mt-l mb-m">
            <div class="flex-column flex-middle" style="flex-basis: 33%;">
                <p class="text-large"><?= $comments['waiting'] ?></p>
                <h1 class="no-break">En attente</h1>
            </div>
            <div class="flex-column flex-middle" style="flex-basis: 33%;">
                <p class="text-large"><?= $comments['approved'] ?></p>
                <h1 class="no-break">Acceptés</h1>
            </div>
            <div class="flex-column flex-middle" style="flex-basis: 33%;">
                <p class="text-large"><?= $comments['declined'] ?></p>
                <h1 class="no-break">Refusés</h1>
            </div>
        </div>
        <a href="/bo/comments" class="flex flex-middle flex-center flex-right@l mt-l mb-l">
            <span class="mr-s">Accéder aux commentaires</span>
            <i class="fas fa-chevron-right"></i>
        </a>
    </div>
</div>