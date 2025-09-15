<?php
$site = json_decode(file_get_contents(__DIR__.'/data/site.json'), true);
$pageTitle = 'Этапы работы — '.$site['company'];
$pageDesc  = 'Как мы работаем';
$active    = 'process';
include __DIR__.'/partials/header.php';

$title    = 'Этапы работы';
$subtitle = 'Путь от заявки до тёплой и красивой бани у вас на участке.';
$img      = 'https://images.unsplash.com/photo-1595877314030-99b0efb17a5b?w=1600&q=80&auto=format&fit=crop';
include __DIR__.'/partials/sections/hero.php';

// Крошки
$crumbs = [
  ['title'=>'Главная','url'=>'/'],
  ['title'=>'Этапы','url'=>null]
];

// Иконки и изображения для шагов (можешь заменить на свои)
$icons = ['🗨️','📐','📝','🏭','🏗️','✅'];
$stepImgs = [
  "https://images.unsplash.com/photo-1600585154526-990dced4db0d?w=1600&q=80&auto=format&fit=crop",
  "https://images.unsplash.com/photo-1505692069463-eb1f9b4c8a2e?w=1600&q=80&auto=format&fit=crop",
  "https://images.unsplash.com/photo-1527430253228-e93688616381?w=1600&q=80&auto=format&fit=crop",
  "https://images.unsplash.com/photo-1616596872800-6ee4f8335a68?w=1600&q=80&auto=format&fit=crop",
  "https://images.unsplash.com/photo-1618220179428-22790b461013?w=1600&q=80&auto=format&fit=crop",
  "https://images.unsplash.com/photo-1600210491892-03d54c0aaf87?w=1600&q=80&auto=format&fit=crop"
];
?>
<main>
  <section class="section">
    <div class="container">
      <?php include __DIR__.'/partials/breadcrumbs.php'; ?>

      <div class="timeline">
        <div class="timeline-progress" aria-hidden="true"></div>

        <?php foreach ($site['process'] as $i => $step): 
          $side = ($i % 2 === 0) ? 'is-left' : 'is-right';
          $img  = $stepImgs[$i % count($stepImgs)];
          $icon = $icons[$i % count($icons)];
          $fullText = $step['text'].' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer commodo, velit vitae ultricies sodales, mauris sapien pulvinar dolor, nec euismod lorem lorem in velit. Suspendisse potenti. Praesent in aliquet odio.';
        ?>
          <article class="timeline-item <?= $side ?> reveal">
            <span class="timeline-dot" aria-hidden="true"></span>
            <button class="timeline-card step-modal-trigger"
                    data-title="<?= htmlspecialchars(($i+1).'. '.$step['title']) ?>"
                    data-text="<?= htmlspecialchars($fullText) ?>"
                    data-img="<?= htmlspecialchars($img) ?>">
              <div class="timeline-meta">
                <div class="timeline-idx"><?= $i+1 ?></div>
                <div class="timeline-ico" aria-hidden="true"><?= $icon ?></div>
              </div>
              <h3 class="timeline-title"><?= htmlspecialchars($step['title']) ?></h3>
              <p class="timeline-text text-muted"><?= htmlspecialchars($step['text']) ?></p>
              <div class="timeline-more">Подробнее</div>
            </button>
          </article>
        <?php endforeach; ?>

        <div style="clear: both"></div>
      </div>
    </div>
  </section>

  <?php include __DIR__.'/partials/sections/contact_form.php'; ?>
  <?php include __DIR__.'/partials/modals/step-modal.php'; ?>
</main>
<?php include __DIR__.'/partials/footer.php'; ?>
