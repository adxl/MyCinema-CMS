<div class="flex flex-middle mb-m mt-s">
    <i class="fas fa-cog"></i>
    <h1 class="ml-s"><?= $title; ?></h1>
</div>

<div class="mt-l flex">
    <div class="col-6">
        <h1 class="mb-s">Paramètres de la base de données</h1>
        <?php if (isset($db_errors)) : ?>
            <div>
                <ul class="p-0">
                    <?php foreach ($db_errors as $error) : ?>
                        <li class="text-alert-error">
                            <i class="fas fa-exclamation-circle"></i> <?= $error ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <?php if (isset($db_success)) : ?>
            <div>
                <ul class="p-0">
                    <li class="text-alert-success">
                        <?= $db_success[0] ?>
                    </li>
                </ul>
            </div>
        <?php endif; ?>
        <div>
            <?php App\Core\FormBuilder::render($formDatabase); ?>
        </div>
    </div>
    <div class="col-6">
        <h1 class="mb-s">Paramètres de mailing</h1>
        <?php if (isset($smtp_errors)) : ?>
            <div>
                <ul class="p-0">
                    <?php foreach ($smtp_errors as $error) : ?>
                        <li class="text-alert-error">
                            <i class="fas fa-exclamation-circle"></i> <?= $error ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <?php if (isset($smtp_success)) : ?>
            <div>
                <ul class="p-0">
                    <li class="text-alert-success">
                        <?= $smtp_success[0] ?>
                    </li>
                </ul>
            </div>
        <?php endif; ?>
        <div>
            <?php App\Core\FormBuilder::render($formMailing); ?>
        </div>
    </div>
</div>