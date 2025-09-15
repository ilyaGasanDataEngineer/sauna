<?php
$pHref = '/projects/'.$p['slug'];
$img = $p['gallery'][0] ?? 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?w=1200&q=80&auto=format&fit=crop';
?>
<div class="col-sm-6 col-lg-4">
  <a class="card-project" href="<?= $pHref ?>">
    <div class="card-img">
      <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($p['title']) ?>" loading="lazy">
    </div>
    <div class="card-body">
      <div class="card-title"><?= htmlspecialchars($p['title']) ?></div>
      <div class="card-sub text-muted"><?= htmlspecialchars($p['subtitle'] ?? '') ?></div>
      <?php if (!empty($p['specs']['area_m2']) || !empty($p['specs']['size'])): ?>
        <div class="card-specs">
          <span><?= (int)($p['specs']['area_m2'] ?? 0) ?> м²</span>
          <span><?= htmlspecialchars($p['specs']['size'] ?? '') ?></span>
        </div>
      <?php endif; ?>
    </div>
  </a>
</div>
