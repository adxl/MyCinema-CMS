<div class="flex flex-middle mb-m mt-s">
  <i class="fas fa-comments"></i>
  <h1 class="ml-s"><?= $title; ?></h1>
  <br />
  <h1 class="ml-s">STATUS = <?= $status; ?></h1>
</div>

<div class=" w-100 flex flex-between flex-middle my-m">
  <div>
    <div id="filter-link-bar" class="flex">
      <a href="/bo/comments?status=ALL">Tous</a>
      <span>|</span>
      <a href="/bo/comments?status=WAITING">En attente</a>
      <span>|</span>
      <a href="/bo/comments?status=APPROVED">Approuvés</a>
      <span>|</span>
      <a href="/bo/comments?status=DECLINED">Refusés</a>
    </div>
  </div>
</div>

<div>
  <table class="table card">
    <thead>
      <tr>
        <th>Author</th>
        <th>Comment</th>
        <th>Event</th>
        <th>Date</th>
        <th>État</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($comments as $comment) : ?>
        <div>
          <tr class="<?= ($comment['id'] === $self['id']) ? 'faded' : '' ?>">
            <td class="author-card flex-middle flex-column">
              <div class="flex">
                <span span width="40" class="card status-active" alt=" ">active</span>
              </div>
              <p><?= $comment['name']; ?></p>
            </td>
            <td><?= $comment['content']; ?></td>
            <td><?= $comment['event']; ?></td>
            <td><?= $comment['date']; ?></td>
            <td>
              <?php switch ($comment['status']) {
                case 'APPROVED':
                  $tag = 'Approuvé';
                  break;
                case 'DECLINED':
                  $tag = 'Refusé';
                  break;
                case 'WAITING':
                  $tag = 'En attente';
                  break;
              } ?>
              <?= $tag; ?>
            </td>
            <td>
              <div class="flex">
                <?php if ($comment['status'] !== 'WAITING') : ?>
                  <a class="flex flex-middle mr-m" href="/bo/comments/suspend?id=<?= $comment['id'] ?>&status=<?= $status ?>">
                    <i style="font-size: 1.25em" class="fas fa-clock mr-s text-yellow"></i>
                    <p>Suspendre</p>
                  </a>
                <?php endif; ?>
                <?php if ($comment['status'] !== 'APPROVE') : ?>
                  <a class="flex flex-middle mr-m" href="/bo/comments/approve?id=<?= $comment['id'] ?>&status=<?= $status ?>">
                    <i style="font-size: 1.25em" class="fas fa-check-square mr-s text-green"></i>
                    <p>Approuver</p>
                  </a>
                <?php endif; ?>
                <?php if ($comment['status'] !== 'DECLINED') : ?>
                  <a class="flex flex-middle mr-m" href="/bo/comments/decline?id=<?= $comment['id'] ?>&status=<?= $status ?>">
                    <i style="font-size: 1.25em" class="fas fa-ban mr-s text-red"></i>
                    <p>Refuser</p>
                  </a>
                <?php endif; ?>
              </div>
            </td>
          </tr>
        <?php endforeach ?>
    </tbody>
  </table>
</div>