<div class="flex mb-m mt-s">
    <img src="/Views/dist/icons/black-building.svg" alt="icon">
    <h1 class="ml-s"><?= $title; ?></h1>
</div>

<div class="flex flex-right">
    <a href="/rooms/new">
        <button class="button button--success mb-l">+ Create Event</button>
    </a>
</div>

<section>
    <div class="row">
        <div class="col-2"></div>
        <div class="row col-10">
            <?php foreach ($events as $event) : ?>
                <div class="card row col-4 mb-m p-s">
                    <div class="col-4 m-0">
                        <img class="w-100 h-100 cover rounded<?= $event['hasPassed'] ? ' faded' : '' ?>" src="https://fr.web.img6.acsta.net/pictures/19/09/03/12/02/4765874.jpg" alt=" " />
                    </div>
                    <div class="flex-column col-8">
                        <h1 class="mb-s"> <?= $event['title']; ?> </h1>
                        <p> Schedulled sessions : <?= $event['sessions']; ?></p>
                        <?php if ($event['nextSession']) : ?>
                            <p class="mb-s"> Next session : <?= $event['nextSession']; ?></p>
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
    </div>
</section>