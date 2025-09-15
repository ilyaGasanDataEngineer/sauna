<?php
$site = json_decode(file_get_contents(__DIR__.'/data/site.json'), true);
$pageTitle = 'О компании — '.$site['company'];
$pageDesc  = 'О нас, ценности и опыт';
$active    = 'about';
include __DIR__.'/partials/header.php';

$title    = 'О компании';
$subtitle = 'Проектируем и строим тёплые, долговечные бани под ваш образ жизни.';
$img      = 'https://images.unsplash.com/photo-1600585154154-1e87b1c743b7?w=1600&q=80&auto=format&fit=crop';
include __DIR__.'/partials/sections/hero.php';

// Крошки
$crumbs = [
  ['title'=>'Главная','url'=>'/'],
  ['title'=>'О нас','url'=>null]
];
?>
<main>
  <section class="section">
    <div class="container">
      <?php include __DIR__.'/partials/breadcrumbs.php'; ?>

      <div class="row g-5">
        <div class="col-lg-6 reveal">
          <h2 class="h3 mb-3">Наш подход</h2>
          <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed at felis id risus imperdiet gravida. Maecenas eget tellus id dolor volutpat dictum. Integer quis urna et mi cursus imperdiet.</p>
          <p class="text-muted">Donec pharetra, arcu sit amet auctor interdum, turpis quam pulvinar mauris, ac efficitur metus odio ac dolor. Cras dictum, eros a vulputate tristique, risus nisl hendrerit magna, sit amet tincidunt eros lorem non turpis.</p>
          <ul class="list-unstyled mt-3">
            <li>• Реализовано проектов: <b><?= (int)$site['about']['stats']['projects'] ?></b></li>
            <li>• Гарантия: <b><?= htmlspecialchars($site['about']['stats']['warranty']) ?></b></li>
            <li>• География: <b><?= htmlspecialchars($site['about']['stats']['locations']) ?></b></li>
          </ul>
        </div>
        <div class="col-lg-6 reveal">
          <img class="img-fluid rounded-4" src="https://images.unsplash.com/photo-1616596872800-6ee4f8335a68?w=1600&q=80&auto=format&fit=crop" alt="">
        </div>
      </div>

      <!-- Сетка карточек с триггером модалки -->
      <?php
        // дефолтные изображения для карточек (можно заменить на свои)
        $benefitImgs = [
          "https://images.unsplash.com/photo-1598300183244-7142c95f9b9b?w=1600&q=80&auto=format&fit=crop",
          "https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?w=1600&q=80&auto=format&fit=crop",
          "https://images.unsplash.com/photo-1582582429416-70a590c3a3c5?w=1600&q=80&auto=format&fit=crop",
          "https://images.unsplash.com/photo-1503387762-592deb58ef4e?w=1600&q=80&auto=format&fit=crop",
          "https://images.unsplash.com/photo-1519710884001-2f43ce221f59?w=1600&q=80&auto=format&fit=crop",
          "https://images.unsplash.com/photo-1503387762-5a5d5d1b1b6b?w=1600&q=80&auto=format&fit=crop"
        ];
      ?>
      <div class="row g-4 mt-2">
        <?php foreach ($site['benefits'] as $i => $b): ?>
          <?php
            $imgUrl = $benefitImgs[$i % count($benefitImgs)];
            $title = $b['title'];
            $text  = $b['text']." Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent eget ex id justo pellentesque vulputate. Maecenas id eros non mi placerat fermentum.";
          ?>
          <div class="col-6 col-lg-4">
            <div class="card-ben ben-modal-trigger" tabindex="0"
                 data-title="<?= htmlspecialchars($title) ?>"
                 data-text="<?= htmlspecialchars($text) ?>"
                 data-img="<?= htmlspecialchars($imgUrl) ?>">
              <div class="ben-ico"><?= $b['icon'] ?></div>
              <div class="ben-title"><?= htmlspecialchars($title) ?></div>
              <div class="ben-text text-muted"><?= htmlspecialchars($b['text']) ?></div>
              <div class="ben-more">Подробнее</div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="row g-5 mt-2">
        <div class="col-lg-6 reveal">
          <h3 class="h4 mb-2">Материалы и инженерия</h3>
          <p class="text-muted">Praesent id arcu ac lacus posuere rhoncus. Integer laoreet ornare orci, at cursus nibh congue eget. Morbi nec sollicitudin lorem. Phasellus pulvinar, arcu vitae faucibus mattis, ipsum mi rutrum sapien, a dapibus libero nulla nec velit.</p>
          <p class="text-muted">Aliquam accumsan, lacus a cursus tempor, orci nibh vestibulum tellus, id viverra tellus risus id justo. Integer finibus metus sed arcu finibus, non luctus lacus accumsan.</p>
        </div>
        <div class="col-lg-6 reveal">
          <h3 class="h4 mb-2">Контроль качества</h3>
          <p class="text-muted">Suspendisse potenti. In sed bibendum lorem, vitae ultricies massa. Suspendisse vitae convallis ipsum. Vestibulum feugiat, ipsum nec congue iaculis, massa erat dapibus metus, in interdum sapien ipsum non lorem.</p>
          <p class="text-muted">Nunc scelerisque, erat non faucibus feugiat, quam odio luctus arcu, vitae hendrerit massa nibh non sem.</p>
        </div>
      </div>
    </div>
  </section>

  <?php include __DIR__.'/partials/sections/contact_form.php'; ?>
  <?php include __DIR__.'/partials/modals/benefit-modal.php'; ?>
</main>
<?php include __DIR__.'/partials/footer.php'; ?>
