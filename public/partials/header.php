<?php if (!isset($pageTitle)) $pageTitle = 'Сайт'; if (!isset($pageDesc)) $pageDesc = ''; $active = $active ?? ''; $site = $site ?? json_decode(file_get_contents(__DIR__.'/../data/site.json'), true); ?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <meta name="description" content="<?= htmlspecialchars($pageDesc) ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;800&family=Cormorant+Garamond:wght@500;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" rel="stylesheet">
  <link href="/assets/css/main.css" rel="stylesheet">
</head>
<body>
<header class="site-header">
  <nav class="navbar navbar-expand-lg navbar-light fixed-top choco-nav" role="navigation" aria-label="Главная навигация">
    <div class="container">
      <a class="navbar-brand fw-800 hover-pop" href="/"><?= htmlspecialchars($site['company']) ?></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Переключить меню">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="nav">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link <?= $active==='projects'?'active':'' ?> hover-underline" href="/projects">Проекты</a></li>
          <li class="nav-item"><a class="nav-link <?= $active==='about'?'active':'' ?> hover-underline" href="/about">О нас</a></li>
          <li class="nav-item"><a class="nav-link <?= $active==='process'?'active':'' ?> hover-underline" href="/process">Этапы</a></li>
          <li class="nav-item"><a class="nav-link <?= $active==='contacts'?'active':'' ?> hover-underline" href="/contacts">Контакты</a></li>
        </ul>
        <a class="btn btn-primary ms-lg-3 hover-elevate" href="tel:<?= htmlspecialchars($site['contacts']['phone_raw']) ?>">Позвонить</a>
      </div>
    </div>
  </nav>
</header>
