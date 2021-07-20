<?php

use App\Core\Helpers;
?>

<div class="flex flex-middle mb-m mt-s">
    <i class="fas fa-building"></i>
    <h1 class="ml-s"><?= $title; ?>
    </h1>
</div>

<div class="flex flex-right">
    <a href="/bo/events/new">
        <button class="button button--success mb-l">Créer un évènement</button>
    </a>
</div>

<section>
    <div class="row">
        <?php foreach ($events as $event) : ?>
            <div class="flex card movie-card col-12 col-6@m col-4@l col-2@xl mb-m p-0<?= $event['hasPassed'] ? ' faded' : '' ?>" style="<?= "background-image: url(" . $event['media'] . ");" ?>">
                <a class="flex-column flex-top flex-right p-m pt-s pb-s" href="/bo/events/edit?id=<?= $event['id'] ?>">
                    <h1 class="no-break text-white mb-s">
                        <?= $event['title']; ?>
                    </h1>

                    <?php if (!$event['hasPassed']) : ?>
                        <p class="no-break"> Séances programées : <?= $event['sessions']; ?></p>
                        <p class="mb-s no-break"> Prochaine séance : <br> <?= Helpers::toDate($event['nextSession']) ?></p>
                        <?php if ($event['rooms'] && $event['nextSession']) : ?>
                            <p class=""> Prévu dans <?= count($event['rooms']); ?> salle(s)
                            </p>
                        <?php endif; ?>
                    <?php else : ?>
                        <em>Pas de séances à venir</em>
                    <?php endif ?>

                    <div class="flex pt-m">
                        <?php foreach ($event['tags'] as $tag) : ?>
                            <p class="bg-dark-gray text-small p-s mr-s rounded"> <?= mb_strtoupper($tag); ?> </p>
                        <?php endforeach; ?>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</section>