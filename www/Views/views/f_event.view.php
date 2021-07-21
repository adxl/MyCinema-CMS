<?php

use App\Core\Helpers; ?>

<section class="bg-dark flex flex-center text-white w-100 mb-l">
    <div class="w-100 w-75@m">
        <div class="flex-column flex-middle">
            <h1 class="text-center text-white text-large text-bold mt-m"><?= $event['title']; ?></h1>
            <hr class="w-25">
            <p class='text-capitalize mb-l'> <?= strtolower(implode(', ', $event['tags'])) ?> </p>
        </div>
        <div class="flex-column flex-row@m">
            <div class="flex flex-center flex-right@l col-6 h-100">
                <div class="h-100 w-75@m p-l">
                    <img class="w-100 rounded" style="min-width: 250px;" src="<?= $event['media']; ?>" alt="poster">
                </div>
            </div>
            <div class="p-m col-6">
                <h2 class="mb-s text-white text-underline text-medium">Synopsis : </h2>
                <p class="mb-l"><?= $event['synopsis']; ?></p>
                <div class="mb-l">
                    <div class="flex mb-s">
                        <p class="text-underline">Par</p>
                        <p>: <?= $event['directors']; ?> </p>
                    </div>
                    <div class="flex">
                        <p class="text-underline">Avec</p>
                        <p>: <?= $event['actors']; ?> </p>
                    </div>
                </div>
                <div class="flex flex-column">
                    <h2 class="mb-s text-white text-underline text-medium"> <?= $event['sessions']['total']; ?> séance<?= $event['sessions']['total'] > 1 ? 's' : ''; ?> à venir :</h2>

                    <?php foreach ($event['sessions']['items'] as $sessionDate => $sessions) : ?>
                        <p class="flex-grow"><?= Helpers::formatDate($sessionDate); ?></p><br>
                        <div class="row">
                            <?php foreach ($sessions as $session) : ?>
                                <div class="bg-dark-gray p-s text-gray mb-l col-6 col-6@m col-4@l col-3@xl rounded no-zoom">
                                    <div class="w-100 rounded" src="<?= $room['media']; ?>" alt="poster">
                                        <div class="flex mb-s">
                                            <i class="fas fa-clock text-normal mr-s"></i>
                                            <h5 class="mt-0 mb-0"><?= Helpers::formatTime($session['startTime']) ?> </h5>
                                        </div>
                                        <div class="flex mb-s">
                                            <i class="fas fa-stopwatch text-normal mr-s"></i>
                                            <h5 class="mt-0 mb-0"><?= Helpers::dateDiff($session['startTime'], $session['endTime']); ?></h5>
                                        </div>
                                        <div class="flex">
                                            <i class="fas fa-map-marker-alt text-normal mr-s"></i>
                                            <small><?= $session['room']['name']; ?>&nbsp;</small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="w-100 w-50@m p-l">
    <div class="mb-l">
        <h1 class="mb-s">Commentaires :</h1>
        <?php if ($comments) : ?>
            <?php foreach ($comments as $comment) : ?>
                <div class="card mb-s">
                    <div class="flex flex-middle mb-s">
                        <p class="mr-s text-bold"><?= $comment['name']; ?></p>
                        <p class="text-small"><?= Helpers::toDate($comment['date']); ?></p>
                    </div>
                    <p><?= $comment['content']; ?></p>
                </div>
            <?php endforeach ?>
        <?php else : ?>
            <div class="card flex flex-center flex-middle">
                <p class="text-muted">Aucun commentaire à afficher pour l'instant </p>
            </div>
        <?php endif; ?>
    </div>

    <!-- input ajout commentaire -->
    <div class="row w-100 mb-l">
        <h1 class="mb-s">Ajouter un commentaire : </h1>
        <div class="flex w-100">
            <?php App\Core\FormBuilder::render($commentForm); ?>
        </div>
    </div>
</section>