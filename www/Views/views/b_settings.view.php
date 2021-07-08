<div class="flex flex-middle mb-m mt-s">
    <i class="fas fa-cog"></i>
    <h1 class="ml-s"><?= $title; ?></h1>
</div>

<div class="mt-l">
    <div class='flex-column flex-row@m card p-s'>
        <div class="col-2 mt-m">
            <ul class="flex flex-column@m p-0 mb-0">
                <li class="p-m mb-m <?= $tab == 'general' ? 'menu-selected' : '' ?>">
                    <a class="flex flex-center flex-left@m" href="/bo/settings?tab=general">
                        <i class='fas fa-cogs'></i>
                        <span class="ml-m visible@m">Site</span>
                    </a>
                </li>
                <li class="p-m mb-m <?= $tab == 'database' ? 'menu-selected' : '' ?>">
                    <a class="flex flex-center flex-left@m" href="/bo/settings?tab=database">
                        <i class='fas fa-database'></i>
                        <span class="ml-m visible@m">Base de données</span>
                    </a>
                </li>
                <li class="p-m mb-m <?= $tab == 'mailing' ? 'menu-selected' : '' ?>">
                    <a class="flex flex-center flex-left@m" href="/bo/settings?tab=mailing">
                        <i class='fas fa-at'></i>
                        <span class="ml-m visible@m">Mailing</span>
                    </a>
                </li>
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