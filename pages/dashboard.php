<?php
/**
 * Dashboard Sayfası - Kullanıcıya Özel
 */
$page_title = "Kontrol Paneli";

// Session kontrolü
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Giriş kontrolü
if (!isLoggedIn()) {
    header("Location: ?page=login");
    exit();
}

// Veritabanı bağlantısı
$database = new Database();
$db = $database->getConnection();
$userId = getUserId();

// Kullanıcı bilgilerini çek
$userQuery = "SELECT * FROM users WHERE id = :user_id LIMIT 1";
$stmt = $db->prepare($userQuery);
$stmt->bindParam(':user_id', $userId);
$stmt->execute();
$userInfo = $stmt->fetch();

// Genel istatistikler
$statsQuery = "SELECT 
    COUNT(*) as total_calculations,
    COALESCE(SUM(total_carbon_kg), 0) as total_carbon,
    COALESCE(AVG(total_carbon_kg), 0) as avg_carbon,
    COALESCE(MIN(total_carbon_kg), 0) as min_carbon,
    COALESCE(MAX(total_carbon_kg), 0) as max_carbon
FROM carbon_calculations 
WHERE user_id = :user_id";

$stmt = $db->prepare($statsQuery);
$stmt->bindParam(':user_id', $userId);
$stmt->execute();
$stats = $stmt->fetch();

// Null kontrolü
$stats['total_calculations'] = $stats['total_calculations'] ?? 0;
$stats['total_carbon'] = $stats['total_carbon'] ?? 0;
$stats['avg_carbon'] = $stats['avg_carbon'] ?? 0;
$stats['min_carbon'] = $stats['min_carbon'] ?? 0;
$stats['max_carbon'] = $stats['max_carbon'] ?? 0;

// Bu ayki istatistikler
$thisMonthQuery = "SELECT 
    COALESCE(SUM(total_carbon_kg), 0) as month_total,
    COUNT(*) as month_calculations
FROM carbon_calculations 
WHERE user_id = :user_id 
AND MONTH(calculation_date) = MONTH(CURDATE())
AND YEAR(calculation_date) = YEAR(CURDATE())";

$stmt = $db->prepare($thisMonthQuery);
$stmt->bindParam(':user_id', $userId);
$stmt->execute();
$thisMonth = $stmt->fetch();
$thisMonth['month_total'] = $thisMonth['month_total'] ?? 0;
$thisMonth['month_calculations'] = $thisMonth['month_calculations'] ?? 0;

// Geçen ayki istatistikler (karşılaştırma için)
$lastMonthQuery = "SELECT 
    COALESCE(SUM(total_carbon_kg), 0) as month_total
FROM carbon_calculations 
WHERE user_id = :user_id 
AND MONTH(calculation_date) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))
AND YEAR(calculation_date) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))";

$stmt = $db->prepare($lastMonthQuery);
$stmt->bindParam(':user_id', $userId);
$stmt->execute();
$lastMonth = $stmt->fetch();
$lastMonth['month_total'] = $lastMonth['month_total'] ?? 0;

// Değişim yüzdesi
$carbonChange = 0;
if ($lastMonth['month_total'] > 0) {
    $carbonChange = (($thisMonth['month_total'] - $lastMonth['month_total']) / $lastMonth['month_total']) * 100;
}

// Son hesaplamaları çek
$recentQuery = "SELECT * FROM carbon_calculations 
WHERE user_id = :user_id 
ORDER BY created_at DESC 
LIMIT 5";

$stmt = $db->prepare($recentQuery);
$stmt->bindParam(':user_id', $userId);
$stmt->execute();
$recentCalculations = $stmt->fetchAll();

// Aylık trend verileri (son 6 ay)
$trendQuery = "SELECT 
    DATE_FORMAT(calculation_date, '%Y-%m') as month,
    SUM(total_carbon_kg) as total,
    AVG(total_carbon_kg) as average
FROM carbon_calculations 
WHERE user_id = :user_id 
AND calculation_date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
GROUP BY month
ORDER BY month ASC";

$stmt = $db->prepare($trendQuery);
$stmt->bindParam(':user_id', $userId);
$stmt->execute();
$trendData = $stmt->fetchAll();

