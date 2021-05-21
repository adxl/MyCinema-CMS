<section>
    <div class="row">
        <div class="flex-column">
            <?php foreach ($events as $event) : ?>
                <a href="/events?id=<?= $event['id']; ?>">
                    <p> <?= $event['title']; ?> </p>
                </a>
            <?php endforeach ?>
        </div>
    </div>
</section>