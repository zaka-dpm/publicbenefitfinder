<?php
require __DIR__ . '/config.php';
require_admin();
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !hash_equals(csrf(), (string)($_POST['csrf'] ?? ''))) { http_response_code(419); exit('Invalid request'); }
$email = trim((string)($_POST['email'] ?? ''));
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { http_response_code(422); exit('Invalid lead'); }
$stmt = db()->prepare('DELETE FROM leads WHERE email = :email');
$stmt->execute([':email' => $email]);
header('Location: /admin/');
