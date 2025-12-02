    <!-- Top Navigation Bar -->
    <nav class="bg-white shadow-md sticky top-0 z-40">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <a href="<?php echo SITE_URL; ?>" class="flex items-center space-x-3 group">
                    <div class="bg-gradient-to-br from-primary to-secondary rounded-xl p-2 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-leaf text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">
                            EcoCarbon
                        </h1>
                        <p class="text-xs text-gray-500">Karbon Ayak İzi Hesaplama</p>
                    </div>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden lg:flex items-center space-x-8">
                    <a href="<?php echo SITE_URL; ?>?page=home" class="nav-link text-gray-700 hover:text-primary font-medium transition-colors duration-300">
                        <i class="fas fa-home mr-2"></i>Ana Sayfa
                    </a>
                    <a href="<?php echo SITE_URL; ?>?page=calculator" class="nav-link text-gray-700 hover:text-primary font-medium transition-colors duration-300">
                        <i class="fas fa-calculator mr-2"></i>Hesapla
                    </a>
                    <a href="<?php echo SITE_URL; ?>?page=tips" class="nav-link text-gray-700 hover:text-primary font-medium transition-colors duration-300">
                        <i class="fas fa-lightbulb mr-2"></i>Öneriler
                    </a>
                    <a href="<?php echo SITE_URL; ?>?page=about" class="nav-link text-gray-700 hover:text-primary font-medium transition-colors duration-300">
                        <i class="fas fa-info-circle mr-2"></i>Hakkımızda
                    </a>
                </div>

                <!-- Auth Buttons -->
                <div class="hidden lg:flex items-center space-x-4">
                    <?php if(isLoggedIn()): ?>
                        <div class="flex items-center space-x-3">
                            <!-- Profile Dropdown -->
                            <div class="relative group">
                                <button class="flex items-center space-x-3 px-4 py-2 bg-gradient-to-r from-primary/10 to-secondary/10 hover:from-primary/20 hover:to-secondary/20 rounded-full transition-all duration-300 border-2 border-primary/20">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-white font-bold text-lg">
                                        <?php echo strtoupper(substr(getFullName(), 0, 1)); ?>
                                    </div>
                                    <div class="text-left">
                                        <div class="text-sm font-bold text-gray-800"><?php echo htmlspecialchars(getFullName()); ?></div>
                                        <div class="text-xs text-gray-500">@<?php echo htmlspecialchars(getUserName()); ?></div>
                                    </div>
                                    <i class="fas fa-chevron-down text-gray-600 text-xs"></i>
                                </button>
                                
                                <!-- Dropdown Menu -->
                                <div class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                                    <div class="p-3 border-b border-gray-100">
                                        <p class="font-bold text-gray-900"><?php echo htmlspecialchars(getFullName()); ?></p>
                                        <p class="text-sm text-gray-500"><?php echo htmlspecialchars($_SESSION['email'] ?? ''); ?></p>
                                    </div>
                                    <div class="py-2">
                                        <a href="<?php echo SITE_URL; ?>?page=dashboard" class="flex items-center px-4 py-3 text-gray-700 hover:bg-primary/10 transition-colors">
                                            <i class="fas fa-tachometer-alt w-5 mr-3 text-primary"></i>
                                            Dashboard
                                        </a>
                                        <a href="<?php echo SITE_URL; ?>?page=profile" class="flex items-center px-4 py-3 text-gray-700 hover:bg-primary/10 transition-colors">
                                            <i class="fas fa-user-edit w-5 mr-3 text-primary"></i>
                                            Profili Düzenle
                                        </a>
                                        <a href="<?php echo SITE_URL; ?>?page=calculator" class="flex items-center px-4 py-3 text-gray-700 hover:bg-primary/10 transition-colors">
                                            <i class="fas fa-calculator w-5 mr-3 text-primary"></i>
                                            Hesaplama Yap
                                        </a>
                                    </div>
                                    <div class="p-2 border-t border-gray-100">
                                        <button onclick="logout()" class="w-full flex items-center px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                            <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                                            Çıkış Yap
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo SITE_URL; ?>?page=login" class="px-5 py-2.5 text-primary border-2 border-primary hover:bg-primary hover:text-white rounded-lg font-medium transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-sign-in-alt mr-2"></i>Giriş Yap
                        </a>
                        <a href="<?php echo SITE_URL; ?>?page=register" class="px-5 py-2.5 bg-gradient-to-r from-primary to-secondary text-white rounded-lg font-medium shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-user-plus mr-2"></i>Kayıt Ol
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="lg:hidden text-gray-700 hover:text-primary focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden lg:hidden bg-white border-t border-gray-200">
            <div class="container mx-auto px-4 py-4 space-y-3">
                <a href="<?php echo SITE_URL; ?>?page=home" class="block px-4 py-3 text-gray-700 hover:bg-primary hover:text-white rounded-lg transition-colors duration-300">
                    <i class="fas fa-home mr-2"></i>Ana Sayfa
                </a>
                <a href="<?php echo SITE_URL; ?>?page=calculator" class="block px-4 py-3 text-gray-700 hover:bg-primary hover:text-white rounded-lg transition-colors duration-300">
                    <i class="fas fa-calculator mr-2"></i>Hesapla
                </a>
                <a href="<?php echo SITE_URL; ?>?page=tips" class="block px-4 py-3 text-gray-700 hover:bg-primary hover:text-white rounded-lg transition-colors duration-300">
                    <i class="fas fa-lightbulb mr-2"></i>Öneriler
                </a>
                <a href="<?php echo SITE_URL; ?>?page=about" class="block px-4 py-3 text-gray-700 hover:bg-primary hover:text-white rounded-lg transition-colors duration-300">
                    <i class="fas fa-info-circle mr-2"></i>Hakkımızda
                </a>
                
                <?php if(isLoggedIn()): ?>
                    <div class="px-4 py-3 bg-gradient-to-r from-primary/10 to-secondary/10 rounded-lg mb-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-white font-bold text-xl">
                                <?php echo strtoupper(substr(getFullName(), 0, 1)); ?>
                            </div>
                            <div>
                                <div class="font-bold text-gray-800"><?php echo htmlspecialchars(getFullName()); ?></div>
                                <div class="text-sm text-gray-600">@<?php echo htmlspecialchars(getUserName()); ?></div>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo SITE_URL; ?>?page=dashboard" class="block px-4 py-3 text-gray-700 hover:bg-primary hover:text-white rounded-lg transition-colors duration-300">
                        <i class="fas fa-tachometer-alt mr-2"></i>Kontrol Paneli
                    </a>
                    <a href="<?php echo SITE_URL; ?>?page=profile" class="block px-4 py-3 text-gray-700 hover:bg-primary hover:text-white rounded-lg transition-colors duration-300">
                        <i class="fas fa-user-edit mr-2"></i>Profili Düzenle
                    </a>
                    <button onclick="logout()" class="w-full text-left px-4 py-3 text-white bg-red-500 hover:bg-red-600 rounded-lg transition-colors duration-300">
                        <i class="fas fa-sign-out-alt mr-2"></i>Çıkış Yap
                    </button>
                <?php else: ?>
                    <a href="<?php echo SITE_URL; ?>?page=login" class="block px-4 py-3 text-center text-primary border-2 border-primary hover:bg-primary hover:text-white rounded-lg transition-colors duration-300">
                        <i class="fas fa-sign-in-alt mr-2"></i>Giriş Yap
                    </a>
                    <a href="<?php echo SITE_URL; ?>?page=register" class="block px-4 py-3 text-center bg-gradient-to-r from-primary to-secondary text-white rounded-lg transition-all duration-300">
                        <i class="fas fa-user-plus mr-2"></i>Kayıt Ol
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
