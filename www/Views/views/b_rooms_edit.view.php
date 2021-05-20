<div class="flex mb-m mt-s">
    <i class="fas fa-building"></i>
    <h1 class="ml-s"><?= $title; ?></h1>
</div>


<section>
    <div class="row">
        <?php App\Core\FormBuilder::render($form); ?>
    </div>
    <div class="flex">
        <form action="/bo/rooms/delete" method="post">
            <button type="submit"> DELETE </button>
        </form>
    </div>
</section>