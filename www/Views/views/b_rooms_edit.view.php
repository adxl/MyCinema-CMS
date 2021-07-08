<div class="flex flex-middle mb-m mt-s">
    <i class="fas fa-building"></i>
    <h1 class="ml-s"><?= $title; ?></h1>
</div>

<section class="flex flex-center">
    <div class="card w-100 w-75@l">
        <?php if (isset($errors)) : ?>
            <div>
                <ul class="p-0">
                    <?php foreach ($errors as $error) : ?>
                        <li class="text-alert-error">
                            <i class="fas fa-exclamation-circle"></i> <?= $error ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <?php App\Core\FormBuilder::render($form); ?>
        <div class="flex flex-center pt-l">
            <form action="<?= "/bo/rooms/delete?id=$room_id" ?>" method="post">
                <button class="button button--danger m-0 p-s" type="submit">
                    <i class="mr-s fas fa-exclamation-triangle"></i>
                    SUPPRIMER LA SALLE
                </button>
            </form>
        </div>
    </div>
</section>