<div class="flex-column p-l rounded w-100 w-75@m w-50@l">
    <h1 class="text-center mt-m mb-l">Contact</h1>

    <div class="w-100">
        <?php if (isset($errors)) : ?>
            <div class="flex-middle flex-column w-100">
                <ul class="p-0 w-100">
                    <?php foreach ($errors as $error) : ?>
                        <li class="text-alert-error">
                            <i class="fas fa-exclamation-circle"></i> <?= $error ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (isset($success)) : ?>
            <div class="flex-middle flex-column w-100 mb-m">
                <p class="text-alert-success">
                    <?= $success ?>
                </p>
            </div>
        <?php endif; ?>
    </div>

    <?php App\Core\FormBuilder::render($form) ?>

</div>