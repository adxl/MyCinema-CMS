<?php

use App\Core\Helpers; ?>

<!-- 3 FILMS + "Voir plus ..." -->
<section class="w-100 w-75@m">
    <div class="w-100 flex-column flex-row@m">
        <div class="col-9">
            <?php if (empty($events)) : ?>
                <div class="flex-column flex-center flex-middle p-m text-center" style="margin-top: 200px;">
                    <h1 class="text-large mb-m faded"><i class="far fa-smile-wink"></i></h1>
                    <p class="text-medium mb-xl faded">Nous aurons bientôt des séances à vous proposer.</p>
                </div>
            <?php else : ?>
                <h1 class="mt-xl mb-l text-bold">NOS FILMS</h1>
                <div class="row flex-top">
                    <?php foreach ($events as $event) : ?>
                        <div class="flex-column mb-l col-12 col-6@m col-4@l col-3@xl">
                            <a href="/events?id=<?= $event['id']; ?>">
                                <img class="w-100 poster rounded" src="<?= $event['media']; ?>" alt="poster">
                                <p class="mt-s"><?= Helpers::toDate($event['nextSession']); ?></p>
                                <p class="mt-m"><?= $event['title']; ?></p>
                                <div class="flex mt-s">
                                    <?php foreach ($event['tags'] as $tag) : ?>
                                        <p class="text-small bg-glossy-gray p-s mr-s rounded"> <?= mb_strtoupper($tag); ?> </p>
                                    <?php endforeach; ?>
                                </div>
                            </a>
                        </div>
                    <?php endforeach ?>
                    <div class="flex-column mb-l col-12 col-6@m col-4@l col-3@xl">
                        <a href="/events">
                            <div class="w-100 poster rounded bg-glossy-gray flex flex-center flex-middle">
                                <p class="p-s">Voir plus</p>
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endif ?>
        </div>
</section>

<!-- 3 SALLES + "Voir plus ..." -->
<?php if (!empty($rooms)) : ?>
    <section class="flex-column flex-middle w-100 w-75@m">
        <div class="col-9">
            <h1 class="mt-xl mb-l text-bold">NOS SALLES</h1>
            <div class="row">
                <?php foreach ($rooms as $room) : ?>
                    <div class="image-card mb-l col-12 col-6@m col-4@l col-3@xl rounded no-zoom">
                        <div>
                            <img class="w-100 rounded" src="<?= $room['media']; ?>" alt="poster">
                        </div>
                        <div class="flex mt-s">
                            <p><?= $room['label']; ?></p>
                            <span class="ml-s mr-s">-</span>
                            <p><?= $room['capacity']; ?> pers.</p>
                        </div>
                    </div>
                <?php endforeach ?>
                <div class="flex-column mb-l col-12 col-6@m col-4@l col-3@xl">
                    <a href="/rooms" class="image-card flex flex-center flex-middle mb-l col-12 col-6@m col-4@l col-3@xl bg-glossy-gray rounded no-zoom">
                        <p class="p-s">Voir plus</p>
                        <i class="fas fa-chevron-right"></i>
                        <p class="mt-s">&nbsp;</p>
                    </a>
                </div>
            </div>
        </div>
    </section>
<?php endif ?>