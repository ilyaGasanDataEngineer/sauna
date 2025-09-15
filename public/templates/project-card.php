<?php
/* Ожидает $p (проект) */
$href   = '/projects/'.urlencode($p['slug']);
$title  = $p['title'] ?? 'Проект';
$sub    = $p['subtitle'] ?? '';
$specs  = $p['specs'] ?? [];
$img    = ($p['gallery'][0] ?? 'https://images.unsplash.com/photo-1600585154154-1e87b1c743b7?w=800&q=80&auto=format&fit=crop');
$area   = isset($specs['area_m2']) ? ((int)$specs['area_m2'].' м²') : null;
$size   = $specs['size'] ?? null;
?>
<a class="card-project" href="<?= htmlspecialchars($href) ?>">
  <div class="card-img">
    <img class="img-fluid" src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($title) ?>" loading="lazy">
  </div>
  <div class="card-body">
    <div class="card-title"><?= htmlspecialchars($title) ?></div>
    <?php if ($sub): ?><div class="card-sub"><?= htmlspecialchars($sub) ?></div><?php endif; ?>
    <div class="card-specs">
      <?php if($area): ?><span>🏷️ <?= htmlspecialchars($area) ?></span><?php endif; ?>
      <?php if($size): ?><span>📐 <?= htmlspecialchars($size) ?></span><?php endif; ?>
    </div>
  </div>
</a>
