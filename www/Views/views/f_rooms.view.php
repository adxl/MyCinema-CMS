<section>
    <div class="row">
        <div class="flex-column">
            <?php foreach ($rooms as $room) : ?>
                <a href="/rooms?id=<?= $room['id']; ?>">
                    <p> <?= $room['label']; ?> </p>
                </a>
            <?php endforeach ?>
        </div>
    </div>
</section>