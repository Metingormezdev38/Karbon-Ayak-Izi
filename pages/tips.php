<?php
/**
 * Öneriler Sayfası
 */
$page_title = "Azaltma Önerileri";

// Veritabanından önerileri çek
$database = new Database();
$db = $database->getConnection();

$query = "SELECT rt.*, cc.name as category_name, cc.icon as category_icon, cc.color as category_color
          FROM reduction_tips rt
          LEFT JOIN calculation_categories cc ON rt.category_id = cc.id
          WHERE rt.is_active = 1
          ORDER BY rt.impact_level DESC, rt.estimated_reduction_kg DESC";

$stmt = $db->prepare($query);
$stmt->execute();
$tips = $stmt->fetchAll();
?>

<section class="py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <!-- Page Header -->
        <div class="text-center mb-12" data-aos="fade-up">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                <i class="fas fa-lightbulb text-yellow-500 mr-3"></i>
                Karbon Azaltma Önerileri
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Karbon ayak izinizi azaltmak için uygulanabilir önerilerimizi keşfedin
            </p>
        </div>

        <!-- Filter Buttons -->
        <div class="flex flex-wrap justify-center gap-3 mb-12" data-aos="fade-up">
            <button class="filter-btn active px-6 py-2 bg-primary text-white rounded-full font-medium transition-all duration-300" data-filter="all">
                Tümü
            </button>
            <button class="filter-btn px-6 py-2 bg-white text-gray-700 rounded-full font-medium border-2 border-gray-200 hover:border-primary transition-all duration-300" data-filter="high">
                Yüksek Etki
            </button>
            <button class="filter-btn px-6 py-2 bg-white text-gray-700 rounded-full font-medium border-2 border-gray-200 hover:border-primary transition-all duration-300" data-filter="easy">
                Kolay
            </button>
        </div>

        <!-- Tips Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach($tips as $tip): 
                $impactClass = $tip['impact_level'] === 'high' ? 'badge-danger' : 
                              ($tip['impact_level'] === 'medium' ? 'badge-warning' : 'badge-success');
                $difficultyClass = $tip['difficulty'] === 'hard' ? 'badge-danger' : 
                                  ($tip['difficulty'] === 'moderate' ? 'badge-warning' : 'badge-success');
            ?>
            <div class="tip-card bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" 
                 data-impact="<?php echo $tip['impact_level']; ?>" 
                 data-difficulty="<?php echo $tip['difficulty']; ?>"
                 data-aos="fade-up">
                
                <div class="h-48 bg-gradient-to-br from-primary/20 to-secondary/20 flex items-center justify-center">
                    <i class="<?php echo $tip['category_icon']; ?> text-6xl" style="color: <?php echo $tip['category_color']; ?>"></i>
                </div>
                
                <div class="p-6">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="badge-custom <?php echo $impactClass; ?>">
                            <?php echo $tip['impact_level'] === 'high' ? 'Yüksek Etki' : 
                                      ($tip['impact_level'] === 'medium' ? 'Orta Etki' : 'Düşük Etki'); ?>
                        </span>
                        <span class="badge-custom <?php echo $difficultyClass; ?>">
                            <?php echo $tip['difficulty'] === 'hard' ? 'Zor' : 
                                      ($tip['difficulty'] === 'moderate' ? 'Orta' : 'Kolay'); ?>
                        </span>
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-900 mb-3"><?php echo htmlspecialchars($tip['title']); ?></h3>
                    <p class="text-gray-600 mb-4 leading-relaxed"><?php echo htmlspecialchars($tip['description']); ?></p>
                    
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <div class="flex items-center text-primary">
                            <i class="fas fa-leaf mr-2"></i>
                            <span class="font-bold"><?php echo number_format($tip['estimated_reduction_kg'], 0); ?> kg/yıl</span>
                        </div>
                        <span class="text-sm text-gray-500">
                            <i class="fas fa-tag mr-1"></i><?php echo htmlspecialchars($tip['category_name']); ?>
                        </span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- CTA Section -->
        <div class="mt-16 bg-gradient-to-r from-primary to-secondary rounded-3xl p-12 text-white text-center" data-aos="zoom-in">
            <h2 class="text-3xl font-bold mb-4">Önerilerimizi Uygulayın!</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Bu önerileri uygulayarak yılda binlerce kilogram karbon tasarrufu yapabilirsiniz.
            </p>
            <a href="?page=calculator" class="inline-flex items-center bg-white text-primary px-8 py-4 rounded-lg font-bold text-lg hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-xl">
                <i class="fas fa-calculator mr-3"></i>
                Karbon Ayak İzinizi Ölçün
            </a>
        </div>
    </div>
</section>

<script>
$(document).ready(function() {
    // Filter functionality
    $('.filter-btn').on('click', function() {
        $('.filter-btn').removeClass('active bg-primary text-white').addClass('bg-white text-gray-700');
        $(this).addClass('active bg-primary text-white').removeClass('bg-white text-gray-700');
        
        const filter = $(this).data('filter');
        
        $('.tip-card').each(function() {
            if (filter === 'all') {
                $(this).fadeIn();
            } else if (filter === 'high') {
                if ($(this).data('impact') === 'high') {
                    $(this).fadeIn();
                } else {
                    $(this).fadeOut();
                }
            } else if (filter === 'easy') {
                if ($(this).data('difficulty') === 'easy') {
                    $(this).fadeIn();
                } else {
                    $(this).fadeOut();
                }
            }
        });
    });
});
</script>
