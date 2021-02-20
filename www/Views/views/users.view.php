<div class="flex my-s mt-0">
    <img src="/Views/dist/icons/black-calendar.svg" alt="icon">
    <h1 class="mx-s"><?= $title; ?></h1>
</div>

<div class=" w-100 flex flex-right">
    <div class="searchbar">
        <img src="/Views/dist/icons/gray-zoom.svg" alt="">
        <input type="text" name="rechercheUsers" placeholder="Recherche utilisateurs">
    </div>
    <button class="button">Rechercher</button>
</div>

<div class="card w-100 my-s">
    <h1>Tableau des utilisateurs</h1>
    <table id="tabUsers">
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Permissions</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Diaby</td>
                <td>Nfassory</td>
                <td>nfassory.diaby@esgi.fr</td>
                <td>Administrateur</td>
                <td>
                    <a href="#"><img src="/Views/dist/icons/blue-eye.svg"></a>
                </td>
            </tr>

            <tr>
                <td>2</td>
                <td>Dechelette</td>
                <td>François</td>
                <td>francois.dechelette@esgi.fr</td>
                <td>Administrateur</td>
                <td>
                    <a href="#"><img src="/Views/dist/icons/blue-eye.svg"></a>
                </td>
            </tr>

            <tr>
                <td>3</td>
                <td>Grupposo</td>
                <td>Anthony</td>
                <td>anthony.grupposo@esgi.fr</td>
                <td>Administrateur</td>
                <td>
                    <a href="#"><img src="/Views/dist/icons/blue-eye.svg"></a>
                </td>
            </tr>

            <tr>
                <td>4</td>
                <td>Senhadji</td>
                <td>Mohammed Adel</td>
                <td>m_adel.senhadji@esgi.fr</td>
                <td>Administrateur</td>
                <td>
                    <a href="#"><img src="/Views/dist/icons/blue-eye.svg"></a>
                </td>
            </tr>

            <tr>
                <td>5</td>
                <td>Marchand</td>
                <td>Maxime</td>
                <td>maxime.marchand@esgi.fr</td>
                <td>Administrateur</td>
                <td>
                    <a href="#"><img src="/Views/dist/icons/blue-eye.svg"></a>
                </td>
            </tr>

            <tr>
                <td>6</td>
                <td>Sombie</td>
                <td>Edouard</td>
                <td>edouard.sombie@esgi.fr</td>
                <td>Gestionnaire</td>
                <td>
                    <a href="#"><img src="/Views/dist/icons/blue-eye.svg"></a>
                </td>
            </tr>

            <tr>
                <td>7</td>
                <td>Serval</td>
                <td>Jérémy</td>
                <td>jeremy.serval@esgi.fr</td>
                <td>Gestionnaire</td>
                <td>
                    <a href="#"><img src="/Views/dist/icons/blue-eye.svg"></a>
                </td>
            </tr>

            <tr>
                <td>8</td>
                <td>Skrzypczyk</td>
                <td>Yves</td>
                <td>yves.skrzypczyk@esgi.fr</td>
                <td>Client</td>
                <td>
                    <a href="#"><img src="/Views/dist/icons/blue-eye.svg"></a>
                </td>
            </tr>

            <tr>
                <td>9</td>
                <td>Coat</td>
                <td>Gael</td>
                <td>gael.coat@esgi.fr</td>
                <td>Client</td>
                <td>
                    <a href="#"><img src="/Views/dist/icons/blue-eye.svg"></a>
                </td>
            </tr>
        </tbody>
    </table>
</div>