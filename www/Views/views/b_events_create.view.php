<div class="flex flex-middle mb-m mt-s">
    <i class="fas fa-calendar-alt"></i>
    <h1 class="ml-s"><?= $title; ?>
    </h1>
</div>

<section class="card w-100">
    <div class="container">
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