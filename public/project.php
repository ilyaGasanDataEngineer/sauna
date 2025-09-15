<?php
$slug = $_GET['slug'] ?? '';

$site     = json_decode(file_get_contents(__DIR__.'/data/site.json'), true);
$projects = json_decode(file_get_contents(__DIR__.'/data/projects.json'), true);

$project = null;
foreach ($projects as $p) {
  if ($p['slug'] === $slug) { $project = $p; break; }
}
if (!$project) { http_response_code(404); include __DIR__.'/404.php'; exit; }

$pageTitle = ($project['title'] ?? 'Проект').' — '.$site['company'];
$pageDesc  = $project['seo']['description'] ?? $site['tagline'];
$active    = 'projects';
include __DIR__.'/partials/header.php';

// Хлебные крошки
$crumbs = [
  ['title'=>'Главная','url'=>'/'],
  ['title'=>'Проекты','url'=>'/projects'],
  ['title'=>$project['title'],'url'=>null]
];

// Данные
$specs = $project['specs'] ?? [];
$gallery = $project['gallery'] ?? [];
$plans = $project['plans'] ?? [];
$priceVal = $project['price']['value'] ?? null;
$priceNote= $project['price']['note'] ?? '';
$subtitle = $project['subtitle'] ?? '';
$descArr  = $project['description'] ?? [];

// SEO JSON-LD Product
$firstImg = $gallery[0] ?? ($project['seo']['og_image'] ?? null);
$schema = [
  '@context'=>'https://schema.org',
  '@type'=>'Product',
  'name'=>$project['title'] ?? 'Проект',
  'description'=>$pageDesc,
  'image'=>array_values($gallery ?: ($firstImg?[$firstImg]:[])),
  'brand'=>['@type'=>'Brand','name'=>$site['company']],
];
if ($priceVal) {
  $schema['offers'] = [
    '@type'=>'Offer',
    'priceCurrency'=>'RUB',
    'price'=> (string) $priceVal,
    'availability'=>'https://schema.org/InStock',
    'url'=> $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']
  ];
}
?>
<script type="application/ld+json"><?= json_encode($schema, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) ?></script>

<main>
  <section class="section">
    <div class="container">
      <?php include __DIR__.'/partials/breadcrumbs.php'; ?>

      <div class="row g-4">
        <!-- Галерея с миниатюрами -->
        <div class="col-lg-8">
          <div class="project-gallery">
            <div class="swiper swiper-main">
              <div class="swiper-wrapper">
                <?php foreach ($gallery as $img): ?>
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

            <?php if (count($gallery) > 1): ?>
              <div class="swiper swiper-thumbs mt-2">
                <div class="swiper-wrapper">
                  <?php foreach ($gallery as $img): ?>
                    <div class="swiper-slide">
                      <img class="img-fluid rounded-3" src="<?= htmlspecialchars($img) ?>" alt="">
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Резюме/характеристики/цена/форма -->
        <div class="col-lg-4">
          <div class="sticky-top" style="top: 90px">
            <h1 class="h3 fw-800 mb-1"><?= htmlspecialchars($project['title']) ?></h1>
            <?php if ($subtitle): ?><div class="text-muted mb-3"><?= htmlspecialchars($subtitle) ?></div><?php endif; ?>

            <div class="specs mb-3">
              <div><b>Площадь:</b> <?= isset($specs['area_m2']) ? (int)$specs['area_m2'].' м²' : '—' ?></div>
              <div><b>Габариты:</b> <?= htmlspecialchars($specs['size'] ?? '—') ?></div>
              <div><b>Материал:</b> <?= htmlspecialchars($specs['material'] ?? '—') ?></div>
              <div><b>Фундамент:</b> <?= htmlspecialchars($specs['foundation'] ?? '—') ?></div>
              <div><b>Кровля:</b> <?= htmlspecialchars($specs['roof'] ?? '—') ?></div>
            </div>

            <?php if ($priceVal): ?>
              <div class="price mb-3">
                <div class="price-val"><?= number_format($priceVal, 0, ',', ' ') ?> ₽</div>
                <div class="small text-muted"><?= htmlspecialchars($priceNote) ?></div>
              </div>
            <?php endif; ?>

            <?php
              $projectSlug = $project['slug'];
              $heading = 'Получить смету по проекту';
              $sub = 'Оставьте контакты — пришлём подробную спецификацию.';
              include __DIR__.'/partials/sections/contact_form.php';
            ?>
          </div>
        </div>
      </div>

      <!-- Вкладки: Описание / Комплектация / Планировки -->
      <ul class="nav nav-tabs mt-4" id="projTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="tab-desc" data-bs-toggle="tab" data-bs-target="#pane-desc" type="button" role="tab">Описание</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="tab-equip" data-bs-toggle="tab" data-bs-target="#pane-equip" type="button" role="tab">Комплектация</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="tab-plans" data-bs-toggle="tab" data-bs-target="#pane-plans" type="button" role="tab">Планировки</button>
        </li>
      </ul>
      <div class="tab-content border rounded-4 p-3 bg-white shadow-sm" id="projTabsContent">
        <div class="tab-pane fade show active" id="pane-desc" role="tabpanel">
          <?php if ($descArr): ?>
            <?php foreach ($descArr as $p): ?><p class="text-muted mb-2"><?= htmlspecialchars($p) ?></p><?php endforeach; ?>
          <?php else: ?>
            <p class="text-muted">Описание будет добавлено.</p>
          <?php endif; ?>
        </div>
        <div class="tab-pane fade" id="pane-equip" role="tabpanel">
          <div class="row g-3">
            <div class="col-md-6">
              <h5 class="fw-800">Базовая</h5>
              <ul class="mb-0">
                <?php foreach (($project['equipment']['base'] ?? []) as $it): ?>
                  <li><?= htmlspecialchars($it) ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
            <div class="col-md-6">
              <h5 class="fw-800">Опции</h5>
              <ul class="mb-0">
                <?php foreach (($project['equipment']['options'] ?? []) as $it): ?>
                  <li><?= htmlspecialchars($it) ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="pane-plans" role="tabpanel">
          <?php if ($plans): ?>
            <div class="row g-3">
              <?php foreach ($plans as $plan): ?>
                <div class="col-6 col-md-4">
                  <a href="<?= htmlspecialchars($plan) ?>" class="glightbox" data-gallery="plans">
                    <img class="img-fluid rounded-3" src="<?= htmlspecialchars($plan) ?>" alt="Планировка">
                  </a>
                </div>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <p class="text-muted">Планировки будут добавлены.</p>
          <?php endif; ?>
        </div>
      </div>

      <!-- Похожие проекты -->
      <?php if (!empty($project['related'])): ?>
        <h3 class="mt-4">Похожие проекты</h3>
        <div class="row g-3">
          <?php
            $rel = array_filter($projects, fn($it)=>in_array($it['slug'], $project['related']));
            foreach ($rel as $p) { ?>
              <div class="col-12 col-md-6 col-lg-4">
                <?php include __DIR__.'/templates/project-card.php'; ?>
              </div>
          <?php } ?>
        </div>
      <?php endif; ?>

    </div>
  </section>
</main>
<?php include __DIR__.'/partials/footer.php'; ?>
