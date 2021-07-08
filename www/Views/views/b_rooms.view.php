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
    <div class="row">
        <?php foreach ($rooms as $room) : ?>
            <div class="flex card room-card col-12 col-12@m col-6@l col-4@xl mb-m p-0<?= !$room['isAvailable'] ? ' faded' : '' ?>" style="<?= "background-image: url(" . $room['media'] . ");" ?>">
                <a class="flex-column flex-top flex-right p-m pt-s pb-s" href="/bo/rooms/edit?id=<?= $room['id'] ?>">
                    <div class="flex flex-between flex-middle mb-s">
                        <h1 class="no-break text-white m-0">
                            <?= $room['label']; ?>
                        </h1>
                        <?php if ($room['isHandicapAccess']) : ?>
                            &nbsp;(<i class="fas fa-wheelchair"></i>)
                        <?php endif ?>
                    </div>

                    <p> Capacité : <?= $room['capacity']; ?>
                    </p>
                    <p> Séances programées : <?= $room['sessions']; ?>
                    </p>
                    <p class="mb-s"> Prochaine séance : <br> <?= $room['nextSession'] ?: '-' ?>
                    </p>
                    <p class="mb-s"> Prochain film : <?= $room['nextMovie'] ?: '-' ?>
                    </p>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</section>