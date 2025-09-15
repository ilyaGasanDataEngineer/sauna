<?php
$site = json_decode(file_get_contents(__DIR__.'/../../data/site.json'), true);
$all  = json_decode(file_get_contents(__DIR__.'/../../data/projects.json'), true);
$projects = array_slice($all, 0, 6); // показываем 6 проектов
?>
<section class="section section-alt">
  <div class="container">
    <div class="d-flex align-items-end justify-content-between mb-3">
      <h2 class="h2 fw-800 m-0">Каталог проектов</h2>
      <div class="text-muted small"><?= count($all) ?> проектов</div>
    </div>

    <div class="row g-4">
      <?php foreach ($projects as $p):
        $img   = $p['gallery'][0] ?? 'https://images.unsplash.com/photo-1600585154154-1e87b1c743b7?w=1200&q=80&auto=format&fit=crop';
        $title = $p['title'] ?? 'Проект';
        $sub   = $p['subtitle'] ?? '';
        $specs = $p['specs'] ?? [];
        $area  = isset($specs['area_m2']) ? ((int)$specs['area_m2'].' м²') : null;
        $size  = $specs['size'] ?? null;
        $slug  = $p['slug'];
        $descLong = trim(($p['seo']['description'] ?? $sub).' '.implode(' ', $p['description'] ?? []));
      ?>
        <div class="col-12 col-md-6 col-lg-4">
          <div class="card-proj project-modal-trigger" tabindex="0"
               data-title="<?= htmlspecialchars($title) ?>"
               data-text="<?= htmlspecialchars($descLong) ?>"
               data-img="<?= htmlspecialchars($img) ?>"
               data-link="/projects/<?= htmlspecialchars($slug) ?>">
            <div class="proj-media">
              <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($title) ?>" loading="lazy">
            </div>
            <div class="proj-body">
              <div class="proj-title"><?= htmlspecialchars($title) ?></div>
              <?php if($sub): ?><div class="proj-sub text-muted"><?= htmlspecialchars($sub) ?></div><?php endif; ?>
              <div class="proj-specs">
                <?php if($area): ?><span>🏷️ <?= htmlspecialchars($area) ?></span><?php endif; ?>
                <?php if($size): ?><span>📐 <?= htmlspecialchars($size) ?></span><?php endif; ?>
              </div>
              <div class="proj-actions">
                <a class="btn btn-sm btn-primary" href="/projects/<?= htmlspecialchars($slug) ?>" data-stop="1">Страница проекта</a>
                <span class="proj-more">Быстрый просмотр</span>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="text-center mt-4">
      <a class="btn btn-primary" href="/projects">Смотреть все проекты</a>
    </div>
  </div>
</section>

<?php // модалка быстрого просмотра (та же, что в каталоге)
include __DIR__.'/../modals/project-modal.php';
?>
