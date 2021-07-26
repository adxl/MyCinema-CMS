<section class="w-100 w-75@m w-50@l p-l flex-center">
    <?php if (empty($rooms)) : ?>
        <div class="flex-column flex-center flex-middle p-m text-center" style="margin-top: 200px;">
            <h1 class="text-large mb-m faded"><i class="fas fa-door-closed"></i></h1>
            <p class="text-medium mb-xl faded">Nos salles s'afficheront ici dès qu'elles seront disponibles.</p>
        </div>
    <?php else : ?>
        <div id="rooms-front" class="flex flex-center mt-l ">
            <div class="w-100">
                <p class="text-white"><?= $cover_room['label']; ?></p>
                <img class="w-100" src="<?= $cover_room['media']; ?>" alt="poster">
            </div>
        </div>
    <?php endif ?>
</section>

<?php if (!empty($rooms)) : ?>
    <!-- TOUTES LES SALLES -->
    <section class="flex-column flex-middle w-75">
        <h1 class="mt-l mb-m">Toutes les salles : </h1>
        <div class="w-100 row">
            <?php foreach ($rooms as $room) : ?>
                <div class="image-card mb-l col-12 col-6@m col-4@l col-3@xl">
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
<?php endif ?>