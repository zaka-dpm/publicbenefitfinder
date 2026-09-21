<?php
declare(strict_types=1);

session_start();

const ADMIN_USER = 'admin';
const ADMIN_PASSWORD = 'change-me-now';

function db(): PDO {
    static $pdo;
    if ($pdo instanceof PDO) return $pdo;
    $dir = dirname(__DIR__) . '/storage';
    if (!is_dir($dir)) mkdir($dir, 0750, true);
    $pdo = new PDO('sqlite:' . $dir . '/leads.sqlite', null, null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $pdo->exec('CREATE TABLE IF NOT EXISTS leads (id INTEGER PRIMARY KEY AUTOINCREMENT, created_at TEXT NOT NULL, name TEXT NOT NULL, email TEXT NOT NULL, phone TEXT, credit_score TEXT, income TEXT, source TEXT, utm_medium TEXT, utm_campaign TEXT)');
    return $pdo;
}

function csrf(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(24));
    return $_SESSION['csrf'];
}

function require_admin(): void {
    if (empty($_SESSION['admin'])) { header('Location: /admin/'); exit; }
}

function esc(string $value): string { return htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); }
