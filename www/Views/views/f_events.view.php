<!-- NE PAS UTILISER LES CLASSES SCSS -->

<!-- PROCHAIN EVENT -->
<section>
    <div>
        <?= $nextEvent['title']; ?>
    </div>
</section>


<!-- EVENTS A VENIR -->
<section style="margin-top: 100px;">
    <div>
        <?php foreach ($incomingEvents as $event) : ?>
            <p><?= $event['title']; ?></p>
        <?php endforeach ?>
    </div>
</section>


<!-- TOUS LES EVENTS -->
<section style="margin-top: 100px;">
    <div>
        <?php foreach ($events as $event) : ?>
            <a href="/events?id=<?= $event['id']; ?>">
                <p> <?= $event['title']; ?> </p>
            </a>
        <?php endforeach ?>
    </div>
</section>