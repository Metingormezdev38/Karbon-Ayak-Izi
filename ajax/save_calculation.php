<?php
/**
 * Save Calculation AJAX Handler
 * Hesaplama kaydetme işlemi
 */

// Debug logging
error_reporting(E_ALL);
ini_set('display_errors', 1);
error_log("=== SAVE CALCULATION START ===");

require_once '../config/config.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    error_log("ERROR: Invalid request method");
    jsonResponse(false, 'Geçersiz istek metodu!');
}

if (!isLoggedIn()) {
    error_log("ERROR: User not logged in");
    jsonResponse(false, 'Giriş yapmanız gerekiyor!');
}

$userId = getUserId();
error_log("User ID: $userId");

$electricity = floatval($_POST['electricity'] ?? 0);
$naturalGas = floatval($_POST['naturalGas'] ?? 0);
$fuel = floatval($_POST['fuel'] ?? 0);
$distance = floatval($_POST['distance'] ?? 0);
$flightKm = floatval($_POST['flightKm'] ?? 0);
$water = floatval($_POST['water'] ?? 0);
$waste = floatval($_POST['waste'] ?? 0);
$recycling = floatval($_POST['recycling'] ?? 0);
$total = floatval($_POST['total'] ?? 0);

error_log("POST Data: " . json_encode($_POST));
error_log("Parsed values: elec=$electricity, gas=$naturalGas, fuel=$fuel, total=$total");

$userId = getUserId();

try {
    $database = new Database();
    $db = $database->getConnection();  
    
    error_log("Database connection OK");
    
    $categoryQuery = "SELECT id FROM calculation_categories WHERE name = 'Genel' LIMIT 1";
    $stmt = $db->prepare($categoryQuery);
    $stmt->execute();
    
    if ($stmt->rowCount() === 0) {
        error_log("Creating new category 'Genel'");
        $insertCat = "INSERT INTO calculation_categories (name, description, icon, color) 
                      VALUES ('Genel', 'Genel hesaplamalar', 'fa-calculator', '#10B981')";
        $db->exec($insertCat);
        $categoryId = $db->lastInsertId();
        error_log("Category created with ID: $categoryId");
    } else {
        $category = $stmt->fetch();
        $categoryId = $category['id'];
        error_log("Using existing category ID: $categoryId");
    }
    
    $query = "INSERT INTO carbon_calculations 
              (user_id, category_id, calculation_date, electricity_usage, natural_gas_usage, 
               fuel_consumption, transportation_km, flight_km, water_usage, waste_kg, 
               recycling_kg, total_carbon_kg, created_at) 
              VALUES 
              (:user_id, :category_id, CURDATE(), :electricity, :gas, :fuel, :distance, 
               :flight, :water, :waste, :recycling, :total, NOW())";
    
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $userId);
    $stmt->bindParam(':category_id', $categoryId);
    $stmt->bindParam(':electricity', $electricity);
    $stmt->bindParam(':gas', $naturalGas);
    $stmt->bindParam(':fuel', $fuel);
    $stmt->bindParam(':distance', $distance);
    $stmt->bindParam(':flight', $flightKm);
    $stmt->bindParam(':water', $water);
    $stmt->bindParam(':waste', $waste);
    $stmt->bindParam(':recycling', $recycling);
    $stmt->bindParam(':total', $total);
    
    if ($stmt->execute()) {
        $calculationId = $db->lastInsertId();
        error_log("SUCCESS: Calculation saved with ID: $calculationId");
        jsonResponse(true, 'Hesaplama başarıyla kaydedildi!', [
            'calculation_id' => $calculationId
        ]);
    } else {
        error_log("ERROR: Execute failed");
        error_log("Error info: " . json_encode($stmt->errorInfo()));
        jsonResponse(false, 'Hesaplama kaydedilemedi!');
    }
    
} catch (PDOException $e) {
    error_log('Save calculation error: ' . $e->getMessage());
    error_log('Stack trace: ' . $e->getTraceAsString());
    jsonResponse(false, 'Bir hata oluştu: ' . $e->getMessage());
}
?>
