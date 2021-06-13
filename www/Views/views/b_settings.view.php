<div class="flex flex-middle mb-m mt-s">
    <i class="fas fa-cog"></i>
    <h1 class="ml-s"><?= $title; ?></h1>
</div>

<div class="mt-l">

    <div class='flex card'>
        <div class="col-2 mt-m">
            <ul class="p-0">
                <li class="mb-m"><a href="/bo/settings?tab=general">Général</a></li>
                <li class="mb-m"><a href="/bo/settings?tab=database">Base de données</a></li>
                <li><a href="/bo/settings?tab=mailing">Mailing</a></li>
            </ul>
        </div>
        <div class="col-10 mt-l">
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
            <?php if (isset($success)) : ?>
                <div>
                    <ul class="p-0">
                        <li class="text-alert-success">
                            <?= $success[0] ?>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>
            <div>
                <?php App\Core\FormBuilder::render($form); ?>
            </div>
        </div>
    </div>
</div>