<div class="flex flex-middle mb-m mt-s">
    <i class="fas fa-cog"></i>
    <h1 class="ml-s"><?= $title; ?></h1>
</div>

<div class="mt-l flex-col">
    <div class="mb-l">
        <h1 class="mb-s">Sitemap</h1>
        <div class="flex">
            <a href="/sitemap" target="_blank" class="button button--success">
                <span class="mr-m">Générer sitemap.xml</span>
                <i class="fas fa-external-link-alt"></i>
            </a>
        </div>
    </div>
    <div>
        <h1 class="mb-s">Base de données</h1>
        <div class="flex flex-middle">
            <a href="/bo/tools/dbcheck" class="button button--success">
                <span class="mr-m">Tester la connexion</span>
                <i class="fas fa-external-link-alt"></i>
            </a>
            <div class="pl-m">
                <?php if (isset($errors)) : ?>
                    <ul class="p-0">
                        <li class="text-alert-error">
                            <i class="fas fa-exclamation-circle"></i> <?= $errors[0] ?>
                        </li>
                    </ul>
                <?php endif; ?>
                <?php if (isset($success)) : ?>
                    <ul class="p-0">
                        <li class="text-alert-success">
                            <i class="fas fa-check-circle"></i> <?= $success[0] ?>
                        </li>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>