-- Karbon Ayak İzi Sitesi Veritabanı
-- Oluşturulma Tarihi: 2025-11-21

CREATE DATABASE IF NOT EXISTS carbon_footprint CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE carbon_footprint;

-- Kullanıcılar Tablosu
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    avatar VARCHAR(255) DEFAULT 'default.png',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    INDEX idx_email (email),
    INDEX idx_username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Karbon Hesaplama Kategorileri
CREATE TABLE IF NOT EXISTS calculation_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    icon VARCHAR(50),
    color VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Karbon Hesaplamaları
CREATE TABLE IF NOT EXISTS carbon_calculations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    category_id INT NOT NULL,
    calculation_date DATE NOT NULL,
    electricity_usage DECIMAL(10,2) DEFAULT 0,
    natural_gas_usage DECIMAL(10,2) DEFAULT 0,
    fuel_consumption DECIMAL(10,2) DEFAULT 0,
    transportation_km DECIMAL(10,2) DEFAULT 0,
    flight_km DECIMAL(10,2) DEFAULT 0,
    water_usage DECIMAL(10,2) DEFAULT 0,
    waste_kg DECIMAL(10,2) DEFAULT 0,
    recycling_kg DECIMAL(10,2) DEFAULT 0,
    total_carbon_kg DECIMAL(10,2) NOT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES calculation_categories(id) ON DELETE CASCADE,
    INDEX idx_user_date (user_id, calculation_date),
    INDEX idx_category (category_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Karbon Azaltma Önerileri
CREATE TABLE IF NOT EXISTS reduction_tips (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    impact_level ENUM('low', 'medium', 'high') DEFAULT 'medium',
    difficulty ENUM('easy', 'moderate', 'hard') DEFAULT 'moderate',
    estimated_reduction_kg DECIMAL(10,2),
    image VARCHAR(255),
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES calculation_categories(id) ON DELETE CASCADE,
    INDEX idx_category_active (category_id, is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Kullanıcı Hedefleri
CREATE TABLE IF NOT EXISTS user_goals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    target_reduction_percentage DECIMAL(5,2) NOT NULL,
    target_date DATE NOT NULL,
    baseline_carbon_kg DECIMAL(10,2) NOT NULL,
    current_carbon_kg DECIMAL(10,2) NOT NULL,
    status ENUM('active', 'completed', 'failed', 'cancelled') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_status (user_id, status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Kullanıcı Başarıları
CREATE TABLE IF NOT EXISTS user_achievements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    achievement_type VARCHAR(50) NOT NULL,
    achievement_name VARCHAR(100) NOT NULL,
    description TEXT,
    earned_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    badge_icon VARCHAR(100),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Varsayılan Kategorileri Ekle
INSERT INTO calculation_categories (name, description, icon, color) VALUES
('Enerji', 'Elektrik ve doğal gaz tüketimi', 'fa-bolt', '#F59E0B'),
('Ulaşım', 'Araç kullanımı ve yakıt tüketimi', 'fa-car', '#3B82F6'),
('Uçuş', 'Hava yolu seyahatleri', 'fa-plane', '#8B5CF6'),
('Su', 'Su tüketimi', 'fa-droplet', '#06B6D4'),
('Atık', 'Çöp ve geri dönüşüm', 'fa-trash', '#10B981');

-- Örnek Azaltma Önerileri
INSERT INTO reduction_tips (category_id, title, description, impact_level, difficulty, estimated_reduction_kg) VALUES
(1, 'LED Ampul Kullanın', 'Evinizdeki tüm ampulleri LED ampullerle değiştirerek yıllık 300 kg karbon tasarrufu sağlayabilirsiniz.', 'high', 'easy', 300),
(1, 'Akıllı Termostat', 'Akıllı termostat ile ısınma maliyetlerinizi %20-30 azaltabilirsiniz.', 'high', 'moderate', 450),
(2, 'Toplu Taşıma', 'Haftada 3 gün toplu taşıma kullanarak yıllık 500 kg karbon azaltabilirsiniz.', 'high', 'easy', 500),
(2, 'Bisiklet Kullanımı', 'Kısa mesafeler için bisiklet kullanarak hem sağlıklı yaşayın hem de karbonu azaltın.', 'medium', 'easy', 250),
(3, 'Video Konferans', 'İş seyahatlerinizi video konferansla değiştirerek büyük karbon tasarrufu sağlayın.', 'high', 'easy', 1000),
(4, 'Duş Süresini Azaltın', 'Duş sürenizi 5 dakika kısaltarak yıllık 100 kg karbon tasarrufu yapabilirsiniz.', 'medium', 'easy', 100),
(5, 'Geri Dönüşüm', 'Düzenli geri dönüşümle yıllık 200 kg karbon azaltabilirsiniz.', 'medium', 'easy', 200);