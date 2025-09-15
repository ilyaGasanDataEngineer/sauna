<?php
/* Simple image proxy with file cache: /img.php?src=<url>
 * Caches to /cache/img/<md5>
 */
declare(strict_types=1);
$PH = __DIR__ . '/assets/img/placeholder.svg';
$CACHE_DIR = __DIR__ . '/cache/img';
if (!is_dir($CACHE_DIR)) @mkdir($CACHE_DIR, 0775, true);

$src = $_GET['src'] ?? '';
if (!$src) { header('Content-Type: image/svg+xml'); readfile($PH); exit; }

$decoded = urldecode($src);
$isUrl = filter_var($decoded, FILTER_VALIDATE_URL) && preg_match('~^https?://~i', $decoded);
$cacheKey = md5($decoded);
$cachePath = $CACHE_DIR . '/' . $cacheKey;
$ctPath    = $cachePath . '.ct';

function outFile($path, $ct = null) {
  if (!$ct) {
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $map = ['jpg'=>'image/jpeg','jpeg'=>'image/jpeg','png'=>'image/png','gif'=>'image/gif','webp'=>'image/webp','svg'=>'image/svg+xml','bmp'=>'image/bmp','avif'=>'image/avif'];
    $ct = $map[$ext] ?? 'image/jpeg';
  }
  header('Content-Type: ' . $ct);
  header('Cache-Control: public, max-age=2592000, immutable');
  header('X-Image-Proxy: hit');
  readfile($path);
  exit;
}

if (file_exists($cachePath)) {
  $ct = file_exists($ctPath) ? trim(@file_get_contents($ctPath)) : null;
  outFile($cachePath, $ct ?: null);
}

if ($isUrl) {
  // basic SSRF guard
  $host = parse_url($decoded, PHP_URL_HOST);
  if (preg_match('~^(localhost|127\.|0\.0\.0\.0)~', (string)$host)) { header('Content-Type: image/svg+xml'); readfile($PH); exit; }

  $ch = curl_init($decoded);
  curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_CONNECTTIMEOUT => 5,
    CURLOPT_TIMEOUT => 12,
    CURLOPT_USERAGENT => 'SmartBani-ImageProxy/1.0',
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => 0,
  ]);
  $data = curl_exec($ch);
  $code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
  $ct   = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
  curl_close($ch);

  if ($code >= 200 && $code < 300 && $data) {
    @file_put_contents($cachePath, $data);
    if ($ct) @file_put_contents($ctPath, $ct);
    outFile($cachePath, $ct ?: null);
  } else {
    header('Content-Type: image/svg+xml'); readfile($PH); exit;
  }
} else {
  // local path support: /img.php?src=/assets/img/...
  $local = $decoded;
  if (strpos($local, '/') !== 0) $local = '/' . $local;
  $file = __DIR__ . $local;
  if (is_file($file)) outFile($file);
  header('Content-Type: image/svg+xml'); readfile($PH); exit;
}
