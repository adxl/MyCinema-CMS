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
            <div class="flex flex-right card movie-card col-4 mb-m p-0 <?= $event['hasPassed'] ? ' faded' : '' ?>" style="<?= "background-image: url(" . $event['media'] . ");" ?>">
                <a class="flex-column flex-bottom p-m pt-s pb-s" href="/bo/events/edit?id=<?= $event['id'] ?>">
                    <h1 class="no-break text-white mb-s">
                        <?= $event['title']; ?>
                    </h1>
                    <p class="no-break"> Séances programées : <?= $event['sessions']; ?>
                    </p>
                    <p class="mb-s no-break"> Prochaine séance : <?= $event['nextSession'] ?: '-' ?>
                    </p>
                    <?php if ($event['rooms'] && $event['nextSession']) : ?>
                        <p class=""> Salle(s) prévues :
                            <?php foreach ($event['rooms'] as $room) : ?>
                                <span><?= $room['label']; ?></span>
                            <?php endforeach; ?>
                        </p>
                    <?php endif; ?>

                    <div class="flex mt-auto pt-l">
                        <?php foreach ($event['tags'] as $tag) : ?>
                            <p class="bg-dark-gray text-small p-s mr-s rounded"> <?= mb_strtoupper($tag); ?> </p>
                        <?php endforeach; ?>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</section>