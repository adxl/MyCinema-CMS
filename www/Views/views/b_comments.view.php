<div class="flex flex-middle mb-m mt-s">
  <i class="fas fa-comments"></i>
  <h1 class="ml-s"><?= $title; ?></h1>
</div>

<div class=" w-100 flex flex-between flex-middle mt-xl mb-m">
  <div>
    <div id="filter-link-bar" class="flex">
      <a href="/bo/comments?status=ALL" class="<?= $status === 'ALL' ? "active" : "" ?>">Tous</a>
      <span>|</span>
      <a href="/bo/comments?status=WAITING" class="<?= $status === 'WAITING' ? "active" : "" ?>">En attente</a>
      <span>|</span>
      <a href="/bo/comments?status=APPROVED" class="<?= $status === 'APPROVED' ? "active" : "" ?>">Approuvés</a>
      <span>|</span>
      <a href="/bo/comments?status=DECLINED" class="<?= $status === 'DECLINED' ? "active" : "" ?>">Refusés</a>
    </div>
  </div>
</div>

<div class="scroll-x">
  <table class="table card">
    <thead>
      <tr>
        <th>Auteur</th>
        <th>Commentaire</th>
        <th>Évènement</th>
        <th>Date</th>
        <th>Actions</th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($comments as $comment) : ?>
        <tr>
          <td><?= $comment['name']; ?></td>
          <td><?= $comment['content'] ?></td>
          <td>
            <a href="/events?id=<?= $comment['eventId']; ?>" target="_blank">
              <span><?= $comment['event']; ?></span>
              <i class="fas fa-external-link-alt faded"></i>
            </a>
          </td>
          <td><?= $comment['date']; ?></td>
          <td>
            <div class="flex">
              <?php if ($comment['status'] !== 'APPROVED') : ?>
                <a class="col-6 flex flex-middle" href="/bo/comments/approve?id=<?= $comment['id'] ?>&status=<?= $status ?>">
                  <i style="font-size: 1.25em" class="fas fa-check-square mr-s text-green"></i>
                  <p class="visible@l">Approuver</p>
                </a>
              <?php endif; ?>
              <?php if ($comment['status'] !== 'DECLINED') : ?>
                <a class="col-6 flex flex-middle" href="/bo/comments/decline?id=<?= $comment['id'] ?>&status=<?= $status ?>">
                  <i style="font-size: 1.25em" class="fas fa-ban mr-s text-red"></i>
                  <p class="visible@l">Refuser</p>
                </a>
              <?php endif; ?>
              <?php if ($comment['status'] !== 'WAITING') : ?>
                <a class="col-6 flex flex-middle" href="/bo/comments/suspend?id=<?= $comment['id'] ?>&status=<?= $status ?>">
                  <i style="font-size: 1.25em" class="fas fa-clock mr-s text-yellow"></i>
                  <p class="visible@l">Suspendre</p>
                </a>
              <?php endif; ?>
            </div>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>