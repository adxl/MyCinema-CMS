<div class="flex mb-m mt-s">
    <i class="fas fa-users"></i>
    <h1 class="mx-s"><?= $title; ?></h1>
</div>

<div class="card m-m">
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

</div>