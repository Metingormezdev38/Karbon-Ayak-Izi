<?php
/**
 * Profil Düzenleme Sayfası
 */
$page_title = "Profil Düzenle";

// Giriş kontrolü
if (!isLoggedIn()) {
    redirect('login');
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
$user = $stmt->fetch();

if (!$user) {
    redirect('login');
}
?>

<section class="py-12 bg-gradient-to-br from-gray-50 via-blue-50 to-green-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-8" data-aos="fade-down">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-bold text-gray-900 mb-2">
                            <i class="fas fa-user-edit text-primary mr-3"></i>Profilimi Düzenle
                        </h1>
                        <p class="text-gray-600">Hesap bilgilerinizi güncelleyin</p>
                    </div>
                    <a href="?page=dashboard" class="px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-medium transition-all duration-300">
                        <i class="fas fa-arrow-left mr-2"></i>Geri Dön
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Sol Panel - Profil Kartı -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-xl p-6 sticky top-24" data-aos="fade-right">
                        <div class="text-center">
                            <!-- Avatar -->
                            <div class="w-32 h-32 mx-auto mb-4 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-white text-5xl font-bold shadow-xl">
                                <?php echo strtoupper(substr($user['full_name'], 0, 1)); ?>
                            </div>
                            
                            <h3 class="text-2xl font-bold text-gray-900 mb-1">
                                <?php echo htmlspecialchars($user['full_name']); ?>
                            </h3>
                            <p class="text-gray-600 mb-1">@<?php echo htmlspecialchars($user['username']); ?></p>
                            <p class="text-sm text-gray-500 mb-4"><?php echo htmlspecialchars($user['email']); ?></p>
                            
                            <div class="inline-flex items-center px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-medium">
                                <i class="fas fa-check-circle mr-2"></i>
                                Aktif
                            </div>
                            
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <div class="text-sm text-gray-600">
                                    <div class="flex items-center justify-between mb-2">
                                        <span><i class="fas fa-calendar-plus text-primary mr-2"></i>Üyelik:</span>
                                        <span class="font-semibold"><?php echo formatDate($user['created_at']); ?></span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span><i class="fas fa-clock text-primary mr-2"></i>Son Giriş:</span>
                                        <span class="font-semibold"><?php echo $user['last_login'] ? formatDateTime($user['last_login']) : 'İlk giriş'; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sağ Panel - Düzenleme Formları -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Kişisel Bilgiler -->
                    <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-up">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-user text-primary mr-3"></i>
                            Kişisel Bilgiler
                        </h2>
                        
                        <form id="profileForm" class="space-y-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="form-label">
                                        <i class="fas fa-id-card text-primary mr-2"></i>Ad Soyad
                                    </label>
                                    <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" class="form-control w-full" required>
                                </div>
                                
                                <div>
                                    <label class="form-label">
                                        <i class="fas fa-at text-primary mr-2"></i>Kullanıcı Adı
                                    </label>
                                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" class="form-control w-full" required>
                                </div>
                            </div>
                            
                            <div>
                                <label class="form-label">
                                    <i class="fas fa-envelope text-primary mr-2"></i>E-posta Adresi
                                </label>
                                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="form-control w-full" required>
                            </div>
                            
                            <div class="flex justify-end pt-4">
                                <button type="submit" class="btn-primary">
                                    <i class="fas fa-save mr-2"></i>Bilgileri Güncelle
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Şifre Değiştirme -->
                    <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-up" data-aos-delay="100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-lock text-primary mr-3"></i>
                            Şifre Değiştir
                        </h2>
                        
                        <form id="passwordForm" class="space-y-5">
                            <div>
                                <label class="form-label">
                                    <i class="fas fa-key text-primary mr-2"></i>Mevcut Şifre
                                </label>
                                <div class="relative">
                                    <input type="password" id="current_password" name="current_password" class="form-control w-full pr-12" required>
                                    <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-primary" id="toggleCurrentPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div>
                                <label class="form-label">
                                    <i class="fas fa-lock text-primary mr-2"></i>Yeni Şifre
                                </label>
                                <div class="relative">
                                    <input type="password" id="new_password" name="new_password" class="form-control w-full pr-12" required>
                                    <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-primary" id="toggleNewPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">En az 6 karakter olmalıdır</p>
                            </div>
                            
                            <div>
                                <label class="form-label">
                                    <i class="fas fa-check-circle text-primary mr-2"></i>Yeni Şifre Tekrar
                                </label>
                                <div class="relative">
                                    <input type="password" id="confirm_password" name="confirm_password" class="form-control w-full pr-12" required>
                                    <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-primary" id="toggleConfirmPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="flex justify-end pt-4">
                                <button type="submit" class="px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-medium transition-all duration-300">
                                    <i class="fas fa-sync-alt mr-2"></i>Şifreyi Değiştir
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Hesap İşlemleri -->
                    <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-up" data-aos-delay="200">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-cog text-primary mr-3"></i>
                            Hesap İşlemleri
                        </h2>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <h3 class="font-semibold text-gray-900">Hesap Durumu</h3>
                                    <p class="text-sm text-gray-600">Hesabınız aktif durumda</p>
                                </div>
                                <span class="px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-medium">
                                    Aktif
                                </span>
                            </div>
                            
                            <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg border-2 border-red-200">
                                <div>
                                    <h3 class="font-semibold text-red-900">Tehlikeli Alan</h3>
                                    <p class="text-sm text-red-600">Hesabınızı kalıcı olarak silebilirsiniz</p>
                                </div>
                                <button onclick="confirmDelete()" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg font-medium transition-all duration-300">
                                    <i class="fas fa-trash-alt mr-2"></i>Hesabı Sil
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function() {
    // Toggle password visibility
    $('#toggleCurrentPassword, #toggleNewPassword, #toggleConfirmPassword').on('click', function() {
        const targetId = $(this).attr('id').replace('toggle', '').replace('Password', '_password').toLowerCase();
        const input = $('#' + targetId);
        const icon = $(this).find('i');
        
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // Profile update
    $('#profileForm').on('submit', function(e) {
        e.preventDefault();
        
        const fullName = $('#full_name').val().trim();
        const username = $('#username').val().trim();
        const email = $('#email').val().trim();
        
        if (fullName.length < 3) {
            showAlert('Ad Soyad en az 3 karakter olmalıdır!', 'error');
            return;
        }
        
        if (username.length < 3) {
            showAlert('Kullanıcı adı en az 3 karakter olmalıdır!', 'error');
            return;
        }
        
        if (!validateEmail(email)) {
            showAlert('Geçerli bir e-posta adresi girin!', 'error');
            return;
        }
        
        const btn = $(this).find('button[type="submit"]');
        const originalText = btn.html();
        btn.html('<i class="fas fa-spinner fa-spin mr-2"></i>Güncelleniyor...').prop('disabled', true);
        
        $.ajax({
            url: 'ajax/update_profile.php',
            type: 'POST',
            dataType: 'json',
            data: {
                full_name: fullName,
                username: username,
                email: email
            },
            success: function(response) {
                if (response.success) {
                    showAlert(response.message, 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    showAlert(response.message, 'error');
                    btn.html(originalText).prop('disabled', false);
                }
            },
            error: function() {
                showAlert('Bir hata oluştu!', 'error');
                btn.html(originalText).prop('disabled', false);
            }
        });
    });

    // Password update
    $('#passwordForm').on('submit', function(e) {
        e.preventDefault();
        
        const currentPassword = $('#current_password').val();
        const newPassword = $('#new_password').val();
        const confirmPassword = $('#confirm_password').val();
        
        if (currentPassword.length < 6) {
            showAlert('Mevcut şifrenizi girin!', 'error');
            return;
        }
        
        if (newPassword.length < 6) {
            showAlert('Yeni şifre en az 6 karakter olmalıdır!', 'error');
            return;
        }
        
        if (newPassword !== confirmPassword) {
            showAlert('Yeni şifreler eşleşmiyor!', 'error');
            return;
        }
        
        const btn = $(this).find('button[type="submit"]');
        const originalText = btn.html();
        btn.html('<i class="fas fa-spinner fa-spin mr-2"></i>Değiştiriliyor...').prop('disabled', true);
        
        $.ajax({
            url: 'ajax/update_password.php',
            type: 'POST',
            dataType: 'json',
            data: {
                current_password: currentPassword,
                new_password: newPassword
            },
            success: function(response) {
                if (response.success) {
                    showAlert(response.message, 'success');
                    $('#passwordForm')[0].reset();
                    btn.html(originalText).prop('disabled', false);
                } else {
                    showAlert(response.message, 'error');
                    btn.html(originalText).prop('disabled', false);
                }
            },
            error: function() {
                showAlert('Bir hata oluştu!', 'error');
                btn.html(originalText).prop('disabled', false);
            }
        });
    });
});

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function confirmDelete() {
    showConfirm(
        'Hesabınızı silmek üzeresiniz! Bu işlem geri alınamaz. Tüm verileriniz kalıcı olarak silinecek. Devam etmek istiyor musunuz?',
        function() {
            // İlk onay verildi, ikinci onay sor
            showConfirm(
                'Son kez soruyoruz: Hesabınızı silmek istediğinizden EMİN misiniz?',
                function() {
                    // İkinci onay da verildi
                    showAlert('Hesabınız siliniyor...', 'warning', 3000);
                    setTimeout(function() {
                        window.location.href = 'ajax/delete_account.php';
                    }, 1000);
                }
            );
        }
    );
}
</script>
