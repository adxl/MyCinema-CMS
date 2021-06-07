<div class="flex flex-center flex-middle bg-lighter h-100">
    <div id="login-form" class=" card flex-column p-l rounded h-100-s">
        <h1 class="text-center mt-m mb-l">Connexion au BackOffice</h1>

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

        <div class="flex flex-center">
            <a class="link mt-l" href="/">Retour à l'accueil</a>
        </div>

    </div>


</div>