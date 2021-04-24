<div class="flex mb-m mt-s">
    <i class="fas fa-calendar-alt"></i>
    <h1 class="ml-s"><?= $title; ?></h1>
</div>


<section>
    <div class="row">
        <?php App\Core\FormBuilder::render($form); ?>
    </div>
</section>