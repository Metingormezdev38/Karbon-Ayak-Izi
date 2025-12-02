<?php
/**
 * Genel Site Ayarları
 */

// Session ayarları
ini_set('session.cookie_lifetime', 0);
ini_set('session.cookie_path', '/');
ini_set('session.cookie_httponly', 1);
ini_set('session.use_cookies', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_samesite', 'Lax');

// Oturum başlat
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Hata raporlama (production'da kapatılmalı)
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('SITE_NAME', 'Karbon Ayak İzi Hesaplama');
define('SITE_URL', 'http://localhost/');
define('BASE_PATH', __DIR__ . '/../');

date_default_timezone_set('Europe/Istanbul');

require_once BASE_PATH . 'config/database.php';

function isLoggedIn() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function getUserId() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return $_SESSION['user_id'] ?? null;
}

function getUserName() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return $_SESSION['username'] ?? 'Misafir';
}

function getFullName() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return $_SESSION['full_name'] ?? 'Kullanıcı';
}

function redirect($page) {
    header("Location: " . SITE_URL . "?page=" . $page);
    exit();
}

function jsonResponse($success, $message, $data = null) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ], JSON_UNESCAPED_UNICODE);
    exit();
}

function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

function formatCarbon($kg) {
    if ($kg >= 1000) {
        return number_format($kg / 1000, 2, ',', '.') . ' ton';
    }
    return number_format($kg, 2, ',', '.') . ' kg';
}

function formatDate($date) {
    return date('d.m.Y', strtotime($date));
}

function formatDateTime($datetime) {
    return date('d.m.Y H:i', strtotime($datetime));
}
?>
