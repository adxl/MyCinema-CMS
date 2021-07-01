<section class="flex-center">
    <?php if (empty($rooms)) : ?>
        <div class="flex flex-middle flex-center">
            <h1>Aucune salle trouvé</h1>
            <?= die() ?>
        </div>
    <?php endif ?>
</section>

<section class="flex-center">
    <div id="rooms-front" class="flex flex-center">
        <div class="w-75">
            <p class="text-white"><?= $rooms[0]['label']; ?></p>
            <img class="w-100" src="https://www.pevelecarembault.fr/wp-content/uploads/2016/12/Salle-cin%C3%A9ma-vide.jpg" alt="poster">
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
                    <img class="w-100 rounded" src="https://www.telerama.fr/sites/tr_master/files/styles/simplecrop1000/public/beaugrenelle.onyx_.hd_.007_0.jpg?itok=Oyx4HmR0" alt="poster">
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