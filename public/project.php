<?php
$slug = $_GET['slug'] ?? '';

$site     = json_decode(file_get_contents(__DIR__.'/data/site.json'), true);
$projects = json_decode(file_get_contents(__DIR__.'/data/projects.json'), true);

$project = null;
foreach ($projects as $p) {
  if ($p['slug'] === $slug) { $project = $p; break; }
}
if (!$project) { http_response_code(404); include __DIR__.'/404.php'; exit; }

$pageTitle = $project['title'].' — проект';
$pageDesc  = $project['seo']['description'] ?? $site['tagline'];
$active    = 'projects';
include __DIR__.'/partials/header.php';

// Хлебные крошки
$crumbs = [
  ['title'=>'Главная','url'=>'/'],
  ['title'=>'Проекты','url'=>'/projects'],
  ['title'=>$project['title'],'url'=>null]
];
?>
<main>
  <section class="section">
    <div class="container">
      <?php include __DIR__.'/partials/breadcrumbs.php'; ?>

      <div class="row g-4">
        <div class="col-lg-7">
          <!-- Галерея -->
          <div class="swiper project-swiper">
            <div class="swiper-wrapper">
              <?php foreach (($project['gallery'] ?? []) as $img): ?>
                <div class="swiper-slide">
                  <a href="<?= htmlspecialchars($img) ?>" class="glightbox" data-gallery="g">
                    <img class="img-fluid rounded-4" src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($project['title']) ?>" loading="lazy">
                  </a>
                </div>
              <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
          </div>

          <?php if (!empty($project['plans'])): ?>
            <h3 class="mt-4">Планировки</h3>
            <div class="row g-3 plan-grid">
              <?php foreach ($project['plans'] as $plan): ?>
                <div class="col-6 col-md-4">
                  <a href="<?= htmlspecialchars($plan) ?>" class="glightbox" data-gallery="plans">
                    <img class="img-fluid rounded-3" src="<?= htmlspecialchars($plan) ?>" alt="План">
                  </a>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>

          <?php if (!empty($project['description'])): ?>
            <h3 class="mt-4">Описание</h3>
            <?php foreach ($project['description'] as $p): ?>
              <p class="text-muted"><?= htmlspecialchars($p) ?></p>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <div class="col-lg-5">
          <div class="sticky-top" style="top: 90px">
            <h1 class="h2 fw-800 mb-2"><?= htmlspecialchars($project['title']) ?></h1>
            <div class="text-muted mb-3"><?= htmlspecialchars($project['subtitle'] ?? '') ?></div>

            <?php $s = $project['specs'] ?? []; ?>
            <div class="specs">
              <div><b>Площадь:</b> <?= isset($s['area_m2']) ? (int)$s['area_m2'].' м²' : '—' ?></div>
              <div><b>Габариты:</b> <?= htmlspecialchars($s['size'] ?? '—') ?></div>
              <div><b>Материал:</b> <?= htmlspecialchars($s['material'] ?? '—') ?></div>
              <div><b>Фундамент:</b> <?= htmlspecialchars($s['foundation'] ?? '—') ?></div>
              <div><b>Кровля:</b> <?= htmlspecialchars($s['roof'] ?? '—') ?></div>
            </div>

            <?php if (!empty($project['price']['value'])): ?>
              <div class="price mt-3">
                <div class="price-val"><?= number_format($project['price']['value'], 0, ',', ' ') ?> ₽</div>
                <div class="small text-muted"><?= htmlspecialchars($project['price']['note'] ?? '') ?></div>
              </div>
            <?php endif; ?>

            <?php
              // Общая форма связи (инклюд)
              $projectSlug = $project['slug'];
              $heading = 'Получить смету по проекту';
              $sub = 'Оставьте контакты — пришлём подробную спецификацию.';
              include __DIR__.'/partials/sections/contact_form.php';
            ?>

            <?php if (!empty($project['related'])): ?>
              <h3 class="mt-4">Похожие проекты</h3>
              <div class="row g-3">
                <?php  = array_filter(, fn()=>in_array(, )); ?>
                <?php foreach ( as ): ?>
                  <div class="col-12 col-md-6 col-lg-4">
                    <?php include __DIR__."/templates/project-card.php"; ?>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>

    </div>
  </section>
</main>
<?php include __DIR__.'/partials/footer.php'; ?>
