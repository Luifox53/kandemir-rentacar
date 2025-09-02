# reCAPTCHA Kurulum Rehberi

## ✅ Tamamlanan İşlemler

1. **odeme.php** - reCAPTCHA script ve div eklendi
2. **rez_tamam.php** - Captcha doğrulama kodu eklendi  
3. **payment.css** - Captcha stilleri eklendi

## 🔑 Yapmanız Gerekenler

### 1. Site Key'i Güncelleyin
**Dosya:** `odeme.php`  
**Satır:** 148  
**Değiştirin:**
```html
<div class="g-recaptcha" data-sitekey="6LfYourSiteKeyHere"></div>
```
**Şununla:**
```html
<div class="g-recaptcha" data-sitekey="BURAYA_SITE_KEY_INIZI_YAZIN"></div>
```

### 2. Secret Key'i Güncelleyin
**Dosya:** `rez_tamam.php`  
**Satır:** 9  
**Değiştirin:**
```php
$recaptcha_secret = "6LfYourSecretKeyHere"; // Buraya secret key'inizi yazın
```
**Şununla:**
```php
$recaptcha_secret = "BURAYA_SECRET_KEY_INIZI_YAZIN";
```

## 🧪 Test Etme

1. Rezervasyon sürecini başlatın
2. Ödeme sayfasına gelin
3. Captcha'nın göründüğünü kontrol edin
4. Captcha'yı tamamlamadan "Rezervasyonu Tamamla" butonuna basın
5. Hata mesajı almalısınız
6. Captcha'yı tamamlayıp tekrar deneyin
7. Rezervasyon başarıyla tamamlanmalı

## 🔧 Özellikler

- ✅ Bot koruması
- ✅ Kullanıcı dostu hata mesajları
- ✅ Responsive tasarım
- ✅ Güvenli doğrulama
- ✅ Mevcut işlevselliği bozmaz

## 📝 Notlar

- Captcha sadece ödeme sayfasında görünür
- Başarısız doğrulamada kullanıcı geri yönlendirilir
- Secret key asla frontend'de görünmez
- Tüm veriler güvenli şekilde işlenir
