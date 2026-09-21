<?php
require dirname(__DIR__) . '/admin/config.php'; require_admin();
header('Content-Type: text/csv'); header('Content-Disposition: attachment; filename="leads-' . date('Y-m-d') . '.csv"');
$out = fopen('php://output','w'); $stmt = db()->query('SELECT created_at,name,email,phone,credit_score,income FROM leads ORDER BY created_at DESC');
fputcsv($out, ['Created','Name','Email','Phone','Credit score','Income']); while ($row=$stmt->fetch(PDO::FETCH_NUM)) fputcsv($out,$row); fclose($out);
