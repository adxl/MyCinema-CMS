<div class="flex my-s mt-0">
    <img src="/Views/dist/icons/black-calendar.svg" alt="icon">
    <h1 class="ml-s"><?= $title; ?></h1>
</div>
<div class="flex flex-right">
    <button class="button button--success">+ Create Event</button>
</div>
<section>
    <div class="row">
        <?php for ($i = 0; $i < 12; $i++) : ?>

            <div class="card row col-4 mb-m p-s">
                <div class="col-4 m-0">
                    <img class="w-100 h-100 cover rounded" src="https://fr.web.img6.acsta.net/pictures/19/09/03/12/02/4765874.jpg" alt=" " />
                </div>
                <div class="flex-column col-8">
                    <h1 class="mb-s"> Joker </h1>
                    <p> Schedulled sessions : 02 </p>
                    <p class="mb-s"> Next session : 005/02/2021 </p>
                    <p class="mb-auto"> Planned rooms : A2,B1 </p>
                    <div class="flex">
                        <p class="bg-lighter p-s mr-s rounded"> Tags </p>
                        <p class="bg-lighter p-s mr-s rounded"> Tags </p>
                        <p class="bg-lighter p-s rounded"> Tags </p>
                    </div>
                </div>
            </div>

        <?php endfor; ?>
    </div>
</section>