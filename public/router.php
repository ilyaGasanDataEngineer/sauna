<?php
$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH) ?? '/';
$full = __DIR__ . $path;

/* 1) отдать статический файл как есть */
if ($path !== '/' && file_exists($full) && is_file($full)) {
  return false; // пусть встроенный сервер отдаст файл
}

/* 2) маршрутизация для страниц */
switch (true) {
  case $path === '/' || $path === '':
    require __DIR__ . '/index.php'; break;
  case $path === '/about':
    require __DIR__ . '/about.php'; break;
  case $path === '/projects':
    require __DIR__ . '/projects.php'; break;
  case preg_match('#^/projects/([a-z0-9\-]+)/?$#', $path, $m):
    $_GET['slug'] = $m[1];
    require __DIR__ . '/project.php'; break;
  case $path === '/process':
    require __DIR__ . '/process.php'; break;
  case $path === '/contacts':
    require __DIR__ . '/contacts.php'; break;
  case $path === '/privacy':
    require __DIR__ . '/privacy.php'; break;
  default:
    http_response_code(404);
    require __DIR__ . '/404.php'; break;
}
