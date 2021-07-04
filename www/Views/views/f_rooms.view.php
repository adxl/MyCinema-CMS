<section class="flex-center">
    <?php if (empty($rooms)) : ?>
        <div class="flex flex-middle flex-center">
            <h1 class="mt-l mb-m">Aucune salle trouvé</h1>
            <?= die() ?>
        </div>
    <?php endif ?>
</section>

<section class="flex-center">
    <div id="rooms-front" class="flex flex-center">
        <div class="w-75">
            <p class="text-white"><?= $cover_room['label']; ?></p>
            <img class="w-100" src="<?= $cover_room['media']; ?>" alt="poster">
        </div>
    </div>
</section>

<!-- TOUTES LES SALLES -->
<section id="all-events-section">
    <h1 class="mt-l mb-m">Toutes les salles : </h1>
    <div class="row">
        <?php foreach ($rooms as $room) : ?>
            <div class="image-card col-4 pb-m">
                <div>
                    <img class="w-100 rounded" src="<?= $room['media']; ?>" alt="poster">
                </div>
                <?php if ($room['isHandicapAccess']) : ?>
                    <p class="handicap">
                        <i class="fas fa-wheelchair"></i>
                    </p>
                <?php endif ?>
                <p class="title"><?= $room['label']; ?></p>
            </div>
        <?php endforeach ?>
    </div>
</section>