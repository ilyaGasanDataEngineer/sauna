<?php
$site = json_decode(file_get_contents(__DIR__.'/data/site.json'), true);
$pageTitle = 'Страница не найдена';
$pageDesc = '';
include __DIR__.'/partials/header.php';
?>
<main class="section">
  <div class="container text-center">
    <h1 class="display-5">404</h1>
    <p class="text-muted">Такой страницы нет. Перейдите на <a href="/">главную</a>.</p>
  </div>
</main>
<?php include __DIR__.'/partials/footer.php'; ?>
