<?php
$site = json_decode(file_get_contents(__DIR__.'/data/site.json'), true);
$all  = json_decode(file_get_contents(__DIR__.'/data/projects.json'), true);

$pageTitle = 'Каталог проектов — '.$site['company'];
$pageDesc  = 'Все проекты бань и саун';
$active    = 'projects';
include __DIR__.'/partials/header.php';

$title    = 'Каталог проектов';
$subtitle = 'Выберите готовое решение или адаптируем под ваши задачи.';
$img      = 'https://images.unsplash.com/photo-1616595077779-9b606e59f8de?w=1600&q=80&auto=format&fit=crop';
include __DIR__.'/partials/sections/hero.php';

// Крошки
$crumbs = [
  ['title'=>'Главная','url'=>'/'],
  ['title'=>'Проекты','url'=>null]
];

// Пагинация
$per    = 9;
$total  = count($all);
$pages  = max(1, (int)ceil($total / $per));
$page   = max(1, min((int)($_GET['page'] ?? 1), $pages));
$offset = ($page - 1) * $per;
$projects = array_slice($all, $offset, $per);
?>
<main>
  <section class="section">
    <div class="container">
      <?php include __DIR__.'/partials/breadcrumbs.php'; ?>

      <div class="row g-4">
        <?php foreach ($projects as $p):
          $img = $p['gallery'][0] ?? 'https://images.unsplash.com/photo-1600585154154-1e87b1c743b7?w=1200&q=80&auto=format&fit=crop';
          $title = $p['title'] ?? 'Проект';
          $sub = $p['subtitle'] ?? '';
          $specs = $p['specs'] ?? [];
          $area = isset($specs['area_m2']) ? ((int)$specs['area_m2'].' м²') : null;
          $size = $specs['size'] ?? null;
          $slug = $p['slug'];
          $descLong = trim(($p['seo']['description'] ?? $sub).' '.implode(' ', $p['description'] ?? []));
        ?>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card-proj project-modal-trigger" tabindex="0"
                 data-title="<?= htmlspecialchars($title) ?>"
                 data-text="<?= htmlspecialchars($descLong) ?>"
                 data-img="<?= htmlspecialchars($img) ?>"
                 data-link="/projects/<?= htmlspecialchars($slug) ?>">
              <a class="proj-media" href="/projects/<?= htmlspecialchars($slug) ?>" data-stop="1">
                <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($title) ?>" loading="lazy">
              </a>
              <div class="proj-body">
                <a class="proj-title d-inline-block" href="/projects/<?= htmlspecialchars($slug) ?>" data-stop="1"><?= htmlspecialchars($title) ?></a>
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

      <div class="mt-4">
        <?php $baseUrl = '/projects'; include __DIR__.'/templates/pagination.php'; ?>
      </div>
    </div>
  </section>

  <?php include __DIR__.'/partials/sections/contact_form.php'; ?>
  <?php include __DIR__.'/partials/modals/project-modal.php'; ?>
</main>
<?php include __DIR__.'/partials/footer.php'; ?>
