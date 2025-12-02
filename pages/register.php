<?php
/**
 * Kayıt Ol Sayfası
 */
$page_title = "Kayıt Ol";

// Zaten giriş yapmışsa dashboard'a yönlendir
if(isLoggedIn()) {
    redirect('dashboard');
}
?>

<section class="py-20 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen flex items-center">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl shadow-2xl p-8" data-aos="fade-up">
                <!-- Logo & Title -->
                <div class="text-center mb-8">
                    <div class="bg-gradient-to-br from-primary to-secondary rounded-xl p-3 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-user-plus text-white text-3xl"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Hesap Oluştur</h1>
                    <p class="text-gray-600">Ücretsiz hesabınızı oluşturun ve başlayın</p>
                </div>

                <!-- Register Form -->
                <form id="registerForm" class="space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="full_name" class="form-label">
                                <i class="fas fa-user text-primary mr-2"></i>Ad Soyad
                            </label>
                            <input 
                                type="text" 
                                id="full_name" 
                                name="full_name" 
                                class="form-control w-full" 
                                placeholder="Ahmet Yılmaz" 
                                required
                            >
                        </div>

                        <div>
                            <label for="username" class="form-label">
                                <i class="fas fa-at text-primary mr-2"></i>Kullanıcı Adı
                            </label>
                            <input 
                                type="text" 
                                id="username" 
                                name="username" 
                                class="form-control w-full" 
                                placeholder="ahmetyilmaz" 
                                required
                            >
                        </div>
                    </div>

                    <div>
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope text-primary mr-2"></i>E-posta Adresi
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-control w-full" 
                            placeholder="ornek@email.com" 
                            required
                        >
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="password" class="form-label">
                                <i class="fas fa-lock text-primary mr-2"></i>Şifre
                            </label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    class="form-control w-full pr-12" 
                                    placeholder="••••••••" 
                                    required
                                >
                                <button 
                                    type="button" 
                                    id="togglePassword" 
                                    class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-primary transition-colors"
                                >
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">En az 6 karakter</p>
                        </div>

                        <div>
                            <label for="password_confirm" class="form-label">
                                <i class="fas fa-lock text-primary mr-2"></i>Şifre Tekrar
                            </label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="password_confirm" 
                                    name="password_confirm" 
                                    class="form-control w-full pr-12" 
                                    placeholder="••••••••" 
                                    required
                                >
                                <button 
                                    type="button" 
                                    id="togglePasswordConfirm" 
                                    class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-primary transition-colors"
                                >
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Password Strength -->
                    <div id="passwordStrength" class="hidden">
                        <div class="flex items-center space-x-2 mb-2">
                            <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div id="strengthBar" class="h-full transition-all duration-300"></div>
                            </div>
                            <span id="strengthText" class="text-sm font-medium"></span>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <input 
                            type="checkbox" 
                            id="terms" 
                            name="terms" 
                            class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary mt-1" 
                            required
                        >
                        <label for="terms" class="ml-2 text-sm text-gray-600">
                            <a href="?page=terms" class="text-primary hover:text-secondary" target="_blank">Kullanım Şartları</a> 
                            ve 
                            <a href="?page=privacy" class="text-primary hover:text-secondary" target="_blank">Gizlilik Politikası</a>'nı 
                            okudum ve kabul ediyorum.
                        </label>
                    </div>

                    <button 
                        type="submit" 
                        id="registerBtn" 
                        class="w-full btn-primary py-3 text-lg font-semibold"
                    >
                        <i class="fas fa-user-plus mr-2"></i>
                        Hesap Oluştur
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500">veya</span>
                    </div>
                </div>

                <!-- Social Register -->
                <div class="grid grid-cols-2 gap-4">
                    <button class="flex items-center justify-center px-4 py-3 border-2 border-gray-300 rounded-lg hover:border-primary hover:bg-gray-50 transition-all duration-300">
                        <i class="fab fa-google text-red-500 mr-2"></i>
                        Google
                    </button>
                    <button class="flex items-center justify-center px-4 py-3 border-2 border-gray-300 rounded-lg hover:border-primary hover:bg-gray-50 transition-all duration-300">
                        <i class="fab fa-facebook text-blue-600 mr-2"></i>
                        Facebook
                    </button>
                </div>

                <!-- Login Link -->
                <div class="mt-8 text-center">
                    <p class="text-gray-600">
                        Zaten hesabınız var mı? 
                        <a href="?page=login" class="text-primary hover:text-secondary font-semibold transition-colors">
                            Giriş Yapın
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Email validasyon fonksiyonu
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

