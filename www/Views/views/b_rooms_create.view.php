<div class="flex flex-middle mb-m mt-s">
    <i class="fas fa-building"></i>
    <h1 class="ml-s"><?= $title; ?></h1>
</div>


<section class="card w-100">
    <div class="container">
        <?php App\Core\FormBuilder::render($form); ?>
    </div>
</section>