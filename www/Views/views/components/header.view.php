<header class="flex flex-between flex-middle bg-soft-white">
    <div class="p-m">
        <a href="/">
            <p>&lt;LOGO&gt;</p>
        </a>
    </div>

    <?php if (!empty($user)) : ?>
        <div id="user-profile-button" class="flex flex-middle mr-m bg-gray rounded crop">
            <div class="flex flex-middle flex-self-stretch bg-white pr-m pl-m">
                <p><?= $user['firstname'] . " " . mb_strtoupper($user['lastname'][0]) . '.'; ?></p>
            </div>
            <div class="flex flex-middle p-s">
                <i class="fas fa-user"></i>
            </div>
        </div>
        <div id="user-profile-menu" class="card p-0 flex-column crop hidden">
            <a href="/bo/account">Compte</a>
            <a href="/bo">BackOffice</a>
            <a href="/bo/logout">Se déconnecter</a>
        </div>
    <?php endif ?>

</header>