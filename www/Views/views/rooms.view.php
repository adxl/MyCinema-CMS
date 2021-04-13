<div class="flex mb-m mt-s">
    <img src="/Views/dist/icons/black-building.svg" alt="icon">
    <h1 class="ml-s"><?= $title; ?></h1>
</div>

<div class="flex flex-right">
    <a href="/rooms/new">
        <button class="button button--success mb-l">+ Create Room</button>
    </a>
</div>

<section>
    <div class="row">
        <?php foreach ($rooms as $room) : ?>

            <a class="card row col-4 mb-m p-s" href="/rooms<?= $isAdmin ? "/edit" : "" ?>?id=<?= $room['id'] ?>">
                <div class="col-4 m-0">
                    <img class="w-100 h-100 cover rounded" src="https://images.rtl.fr/rtl/www/1196574-une-salle-de-cinema-illustration.jpg" alt="image" />
                </div>
                <div class="flex-column col-8">
                    <h1 class="mb-s">
                        <?= $room['label']; ?>
                    </h1>
                    <div class="mb-auto">
                        <p> Scheduled sessions : <?= null; ?> </p>
                        <p class="mb-s"> Next session : <?= null; ?> </p>
                    </div>
                    <p> Planned rooms : <?= null; ?> </p>
                </div>
            </a>

        <?php endforeach; ?>

    </div>
</section>