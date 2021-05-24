<div class="flex flex-middle  mb-m mt-s">
    <i class="fas fa-users"></i>
    <h1 class="ml-s"><?= $title; ?></h1>
</div>

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

<?php if (isset($success)) : ?>
    <div>
        <ul class="p-0">
            <li class="text-alert-success">
                <?= $success[0] ?>
            </li>
        </ul>
    </div>
<?php endif; ?>


<div class="card m-m">
    <?php App\Core\FormBuilder::render($formNames); ?>
</div>

<div class="card m-m">
    <?php App\Core\FormBuilder::render($formEmail); ?>
</div>

<div class="card m-m">
    <?php App\Core\FormBuilder::render($formPassword); ?>
</div>