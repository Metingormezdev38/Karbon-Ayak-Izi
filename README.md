# EcoCarbon - Karbon Ayak İzi Hesaplama Sistemi

## 📋 Proje Hakkında

EcoCarbon, kullanıcıların karbon ayak izlerini hesaplamalarına, takip etmelerine ve azaltmalarına yardımcı olan modern bir web uygulamasıdır. Tailwind CSS ve Bootstrap kullanılarak responsive bir tasarımla geliştirilmiştir.

## ✨ Özellikler

- ✅ Modern ve responsive tasarım (Tailwind CSS + Bootstrap)
- ✅ Kullanıcı kayıt ve giriş sistemi
- ✅ Detaylı karbon ayak izi hesaplama
- ✅ Kişiselleştirilmiş dashboard
- ✅ Karbon azaltma önerileri
- ✅ Grafikler ve istatistikler
- ✅ Modüler PHP yapısı
- ✅ PDO ile güvenli veritabanı işlemleri
- ✅ AJAX ile asenkron işlemler
- ✅ Responsive mobil uyumlu tasarım

## 🛠️ Teknolojiler

### Backend
- PHP 7.4+
- MySQL 5.7+
- PDO (PHP Data Objects)

### Frontend
- HTML5
- Tailwind CSS 3.x
- Bootstrap 5.3
- JavaScript (ES6+)
- jQuery 3.7
- Chart.js 4.4
- Font Awesome 6.4
- AOS (Animate On Scroll)

## 📁 Proje Yapısı

```
htdocs/
├── ajax/                  # AJAX işlem dosyaları
│   ├── login.php
│   ├── register.php
│   ├── logout.php
│   └── save_calculation.php
├── assets/
│   ├── css/               # CSS dosyaları
│   │   └── style.css
│   ├── js/                # JavaScript dosyaları
│   │   └── main.js
│   └── images/            # Resim dosyaları
├── config/                # Yapılandırma dosyaları
│   ├── config.php         # Genel ayarlar
│   └── database.php       # Veritabanı bağlantısı
├── modules/               # Modüler bileşenler
│   ├── _header.php        # Header (head bölümü)
│   ├── _navbar.php        # Navigation bar
│   └── _footer.php        # Footer
├── pages/                 # Sayfa dosyaları
│   ├── home.php
│   ├── login.php
│   ├── register.php
│   ├── calculator.php
│   ├── dashboard.php
│   ├── tips.php
│   └── about.php
├── database.sql           # Veritabanı şeması
├── index.php              # Ana giriş dosyası
└── README.md              # Bu dosya
```

### Uygulamayı Çalıştırın
Tarayıcınızda şu adresi açın:
```
http://localhost/
```

## 👤 Demo Hesap

**Email:** admin@carbonfoot.com  
**Şifre:** admin123

## 📊 Veritabanı Tabloları

- **users** - Kullanıcı bilgileri
- **calculation_categories** - Hesaplama kategorileri
- **carbon_calculations** - Karbon hesaplamaları
- **reduction_tips** - Karbon azaltma önerileri
- **user_goals** - Kullanıcı hedefleri
- **user_achievements** - Kullanıcı başarıları

## 🎨 Tasarım Özellikleri

- Modern gradient renkler
- Smooth animasyonlar (AOS)
- Card-based layout
- Responsive grid system
- Custom scrollbar
- Loading animations
- Toast notifications
- Interactive charts

## 🔒 Güvenlik

- PDO ile SQL injection koruması
- Password hashing (bcrypt)
- XSS koruması
- CSRF token (geliştirilecek)
- Input sanitization
- Session yönetimi

## 📱 Responsive Tasarım

- Mobile-first yaklaşım
- Tablet ve desktop optimize
- Hamburger menu (mobil)
- Flexible grid layout
- Touch-friendly buttons

## 🌟 Karbon Hesaplama Faktörleri

- **Elektrik:** 0.82 kg CO2/kWh
- **Doğal Gaz:** 2.03 kg CO2/m³
- **Yakıt:** 2.31 kg CO2/litre
- **Toplu Taşıma:** 0.12 kg CO2/km
- **Uçuş:** 0.255 kg CO2/km
- **Su:** 0.344 kg CO2/m³
- **Atık:** 0.5 kg CO2/kg
- **Geri Dönüşüm:** -0.3 kg CO2/kg

## 🤝 Katkıda Bulunma

1. Fork yapın
2. Feature branch oluşturun (`git checkout -b feature/amazing`)
3. Commit yapın (`git commit -m 'Add amazing feature'`)
4. Push yapın (`git push origin feature/amazing`)
5. Pull Request açın

## 📄 Lisans

Bu proje eğitim amaçlı geliştirilmiştir.

## 🙏 Teşekkürler

- Tailwind CSS ekibine
- Bootstrap ekibine
- Chart.js geliştiricilerine
- Font Awesome ekibine
- Açık kaynak topluluğuna

---

**Not:** Bu proje sürdürülebilir bir gelecek için geliştirilmiştir. 🌍💚

**Geliştirme Tarihi:** Kasım 2025
