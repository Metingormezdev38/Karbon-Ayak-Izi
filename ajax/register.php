<?php
/**
 * Register AJAX Handler
 * Kullanıcı kayıt işlemleri
 */

// Config dosyasını dahil et (session config içinde başlıyor)
require_once '../config/config.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Geçersiz istek metodu!');
}

$fullName = sanitizeInput($_POST['full_name'] ?? '');
$username = sanitizeInput($_POST['username'] ?? '');
$email = sanitizeInput($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($fullName) || empty($username) || empty($email) || empty($password)) {
    jsonResponse(false, 'Tüm alanları doldurun!');
}

if (strlen($fullName) < 3) {
    jsonResponse(false, 'Ad Soyad en az 3 karakter olmalıdır!');
}

if (strlen($username) < 3) {
    jsonResponse(false, 'Kullanıcı adı en az 3 karakter olmalıdır!');
}

if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
    jsonResponse(false, 'Kullanıcı adı sadece harf, rakam ve alt çizgi içerebilir!');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonResponse(false, 'Geçerli bir e-posta adresi girin!');
}

if (strlen($password) < 6) {
    jsonResponse(false, 'Şifre en az 6 karakter olmalıdır!');
}

try {
    $database = new Database();
    $db = $database->getConnection();
    
    $checkEmail = "SELECT id FROM users WHERE email = :email LIMIT 1";
    $stmt = $db->prepare($checkEmail);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        jsonResponse(false, 'Bu e-posta adresi zaten kullanılıyor!');
    }
    
    $checkUsername = "SELECT id FROM users WHERE username = :username LIMIT 1";
    $stmt = $db->prepare($checkUsername);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        jsonResponse(false, 'Bu kullanıcı adı zaten kullanılıyor!');
    }
    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    $query = "INSERT INTO users (username, email, password, full_name, status, created_at) 
              VALUES (:username, :email, :password, :full_name, 'active', NOW())";
    
    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':full_name', $fullName);
    
    if ($stmt->execute()) {
        jsonResponse(true, 'Kayıt başarılı! Giriş sayfasına yönlendiriliyorsunuz...', [
            'user_id' => $db->lastInsertId(),
            'username' => $username
        ]);
    } else {
        jsonResponse(false, 'Kayıt sırasında bir hata oluştu!');
    }
    
} catch (PDOException $e) {
    error_log('Register error: ' . $e->getMessage());
    jsonResponse(false, 'Bir hata oluştu. Lütfen daha sonra tekrar deneyin.');
}
?>
