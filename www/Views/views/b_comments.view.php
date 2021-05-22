<div class="flex flex-middle mb-m mt-s">
    <i class="fas fa-comments"></i>
    <h1 class="ml-s"><?= $title; ?></h1>
</div>

<div class=" w-100 flex flex-between flex-middle my-m">
    <div>
        <div id="filter-link-bar" class="flex">
            <a href="#">All</a>
            <span>|</span>
            <a href="#">Validated</a>
            <span>|</span>
            <a href="#">Reported</a>
            <span>|</span>
            <a href="#">Deleted</a>
        </div>
    </div>
    <div class="flex">
        <div class="searchbar">
            <i class="fas fa-search faded"></i>
            <input type="text" name="comment-search" placeholder="Search a comment or user">
        </div>
        <button class="button">Rechercher</button>
    </div>
</div>

<div>
    <table class="table card">
        <thead>
            <tr>
                <th>Author</th>
                <th>Comment</th>
                <th>Event</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <div>

                <?php for ($i = 0; $i < 3; $i++) : ?>
                    <tr>
                        <td class="author-card flex-middle flex-column">
                            <div class="flex">
                                <i class="fas fa-user-circle"></i>
                                <span width="40" class="card status-active" alt=" ">active</span>
                            </div>
                            <p class="m-0 text-bold text-underline">Sasha Soushi</p>
                            <div class="flex">
                                <i class="fas fa-xs text-light-gray fa-user-plus"></i>
                                <span class="mx-s">18-05-2020</span>
                            </div>
                        </td>
                        <td>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</td>
                        <td>Blade runner 2049</td>
                        <td>18-10-2015</td>
                        <td>
                            <i class="fas fa-exclamation-triangle"></i>
                            <i class="fas fa-trash"></i>
                        </td>
                    </tr>
                    <tr>
                        <td class="author-card flex-middle flex-column">
                            <div class="flex">
                                <i class="fas fa-user-circle"></i>
                                <span width="40" class="card status-inactive" alt=" ">Inactive</span>
                            </div>
                            <p class="m-0 text-bold text-underline">Sasha Soushi</p>
                            <div class="flex">
                                <i class="fas fa-xs text-light-gray fa-user-plus"></i>
                                <span class="mx-s">18-05-2020</span>
                            </div>
                        </td>
                        <td>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</td>
                        <td>Blade runner 2049</td>
                        <td>18-10-2015</td>
                        <td>
                            <i class="fas fa-exclamation-triangle"></i>
                            <i class="fas fa-trash"></i>
                        </td>
                    </tr>
                <?php endfor ?>
        </tbody>
    </table>
</div>