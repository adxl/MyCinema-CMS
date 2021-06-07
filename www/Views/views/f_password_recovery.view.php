<div class="flex flex-center flex-middle bg-lighter h-100">
    <div id="login-form" class=" card flex-column p-l rounded h-100-s">
        <h1 class="text-center mt-m mb-l">Récupération de mot de passe</h1>

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

        <div class="flex flex-center">
            <?= $success ?? "" ?>
        </div>

        <?php isset($form) && App\Core\FormBuilder::render($form) ?>

        <div class="flex-column flex-center flex-middle">
            <a class="link mt-l" href="/bo/login">Retour à la page de connexion</a>
            <a class="link mt-s" href="/">Retour à l'accueil</a>
        </div>

    </div>


</div>