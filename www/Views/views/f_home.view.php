<?php

use App\Core\Helpers; ?>

<!-- 3 FILMS + "Voir plus ..." -->
<section class="w-75">
    <div class="w-100 flex-column flex-row@m">
        <div class="col-9">
            <h1 class="mt-xl mb-l text-bold">NOS FILMS</h1>
            <div class="row flex-top">
                <?php foreach ($incomingEvents as $event) : ?>
                    <div class="flex-column mb-l col-12 col-6@m col-4@l col-3@xl">
                        <a href="/events?id=<?= $event['id']; ?>">
                            <img class="w-100 poster rounded" src="<?= $event['media']; ?>" alt="poster">
                            <p class="mt-s"><?= Helpers::toDate($event['nextSession']); ?></p>
                            <p class="mt-m"><?= $event['title']; ?></p>
                            <div class="flex mt-s">
                                <?php foreach ($event['tags'] as $tag) : ?>
                                    <p class="text-small bg-lighter p-s mr-s rounded"> <?= mb_strtoupper($tag); ?> </p>
                                <?php endforeach; ?>
                            </div>
                        </a>
                    </div>
                <?php endforeach ?>
                <div class="flex-column mb-l col-12 col-6 col-4@l col-3@xl">
                    <a href="/events">
                        <div class="w-100 poster rounded bg-lighter flex flex-center flex-middle" alt="poster">
                            <p class="text-bold p-s">Voir plus ...</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
</section>

<!-- 3 SALLES + "Voir plus ..." -->
<?php if (!empty($rooms)) : ?>
    <section class="flex-column flex-middle w-75">
        <div class="col-9">
            <h1 class="mt-xl mb-l text-bold">NOS SALLES</h1>
            <div class="row">
                <?php foreach ($rooms as $room) : ?>
                    <div class="image-card mb-l col-12 col-6@m col-4@l col-3@xl rounded no-zoom">
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
                <a href="rooms" class="image-card mb-l col-12 col-6@m col-4@l col-3@xl bg-lighter rounded no-zoom flex flex-center flex-middle">
                    <p class="text-bold p-s">Voir plus ...</p>
                </a>
            </div>
        </div>
    </section>
<?php endif ?>
</div>