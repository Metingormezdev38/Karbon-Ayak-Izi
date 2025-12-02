<?php
/**
 * Giriş Yap Sayfası
 */
$page_title = "Giriş Yap";

// Zaten giriş yapmışsa dashboard'a yönlendir
if(isLoggedIn()) {
    redirect('dashboard');
}
?>

<section class="py-20 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen flex items-center">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto">
            <div class="bg-white rounded-2xl shadow-2xl p-8" data-aos="fade-up">
                <!-- Logo & Title -->
                <div class="text-center mb-8">
                    <div class="bg-gradient-to-br from-primary to-secondary rounded-xl p-3 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-leaf text-white text-3xl"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Hoş Geldiniz</h1>
                    <p class="text-gray-600">Hesabınıza giriş yapın</p>
                </div>

                <!-- Login Form -->
                <form id="loginForm" class="space-y-5">
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
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" id="remember" name="remember" class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                            <span class="ml-2 text-sm text-gray-600">Beni Hatırla</span>
                        </label>
                        <a href="?page=forgot-password" class="text-sm text-primary hover:text-secondary transition-colors">
                            Şifremi Unuttum?
                        </a>
                    </div>

                    <button 
                        type="submit" 
                        id="loginBtn" 
                        class="w-full btn-primary py-3 text-lg font-semibold"
                    >
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Giriş Yap
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

                <!-- Social Login -->
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

                <!-- Register Link -->
                <div class="mt-8 text-center">
                    <p class="text-gray-600">
                        Hesabınız yok mu? 
                        <a href="?page=register" class="text-primary hover:text-secondary font-semibold transition-colors">
                            Kayıt Olun
                        </a>
                    </p>
                </div>
            </div>

            <!-- Info Card -->
            <div class="mt-6 bg-gradient-to-r from-primary/10 to-secondary/10 rounded-xl p-6 text-center" data-aos="fade-up" data-aos-delay="200">
                <i class="fas fa-info-circle text-primary text-2xl mb-2"></i>
                <p class="text-gray-700 text-sm">
                    <strong>Demo Hesap:</strong> admin@carbonfoot.com / admin123
                </p>
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
    $('#togglePassword').on('click', function() {
        const passwordInput = $('#password');
        const icon = $(this).find('i');
        
        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordInput.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // Login Form Submit
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        
        const email = $('#email').val();
        const password = $('#password').val();
        const remember = $('#remember').is(':checked');
        
        // Validation
        if (!validateEmail(email)) {
            showAlert('Geçerli bir e-posta adresi girin!', 'error');
            return;
        }
        
        if (password.length < 6) {
            showAlert('Şifre en az 6 karakter olmalıdır!', 'error');
            return;
        }
        
        // Disable button
        const loginBtn = $('#loginBtn');
        const originalText = loginBtn.html();
        loginBtn.html('<i class="fas fa-spinner fa-spin mr-2"></i>Giriş yapılıyor...').prop('disabled', true);
        
        console.log('Starting login AJAX call...');
        console.log('Data:', { email: email, remember: remember });
        
        // AJAX Request
        $.ajax({
            url: 'ajax/login.php',
            type: 'POST',
            dataType: 'json',
            data: {
                email: email,
                password: password,
                remember: remember
            },
            success: function(response) {
                console.log('Login Response:', response);
                if (response.success) {
                    showAlert(response.message, 'success');
                    setTimeout(function() {
                        window.location.href = '?page=dashboard';
                    }, 1000);
                } else {
                    showAlert(response.message, 'error');
                    loginBtn.html(originalText).prop('disabled', false);
                }
            },
            error: function(xhr, status, error) {
                console.error('Login Error:', {
                    status: status,
                    error: error,
                    response: xhr.responseText
                });
                showAlert('Bir hata oluştu. Lütfen tekrar deneyin.', 'error');
                loginBtn.html(originalText).prop('disabled', false);
            }
        });
    });
});
</script>
