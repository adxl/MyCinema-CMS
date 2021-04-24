<div class="flex mb-m mt-s">
    <img src="/Views/dist/icons/black-building.svg" alt="icon">
    <h1 class="ml-s"><?= $title; ?>
    </h1>
</div>

<div class="flex flex-right">
    <a href="/rooms/new">
        <button class="button button--success mb-l">+ Create Room</button>
    </a>
</div>

<section>

    <div class="row">
        
        <div class="row col-10 flex-column-m">
            <?php foreach ($rooms as $room) : ?>
                <a class="card row no-wrap col-2 mb-m p-s" href="/rooms/edit?id=<?= $room['id'] ?>">
                    <div class="col-4 m-0">
                        <img class="w-100 h-100 poster<?= !$room['isAvailable'] ? ' faded' : '' ?>" src="https://images.rtl.fr/rtl/www/1196574-une-salle-de-cinema-illustration.jpg" alt="image" />
                    </div>
                    <div class="flex-column col-8">    
                      <div class="mb-s flex flex-middle flex-between">
                        <h1 class="mb-s">
                            <?= $room['label']; ?>
                        </h1>
                        <?php if ($room['isHandicapAccess']) : ?>
                        <div class="flex flex-right"><img class="icon" src="/Views/dist/icons/handicap.svg"
                                alt="handicap-icon"></div>
                        <?php endif; ?>
                      </div>
                    </div>

                    <div class="mb-auto">
                        <p> Capacity : <?= $room['capacity']; ?>
                        <p> Schedulled sessions : <?= $room['sessions']; ?>
                        </p>
                        <?php if ($room['nextSession']) : ?>
                        <p class="mb-s"> Next session : <?= $room['nextSession']; ?>
                        </p>
                        <?php endif; ?>
                        <?php if ($room['nextMovie']) : ?>
                        <p class="mb-s"> Next Movie : <?= $room['nextMovie']; ?>
                        </p>
                        <?php endif; ?>

                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>

    </div>

</section>