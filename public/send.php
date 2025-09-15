<?php
header('Content-Type: application/json; charset=utf-8');

function ok($msg){ echo json_encode(['ok'=>true,'msg'=>$msg]); exit; }
function fail($msg){ http_response_code(400); echo json_encode(['ok'=>false,'msg'=>$msg]); exit; }

$name = trim($_POST['name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$email = trim($_POST['email'] ?? '');
$comment = trim($_POST['comment'] ?? '');
$project = trim($_POST['project'] ?? '');

if (strlen($name) < 2) fail('Укажите имя');
if (strlen($phone) < 5) fail('Укажите телефон');

$to = "info@example.com"; // <-- замените на вашу почту
$sub = "Заявка с сайта: $name";
$body = "Имя: $name\nТелефон: $phone\nEmail: $email\nПроект: $project\nКомментарий: $comment\nIP: ".$_SERVER['REMOTE_ADDR'];
$headers = "Content-Type: text/plain; charset=utf-8\r\n";

if (function_exists('mail') && @mail($to, '=?UTF-8?B?'.base64_encode($sub).'?=', $body, $headers)) {
  ok('Заявка отправлена. Мы свяжемся с вами.');
} else {
  fail('Не удалось отправить заявку. Напишите нам на почту.');
}
