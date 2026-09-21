<?php
declare(strict_types=1);
require dirname(__DIR__) . '/admin/config.php';
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); echo json_encode(['error'=>'POST required']); exit; }
$input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
$name = trim((string)($input['name'] ?? '')); $email = trim((string)($input['email'] ?? ''));
if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) { http_response_code(422); echo json_encode(['error'=>'Name and valid email are required']); exit; }
$allowed = ['name','email','phone','credit_score','income','source','utm_medium','utm_campaign']; $data = [];
foreach ($allowed as $key) $data[$key] = trim((string)($input[$key] ?? ''));
$data['created_at'] = gmdate('c');
$stmt = db()->prepare('INSERT INTO leads (created_at,name,email,phone,credit_score,income,source,utm_medium,utm_campaign) VALUES (:created_at,:name,:email,:phone,:credit_score,:income,:source,:utm_medium,:utm_campaign)');
$stmt->execute($data); echo json_encode(['ok'=>true,'id'=>(int)db()->lastInsertId()]);
