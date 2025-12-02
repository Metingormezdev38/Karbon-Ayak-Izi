<?php
/**
 * Ana Sayfa
 */
$page_title = "Ana Sayfa";
?>

<!-- Hero Section -->
<section class="hero-section" data-aos="fade-up">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 leading-tight">
                    Karbon <span class="gradient-text">Ayak İzinizi</span> Hesaplayın
                </h1>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Çevreye verdiğiniz zararı ölçün, azaltma önerileri alın ve sürdürülebilir bir geleceğe katkıda bulunun.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="?page=calculator" class="btn-primary inline-flex items-center">
                        <i class="fas fa-calculator mr-2"></i>
                        Hemen Hesapla
                    </a>
                    <a href="?page=about" class="btn-outline inline-flex items-center">
                        <i class="fas fa-info-circle mr-2"></i>
                        Daha Fazla Bilgi
                    </a>
                </div>
                
                <!-- Stats -->
                <div class="grid grid-cols-3 gap-4 pt-8">
                    <div class="text-center">
                        <h3 class="text-3xl font-bold text-primary">5K+</h3>
                        <p class="text-gray-600 text-sm">Kullanıcı</p>
                    </div>
                    <div class="text-center">
                        <h3 class="text-3xl font-bold text-primary">15K+</h3>
                        <p class="text-gray-600 text-sm">Hesaplama</p>
                    </div>
                    <div class="text-center">
                        <h3 class="text-3xl font-bold text-primary">2M+</h3>
                        <p class="text-gray-600 text-sm">kg CO2 Azaltıldı</p>
                    </div>
                </div>
            </div>
            
            <div class="relative" data-aos="fade-left" data-aos-delay="200">
                <div class="bg-white rounded-3xl shadow-2xl p-8">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Hızlı Hesaplama</h3>
                        <p class="text-gray-600">Ortalama aylık tüketiminizi girin:</p>
                    </div>
                    
                    <form id="quickCalculatorForm" class="space-y-4">
                        <div>
                            <label class="form-label"><i class="fas fa-bolt text-yellow-500 mr-2"></i>Elektrik (kWh)</label>
                            <input type="number" class="form-control w-full" id="quick_electricity" placeholder="Örn: 300" required>
                        </div>
                        <div>
                            <label class="form-label"><i class="fas fa-fire text-orange-500 mr-2"></i>Doğal Gaz (m³)</label>
                            <input type="number" class="form-control w-full" id="quick_gas" placeholder="Örn: 50" required>
                        </div>
                        <div>
                            <label class="form-label"><i class="fas fa-gas-pump text-blue-500 mr-2"></i>Yakıt (Litre)</label>
                            <input type="number" class="form-control w-full" id="quick_fuel" placeholder="Örn: 100" required>
                        </div>
                        
                        <button type="submit" class="w-full btn-primary">
                            <i class="fas fa-calculator mr-2"></i>Hesapla
                        </button>
                    </form>
                    
                    <div id="quickResult" class="mt-6 hidden">
                        <div class="bg-gradient-to-r from-primary/10 to-secondary/10 rounded-xl p-6 text-center">
                            <p class="text-gray-600 mb-2">Aylık Karbon Ayak İziniz</p>
                            <h4 class="text-4xl font-bold text-primary" id="quickResultValue">0 kg</h4>
                            <p class="text-sm text-gray-500 mt-2">CO2 Salınımı</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Neden EcoCarbon?</h2>
            <p class="text-xl text-gray-600">Karbon ayak izinizi azaltmak için ihtiyacınız olan her şey</p>
        </div>
        
        <div class="features-grid">
            <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-icon">
                    <i class="fas fa-calculator"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Detaylı Hesaplama</h3>
                <p class="text-gray-600">Enerji, ulaşım, su ve atık kategorilerinde detaylı karbon ayak izi hesaplaması yapın.</p>
            </div>
            
            <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">İzleme ve Analiz</h3>
                <p class="text-gray-600">Karbon ayak izinizi zaman içinde takip edin ve ilerlemenizi görselleştirin.</p>
            </div>
            
            <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-icon">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Kişiselleştirilmiş Öneriler</h3>
                <p class="text-gray-600">Size özel karbon azaltma önerileri alın ve uygulamaya başlayın.</p>
            </div>
            
            <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Başarılar ve Hedefler</h3>
                <p class="text-gray-600">Hedefler belirleyin, başarılar kazanın ve motivasyonunuzu koruyun.</p>
            </div>
            
            <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Topluluk</h3>
                <p class="text-gray-600">Binlerce kullanıcıyla birlikte sürdürülebilir bir gelecek için çalışın.</p>
            </div>
            
            <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Responsive Tasarım</h3>
                <p class="text-gray-600">Her cihazdan kolayca erişin, hesaplama yapın ve verilerinizi görün.</p>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Nasıl Çalışır?</h2>
            <p class="text-xl text-gray-600">3 basit adımda karbon ayak izinizi azaltmaya başlayın</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                <div class="w-20 h-20 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center text-white text-3xl font-bold mx-auto mb-6 shadow-lg">
                    1
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Hesaplayın</h3>
                <p class="text-gray-600">Enerji, ulaşım ve yaşam tarzınıza dair bilgileri girerek karbon ayak izinizi hesaplayın.</p>
            </div>
            
            <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                <div class="w-20 h-20 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center text-white text-3xl font-bold mx-auto mb-6 shadow-lg">
                    2
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Analiz Edin</h3>
                <p class="text-gray-600">Karbon ayak izinizi kategorilere göre inceleyin ve en çok etki yaratan alanları belirleyin.</p>
            </div>
            
            <div class="text-center" data-aos="fade-up" data-aos-delay="300">
                <div class="w-20 h-20 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center text-white text-3xl font-bold mx-auto mb-6 shadow-lg">
                    3
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Azaltın</h3>
                <p class="text-gray-600">Size özel önerilerimizi uygulayın ve karbon ayak izinizi sürekli olarak azaltın.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-primary to-secondary">
    <div class="container mx-auto px-4 text-center" data-aos="zoom-in">
        <h2 class="text-4xl font-bold text-white mb-6">Bugün Başlayın!</h2>
        <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
            Ücretsiz hesap oluşturun ve çevreye katkıda bulunmaya hemen başlayın.
        </p>
        <a href="?page=register" class="inline-flex items-center px-8 py-4 bg-white text-primary rounded-lg font-bold text-lg hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-xl">
            <i class="fas fa-user-plus mr-3"></i>
            Ücretsiz Kayıt Ol
        </a>
    </div>
</section>

<script>
$(document).ready(function() {
    // Quick Calculator
    $('#quickCalculatorForm').on('submit', function(e) {
        e.preventDefault();
        
        const electricity = parseFloat($('#quick_electricity').val()) || 0;
        const gas = parseFloat($('#quick_gas').val()) || 0;
        const fuel = parseFloat($('#quick_fuel').val()) || 0;
        
        const total = calculateCarbon(electricity, gas, fuel, 0);
        
        $('#quickResultValue').text(formatNumber(total) + ' kg');
        $('#quickResult').removeClass('hidden').hide().fadeIn();
    });
});
</script>
