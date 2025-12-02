<?php
/**
 * Login AJAX Handler
 * Kullanıcı giriş işlemleri
 */

// Config dosyasını dahil et (session config içinde başlıyor)
require_once '../config/config.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Geçersiz istek metodu!');
}

$email = sanitizeInput($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$remember = isset($_POST['remember']) && $_POST['remember'] === 'true';


if (empty($email) || empty($password)) {
    jsonResponse(false, 'Tüm alanları doldurun!');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonResponse(false, 'Geçerli bir e-posta adresi girin!');
}

try {
    $database = new Database();
    $db = $database->getConnection();
    
    $query = "SELECT id, username, email, password, full_name, status FROM users WHERE email = :email LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    if ($stmt->rowCount() === 0) {
        jsonResponse(false, 'E-posta veya şifre hatalı!');
    }
    
    $user = $stmt->fetch();
    
    if ($user['status'] !== 'active') {
        jsonResponse(false, 'Hesabınız aktif değil. Lütfen destek ile iletişime geçin.');
    }
    
    if (!password_verify($password, $user['password'])) {
        jsonResponse(false, 'E-posta veya şifre hatalı!');
    }
    
    $updateQuery = "UPDATE users SET last_login = NOW() WHERE id = :id";
    $updateStmt = $db->prepare($updateQuery);
    $updateStmt->bindParam(':id', $user['id']);
    $updateStmt->execute();
    

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    session_regenerate_id(true);
    
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['full_name'] = $user['full_name'];
    $_SESSION['logged_in'] = true;
    $_SESSION['login_time'] = time();
    session_write_close();
    
    if ($remember) {
        $token = bin2hex(random_bytes(32));
        setcookie('remember_token', $token, time() + (86400 * 30), '/'); 
    }
    
    jsonResponse(true, 'Giriş başarılı! Yönlendiriliyorsunuz...', [
        'username' => $user['username'],
        'redirect' => '?page=dashboard'
    ]);
    
} catch (PDOException $e) {
    error_log('Login error: ' . $e->getMessage());
    jsonResponse(false, 'Bir hata oluştu. Lütfen daha sonra tekrar deneyin.');
}
?>
