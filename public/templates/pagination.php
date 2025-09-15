<?php
/* Требуются переменные:
 * $page   — текущая страница (int)
 * $pages  — всего страниц (int)
 * $baseUrl — базовый URL, напр. "/projects"
 */
if (!isset($page) || !isset($pages) || $pages <= 1) return;

$qs = $_GET;
unset($qs['page']);

$build = function($n) use ($baseUrl, $qs) {
  $qs['page'] = $n;
  $q = http_build_query($qs);
  return $baseUrl . ($q ? ('?' . $q) : '');
};
?>
<nav aria-label="Навигация по страницам">
  <ul class="pagination pagination-choco justify-content-center">
    <li class="page-item <?= $page<=1?'disabled':'' ?>">
      <a class="page-link" href="<?= $build(max(1,$page-1)) ?>" aria-label="Предыдущая">‹</a>
    </li>
    <?php for($i=1;$i<=$pages;$i++): ?>
      <li class="page-item <?= $i==$page?'active':'' ?>">
        <a class="page-link" href="<?= $build($i) ?>"><?= $i ?></a>
      </li>
    <?php endfor; ?>
    <li class="page-item <?= $page>=$pages?'disabled':'' ?>">
      <a class="page-link" href="<?= $build(min($pages,$page+1)) ?>" aria-label="Следующая">›</a>
    </li>
  </ul>
</nav>
