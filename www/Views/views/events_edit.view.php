<div class="flex mb-m mt-s">
    <img src="/Views/dist/icons/black-calendar.svg" alt="icon">
    <h1 class="ml-s"><?= $title; ?></h1>
</div>


<section>
    <div class="row">
        <?php App\Core\FormBuilder::render($form); ?>
    </div>
</section>