    <!-- Footer -->
    <footer class="bg-gradient-to-br from-dark via-gray-900 to-dark text-white mt-20">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Hakkımızda -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="bg-gradient-to-br from-primary to-secondary rounded-xl p-2">
                            <i class="fas fa-leaf text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold">EcoCarbon</h3>
                    </div>
                    <p class="text-gray-300 text-sm leading-relaxed">
                        Karbon ayak izinizi hesaplayın, çevreye katkıda bulunun. Sürdürülebilir bir gelecek için birlikte çalışalım.
                    </p>
                    <div class="flex space-x-3">
                        <a href="#" class="w-10 h-10 bg-primary/20 hover:bg-primary rounded-lg flex items-center justify-center transition-all duration-300 transform hover:scale-110">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-primary/20 hover:bg-primary rounded-lg flex items-center justify-center transition-all duration-300 transform hover:scale-110">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-primary/20 hover:bg-primary rounded-lg flex items-center justify-center transition-all duration-300 transform hover:scale-110">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-primary/20 hover:bg-primary rounded-lg flex items-center justify-center transition-all duration-300 transform hover:scale-110">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4 text-accent">Hızlı Linkler</h4>
                    <ul class="space-y-3">
                        <li>
                            <a href="<?php echo SITE_URL; ?>?page=home" class="text-gray-300 hover:text-accent transition-colors duration-300 flex items-center space-x-2">
                                <i class="fas fa-chevron-right text-xs"></i>
                                <span>Ana Sayfa</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo SITE_URL; ?>?page=calculator" class="text-gray-300 hover:text-accent transition-colors duration-300 flex items-center space-x-2">
                                <i class="fas fa-chevron-right text-xs"></i>
                                <span>Karbon Hesaplama</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo SITE_URL; ?>?page=tips" class="text-gray-300 hover:text-accent transition-colors duration-300 flex items-center space-x-2">
                                <i class="fas fa-chevron-right text-xs"></i>
                                <span>Azaltma Önerileri</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo SITE_URL; ?>?page=about" class="text-gray-300 hover:text-accent transition-colors duration-300 flex items-center space-x-2">
                                <i class="fas fa-chevron-right text-xs"></i>
                                <span>Hakkımızda</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4 text-accent">İletişim</h4>
                    <ul class="space-y-3">
                        <li class="flex items-start space-x-3 text-gray-300">
                            <i class="fas fa-map-marker-alt text-accent mt-1"></i>
                            <span>Kayseri, Türkiye</span>
                        </li>
                        <li class="flex items-start space-x-3 text-gray-300">
                            <i class="fas fa-phone text-accent mt-1"></i>
                            <span>+90 (505) 012 99 23</span><br>
                        </li>
                        <li class="flex items-start space-x-3 text-gray-300">
                            <i class="fas fa-envelope text-accent mt-1"></i>
                            <span>info@ecocarbon.com</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 text-center">
                <p class="text-gray-400 text-sm">
                    © 2025 <span class="text-accent font-semibold">EcoCarbon</span>. Tüm hakları saklıdır. 
                    <span class="mx-2">| Bu Site Furkan Boyvat , Metin Görmez , Mustafa Bahar tarafından yapılmıştır.
                </p>
            </div>
        </div>
    </footer>

    <button id="scrollToTop" class="fixed bottom-8 right-8 w-12 h-12 bg-gradient-to-r from-primary to-secondary text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110 hidden z-50">
        <i class="fas fa-arrow-up"></i>
    </button>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
