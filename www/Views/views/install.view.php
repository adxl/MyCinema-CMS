<div class="flex flex-center flex-middle bg-lighter h-100 p-l">
    <div class="card flex-column p-l rounded h-100 scroll-y">
        <h1 class="text-center mt-m mb-l">Installation de MyCinema CMS</h1>

        <?php if (isset($errors)) : ?>
            <p class="text-red">
                <i class="fas fa-exclamation-circle"></i>
                Erreurs : <?= count($errors); ?>
            </p>
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


</div>