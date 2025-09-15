<?php
$site = json_decode(file_get_contents(__DIR__.'/data/site.json'), true);
$projects = json_decode(file_get_contents(__DIR__.'/data/projects.json'), true);
$pageTitle = $site['company'].' — Бани/сауны под ключ';
$pageDesc  = $site['tagline'];
include __DIR__.'/partials/header.php';
?>
<main>
  <!-- HERO -->
  <section id="hero" class="section-hero">
    <div class="container py-5">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <h1 class="display-5 fw-800 mb-3"><?= htmlspecialchars($site['hero']['title']) ?></h1>
          <p class="lead mb-4"><?= htmlspecialchars($site['hero']['subtitle']) ?></p>
          <div class="d-flex gap-2">
            <a href="#catalog" class="btn btn-primary btn-lg">Смотреть проекты</a>
            <a href="#contacts" class="btn btn-outline-light btn-lg">Получить консультацию</a>
          </div>
          <div class="mt-4 text-white-50">
            <a class="link-light me-3" href="tel:<?= htmlspecialchars($site['contacts']['phone_raw']) ?>">📞 <?= htmlspecialchars($site['contacts']['phone']) ?></a>
            <a class="link-light" href="mailto:<?= htmlspecialchars($site['contacts']['email']) ?>">✉️ <?= htmlspecialchars($site['contacts']['email']) ?></a>
          </div>
        </div>
        <div class="col-lg-6 mt-4 mt-lg-0">
          <div class="hero-card shadow-xl">
            <img class="img-fluid rounded-4" src="<?= htmlspecialchars($site['hero']['image']) ?>" alt="Проекты бань" loading="lazy">
          </div>
        </div>
      </div>
    </div>
    <div class="hero-bg"></div>
  </section>

  <!-- ABOUT -->
  <section id="about" class="section">
    <div class="container">
      <div class="row g-4 align-items-center">
        <div class="col-lg-5">
          <h2 class="h1 mb-3">О компании</h2>
          <p class="mb-3"><?= htmlspecialchars($site['about']['text']) ?></p>
          <ul class="list-unstyled text-muted">
            <li>• Реализовано проектов: <b><?= (int)$site['about']['stats']['projects'] ?></b></li>
            <li>• Гарантия: <b><?= htmlspecialchars($site['about']['stats']['warranty']) ?></b></li>
            <li>• География: <b><?= htmlspecialchars($site['about']['stats']['locations']) ?></b></li>
          </ul>
        </div>
        <div class="col-lg-7">
          <div class="row g-3">
            <?php foreach ($site['benefits'] as $b): ?>
              <div class="col-6">
                <div class="card-ben">
                  <div class="ben-ico"><?= $b['icon'] ?></div>
                  <div class="ben-title"><?= htmlspecialchars($b['title']) ?></div>
                  <div class="ben-text text-muted"><?= htmlspecialchars($b['text']) ?></div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </section>

<?php include __DIR__."/partials/sections/home_projects.php"; ?>

  <!-- PROCESS -->
  <section id="process" class="section section-alt">
    <div class="container">
      <h2 class="h1 mb-4">Этапы работы</h2>
      <div class="row g-4">
        <?php foreach ($site['process'] as $i => $step): ?>
          <div class="col-md-6 col-lg-4">
            <div class="step-card">
              <div class="step-num"><?= $i+1 ?></div>
              <div class="step-title"><?= htmlspecialchars($step['title']) ?></div>
              <div class="step-text text-muted"><?= htmlspecialchars($step['text']) ?></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- FAQ -->
  <section id="faq" class="section">
    <div class="container">
      <h2 class="h1 mb-4">FAQ</h2>
      <div class="accordion" id="faqAcc">
        <?php foreach ($site['faq'] as $idx => $f): ?>
          <div class="accordion-item">
            <h2 class="accordion-header" id="h<?= $idx ?>">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#c<?= $idx ?>">
                <?= htmlspecialchars($f['q']) ?>
              </button>
            </h2>
            <div id="c<?= $idx ?>" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
              <div class="accordion-body"><?= htmlspecialchars($f['a']) ?></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- CONTACTS -->
  <section id="contacts" class="section section-contacts">
    <div class="container">
      <div class="row g-4">
        <div class="col-lg-5">
          <h2 class="h1 mb-3">Связаться с нами</h2>
          <p class="text-muted mb-4"><?= htmlspecialchars($site['contacts']['hint']) ?></p>
          <ul class="list-unstyled mb-4">
            <li>📍 <?= htmlspecialchars($site['contacts']['address']) ?></li>
            <li>📞 <a href="tel:<?= htmlspecialchars($site['contacts']['phone_raw']) ?>"><?= htmlspecialchars($site['contacts']['phone']) ?></a></li>
            <li>✉️ <a href="mailto:<?= htmlspecialchars($site['contacts']['email']) ?>"><?= htmlspecialchars($site['contacts']['email']) ?></a></li>
          </ul>
        </div>
        <div class="col-lg-7">
          <form id="contactForm" class="card-form">
            <input type="hidden" name="project" value="">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Имя*</label>
                <input name="name" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Телефон*</label>
                <input name="phone" class="form-control" required>
              </div>
              <div class="col-12">
                <label class="form-label">Email</label>
                <input name="email" type="email" class="form-control">
              </div>
              <div class="col-12">
                <label class="form-label">Комментарий</label>
                <textarea name="comment" rows="3" class="form-control"></textarea>
              </div>
              <div class="col-12 form-check mb-2">
                <input class="form-check-input" type="checkbox" id="consent" required>
                <label class="form-check-label" for="consent">Согласен(на) с <a href="/privacy">политикой обработки ПДн</a></label>
              </div>
              <div class="col-12">
                <button class="btn btn-primary btn-lg w-100" type="submit">Отправить заявку</button>
              </div>
              <div class="col-12">
                <div id="formMsg" class="small text-muted"></div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</main>
<?php include __DIR__."/partials/footer.php"; ?>
