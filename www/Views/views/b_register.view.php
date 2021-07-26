<div class="flex flex-middle mb-l mt-s">
    <i class="fas fa-users"></i>
    <h1 class="ml-s"><?= $title; ?>
    </h1>
</div>

<section class="flex flex-center">
    <div class="w-100 w-75@m w-50@l bg-white flex-column p-l">
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
</section>