$(document).ready(function() {
    // Toggle Password Visibility
    $('#togglePassword, #togglePasswordConfirm').on('click', function() {
        const targetId = $(this).attr('id') === 'togglePassword' ? '#password' : '#password_confirm';
        const passwordInput = $(targetId);
        const icon = $(this).find('i');
        
        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordInput.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // Password Strength Checker
    $('#password').on('input', function() {
        const password = $(this).val();
        if (password.length > 0) {
            $('#passwordStrength').removeClass('hidden');
            
            let strength = 0;
            let text = '';
            let color = '';
            
            if (password.length >= 6) strength++;
            if (password.length >= 10) strength++;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^a-zA-Z0-9]/.test(password)) strength++;
            
            if (strength <= 2) {
                text = 'Zayıf';
                color = '#EF4444';
            } else if (strength <= 3) {
                text = 'Orta';
                color = '#F59E0B';
            } else {
                text = 'Güçlü';
                color = '#10B981';
            }
            
            $('#strengthBar').css({
                'width': (strength * 20) + '%',
                'background': color
            });
            $('#strengthText').text(text).css('color', color);
        } else {
            $('#passwordStrength').addClass('hidden');
        }
    });

    // Register Form Submit
    $('#registerForm').on('submit', function(e) {
        e.preventDefault();
        
        const fullName = $('#full_name').val().trim();
        const username = $('#username').val().trim();
        const email = $('#email').val().trim();
        const password = $('#password').val();
        const passwordConfirm = $('#password_confirm').val();
        const terms = $('#terms').is(':checked');
        
        // Validation
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
        
        if (password.length < 6) {
            showAlert('Şifre en az 6 karakter olmalıdır!', 'error');
            return;
        }
        
        if (password !== passwordConfirm) {
            showAlert('Şifreler eşleşmiyor!', 'error');
            return;
        }
        
        if (!terms) {
            showAlert('Kullanım şartlarını kabul etmelisiniz!', 'error');
            return;
        }
        
        // Disable button
        const registerBtn = $('#registerBtn');
        const originalText = registerBtn.html();
        registerBtn.html('<i class="fas fa-spinner fa-spin mr-2"></i>Hesap oluşturuluyor...').prop('disabled', true);
        
        console.log('Starting register AJAX call...');
        console.log('Data:', { full_name: fullName, username: username, email: email });
        
        // AJAX Request
        $.ajax({
            url: 'ajax/register.php',
            type: 'POST',
            dataType: 'json',
            data: {
                full_name: fullName,
                username: username,
                email: email,
                password: password
            },
            success: function(response) {
                console.log('Register Response:', response);
                if (response.success) {
                    showAlert(response.message, 'success');
                    setTimeout(function() {
                        window.location.href = '?page=login';
                    }, 2000);
                } else {
                    showAlert(response.message, 'error');
                    registerBtn.html(originalText).prop('disabled', false);
                }
            },
            error: function(xhr, status, error) {
                console.error('Register Error:', {
                    status: status,
                    error: error,
                    response: xhr.responseText
                });
                showAlert('Bir hata oluştu. Lütfen tekrar deneyin.', 'error');
                registerBtn.html(originalText).prop('disabled', false);
            }
        });
    });
});
</script>
