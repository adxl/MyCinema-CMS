<!-- PROCHAIN EVENT -->
<?php

use App\Core\Helpers;

if ($nextEvent) : ?>
    <section class="w-100 bg-image" style="background-image: url(<?= $nextEvent['media'] ?>)">
        <div class="flex-column flex-row@m">
            <div class="flex flex-center col-5">
                <div class="p-l w-100 w-50@m">
                    <a href="/events?id=<?= $nextEvent['id']; ?>">
                        <img class="w-100 cover rounded" style="min-width: 200px;" src="<?= $nextEvent['media']; ?>" alt="poster">
                    </a>
                </div>
            </div>
            <div class="col-7 p-l">
                <a href="/events?id=<?= $nextEvent['id']; ?>">
                    <h1 class="text-large text-white mb-m"><?= $nextEvent['title']; ?></h1>
                </a>
                <div class="flex-column">
                    <p class="mb-s text-medium text-underline">Synopsis : </p>
                    <p class="pr-l"><?= $nextEvent['synopsis']; ?></p>
                </div>
                <hr class="w-50 mb-l mt-l ml-0">
                <div class="flex-column flex-top flex-row@m">
                    <p><?= $nextEvent['actors']; ?></p>
                    <span class="ml-s mr-s visible@m">|</span>
                    <br class="hidden@m">
                    <p class='text-capitalize'> <?= strtolower(implode(', ', $nextEvent['tags'])) ?> </p>
                </div>
            </div>
        </div>
    </section>
<?php endif ?>


<section class="flex-column flex-middle w-75">
    <h1 class="mt-xl mb-l">PROCHAINEMENT : </h1>
    <div class="w-100 row">
        <?php foreach ($incomingEvents as $event) : ?>
            <div class="flex-column mb-l col-12 col-6@m col-4@l col-3@xl">
                <a href="/events?id=<?= $event['id']; ?>">
                    <img class="w-100 poster rounded" src="<?= $event['media']; ?>" alt="poster">
                    <p class="mt-s"><?= Helpers::toDate($event['nextSession']); ?></p>
                    <p class="mt-m"><?= $event['title']; ?></p>
                    <div class="flex mt-s">
                        <?php foreach ($event['tags'] as $tag) : ?>
                            <p class="text-small bg-lighter p-s mr-s rounded"> <?= mb_strtoupper($tag); ?> </p>
                        <?php endforeach; ?>
                    </div>
                </a>
            </div>
        <?php endforeach ?>
    </div>
</section>