// Kategori bazlı dağılım
$categoryQuery = "SELECT 
    SUM(electricity_usage * 0.82) as energy_carbon,
    SUM(natural_gas_usage * 2.03) as gas_carbon,
    SUM(fuel_consumption * 2.31) as transport_carbon,
    SUM(flight_km * 0.255) as flight_carbon,
    SUM((water_usage * 0.344) + (waste_kg * 0.5) + (recycling_kg * -0.3)) as water_waste_carbon
FROM carbon_calculations 
WHERE user_id = :user_id";

$stmt = $db->prepare($categoryQuery);
$stmt->bindParam(':user_id', $userId);
$stmt->execute();
$categoryData = $stmt->fetch();

// Null kontrolü
$categoryData['energy_carbon'] = $categoryData['energy_carbon'] ?? 0;
$categoryData['gas_carbon'] = $categoryData['gas_carbon'] ?? 0;
$categoryData['transport_carbon'] = $categoryData['transport_carbon'] ?? 0;
$categoryData['flight_carbon'] = $categoryData['flight_carbon'] ?? 0;
$categoryData['water_waste_carbon'] = $categoryData['water_waste_carbon'] ?? 0;

// Rastgele öneri çek
$tipQuery = "SELECT rt.*, cc.name as category_name 
FROM reduction_tips rt
LEFT JOIN calculation_categories cc ON rt.category_id = cc.id
WHERE rt.is_active = 1
ORDER BY RAND()
LIMIT 1";
$stmt = $db->prepare($tipQuery);
$stmt->execute();
$randomTip = $stmt->fetch();

// Başarılar (basit hesaplama)
$achievements = [];
if ($stats['total_calculations'] >= 1) $achievements[] = ['icon' => 'fa-star', 'title' => 'İlk Adım', 'desc' => 'İlk hesaplamanızı yaptınız'];
if ($stats['total_calculations'] >= 5) $achievements[] = ['icon' => 'fa-fire', 'title' => 'Aktif Kullanıcı', 'desc' => '5 hesaplama tamamladınız'];
if ($stats['total_calculations'] >= 10) $achievements[] = ['icon' => 'fa-gem', 'title' => 'Kararlı', 'desc' => '10 hesaplama yaptınız'];
if ($carbonChange < 0) $achievements[] = ['icon' => 'fa-leaf', 'title' => 'Çevre Dostu', 'desc' => 'Karbon ayak izinizi azalttınız'];
?>

