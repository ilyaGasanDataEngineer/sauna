<?php
$site = json_decode(file_get_contents(__DIR__.'/data/site.json'), true);
$pageTitle = 'Политика конфиденциальности';
$pageDesc = 'Политика обработки персональных данных';
include __DIR__.'/partials/header.php';
?>
<main class="section">
  <div class="container">
    <h1 class="h2 mb-4">Политика конфиденциальности</h1>
    <p class="text-muted">Здесь будет текст политики обработки персональных данных. Подставим реквизиты компании после согласования.</p>
  </div>
</main>
<?php include __DIR__.'/partials/footer.php'; ?>
