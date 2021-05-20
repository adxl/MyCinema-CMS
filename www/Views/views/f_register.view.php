<div class="w-100 bg-white flex-column p-l">
    <h1 class="text-center mt-m mb-l">Register</h1>

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
    <hr class="w-50">
    <div class="flex flex-center">
        <p>Already a member ? <a href=/bo/login" class="link">Sign in</a></p>
    </div>
</div>