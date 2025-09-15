<?php $s = $project['specs'] ?? []; ?>
<div class="specs">
  <div><b>Площадь:</b> <?= isset($s['area_m2']) ? (int)$s['area_m2'].' м²' : '—' ?></div>
  <div><b>Габариты:</b> <?= htmlspecialchars($s['size'] ?? '—') ?></div>
  <div><b>Материал:</b> <?= htmlspecialchars($s['material'] ?? '—') ?></div>
  <div><b>Фундамент:</b> <?= htmlspecialchars($s['foundation'] ?? '—') ?></div>
  <div><b>Кровля:</b> <?= htmlspecialchars($s['roof'] ?? '—') ?></div>
</div>
