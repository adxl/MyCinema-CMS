<div class="flex flex-center flex-middle bg-lighter h-100 p-m">
    <div class="card flex-column p-l rounded w-100 w-75@m w-50@l" style="max-width: 500px;">
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