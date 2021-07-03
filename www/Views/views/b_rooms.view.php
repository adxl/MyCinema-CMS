<div class="flex flex-middle mb-m mt-s">
    <i class="fas fa-building"></i>
    <h1 class="ml-s"><?= $title; ?>
    </h1>
</div>

<div class="flex flex-right">
    <a href="/bo/rooms/new">
        <button class="button button--success mb-l">Créer une salle</button>
    </a>
</div>

<section>
    <div class="row flex-column-m">
        <?php foreach ($rooms as $room) : ?>
            <a class="flex-column card col-3 mb-m p-s" href="/bo/rooms/edit?id=<?= $room['id'] ?>">
                <div class="m-0">
                    <img class="card-image <?= !$room['isAvailable'] ? 'faded' : '' ?>" src="<?= $room['media']; ?>" alt="image" />
                </div>
                <div class="flex-column col-8">
                    <div class="mb-s flex flex-middle flex-between">
                        <h1>
                            <?= $room['label']; ?>
                        </h1>
                        <div class=" flex flex-right <?= !$room['isHandicapAccess'] ? 'faded' : '' ?>">
                            <i class="fas fa-wheelchair"></i>
                        </div>
                    </div>
                    <div class="mb-auto">
                        <p> Capacité : <?= $room['capacity']; ?>
                        <p> Séances programées : <?= $room['sessions']; ?>
                        </p>
                        <p class="mb-s"> Prochaine séance : <?= $room['nextSession'] ?: '-' ?>
                        </p>
                        <p class="mb-s"> Prochain film : <?= $room['nextMovie'] ?: '-' ?>
                        </p>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>