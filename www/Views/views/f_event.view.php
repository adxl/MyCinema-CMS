<section id="next-event-section">
    <h1 class="text-center"><?= $event['title']; ?></h1>

    <div class="row">
        <div class="flex flex-center rounded col-6 h-100">
            <div class="h-100 p-l">
                <img class="w-100 rounded" src="https://ae01.alicdn.com/kf/HTB1RHpBIXXXXXbLXFXXq6xXFXXXz/Free-shipping-HD-wallpaper-poster-Captain-America-Civil-War-movie-poster-Smith-24x36inch.jpg_Q90.jpg_.webp" alt="poster">
            </div>
        </div>
        <div class="flex-column p-m col-6">
            <p>Synopsis : </p>
            <p class="mb-l"><?= $event['synopsis']; ?></p>

            <p class="mb-s">Par : <?= $event['directors']; ?></p>
            <p>Avec : <?= $event['actors']; ?></p>
            <div class="flex mt-auto mb-m">
                <?php foreach ($event['tags'] as $tag) : ?>
                    <p class="bg-lighter p-s mr-s rounded"> <?= mb_strtoupper($tag); ?> </p>
                <?php endforeach; ?>
            </div>
        </div>
    </div>




</section>

<section class="mt-l">
    <!-- input ajout commentaire -->
    <div class="row card w-100">
        <h1 class="text-center">Ajouter un commentaire : </h1>
        <div class="flex flex-center w-100">
            <?php App\Core\FormBuilder::render($commentForm); ?>
        </div>
    </div>
</section>

<?php if ($comments) : ?>
    <section class="mt-l mb-l">
        <!-- Liste des commentaires -->
        <div>
            <table class="event-details-comments-table card">
                <thead>
                    <tr>
                        <th>Auteur</th>
                        <th>Commentaire</th>
                        <th>Date</th>
                    </tr>

                </thead>
                <tbody>
                    <?php foreach ($comments as $comment) : ?>
                        <tr>
                            <td><?= $comment['name']; ?></td>
                            <td><?= $comment['content']; ?></td>
                            <td><?= $comment['date']; ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </section>
<?php endif; ?>