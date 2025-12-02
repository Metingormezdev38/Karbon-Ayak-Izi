<?php
$page_title = "Karbon Hesaplama";
?>

<section class="py-12 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            <!-- Page Header -->
            <div class="text-center mb-12" data-aos="fade-up">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">
                    <i class="fas fa-calculator text-primary mr-3"></i>
                    Karbon Ayak İzi Hesaplama
                </h1>
                <p class="text-xl text-gray-600">Aylık tüketiminizi girerek karbon ayak izinizi hesaplayın</p>
            </div>

            <!-- Calculator Form -->
            <form id="carbonCalculatorForm">
                <!-- Enerji Tüketimi -->
                <div class="calculator-section" data-aos="fade-up">
                    <h3>
                        <i class="fas fa-bolt"></i>
                        Enerji Tüketimi
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="electricity" class="form-label">
                                <i class="fas fa-plug text-yellow-500 mr-2"></i>Elektrik Tüketimi (kWh/ay)
                            </label>
                            <input 
                                type="number" 
                                id="electricity" 
                                name="electricity" 
                                class="form-control w-full" 
                                placeholder="300"
                                min="0"
                                step="0.01"
                            >
                            <p class="text-xs text-gray-500 mt-1">Ortalama: 200-400 kWh</p>
                        </div>

                        <div>
                            <label for="natural_gas" class="form-label">
                                <i class="fas fa-fire text-orange-500 mr-2"></i>Doğal Gaz (m³/ay)
                            </label>
                            <input 
                                type="number" 
                                id="natural_gas" 
                                name="natural_gas" 
                                class="form-control w-full" 
                                placeholder="50"
                                min="0"
                                step="0.01"
                            >
                            <p class="text-xs text-gray-500 mt-1">Ortalama: 30-80 m³</p>
                        </div>
                    </div>
                </div>

                <!-- Ulaşım -->
                <div class="calculator-section" data-aos="fade-up" data-aos-delay="100">
                    <h3>
                        <i class="fas fa-car"></i>
                        Ulaşım
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="fuel" class="form-label">
                                <i class="fas fa-gas-pump text-blue-500 mr-2"></i>Yakıt Tüketimi (Litre/ay)
                            </label>
                            <input 
                                type="number" 
                                id="fuel" 
                                name="fuel" 
                                class="form-control w-full" 
                                placeholder="100"
                                min="0"
                                step="0.01"
                            >
                            <p class="text-xs text-gray-500 mt-1">Benzin veya dizel</p>
                        </div>

                        <div>
                            <label for="distance" class="form-label">
                                <i class="fas fa-road text-gray-500 mr-2"></i>Toplu Taşıma (km/ay)
                            </label>
                            <input 
                                type="number" 
                                id="distance" 
                                name="distance" 
                                class="form-control w-full" 
                                placeholder="200"
                                min="0"
                                step="0.01"
                            >
                            <p class="text-xs text-gray-500 mt-1">Otobüs, metro, tramvay</p>
                        </div>
                    </div>
                </div>

                <!-- Hava Yolu -->
                <div class="calculator-section" data-aos="fade-up" data-aos-delay="200">
                    <h3>
                        <i class="fas fa-plane"></i>
                        Hava Yolu Seyahatleri
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="flight_km" class="form-label">
                                <i class="fas fa-plane-departure text-purple-500 mr-2"></i>Uçuş Mesafesi (km/ay)
                            </label>
                            <input 
                                type="number" 
                                id="flight_km" 
                                name="flight_km" 
                                class="form-control w-full" 
                                placeholder="1000"
                                min="0"
                                step="0.01"
                            >
                            <p class="text-xs text-gray-500 mt-1">Ortalama aylık uçuş mesafesi</p>
                        </div>
                    </div>
                </div>

                <!-- Su ve Atık -->
                <div class="calculator-section" data-aos="fade-up" data-aos-delay="300">
                    <h3>
                        <i class="fas fa-droplet"></i>
                        Su ve Atık Yönetimi
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="water" class="form-label">
                                <i class="fas fa-water text-cyan-500 mr-2"></i>Su Tüketimi (m³/ay)
                            </label>
                            <input 
                                type="number" 
                                id="water" 
                                name="water" 
                                class="form-control w-full" 
                                placeholder="10"
                                min="0"
                                step="0.01"
                            >
                            <p class="text-xs text-gray-500 mt-1">Ortalama: 8-15 m³</p>
                        </div>

                        <div>
                            <label for="waste" class="form-label">
                                <i class="fas fa-trash text-green-500 mr-2"></i>Atık Üretimi (kg/ay)
                            </label>
                            <input 
                                type="number" 
                                id="waste" 
                                name="waste" 
                                class="form-control w-full" 
                                placeholder="50"
                                min="0"
                                step="0.01"
                            >
                            <p class="text-xs text-gray-500 mt-1">Geri dönüşüme gitmeyenler</p>
                        </div>

                        <div>
                            <label for="recycling" class="form-label">
                                <i class="fas fa-recycle text-green-600 mr-2"></i>Geri Dönüşüm (kg/ay)
                            </label>
                            <input 
                                type="number" 
                                id="recycling" 
                                name="recycling" 
                                class="form-control w-full" 
                                placeholder="20"
                                min="0"
                                step="0.01"
                            >
                            <p class="text-xs text-gray-500 mt-1">Geri dönüşüme giden atık</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-center mt-8" data-aos="fade-up" data-aos-delay="400">
                    <button type="submit" id="calculateBtn" class="btn-primary px-12 py-4 text-lg">
                        <i class="fas fa-calculator mr-2"></i>
                        Hesapla
                    </button>
                </div>
            </form>

            <!-- Results Section -->
            <div id="resultsSection" class="mt-12 hidden" data-aos="fade-up">
                <div class="bg-gradient-to-br from-primary to-secondary rounded-3xl p-8 text-white shadow-2xl">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold mb-2">Aylık Karbon Ayak İziniz</h2>
                        <p class="text-white/80">CO2 Salınımı</p>
                    </div>
                    
                    <div class="text-center mb-8">
                        <div class="inline-block bg-white/20 rounded-2xl px-8 py-6 backdrop-blur-sm">
                            <h3 id="totalCarbon" class="text-6xl font-bold mb-2">0 kg</h3>
                            <p class="text-white/90">CO2</p>
                        </div>
                    </div>

                    <!-- Category Breakdown -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                        <div class="bg-white/10 rounded-xl p-4 backdrop-blur-sm text-center">
                            <i class="fas fa-bolt text-3xl mb-2"></i>
                            <p class="text-sm mb-1">Enerji</p>
                            <p id="energyCarbon" class="text-xl font-bold">0 kg</p>
                        </div>
                        <div class="bg-white/10 rounded-xl p-4 backdrop-blur-sm text-center">
                            <i class="fas fa-car text-3xl mb-2"></i>
                            <p class="text-sm mb-1">Ulaşım</p>
                            <p id="transportCarbon" class="text-xl font-bold">0 kg</p>
                        </div>
                        <div class="bg-white/10 rounded-xl p-4 backdrop-blur-sm text-center">
                            <i class="fas fa-plane text-3xl mb-2"></i>
                            <p class="text-sm mb-1">Uçuş</p>
                            <p id="flightCarbon" class="text-xl font-bold">0 kg</p>
                        </div>
                        <div class="bg-white/10 rounded-xl p-4 backdrop-blur-sm text-center">
                            <i class="fas fa-droplet text-3xl mb-2"></i>
                            <p class="text-sm mb-1">Su & Atık</p>
                            <p id="waterCarbon" class="text-xl font-bold">0 kg</p>
                        </div>
                    </div>

                    <!-- Chart -->
                    <div class="bg-white/10 rounded-2xl p-6 backdrop-blur-sm">
                        <canvas id="carbonChart" height="200"></canvas>
                    </div>

                    <!-- Actions -->
                    <?php if(isLoggedIn()): ?>
                    <div class="flex justify-center gap-4 mt-8">
                        <button id="saveCalculation" class="bg-white text-primary px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-300">
                            <i class="fas fa-clock mr-2"></i>Otomatik Kaydediliyor...
                        </button>
                        <a href="?page=dashboard" class="bg-white/20 text-white px-6 py-3 rounded-lg font-semibold hover:bg-white/30 transition-all duration-300 inline-block">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard'a Git
                        </a>
                        <button onclick="window.location.href='?page=tips'" class="bg-white/20 text-white px-6 py-3 rounded-lg font-semibold hover:bg-white/30 transition-all duration-300">
                            <i class="fas fa-lightbulb mr-2"></i>Öneriler
                        </button>
                    </div>
                    <?php else: ?>
                    <div class="text-center mt-8">
                        <p class="mb-4">Hesaplamalarınızı kaydetmek için giriş yapın</p>
                        <a href="?page=login" class="bg-white text-primary px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-300 inline-block">
                            <i class="fas fa-sign-in-alt mr-2"></i>Giriş Yap
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
let carbonChart = null;

