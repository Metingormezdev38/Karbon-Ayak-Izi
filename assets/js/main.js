$(document).ready(function() {
    setTimeout(function() {
        $('#preloader').fadeOut('slow');
    }, 800);

    AOS.init({
        duration: 1000,
        once: true,
        offset: 100
    });
    $('#mobile-menu-btn').on('click', function() {
        $('#mobile-menu').slideToggle(300);
        $(this).find('i').toggleClass('fa-bars fa-times');
    });

    $(window).scroll(function() {
        if ($(this).scrollTop() > 300) {
            $('#scrollToTop').fadeIn();
        } else {
            $('#scrollToTop').fadeOut();
        }
    });

    $('#scrollToTop').click(function() {
        $('html, body').animate({scrollTop: 0}, 600);
        return false;
    });

    const currentPage = new URLSearchParams(window.location.search).get('page') || 'home';
    $('.nav-link').each(function() {
        const href = $(this).attr('href');
        if (href && href.includes('page=' + currentPage)) {
            $(this).addClass('text-primary font-bold');
        }
    });

    window.validateEmail = function(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    };
    
    // Modern Alert Sistemi
    window.showAlert = function(message, type = 'success', duration = 5000) {
        // Eğer container yoksa oluştur
        if ($('#modernAlertContainer').length === 0) {
            $('body').append('<div id="modernAlertContainer" class="fixed top-4 right-4 z-[9999] space-y-3 max-w-md"></div>');
        }
        
        const icons = {
            success: 'fa-check-circle',
            error: 'fa-times-circle',
            warning: 'fa-exclamation-triangle',
            info: 'fa-info-circle'
        };
        
        const colors = {
            success: 'from-green-500 to-emerald-600',
            error: 'from-red-500 to-rose-600',
            warning: 'from-yellow-500 to-orange-600',
            info: 'from-blue-500 to-indigo-600'
        };
        
        const bgColors = {
            success: 'bg-green-50 border-green-200',
            error: 'bg-red-50 border-red-200',
            warning: 'bg-yellow-50 border-yellow-200',
            info: 'bg-blue-50 border-blue-200'
        };
        
        const textColors = {
            success: 'text-green-800',
            error: 'text-red-800',
            warning: 'text-yellow-800',
            info: 'text-blue-800'
        };
        
        const alertId = 'alert-' + Date.now();
        
        const alertHtml = `
            <div id="${alertId}" class="alert-modern ${bgColors[type]} border-2 rounded-xl shadow-2xl p-4 flex items-start space-x-3 animate-slide-in-right transform transition-all duration-300 hover:scale-105">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br ${colors[type]} flex items-center justify-center shadow-lg">
                        <i class="fas ${icons[type]} text-white text-lg"></i>
                    </div>
                </div>
                <div class="flex-1 pt-1">
                    <p class="${textColors[type]} font-medium text-sm leading-relaxed">${message}</p>
                </div>
                <button onclick="closeAlert('${alertId}')" class="${textColors[type]} hover:opacity-70 transition-opacity focus:outline-none">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        `;
        
        $('#modernAlertContainer').append(alertHtml);
        
        // Otomatik kapat
        if (duration > 0) {
            setTimeout(function() {
                closeAlert(alertId);
            }, duration);
        }
    };
    
    window.closeAlert = function(alertId) {
        const alert = $('#' + alertId);
        alert.addClass('animate-slide-out-right opacity-0');
        setTimeout(function() {
            alert.remove();
        }, 300);
    };
    
    // Confirm Dialog (Alert yerine kullanılabilir)
    window.showConfirm = function(message, onConfirm, onCancel) {
        const confirmHtml = `
            <div id="confirmDialog" class="fixed inset-0 z-[10000] flex items-center justify-center bg-black bg-opacity-50 animate-fade-in">
                <div class="bg-white rounded-2xl shadow-2xl p-6 max-w-md w-full mx-4 animate-scale-in">
                    <div class="flex items-start space-x-4 mb-6">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-yellow-500 to-orange-600 flex items-center justify-center">
                                <i class="fas fa-question-circle text-white text-2xl"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Emin misiniz?</h3>
                            <p class="text-gray-600">${message}</p>
                        </div>
                    </div>
                    <div class="flex space-x-3 justify-end">
                        <button id="confirmCancel" class="px-6 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-medium transition-all duration-300">
                            İptal
                        </button>
                        <button id="confirmOk" class="px-6 py-2.5 bg-gradient-to-r from-primary to-secondary text-white rounded-lg font-medium transition-all duration-300 hover:shadow-lg">
                            Evet, Devam Et
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        $('body').append(confirmHtml);
        
        $('#confirmOk').on('click', function() {
            $('#confirmDialog').remove();
            if (onConfirm) onConfirm();
        });
        
        $('#confirmCancel').on('click', function() {
            $('#confirmDialog').remove();
            if (onCancel) onCancel();
        });
        
        // Backdrop click
        $('#confirmDialog').on('click', function(e) {
            if (e.target.id === 'confirmDialog') {
                $(this).remove();
                if (onCancel) onCancel();
            }
        });
    };
    
    window.showLoading = function(element) {
        const spinner = '<div class="spinner mx-auto"></div>';
        $(element).html(spinner);
    };

    window.formatNumber = function(num, decimals = 2) {
        return num.toFixed(decimals).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    };
    $('a[href^="#"]').on('click', function(e) {
        e.preventDefault();
        const target = $(this.hash);
        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top - 80
            }, 600);
        }
    });
});

function logout() {
    showConfirm(
        'Çıkış yapmak istediğinize emin misiniz?',
        function() {
            // Onay verildi
            showAlert('Çıkış yapılıyor...', 'info', 2000);
            $.ajax({
                url: 'ajax/logout.php',
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        showAlert('Başarıyla çıkış yaptınız!', 'success', 2000);
                        setTimeout(function() {
                            window.location.href = '?page=home';
                        }, 1000);
                    } else {
                        showAlert(response.message, 'error');
                    }
                },
                error: function() {
                    showAlert('Bir hata oluştu. Lütfen tekrar deneyin.', 'error');
                }
            });
        }
    );
}

function animateCounter(element, target, duration = 2000) {
    let current = 0;
    const increment = target / (duration / 16);
    const timer = setInterval(function() {
        current += increment;
        if (current >= target) {
            current = target;
            clearInterval(timer);
        }
        $(element).text(formatNumber(current));
    }, 16);
}

const chartColors = {
    primary: '#10B981',
    secondary: '#059669',
    accent: '#34D399',
    warning: '#F59E0B',
    danger: '#EF4444',
    info: '#3B82F6',
    purple: '#8B5CF6',
    pink: '#EC4899'
};

function createChart(canvasId, type, labels, datasets) {
    const ctx = document.getElementById(canvasId);
    if (!ctx) return;

    return new Chart(ctx, {
        type: type,
        data: {
            labels: labels,
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: {
                            size: 12,
                            family: 'Inter'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 14,
                        family: 'Inter'
                    },
                    bodyFont: {
                        size: 13,
                        family: 'Inter'
                    },
                    cornerRadius: 8
                }
            },
            scales: type !== 'pie' && type !== 'doughnut' ? {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            } : {}
        }
    });
}

function calculateCarbon(electricity, gas, fuel, distance) {
    // Karbon faktörleri 
    const factors = {
        electricity: 0.82,  // kWh başına
        gas: 2.03,          // m3 başına
        fuel: 2.31,         // litre başına
        distance: 0.12      // km başına
    };

    const total = 
        (electricity * factors.electricity) +
        (gas * factors.gas) +
        (fuel * factors.fuel) +
        (distance * factors.distance);

    return total;
}
function copyToClipboard(text) {
    const temp = $('<input>');
    $('body').append(temp);
    temp.val(text).select();
    document.execCommand('copy');
    temp.remove();
    showAlert('Panoya kopyalandı!', 'success');
}

function shareOnSocial(platform, url, text) {
    let shareUrl = '';
    switch(platform) {
        case 'facebook':
            shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
            break;
        case 'twitter':
            shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(text)}`;
            break;
        case 'linkedin':
            shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`;
            break;
        case 'whatsapp':
            shareUrl = `https://wa.me/?text=${encodeURIComponent(text + ' ' + url)}`;
            break;
    }
    window.open(shareUrl, '_blank', 'width=600,height=400');
}

function downloadCSV(data, filename) {
    const csv = data.map(row => row.join(',')).join('\n');
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    a.click();
    window.URL.revokeObjectURL(url);
}

function printPage() {
    window.print();
}
console.log('%cEcoCarbon', 'color: #10B981; font-size: 24px; font-weight: bold;');
console.log('%cKarbon Ayak İzi Hesaplama Sistemi', 'color: #059669; font-size: 14px;');
console.log('%c© 2025 Tüm hakları saklıdır.', 'color: #6B7280; font-size: 12px;');
