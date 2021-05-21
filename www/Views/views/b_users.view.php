<div class="flex my-s mt-0">
    <i class="fas fa-users"></i>
    <h1 class="mx-s"><?= $title; ?></h1>
</div>



<div class="flex flex-right mb-m">
    <a href="/bo/register">
        <button class="button button--success">+ Register admin</button>
    </a>
</div>

<div class=" w-100 flex flex-right mb-m">
    <div class="searchbar">
        <i class="fas fa-search faded"></i>
        <input type="text" name="user-search" placeholder="Search an user">
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
                    <td><?= $user['role']; ?></td>
                    <td>
                        <p> <?= $user['isActive'] ? 'OUI' : 'NON' ?> </p>
                    </td>
                    <td>
                        <div class="flex flex-middle">

                            <a class="mr-m" href="/bo/users/status?id=<?= $user['id']; ?>&status=<?= (int)!$user['isActive']; ?>" type="submit">
                                <i class="fas fa-<?= (int)$user['isActive'] ? 'lock' : 'unlock' ?>"></i>
                            </a>

                            <a href="#">
                                <i class="fas fa-trash-alt"></i>
                            </a>

                        </div>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>