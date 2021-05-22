<!-- PROCHAIN EVENT -->
<section id="next-event-section">
    <h1 class="text-center">PROCHAINEMENT</h1>
    <div class="row">
        <div class="flex flex-center rounded col-6 h-100">
            <div class="h-100 p-l">
                <img class="h-100 w-100 cover rounded" src="https://farm5.staticflickr.com/4432/37156603705_88d8f43f1b_o.jpg" alt="poster">
            </div>
        </div>
        <div class="flex-column p-m col-6">
            <h1><?= $nextEvent['title']; ?></h1>
            <p>Synopsis : </p>
            <p class="mb-l"><?= $nextEvent['synopsis']; ?></p>

            <p class="mb-s">Par : <?= $nextEvent['directors']; ?></p>
            <p>Avec : <?= $nextEvent['actors']; ?></p>
            <div class="flex mt-auto mb-m">
                <?php foreach ($nextEvent['tags'] as $tag) : ?>
                    <p class="bg-lighter p-s mr-s rounded"> <?= mb_strtoupper($tag); ?> </p>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>


<!-- EVENTS A VENIR -->
<section id="incoming-events-section">
    <h1>Prochainement : </h1>
    <div class="row">
        <?php foreach ($incomingEvents as $event) : ?>
            <div class="flex-column col-3">
                <img class="w-100 rounded" src="https://ae01.alicdn.com/kf/HTB1RHpBIXXXXXbLXFXXq6xXFXXXz/Free-shipping-HD-wallpaper-poster-Captain-America-Civil-War-movie-poster-Smith-24x36inch.jpg_Q90.jpg_.webp" alt="poster">
                <p><?= $event['title']; ?></p>
                <p><?= $event['directors']; ?></p>
                <div class="flex mt-auto">
                    <?php foreach ($event['tags'] as $tag) : ?>
                        <p class="bg-lighter p-s mr-s rounded"> <?= mb_strtoupper($tag); ?> </p>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</section>


<!-- TOUS LES EVENTS -->
<section id="all-events-section">
    <h1>Tous les évènements : </h1>
    <div class="row">
        <?php foreach ($events as $event) : ?>
            <div class="flex-column col-3">
                <img class="w-100 rounded" src="https://ae01.alicdn.com/kf/HTB1RHpBIXXXXXbLXFXXq6xXFXXXz/Free-shipping-HD-wallpaper-poster-Captain-America-Civil-War-movie-poster-Smith-24x36inch.jpg_Q90.jpg_.webp" alt="poster">
                <p><?= $event['title']; ?></p>
                <p><?= $event['directors']; ?></p>
                <div class="flex mt-auto">
                    <?php foreach ($event['tags'] as $tag) : ?>
                        <p class="bg-lighter p-s mr-s rounded"> <?= mb_strtoupper($tag); ?> </p>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</section>