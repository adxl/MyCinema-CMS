<div class="w-100 bg-white flex-column p-l">
    <h1 class="text-center mt-m mb-l">Login</h1>

    <?php if (isset($errors)) : ?>
        <div>
            <ul class="p-0">
                <?php foreach ($errors as $error) : ?>
                    <i class="fas fa-exclamation-circle"></i> <?= $error ?>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php App\Core\FormBuilder::render($form); ?>
    <hr class="w-50">
    <div class="flex flex-center">
        <p>Don't have an account ? <a href="/register" class="link">Sign up</a></p>
    </div>
</div>