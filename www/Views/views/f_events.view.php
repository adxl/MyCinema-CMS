<!-- PROCHAIN EVENT -->
<?php if ($nextEvent) : ?>
    <section class="bg-dark text-white w-100 flex-column flex-middle">
        <h1 class="text-center text-white mt-l mb-m">À L'AFFICHE</h1>
        <div class="p-l w-100">
            <img id="events-main-cover" class="w-100 cover rounded" src="https://images-na.ssl-images-amazon.com/images/I/91SDjtFQRWL._AC_SL1500_.jpg" alt="poster">
        </div>
        <div class="flex w-50">
            <div class="flex flex-center rounded col-6">
                <div class="p-l">
                    <img class="h-100 w-100 cover rounded" src="https://images-na.ssl-images-amazon.com/images/I/91SDjtFQRWL._AC_SL1500_.jpg" alt="poster">
                </div>
            </div>
            <div class="flex-column p-l col-6">
                <h1 class="text-white mb-m"><?= $nextEvent['title']; ?></h1>
                <p class="mb-s text-underline">Synopsis : </p>
                <p class="mb-l"><?= $nextEvent['synopsis']; ?></p>
                <div class="flex">
                    <p class="mb-s text-underline">Par </p>
                    <p> : <?= $nextEvent['directors']; ?></p>
                </div>
                <div class="flex">
                    <p class="text-underline">Avec </p>
                    <p> : <?= $nextEvent['actors']; ?></p>
                </div>
                <div class="flex mt-auto mb-m">
                    <?php foreach ($nextEvent['tags'] as $tag) : ?>
                        <p class="bg-dark-gray p-s mr-s rounded"> <?= mb_strtoupper($tag); ?> </p>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif ?>



<section id="all-events-section" class="flex-column flex-middle w-100">
    <h1 class="mt-xl mb-l">PROCHAINEMENT : </h1>
    <div class="flex w-75">
        <div class="flex flex-center">
            <?php foreach ($incomingEvents as $event) : ?>
                <div class="flex-column col-2">
                    <a href="/events?id=<?= $event['id']; ?>">
                        <img class="w-100 rounded" src="https://ae01.alicdn.com/kf/HTB1RHpBIXXXXXbLXFXXq6xXFXXXz/Free-shipping-HD-wallpaper-poster-Captain-America-Civil-War-movie-poster-Smith-24x36inch.jpg_Q90.jpg_.webp" alt="poster">
                        <p><?= $event['title']; ?></p>
                        <p><?= $event['directors']; ?></p>
                        <div class="flex mt-auto">
                            <?php foreach ($event['tags'] as $tag) : ?>
                                <p class="text-small bg-lighter p-s mr-s rounded"> <?= mb_strtoupper($tag); ?> </p>
                            <?php endforeach; ?>
                        </div>
                    </a>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</section>