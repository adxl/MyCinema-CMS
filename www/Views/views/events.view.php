<div class="flex mb-m mt-s">
    <img src="/Views/dist/icons/black-building.svg" alt="icon">
    <h1 class="ml-s"><?= $title; ?>
    </h1>
</div>

<div class="flex flex-right">
    <a href="/events/new">
        <button class="button button--success mb-l">+ Create Event</button>
    </a>
</div>

<section>
    <div class="row col-9 flex-column-m">
        <?php foreach ($events as $event) : ?>
            <div class="card row no-wrap col-2 mb-m p-s">
                <a class="col-4 m-0" href="/events/edit?id=<?= $event['id'] ?>">
                    <img class="w-100 h-100 poster<?= $event['hasPassed'] ? ' faded' : '' ?>" src="https://fr.web.img6.acsta.net/pictures/19/09/03/12/02/4765874.jpg" alt=" " />
                </a>
                <div class="flex-column col-8">
                    <div class="mb-s flex flex-middle flex-between">
                        <h1>
                            <?= $event['title']; ?>
                        </h1>
                        <a href="/events?id=<?= $event['id']; ?>">
                            <i class="fas fa-eye faded"></i>
                        </a>
                    </div>
                    <p> Schedulled sessions : <?= $event['sessions']; ?>
                    </p>
                    <?php if ($event['nextSession']) : ?>
                        <p class="mb-s"> Next session : <?= $event['nextSession']; ?>
                        </p>
                    <?php endif; ?>
                    <?php if ($event['rooms']) : ?>
                        <p class=""> Planned room(s) :
                            <?php foreach ($event['rooms'] as $room) : ?>
                                <span><?= $room['label']; ?></span>
                            <?php endforeach; ?>
                        </p>
                    <?php endif; ?>
                    <div class="flex mt-auto">
                        <p class="bg-lighter p-s mr-s rounded"> Tags </p>
                        <p class="bg-lighter p-s mr-s rounded"> Tags </p>
                        <p class="bg-lighter p-s rounded"> Tags </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>