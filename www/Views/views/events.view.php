<div class="flex my-s mt-0">
    <img src="/Views/dist/icons/black-calendar.svg" alt="icon">
    <h1 class="mx-s"><?= $title; ?></h1>
</div>
<div class="flex flex-right">
    <button class="button button--success">+ Create Event</button>
</div>
<section>
    <div class="row">
        <?php for ($i = 0; $i < 12; $i++) : ?>

            <div class="card row col-6 my-s p-s">
                <div class="col-4 m-0">
                    <img class="w-100 h-100 cover rounded" src="../Views/dist/images/joker.jpg" alt="image" />
                </div>
                <div class="col-1">
                </div>
                <div class="flex-column col-7">
                    <h1 class="my-s mt-0"> Joker </h1>
                    <p> Schedulled sessions : 02 </p>
                    <p class="my-s mt-0"> Next session : 005/02/2021 </p>
                    <p style="margin-bottom: auto"> Planned rooms : A2,B1 </p>
                    <div class="flex">
                        <p class="bg-lighter p-s mx-s ml-0 rounded"> Tags </p>
                        <p class="bg-lighter p-s mx-s rounded"> Tags </p>
                        <p class="bg-lighter p-s mx-s rounded"> Tags </p>
                    </div>
                </div>
            </div>

        <?php endfor; ?>
    </div>
</section>