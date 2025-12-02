<?php
/**
 * Update Profile AJAX Handler
 * Profil bilgilerini güncelleme
 */

require_once '../config/config.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Geçersiz istek metodu!');
}

if (!isLoggedIn()) {
    jsonResponse(false, 'Giriş yapmanız gerekiyor!');
}

$userId = getUserId();
$fullName = sanitizeInput($_POST['full_name'] ?? '');
$username = sanitizeInput($_POST['username'] ?? '');
$email = sanitizeInput($_POST['email'] ?? '');

// Validation
if (empty($fullName) || empty($username) || empty($email)) {
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

try {
    $database = new Database();
    $db = $database->getConnection();
    
    // Email kontrolü (başka kullanıcı kullanıyorsa)
    $checkEmail = "SELECT id FROM users WHERE email = :email AND id != :user_id LIMIT 1";
    $stmt = $db->prepare($checkEmail);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        jsonResponse(false, 'Bu e-posta adresi başka bir kullanıcı tarafından kullanılıyor!');
    }
    
    // Username kontrolü (başka kullanıcı kullanıyorsa)
    $checkUsername = "SELECT id FROM users WHERE username = :username AND id != :user_id LIMIT 1";
    $stmt = $db->prepare($checkUsername);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        jsonResponse(false, 'Bu kullanıcı adı başka bir kullanıcı tarafından kullanılıyor!');
    }
    
    // Update user
    $query = "UPDATE users SET 
              full_name = :full_name,
              username = :username,
              email = :email
              WHERE id = :user_id";
    
    $stmt = $db->prepare($query);
    $stmt->bindParam(':full_name', $fullName);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':user_id', $userId);
    
    if ($stmt->execute()) {
        // Update session
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['full_name'] = $fullName;
        
        jsonResponse(true, 'Profil bilgileriniz başarıyla güncellendi!');
    } else {
        jsonResponse(false, 'Güncelleme sırasında bir hata oluştu!');
    }
    
} catch (PDOException $e) {
    error_log('Update profile error: ' . $e->getMessage());
    jsonResponse(false, 'Bir hata oluştu. Lütfen daha sonra tekrar deneyin.');
}
?>
