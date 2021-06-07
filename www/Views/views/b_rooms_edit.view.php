<div class="flex flex-middle mb-m mt-s">
    <i class="fas fa-building"></i>
    <h1 class="ml-s"><?= $title; ?></h1>
</div>


<section class="card w-100">
    <div class="container">
        <?php App\Core\FormBuilder::render($form); ?>
    </div>
    <div class="flex flex-right">
        <form action="/bo/rooms/delete" method="post">
            <button class="button button--danger m-0 p-s" type="submit"><i class="mr-s fas fa-exclamation-triangle"></i> SUPPRIMER </button>
        </form>
    </div>
</section>