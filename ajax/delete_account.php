<?php
/**
 * Delete Account Handler
 * Hesap silme işlemi
 */

require_once '../config/config.php';

if (!isLoggedIn()) {
    header('Location: ?page=login');
    exit();
}

$userId = getUserId();

try {
    $database = new Database();
    $db = $database->getConnection();
    
    // Start transaction
    $db->beginTransaction();
    
    // Delete user's calculations
    $deleteCalc = "DELETE FROM carbon_calculations WHERE user_id = :user_id";
    $stmt = $db->prepare($deleteCalc);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();
    
    // Delete user's goals (if table exists)
    $deleteGoals = "DELETE FROM user_goals WHERE user_id = :user_id";
    $stmt = $db->prepare($deleteGoals);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();
    
    // Delete user's achievements (if table exists)
    $deleteAchievements = "DELETE FROM user_achievements WHERE user_id = :user_id";
    $stmt = $db->prepare($deleteAchievements);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();
    
    // Delete user
    $deleteUser = "DELETE FROM users WHERE id = :user_id";
    $stmt = $db->prepare($deleteUser);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();
    
    // Commit transaction
    $db->commit();
    
    // Destroy session
    session_destroy();
    
    // Redirect to home with message
    header('Location: ?page=home&deleted=1');
    exit();
    
} catch (PDOException $e) {
    // Rollback on error
    $db->rollBack();
    error_log('Delete account error: ' . $e->getMessage());
    header('Location: ?page=profile&error=1');
    exit();
}
?>