$(document).ready(function() {
    $('#carbonCalculatorForm').on('submit', function(e) {
        e.preventDefault();
        
        const electricity = parseFloat($('#electricity').val()) || 0;
        const naturalGas = parseFloat($('#natural_gas').val()) || 0;
        const fuel = parseFloat($('#fuel').val()) || 0;
        const distance = parseFloat($('#distance').val()) || 0;
        const flightKm = parseFloat($('#flight_km').val()) || 0;
        const water = parseFloat($('#water').val()) || 0;
        const waste = parseFloat($('#waste').val()) || 0;
        const recycling = parseFloat($('#recycling').val()) || 0;

        const factors = {
            electricity: 0.82,
            naturalGas: 2.03,
            fuel: 2.31,
            distance: 0.12,
            flight: 0.255,
            water: 0.344,
            waste: 0.5,
            recycling: -0.3
        };
        
        // Calculate
        const energyCarbon = (electricity * factors.electricity) + (naturalGas * factors.naturalGas);
        const transportCarbon = (fuel * factors.fuel) + (distance * factors.distance);
        const flightCarbon = flightKm * factors.flight;
        const waterCarbon = (water * factors.water) + (waste * factors.waste) + (recycling * factors.recycling);
        const total = energyCarbon + transportCarbon + flightCarbon + waterCarbon;
        
        // Display results
        $('#totalCarbon').text(formatNumber(total) + ' kg');
        $('#energyCarbon').text(formatNumber(energyCarbon) + ' kg');
        $('#transportCarbon').text(formatNumber(transportCarbon) + ' kg');
        $('#flightCarbon').text(formatNumber(flightCarbon) + ' kg');
        $('#waterCarbon').text(formatNumber(waterCarbon) + ' kg');
        
        // Show results
        $('#resultsSection').removeClass('hidden').hide().fadeIn();
        
        // Scroll to results
        $('html, body').animate({
            scrollTop: $('#resultsSection').offset().top - 100
        }, 600);
        
        // Create chart
        if (carbonChart) {
            carbonChart.destroy();
        }
        
        carbonChart = createChart('carbonChart', 'doughnut', 
            ['Enerji', 'Ulaşım', 'Uçuş', 'Su & Atık'],
            [{
                data: [energyCarbon, transportCarbon, flightCarbon, waterCarbon],
                backgroundColor: [
                    chartColors.warning,
                    chartColors.info,
                    chartColors.purple,
                    chartColors.accent
                ],
                borderWidth: 0
            }]
        );
        
        // Store data for saving
        window.calculationData = {
            electricity, naturalGas, fuel, distance, flightKm, water, waste, recycling, total
        };
        
        // Otomatik kaydet (giriş yapmış kullanıcılar için)
        <?php if(isLoggedIn()): ?>
        autoSaveCalculation();
        <?php endif; ?>
    });
    
    // Otomatik kaydetme fonksiyonu
    function autoSaveCalculation() {
        if (!window.calculationData) return;
        
        console.log('💾 Hesaplama otomatik kaydediliyor...');
        console.log('Data:', window.calculationData);
        
        const saveBtn = $('#saveCalculation');
        saveBtn.html('<i class="fas fa-spinner fa-spin mr-2"></i>Kaydediliyor...').prop('disabled', true);
        
        $.ajax({
            url: 'ajax/save_calculation.php',
            type: 'POST',
            dataType: 'json',
            data: window.calculationData,
            beforeSend: function() {
                console.log('📤 AJAX isteği gönderiliyor...');
            },
            success: function(response) {
                console.log('✅ AJAX başarılı:', response);
                if (response.success) {
                    saveBtn.html('<i class="fas fa-check mr-2"></i>Kaydedildi')
                           .removeClass('bg-white text-primary hover:bg-gray-100')
                           .addClass('bg-green-500 text-white');
                    
                    // Başarı mesajı göster
                    if (typeof showAlert !== 'undefined') {
                        showAlert('Hesaplama başarıyla kaydedildi!', 'success');
                    }
                } else {
                    console.error('Kaydetme başarısız:', response.message);
                    saveBtn.html('<i class="fas fa-exclamation-triangle mr-2"></i>Hata')
                           .removeClass('bg-white text-primary')
                           .addClass('bg-red-500 text-white');
                }
            },
            error: function(xhr, status, error) {
                console.error('❌ AJAX hatası:', {
                    status: status,
                    error: error,
                    response: xhr.responseText,
                    statusCode: xhr.status
                });
                saveBtn.html('<i class="fas fa-exclamation-triangle mr-2"></i>Kayıt Hatası')
                       .removeClass('bg-white text-primary')
                       .addClass('bg-red-500 text-white')
                       .prop('disabled', false);
            }
        });
    }
    
    // Manuel kaydetme (butona tıklanınca - zaten otomatik kaydoluyor ama buton da çalışsın)
    $('#saveCalculation').on('click', function() {
        if (!window.calculationData) {
            showAlert('Önce hesaplama yapın!', 'warning');
            return;
        }
        
        // Eğer daha önce kaydedilmemişse kaydet
        if ($(this).text().includes('Kaydet')) {
            autoSaveCalculation();
        }
    });
});
</script>
