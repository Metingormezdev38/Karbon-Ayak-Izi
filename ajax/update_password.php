<?php
/**
 * Update Password AJAX Handler
 * Şifre değiştirme
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
$currentPassword = $_POST['current_password'] ?? '';
$newPassword = $_POST['new_password'] ?? '';

// Validation
if (empty($currentPassword) || empty($newPassword)) {
    jsonResponse(false, 'Tüm alanları doldurun!');
}

if (strlen($newPassword) < 6) {
    jsonResponse(false, 'Yeni şifre en az 6 karakter olmalıdır!');
}

try {
    $database = new Database();
    $db = $database->getConnection();
    
    // Get current password from database
    $query = "SELECT password FROM users WHERE id = :user_id LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();
    
    if ($stmt->rowCount() === 0) {
        jsonResponse(false, 'Kullanıcı bulunamadı!');
    }
    
    $user = $stmt->fetch();
    
    // Verify current password
    if (!password_verify($currentPassword, $user['password'])) {
        jsonResponse(false, 'Mevcut şifreniz hatalı!');
    }
    
    // Hash new password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    
    // Update password
    $updateQuery = "UPDATE users SET password = :password WHERE id = :user_id";
    $stmt = $db->prepare($updateQuery);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':user_id', $userId);
    
    if ($stmt->execute()) {
        jsonResponse(true, 'Şifreniz başarıyla değiştirildi!');
    } else {
        jsonResponse(false, 'Şifre değiştirme sırasında bir hata oluştu!');
    }
    
} catch (PDOException $e) {
    error_log('Update password error: ' . $e->getMessage());
    jsonResponse(false, 'Bir hata oluştu. Lütfen daha sonra tekrar deneyin.');
}
?>
