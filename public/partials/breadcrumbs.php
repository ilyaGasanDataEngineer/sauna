<?php
/* Ожидает массив $crumbs вида:
$crumbs = [
  ['title'=>'Главная','url'=>'/'],
  ['title'=>'Проекты','url'=>'/projects'],
  ['title'=>'Classic 1','url'=>null],
];
*/
$crumbs = $crumbs ?? [];
?>
<nav aria-label="Хлебные крошки" class="mb-3">
  <ol class="breadcrumb">
    <?php foreach ($crumbs as $i=>$c): ?>
      <?php if (!empty($c['url']) && $i < count($crumbs)-1): ?>
        <li class="breadcrumb-item">
          <a href="<?= htmlspecialchars($c['url']) ?>"><?= htmlspecialchars($c['title']) ?></a>
        </li>
      <?php else: ?>
        <li class="breadcrumb-item active" aria-current="page">
          <?= htmlspecialchars($c['title']) ?>
        </li>
      <?php endif; ?>
    <?php endforeach; ?>
  </ol>
</nav>
