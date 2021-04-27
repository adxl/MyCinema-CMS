<div class="flex my-s mt-0">
    <i class="fas fa-users"></i>
    <h1 class="mx-s"><?= $title; ?></h1>
</div>

<div class=" w-100 flex flex-right my-m">
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
                <th>Permissions</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php for ($i = 0; $i < 3; $i++) : ?>
                <tr>
                    <td>Jon</td>
                    <td>Snow</td>
                    <td>jonsnow@esgi.fr</td>
                    <td>Administrateur</td>
                    <td>
                        <a href="#">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
            <?php endfor ?>
        </tbody>
    </table>
</div>