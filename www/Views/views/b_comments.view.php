<div class="flex flex-middle mb-m mt-s">
    <i class="fas fa-comments"></i>
    <h1 class="ml-s"><?= $title; ?></h1>
</div>

<div class=" w-100 flex flex-between flex-middle my-m">
    <div>
        <div id="filter-link-bar" class="flex">
            <a href="/bo/comments">Tous</a>
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
  <pre>
    <?php
    	print_r($comments)
    ?>
  </pre>

  <table class="table card">
    <thead>
      <tr>
        <th>Author</th>
        <th>Comment</th>
        <th>Event</th>
        <th>Date</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($comments as $comment ) : ?>
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
              <div class="flex">
                <?php if ($comment['status'] == 'APPROVED' || $comment['status'] == 'WAITING' ) : ?>
                  <a class="flex flex-middle mr-m" href="/bo/comments/decline?id=<?= $comment['id'] ?>&status=<?php $status ?>">
                    <i class="mr-s  fas fa-times"></i>
                    <p>Refuser</p>
                  </a>
                </a>
                <?php endif; ?>
                <?php if ($comment['status'] == 'DECLINED'|| $comment['status'] == 'WAITING' ) : ?>
                  <a class="flex flex-middle mr-m" href="/bo/comments/approve?id=<?= $comment['id'] ?>&status=<?php $status ?>">
                    <i class="mr-s fas fa-check-square"></i>
                    <p>Approuver</p>
                  </a>
                <?php endif; ?>
              </div>
              </td>
          </tr>
          <?php endforeach ?>
      </tbody>
  </table>
</div>