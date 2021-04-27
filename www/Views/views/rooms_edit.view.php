<div class="flex mb-m mt-s">
    <i class="fas fa-building"></i>
    <h1 class="ml-s"><?= $title; ?></h1>
</div>


<section>
    <div class="row">
        <?php App\Core\FormBuilder::render($form); ?>
    </div>
</section>