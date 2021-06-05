<section>
    <div class="row">
        <h1><?= $event['title']; ?></h1>
    </div>


    <!-- input ajout commentaire -->
    <div class="row">
        <?php App\Core\FormBuilder::render($commentForm); ?>
    </div>



    <!-- Liste des commentaires -->
    <div>
        <pre> <?php print_r($comments) ?> </pre>
    </div>
</section>