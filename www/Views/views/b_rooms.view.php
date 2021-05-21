<div class="flex flex-middle mb-m mt-s">
    <i class="fas fa-building"></i>
    <h1 class="ml-s"><?= $title; ?>
    </h1>
</div>

<div class="flex flex-right">
    <a href="/bo/rooms/new">
        <button class="button button--success mb-l">+ Create Room</button>
    </a>
</div>

<section>
    <div class="row flex-column-m">
        <?php foreach ($rooms as $room) : ?>
            <a class="card row no-wrap col-2 mb-m p-s" href="/bo/rooms/edit?id=<?= $room['id'] ?>">
                <div class="col-4 m-0">
                    <img class="w-100 h-100 poster <?= !$room['isAvailable'] ? 'faded' : '' ?>" src="https://images.rtl.fr/rtl/www/1196574-une-salle-de-cinema-illustration.jpg" alt="image" />
                </div>
                <div class="flex-column col-8">
                    <div class="mb-s flex flex-middle flex-between">
                        <h1>
                            <?= $room['label']; ?>
                        </h1>
                        <div class=" flex flex-right <?= !$room['isHandicapAccess'] ? 'faded' : '' ?>">
                            <i class="fas fa-wheelchair"></i>
                        </div>
                    </div>
                    <div class="mb-auto">
                        <p> Capacity : <?= $room['capacity']; ?>
                        <p> Schedulled sessions : <?= $room['sessions']; ?>
                        </p>
                        <p class="mb-s"> Next session : <?= $room['nextSession'] ?: '-' ?>
                        </p>
                        <p class="mb-s"> Next Movie : <?= $room['nextMovie'] ?: '-' ?>
                        </p>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>