<section class="py-12 bg-gradient-to-br from-gray-50 via-blue-50 to-green-50 min-h-screen">
    <div class="container mx-auto px-4">
        <!-- Kişiselleştirilmiş Karşılama -->
        <div class="mb-8 bg-gradient-to-r from-primary to-secondary rounded-3xl p-8 text-white shadow-2xl" data-aos="fade-down">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="mb-4 md:mb-0">
                    <h1 class="text-4xl md:text-5xl font-bold mb-3">
                        Merhaba, <?php echo htmlspecialchars($userInfo['full_name']); ?>! 👋
                    </h1>
                    <p class="text-white/90 text-lg">
                        <i class="fas fa-calendar-check mr-2"></i>
                        Son giriş: <?php echo $userInfo['last_login'] ? formatDateTime($userInfo['last_login']) : 'İlk girişiniz'; ?>
                    </p>
                </div>
                <div class="text-center">
                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-6">
                        <p class="text-white/80 text-sm mb-1">Bu Ay</p>
                        <p class="text-4xl font-bold"><?php echo number_format(floatval($thisMonth['month_total'] ?? 0), 0); ?> <span class="text-xl">kg</span></p>
                        <p class="text-white/90 text-sm mt-1">CO2 Salınımı</p>
                        <?php if ($carbonChange != 0): ?>
                        <div class="mt-2">
                            <span class="<?php echo $carbonChange < 0 ? 'bg-green-500' : 'bg-red-500'; ?> text-white text-xs px-3 py-1 rounded-full">
                                <i class="fas fa-<?php echo $carbonChange < 0 ? 'arrow-down' : 'arrow-up'; ?> mr-1"></i>
                                <?php echo abs(number_format(floatval($carbonChange ?? 0), 1)); ?>%
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gelişmiş İstatistik Kartları -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="stat-card group hover:scale-105" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-icon bg-gradient-to-br from-blue-500 to-blue-600 text-white group-hover:scale-110 transition-transform">
                    <i class="fas fa-calculator"></i>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Toplam Hesaplama</h3>
                <p class="text-3xl font-bold text-gray-900 mb-2"><?php echo $stats['total_calculations']; ?></p>
                <p class="text-xs text-gray-500">
                    <i class="fas fa-chart-line mr-1"></i>
                    Bu ay: <?php echo $thisMonth['month_calculations']; ?>
                </p>
            </div>

            <div class="stat-card group hover:scale-105" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-icon bg-gradient-to-br from-green-500 to-green-600 text-white group-hover:scale-110 transition-transform">
                    <i class="fas fa-leaf"></i>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Toplam Karbon</h3>
                <p class="text-3xl font-bold text-gray-900 mb-2">
                    <?php echo number_format(floatval($stats['total_carbon'] ?? 0), 0, ',', '.'); ?> <span class="text-lg">kg</span>
                </p>
                <p class="text-xs text-gray-500">
                    <i class="fas fa-tree mr-1"></i>
                    <?php echo number_format(floatval($stats['total_carbon'] ?? 0) / 21, 0); ?> ağaç etkisi
                </p>
            </div>

            <div class="stat-card group hover:scale-105" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-icon bg-gradient-to-br from-yellow-500 to-orange-600 text-white group-hover:scale-110 transition-transform">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">Ortalama/Hesaplama</h3>
                <p class="text-3xl font-bold text-gray-900 mb-2">
                    <?php echo number_format(floatval($stats['avg_carbon'] ?? 0), 0, ',', '.'); ?> <span class="text-lg">kg</span>
                </p>
                <p class="text-xs text-gray-500">
                    <i class="fas fa-<?php echo $stats['avg_carbon'] < 500 ? 'smile' : 'meh'; ?> mr-1"></i>
                    <?php echo $stats['avg_carbon'] < 500 ? 'Harika!' : 'İyileştirilebilir'; ?>
                </p>
            </div>

            <div class="stat-card group hover:scale-105" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-icon bg-gradient-to-br from-purple-500 to-pink-600 text-white group-hover:scale-110 transition-transform">
                    <i class="fas fa-trophy"></i>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1">En İyi Performans</h3>
                <p class="text-3xl font-bold text-gray-900 mb-2">
                    <?php echo number_format(floatval($stats['min_carbon'] ?? 0), 0, ',', '.'); ?> <span class="text-lg">kg</span>
                </p>
                <p class="text-xs text-gray-500">
                    <i class="fas fa-star mr-1"></i>
                    Rekor: <?php echo number_format(floatval($stats['max_carbon'] ?? 0), 0); ?> kg
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Ana İçerik -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Karbon Kategorileri Dağılımı -->
                <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-up">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">
                        <i class="fas fa-chart-pie text-primary mr-2"></i>
                        Karbon Kaynaklarınız
                    </h2>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <?php 
                        $categories = [
                            ['name' => 'Enerji', 'value' => floatval($categoryData['energy_carbon'] ?? 0) + floatval($categoryData['gas_carbon'] ?? 0), 'icon' => 'fa-bolt', 'color' => 'from-yellow-500 to-orange-500'],
                            ['name' => 'Ulaşım', 'value' => floatval($categoryData['transport_carbon'] ?? 0), 'icon' => 'fa-car', 'color' => 'from-blue-500 to-cyan-500'],
                            ['name' => 'Uçuş', 'value' => floatval($categoryData['flight_carbon'] ?? 0), 'icon' => 'fa-plane', 'color' => 'from-purple-500 to-pink-500'],
                            ['name' => 'Su & Atık', 'value' => floatval($categoryData['water_waste_carbon'] ?? 0), 'icon' => 'fa-droplet', 'color' => 'from-cyan-500 to-teal-500']
                        ];
                        $total_category = array_sum(array_column($categories, 'value'));
                        foreach($categories as $cat): 
                            $catValue = floatval($cat['value'] ?? 0);
                            $percentage = $total_category > 0 ? ($catValue / $total_category) * 100 : 0;
                        ?>
                        <div class="bg-gradient-to-br <?php echo $cat['color']; ?> rounded-xl p-4 text-white">
                            <div class="flex items-center justify-between mb-2">
                                <i class="fas <?php echo $cat['icon']; ?> text-2xl"></i>
                                <span class="text-sm font-bold"><?php echo number_format($percentage, 0); ?>%</span>
                            </div>
                            <h4 class="font-bold text-sm mb-1"><?php echo $cat['name']; ?></h4>
                            <p class="text-2xl font-bold"><?php echo number_format($catValue, 0); ?> kg</p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>

                <!-- Trend Grafiği -->
                <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-up">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">
                            <i class="fas fa-chart-area text-primary mr-2"></i>
                            6 Aylık Karbon Trendi
                        </h2>
                        <div class="flex gap-2">
                            <button class="px-4 py-2 bg-primary/10 text-primary rounded-lg text-sm font-medium">
                                6 Ay
                            </button>
                            <button class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm font-medium">
                                12 Ay
                            </button>
                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>

                <!-- Son Hesaplamalar -->
                <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-up">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">
                            <i class="fas fa-history text-primary mr-2"></i>
                            Son Hesaplamalar
                        </h2>
                        <a href="?page=calculator" class="text-primary hover:text-secondary font-medium transition-colors">
                            Yeni Hesapla <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>

                    <?php if (count($recentCalculations) > 0): ?>
                    <div class="space-y-3">
                        <?php foreach($recentCalculations as $index => $calc): ?>
                        <div class="border-2 border-gray-200 rounded-xl p-4 hover:border-primary hover:shadow-lg transition-all duration-300 cursor-pointer" data-aos="fade-right" data-aos-delay="<?php echo $index * 50; ?>">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <span class="text-sm text-gray-500">
                                        <i class="fas fa-calendar mr-1"></i>
                                        <?php echo formatDate($calc['calculation_date']); ?>
                                    </span>
                                    <p class="text-xs text-gray-400 mt-1">
                                        <?php echo formatDateTime($calc['created_at']); ?>
                                    </p>
                                </div>
                                <span class="badge-custom <?php echo $calc['total_carbon_kg'] < 300 ? 'badge-success' : ($calc['total_carbon_kg'] < 600 ? 'badge-warning' : 'badge-danger'); ?>">
                                    <i class="fas fa-leaf mr-1"></i>
                                    <?php echo number_format(floatval($calc['total_carbon_kg'] ?? 0), 1, ',', '.'); ?> kg CO2
                                </span>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                                <div class="flex items-center">
                                    <i class="fas fa-bolt text-yellow-500 mr-2"></i>
                                    <span><strong><?php echo $calc['electricity_usage']; ?></strong> kWh</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-gas-pump text-blue-500 mr-2"></i>
                                    <span><strong><?php echo $calc['fuel_consumption']; ?></strong> L</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-plane text-purple-500 mr-2"></i>
                                    <span><strong><?php echo $calc['flight_km']; ?></strong> km</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-droplet text-cyan-500 mr-2"></i>
                                    <span><strong><?php echo $calc['water_usage']; ?></strong> m³</span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-16 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl">
                        <div class="w-24 h-24 bg-gradient-to-br from-primary/20 to-secondary/20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-calculator text-primary text-4xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Henüz Hesaplama Yapmadınız</h3>
                        <p class="text-gray-600 mb-6">Karbon ayak izinizi ölçmek için ilk hesaplamanızı yapın</p>
                        <a href="?page=calculator" class="btn-primary inline-flex items-center">
                            <i class="fas fa-plus mr-2"></i>İlk Hesaplamanızı Yapın
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Yan Panel -->
            <div class="space-y-6">
                <!-- Profil Özeti -->
                <div class="bg-gradient-to-br from-primary to-secondary rounded-2xl shadow-xl p-6 text-white" data-aos="fade-left">
                    <div class="text-center mb-6">
                        <div class="w-24 h-24 bg-white/20 backdrop-blur-sm rounded-full mx-auto mb-4 flex items-center justify-center">
                            <i class="fas fa-user text-5xl"></i>
                        </div>
                        <h3 class="text-xl font-bold"><?php echo htmlspecialchars($userInfo['full_name']); ?></h3>
                        <p class="text-white/80 text-sm">@<?php echo htmlspecialchars($userInfo['username']); ?></p>
                        <p class="text-white/70 text-xs mt-2">
                            <i class="fas fa-envelope mr-1"></i><?php echo htmlspecialchars($userInfo['email']); ?>
                        </p>
                    </div>
                    <div class="space-y-3">
                        <a href="?page=profile" class="block bg-white/20 hover:bg-white/30 rounded-lg p-3 transition-all duration-300 text-center">
                            <i class="fas fa-user-edit mr-2"></i>Profili Düzenle
                        </a>
                        <a href="?page=calculator" class="block bg-white/20 hover:bg-white/30 rounded-lg p-3 transition-all duration-300 text-center">
                            <i class="fas fa-calculator mr-2"></i>Yeni Hesaplama
                        </a>
                        <a href="?page=tips" class="block bg-white/20 hover:bg-white/30 rounded-lg p-3 transition-all duration-300 text-center">
                            <i class="fas fa-lightbulb mr-2"></i>Öneriler
                        </a>
                    </div>
                </div>

                <!-- Başarılar -->
                <?php if (count($achievements) > 0): ?>
                <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-left" data-aos-delay="100">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">
                        <i class="fas fa-trophy text-yellow-500 mr-2"></i>
                        Başarılarınız
                    </h3>
                    <div class="space-y-3">
                        <?php foreach($achievements as $achievement): ?>
                        <div class="flex items-center gap-3 p-3 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-lg">
                            <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center text-white">
                                <i class="fas <?php echo $achievement['icon']; ?>"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm"><?php echo $achievement['title']; ?></h4>
                                <p class="text-xs text-gray-600"><?php echo $achievement['desc']; ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Günün Önerisi -->
                <?php if ($randomTip): ?>
                <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-left" data-aos-delay="200">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">
                        <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                        Günün Önerisi
                    </h3>
                    <div class="bg-gradient-to-br from-yellow-50 to-green-50 rounded-xl p-4">
                        <div class="flex items-start justify-between mb-3">
                            <span class="badge-custom <?php echo $randomTip['difficulty'] === 'easy' ? 'badge-success' : ($randomTip['difficulty'] === 'moderate' ? 'badge-warning' : 'badge-danger'); ?>">
                                <?php echo $randomTip['difficulty'] === 'easy' ? 'Kolay' : ($randomTip['difficulty'] === 'moderate' ? 'Orta' : 'Zor'); ?>
                            </span>
                            <span class="text-xs text-gray-500">
                                <i class="fas fa-tag mr-1"></i><?php echo $randomTip['category_name']; ?>
                            </span>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2"><?php echo htmlspecialchars($randomTip['title']); ?></h4>
                        <p class="text-sm text-gray-700 mb-3"><?php echo htmlspecialchars($randomTip['description']); ?></p>
                        <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                            <span class="text-sm font-bold text-primary">
                                <i class="fas fa-leaf mr-1"></i>-<?php echo number_format(floatval($randomTip['estimated_reduction_kg'] ?? 0), 0); ?> kg/yıl
                            </span>
                            <a href="?page=tips" class="text-sm text-primary hover:text-secondary font-medium">
                                Tümünü Gör <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- İlerleme Kartı -->
                <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-left" data-aos-delay="300">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">
                        <i class="fas fa-bullseye text-red-500 mr-2"></i>
                        Aylık Hedef
                    </h3>
                    <?php 
                    $monthlyGoal = 500; // kg CO2
                    $progress = min(100, ($thisMonth['month_total'] / $monthlyGoal) * 100);
                    ?>
                    <div class="mb-4">
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Hedef: <?php echo $monthlyGoal; ?> kg</span>
                            <span class="font-bold text-primary"><?php echo number_format(floatval($progress ?? 0), 0); ?>%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" style="width: <?php echo $progress; ?>%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">
                            <?php echo number_format(floatval($thisMonth['month_total'] ?? 0), 0); ?> / <?php echo $monthlyGoal; ?> kg
                        </p>
                    </div>
                    <p class="text-sm text-gray-600">
                        <?php if ($progress < 50): ?>
                            <i class="fas fa-smile text-green-500 mr-1"></i>Harika gidiyorsunuz! Hedefinizin altındasınız.
                        <?php elseif ($progress < 100): ?>
                            <i class="fas fa-meh text-yellow-500 mr-1"></i>İyi bir performans gösteriyorsunuz.
                        <?php else: ?>
                            <i class="fas fa-exclamation-triangle text-red-500 mr-1"></i>Hedefi aştınız. Önerilere göz atın!
                        <?php endif; ?>
                    </p>
                </div>

                <!-- Hızlı İstatistikler -->
                <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-2xl shadow-xl p-6" data-aos="fade-left" data-aos-delay="400">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                        Hızlı Bilgiler
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600"><i class="fas fa-calendar-alt mr-2"></i>Üyelik</span>
                            <span class="font-bold text-gray-900"><?php echo formatDate($userInfo['created_at']); ?></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600"><i class="fas fa-tree mr-2"></i>Ağaç Etkisi</span>
                            <span class="font-bold text-green-600"><?php echo number_format(floatval($stats['total_carbon'] ?? 0) / 21, 0); ?> ağaç</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600"><i class="fas fa-car mr-2"></i>Araba Eşdeğeri</span>
                            <span class="font-bold text-blue-600"><?php echo number_format(floatval($stats['total_carbon'] ?? 0) / 2.3, 0); ?> L yakıt</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600"><i class="fas fa-bolt mr-2"></i>Enerji Eşdeğeri</span>
                            <span class="font-bold text-yellow-600"><?php echo number_format(floatval($stats['total_carbon'] ?? 0) / 0.82, 0); ?> kWh</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function() {
    // Trend Chart
    const trendData = <?php echo json_encode($trendData); ?>;
    const labels = trendData.map(item => {
        const [year, month] = item.month.split('-');
        const monthNames = ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'];
        return monthNames[parseInt(month) - 1];
    });
    const values = trendData.map(item => parseFloat(item.total));
    const averages = trendData.map(item => parseFloat(item.average));
    
    createChart('trendChart', 'line', labels, [
        {
            label: 'Toplam Karbon (kg CO2)',
            data: values,
            borderColor: chartColors.primary,
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            borderWidth: 3,
            tension: 0.4,
            fill: true,
            pointRadius: 6,
            pointHoverRadius: 8,
            pointBackgroundColor: chartColors.primary,
            pointBorderColor: '#fff',
            pointBorderWidth: 2
        },
        {
            label: 'Ortalama (kg CO2)',
            data: averages,
            borderColor: chartColors.accent,
            backgroundColor: 'rgba(52, 211, 153, 0.05)',
            borderWidth: 2,
            borderDash: [5, 5],
            tension: 0.4,
            fill: true,
            pointRadius: 4,
            pointHoverRadius: 6
        }
    ]);

    // Category Chart
    const categoryLabels = ['Enerji', 'Ulaşım', 'Uçuş', 'Su & Atık'];
    const categoryValues = [
        <?php echo $categoryData['energy_carbon'] + $categoryData['gas_carbon']; ?>,
        <?php echo $categoryData['transport_carbon']; ?>,
        <?php echo $categoryData['flight_carbon']; ?>,
        <?php echo $categoryData['water_waste_carbon']; ?>
    ];

    createChart('categoryChart', 'doughnut', categoryLabels, [{
        data: categoryValues,
        backgroundColor: [
            'rgba(251, 146, 60, 0.8)',
            'rgba(59, 130, 246, 0.8)',
            'rgba(168, 85, 247, 0.8)',
            'rgba(6, 182, 212, 0.8)'
        ],
        borderColor: [
            'rgba(251, 146, 60, 1)',
            'rgba(59, 130, 246, 1)',
            'rgba(168, 85, 247, 1)',
            'rgba(6, 182, 212, 1)'
        ],
        borderWidth: 3,
        hoverOffset: 15
    }]);

    // Animasyon sayaçları
    $('.stat-card p.text-3xl').each(function() {
        const $this = $(this);
        const text = $this.text();
        const number = parseInt(text.replace(/[^0-9]/g, ''));
        if (number) {
            animateCounter($this[0], number, 2000);
        }
    });
});
</script>
