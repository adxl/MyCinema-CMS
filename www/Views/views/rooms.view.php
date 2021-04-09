<div class="flex my-s mt-0">
    <img src="/Views/dist/icons/black-building.svg" alt="icon">
    <h1 class="mx-s"><?= $title; ?></h1>
</div>


<section>
    <div class="row">
        <?php foreach ($rooms as $room) : ?>

            <div class="card row col-4 my-s p-s">
                <div class="col-4 m-0">
                    <img class="w-100 h-100 cover rounded" src="https://images.rtl.fr/rtl/www/1196574-une-salle-de-cinema-illustration.jpg" alt="image" />
                </div>
                <div class="flex-column col-8">
                    <h1 class="my-s mt-0"> <?= $room['label']; ?> </h1>
                    <div class="mb-auto">
                        <p> Scheduled sessions : <?= null; ?> </p>
                        <p class="my-s mt-0"> Next session : <?= null; ?> </p>
                    </div>
                    <p> Planned rooms : <?= null; ?> </p>
                </div>
            </div>

        <?php endforeach; ?>



    </div>
</section>