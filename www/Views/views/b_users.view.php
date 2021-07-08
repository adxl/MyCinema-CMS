<div class="flex flex-middle mb-m mt-s">
    <i class="fas fa-users"></i>
    <h1 class="ml-s"><?= $title; ?></h1>
</div>

<div class="flex flex-right mb-m">
    <a href="/bo/register">
        <button class="button button--success">Ajouter un collaborateur</button>
    </a>
</div>



<div class="scroll-x">
    <table class="table card">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actif</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as  $user) : ?>
                <tr class="<?= ($user['id'] === $self['id']) ? 'faded' : '' ?>">
                    <td><?= $user['firstname']; ?></td>
                    <td><?= $user['lastname']; ?></td>
                    <td><?= $user['email']; ?></td>
                    <td>
                        <div class="flex">
                            <a class="mr-m" <?= ($user['isActive'] && $user['id'] !== $self['id']) ? "href='/bo/users/role?id=" . $user['id'] . "'" : "" ?>>
                                <i class="fas fa-exchange-alt text-blue"></i>
                            </a>

                            <p><?= $user['role']; ?></p>
                        </div>
                    </td>
                    <td>
                        <div class="flex flex-middle">
                            <a class="mr-m" style="font-size: 1.5em" <?= ($user['id'] !== $self['id']) ? "href='/bo/users/status?id=" . $user['id'] . "&status=" . (int)!$user['isActive'] . "'" : "" ?>>
                                <i class="fas fa-toggle-<?= (int)$user['isActive'] ? 'on text-green' : 'off faded' ?>"></i>
                            </a>
                        </div>
                    </td>
                    <td>
                        <a <?= ($user['id'] !== $self['id']) ? "href='/bo/users/delete?id=" . $user['id'] . "'" : "" ?>>
                            <i class="fas fa-trash-alt text-red"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>