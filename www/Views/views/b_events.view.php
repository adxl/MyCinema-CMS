<div class="flex mb-m mt-s">
    <i class="fas fa-building"></i>
    <h1 class="ml-s"><?= $title; ?>
    </h1>
</div>

<div class="flex flex-right">
    <a href="/admin/events/new">
        <button class="button button--success mb-l">+ Create Event</button>
    </a>
</div>

<section>
    <div class="row col-9 flex-column-m">
        <?php foreach ($events as $event) : ?>
            <div class="card row no-wrap col-2 mb-m p-s">
                <a class="col-4 m-0" href="/admin/events/edit?id=<?= $event['id'] ?>">
                    <img class="w-100 h-100 poster<?= $event['hasPassed'] ? ' faded' : '' ?>" src="https://fr.web.img6.acsta.net/pictures/19/09/03/12/02/4765874.jpg" alt=" " />
                </a>
                <div class="flex-column col-8">
                    <div class="mb-s flex flex-middle flex-between">
                        <h1 class="no-break">
                            <?= $event['title']; ?>
                        </h1>
                        <a href="/events?id=<?= $event['id']; ?>">
                            <i class="fas fa-eye faded"></i>
                        </a>
                    </div>
                    <p class="no-break"> Schedulled sessions : <?= $event['sessions']; ?>
                    </p>
                    <p class="mb-s no-break"> Next session : <?= $event['nextSession'] ?: '-' ?>
                    </p>
                    <?php if ($event['rooms'] && $event['nextSession']) : ?>
                        <p class=""> Planned room(s) :
                            <?php foreach ($event['rooms'] as $room) : ?>
                                <span><?= $room['label']; ?></span>
                            <?php endforeach; ?>
                        </p>
                    <?php endif; ?>

                    <div class="flex mt-auto">
                        <?php foreach ($event['tags'] as $tag) : ?>
                            <p class="bg-lighter p-s mr-s rounded"> <?= mb_strtoupper($tag); ?> </p>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>