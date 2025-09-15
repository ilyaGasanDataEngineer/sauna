<?php
header('Content-Type: text/html; charset=utf-8');
$sitePath = __DIR__ . '/../data/site.json';
$projPath = __DIR__ . '/../data/projects.json';
$urls = [];

// 4.1 Из JSON проектов
if (is_file($projPath)) {
  $projects = json_decode(file_get_contents($projPath), true) ?: [];
  foreach ($projects as $p) {
    foreach (($p['gallery'] ?? []) as $u) $urls[] = $u;
    foreach (($p['plans'] ?? []) as $u)   $urls[] = $u;
    if (!empty($p['seo']['og_image']))     $urls[] = $p['seo']['og_image'];
  }
}

// 4.2 Из основных страниц — вытянем все https://images.unsplash... из PHP-файлов
$scanFiles = glob(__DIR__.'/../*.php');
foreach ($scanFiles as $f) {
  $txt = file_get_contents($f);
  if (preg_match_all('~https?://[^\s"\']+images\.unsplash[^\s"\']+~i', $txt, $m)) {
    foreach ($m[0] as $u) $urls[] = $u;
  }
}

$urls = array_values(array_unique(array_filter($urls)));
function headStatus($url) {
  $ch = curl_init($url);
  curl_setopt_array($ch, [
    CURLOPT_NOBODY => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_MAXREDIRS => 5,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CONNECTTIMEOUT => 5,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_USERAGENT => 'SmartBani-ImageCheck/1.0'
  ]);
  curl_exec($ch);
  $info = [
    'http_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
    'content_type' => curl_getinfo($ch, CURLINFO_CONTENT_TYPE),
    'content_length' => curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD),
    'final_url' => curl_getinfo($ch, CURLINFO_EFFECTIVE_URL),
  ];
  curl_close($ch);
  // Если HEAD не дал длину/тип — попробуем быстрый GET с range
  if (!$info['content_type'] || $info['http_code'] >= 400) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_RANGE => '0-2048',
      CURLOPT_CONNECTTIMEOUT => 5,
      CURLOPT_TIMEOUT => 10,
      CURLOPT_USERAGENT => 'SmartBani-ImageCheck/1.0'
    ]);
    curl_exec($ch);
    $info['http_code'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $info['content_type'] = $info['content_type'] ?: curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
    $info['final_url'] = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL) ?: $info['final_url'];
    curl_close($ch);
  }
  return $info;
}
?>
<!doctype html>
<html lang="ru"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Проверка изображений</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.badge-ok{background:#28a745} .badge-bad{background:#dc3545}
table td{vertical-align:middle}
</style>
</head><body class="p-3">
<div class="container">
  <h1 class="h3 mb-3">Проверка изображений</h1>
  <p class="text-muted">Источник: projects.json + ссылки Unsplash из основных страниц. Клик по «proxy» откроет через локальный прокси <code>/img.php</code>.</p>
  <table class="table table-sm table-hover align-middle">
    <thead><tr><th>#</th><th>URL</th><th>Статус</th><th>Тип</th><th>Размер</th><th>Просмотр</th></tr></thead>
    <tbody>
    <?php foreach ($urls as $i=>$u): $r = headStatus($u); ?>
      <tr>
        <td><?= $i+1 ?></td>
        <td style="max-width:560px; word-break:break-all"><a href="<?= htmlspecialchars($u) ?>" target="_blank" rel="noopener"><?= htmlspecialchars($u) ?></a></td>
        <td>
          <?php if ($r['http_code']>=200 && $r['http_code']<300): ?>
            <span class="badge badge-ok">OK <?= (int)$r['http_code'] ?></span>
          <?php else: ?>
            <span class="badge badge-bad">ERR <?= (int)$r['http_code'] ?></span>
          <?php endif; ?>
        </td>
        <td><?= htmlspecialchars($r['content_type'] ?: '-') ?></td>
        <td><?= ($r['content_length']>0)? number_format($r['content_length'],0,',',' ') . ' B' : '-' ?></td>
        <td>
          <a class="btn btn-sm btn-outline-primary" href="/img.php?src=<?= urlencode($u) ?>" target="_blank">proxy</a>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
</body></html>
