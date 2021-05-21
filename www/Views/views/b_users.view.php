<div class="flex my-s mt-0">
    <i class="fas fa-users"></i>
    <h1 class="mx-s"><?= $title; ?></h1>
</div>



<div class="flex flex-right mb-m">
    <a href="/bo/register">
        <button class="button button--success">Ajouter un collaborateur</button>
    </a>
</div>

<div class=" w-100 flex flex-right mb-m">
    <div class="searchbar">
        <i class="fas fa-search faded"></i>
        <input type="text" name="user-search">
    </div>
    <button class="button">Rechercher</button>
</div>

<div>
    <table class="table card">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actif ?</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as  $user) : ?>
                <tr class="<?= !$user['isActive'] ? 'faded' : '' ?>">
                    <td><?= $user['firstname']; ?></td>
                    <td><?= $user['lastname']; ?></td>
                    <td><?= $user['email']; ?></td>
                    <td>
                        <div class="flex">
                            <a class="mr-m" <?= ($user['isActive'] && $user['id'] !== $self['id']) ? "href='/bo/users/role?id=" . $user['id'] . "'" : "" ?>>
                                <i class="fas fa-exchange-alt"></i>
                            </a>

                            <p><?= $user['role']; ?></p>
                        </div>
                    </td>
                    <td>
                        <div class="flex flex-middle">
                            <a class="mr-m" href="/bo/users/status?id=<?= $user['id'] ?>&status=<?= (int)!$user['isActive']; ?>">
                                <i class="fas fa-toggle-<?= (int)$user['isActive'] ? 'on' : 'off' ?>"></i>
                            </a>
                            <p><?= $user['isActive'] ? 'OUI' : 'NON'; ?></p>
                        </div>
                    </td>
                    <td>
                        <a href="/bo/users/delete?id=<?= $user['id'] ?>">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>