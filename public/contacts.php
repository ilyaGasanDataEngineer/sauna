<?php
$site = json_decode(file_get_contents(__DIR__.'/data/site.json'), true);
$pageTitle = 'Контакты — '.$site['company'];
$pageDesc  = 'Связаться с нами';
$active    = 'contacts';
include __DIR__.'/partials/header.php';

$title    = 'Контакты';
$subtitle = 'Ответим на вопросы и подготовим смету.';
$img      = 'https://images.unsplash.com/photo-1505691938895-1758d7feb511?w=1600&q=80&auto=format&fit=crop';
include __DIR__.'/partials/sections/hero.php';

// Крошки
$crumbs = [
  ['title'=>'Главная','url'=>'/'],
  ['title'=>'Контакты','url'=>null]
];
?>
<main>
  <section class="section">
    <div class="container">
      <?php include __DIR__.'/partials/breadcrumbs.php'; ?>

      <div class="row g-4 align-items-start">
        <div class="col-lg-6 reveal">
          <div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow-sm">
            <img src="https://images.unsplash.com/photo-1528909514045-2fa4ac7a08ba?w=1600&q=80&auto=format&fit=crop" alt="Карта/офис">
          </div>
        </div>
        <div class="col-lg-6">
          <?php include __DIR__.'/partials/sections/contact_form.php'; ?>
        </div>
      </div>
    </div>
  </section>
</main>
<?php include __DIR__.'/partials/footer.php'; ?>
