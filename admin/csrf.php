<?php
require __DIR__ . '/config.php';
require_admin();
header('Content-Type: application/json');
echo json_encode(['csrf' => csrf()]);
