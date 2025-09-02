<?php
// E-posta gönderim fonksiyonları
require_once __DIR__ . '/../phpmailer/RealSMTP.php';

// E-posta yapılandırması
define('SMTP_USERNAME', 'antalya.transfer.tr@gmail.com'); // Gmail adresiniz
define('SMTP_PASSWORD', 'lzpaqmtmlotqabce');    // Gmail app password (boşluksuz)
define('TEST_MODE', false); // Test modunu açık/kapalı yapabilirsiniz
define('USE_REAL_SMTP', true); // Gerçek SMTP kullan (XAMPP'ta çalışır)

function sendReservationEmail($rezervasyon_bilgileri) {
    $musteri_email = $rezervasyon_bilgileri['email'];
    $musteri_isim = $rezervasyon_bilgileri['musteri_isim'];
    
    // E-posta içeriğini hazırla (mevcut dil ile)
    $subject = translate('email_rezervasyon_onay');
    $message = generateEmailTemplate($rezervasyon_bilgileri);
    
    // E-posta gönderim modu kontrolü
    if (TEST_MODE) {
        // Test modunda e-postayı dosyaya kaydet
        echo "<div style='background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
        echo "<strong>🧪 TEST MODU:</strong> E-posta dosyaya kaydedildi.";
        echo "</div>";
        return saveEmailToFile($musteri_email, $subject, $message, 'customer');
        } elseif (USE_REAL_SMTP) {
        // Gerçek SMTP ile gönder (XAMPP'ta çalışır)
        $smtp = new RealSMTP();
        $smtp->setAuth(SMTP_USERNAME, SMTP_PASSWORD);
        $smtp->setFrom('info@antalyatransfer.com', 'Antalya Transfer');
        $smtp->setDebug(false); // Debug kapalı - ekranda mesaj göstermez
        
        $result = $smtp->sendMail($musteri_email, $subject, $message);
        
        return $result;
    } else {
        // Hosting sağlayıcısının mail() fonksiyonunu kullan
        return sendWithHostingMail($musteri_email, $subject, $message);
    }
}

// Hosting sağlayıcısının mail() fonksiyonu ile gönderim
function sendWithHostingMail($to_email, $subject, $html_message) {
    // E-posta başlıkları
    $headers = array(
        'MIME-Version: 1.0',
        'Content-type: text/html; charset=UTF-8',
        'From: Antalya Transfer <info@antalyatransfer.com>',
        'Reply-To: info@antalyatransfer.com',
        'X-Mailer: Antalya Transfer System'
    );
    
    // PHP'nin mail() fonksiyonu ile gönder
    $result = mail($to_email, $subject, $html_message, implode("\r\n", $headers));
    
    return $result;
}

// Test modu için e-postayı dosyaya kaydet
function saveEmailToFile($to_email, $subject, $html_message, $type = 'customer') {
    $filename = $type . '_email_' . date('Y-m-d_H-i-s') . '.html';
    
    $html_preview = '
    <!DOCTYPE html>
    <html lang="tr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>E-posta Test Görünümü</title>
        <style>
            body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
            .test-header { background: #17a2b8; color: white; padding: 15px; text-align: center; margin-bottom: 20px; border-radius: 5px; }
            .email-preview { background: white; border: 2px solid #17a2b8; border-radius: 10px; overflow: hidden; }
            .email-meta { background: #f8f9fa; padding: 15px; border-bottom: 1px solid #dee2e6; }
            .email-content { padding: 0; }
        </style>
    </head>
    <body>
        <div class="test-header">
            <h2>📧 E-posta Test Görünümü (' . ucfirst($type) . ')</h2>
            <p>Bu, gönderilecek e-postanın önizlemesidir</p>
        </div>
        
        <div class="email-preview">
            <div class="email-meta">
                <p><strong>Kime:</strong> ' . htmlspecialchars($to_email) . '</p>
                <p><strong>Konu:</strong> ' . htmlspecialchars($subject) . '</p>
                <p><strong>Tarih:</strong> ' . date('d.m.Y H:i:s') . '</p>
                <p><strong>Tip:</strong> ' . ucfirst($type) . ' E-postası</p>
            </div>
            <div class="email-content">
                ' . $html_message . '
            </div>
        </div>
        
        <div style="text-align: center; margin: 20px; padding: 15px; background: #e9ecef; border-radius: 5px;">
            <p><strong>🧪 Bu bir test dosyasıdır</strong></p>
            <p>Gerçek e-posta gönderimi için <code>TEST_MODE = false</code> yapın</p>
        </div>
    </body>
    </html>';
    
    $filepath = __DIR__ . '/../' . $filename;
    $success = file_put_contents($filepath, $html_preview);
    
    if ($success) {
        echo "<p><a href='{$filename}' target='_blank' style='color: #007bff; text-decoration: underline;'>📄 {$filename} - E-postayı Görüntüle</a></p>";
        return true;
    }
    
    return false;
}

function generateEmailTemplate($bilgi) {
    $current_lang = getCurrentLanguage();
    $html = '
    <!DOCTYPE html>
    <html lang="' . $current_lang . '">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . translate('email_rezervasyon_onay') . '</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                color: #333;
                background-color: #f4f4f4;
                margin: 0;
                padding: 20px;
            }
            .container {
                max-width: 600px;
                margin: 0 auto;
                background: white;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 0 20px rgba(0,0,0,0.1);
            }
            .header {
                text-align: center;
                margin-bottom: 30px;
                padding-bottom: 20px;
                border-bottom: 2px solid #007bff;
            }
            .header h1 {
                color: #007bff;
                margin: 0;
                font-size: 28px;
            }
            .section {
                margin-bottom: 25px;
                padding: 20px;
                background: #f8f9fa;
                border-radius: 8px;
                border-left: 4px solid #007bff;
            }
            .section h2 {
                color: #007bff;
                margin-top: 0;
                font-size: 18px;
            }
            .info-row {
                display: flex;
                justify-content: space-between;
                margin-bottom: 10px;
                padding: 8px 0;
                border-bottom: 1px solid #eee;
            }
            .info-row:last-child {
                border-bottom: none;
            }
            .label {
                font-weight: bold;
                color: #555;
            }
            .value {
                color: #333;
            }
            .passenger-card {
                background: white;
                padding: 15px;
                margin: 10px 0;
                border-radius: 5px;
                border: 1px solid #ddd;
            }
            .footer {
                text-align: center;
                margin-top: 30px;
                padding-top: 20px;
                border-top: 1px solid #eee;
                color: #666;
                font-size: 14px;
            }
            .important-note {
                background: #fff3cd;
                border: 1px solid #ffeaa7;
                padding: 15px;
                border-radius: 5px;
                margin: 20px 0;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>🚗 Antalya Transfer</h1>
                <p>' . translate('email_rezervasyon_onay') . '</p>
            </div>
            
            <div class="section">
                <h2>👤 ' . translate('email_musteri_bilgileri') . '</h2>
                <div class="info-row">
                    <span class="label">' . translate('rez_tamam_isim') . ':</span>
                    <span class="value">' . htmlspecialchars($bilgi['musteri_isim']) . '</span>
                </div>
                <div class="info-row">
                    <span class="label">' . translate('rez_tamam_eposta') . ':</span>
                    <span class="value">' . htmlspecialchars($bilgi['email']) . '</span>
                </div>
                <div class="info-row">
                    <span class="label">' . translate('rez_tamam_telefon') . ':</span>
                    <span class="value">' . htmlspecialchars($bilgi['telno']) . '</span>
                </div>
            </div>
            
            <div class="section">
                <h2>🚙 ' . translate('email_transfer_detaylari') . '</h2>
                <div class="info-row">
                    <span class="label">' . translate('rez_tamam_arac') . ':</span>
                    <span class="value">' . htmlspecialchars($bilgi['araba_ismi']) . '</span>
                </div>
                <div class="info-row">
                    <span class="label">' . translate('rez_tamam_kisi_sayisi') . ':</span>
                    <span class="value">' . htmlspecialchars($bilgi['kisiler']) . ' ' . translate('kisi_birimi') . '</span>
                </div>
                <div class="info-row">
                    <span class="label">' . translate('rez_tamam_nereden') . ':</span>
                    <span class="value">' . translate('email_havalimani') . '</span>
                </div>
                <div class="info-row">
                    <span class="label">' . translate('rez_tamam_nereye') . ':</span>
                    <span class="value">' . htmlspecialchars($bilgi['nereye']) . '</span>
                </div>
                <div class="info-row">
                    <span class="label">' . translate('rez_tamam_fiyat') . ':</span>
                    <span class="value"><strong>' . htmlspecialchars($bilgi['fiyat']) . ' €</strong></span>
                </div>
            </div>
            
            <div class="section">
                <h2>✈️ ' . translate('email_ucus_bilgileri') . '</h2>
                <div class="info-row">
                    <span class="label">' . translate('rez_tamam_ucak_varis') . ':</span>
                    <span class="value">' . htmlspecialchars($bilgi['ucak_inis']) . '</span>
                </div>
                <div class="info-row">
                    <span class="label">' . translate('rez_tamam_ucus_no') . ':</span>
                    <span class="value">' . htmlspecialchars($bilgi['ucus_no'] ?: translate('email_belirtilmedi')) . '</span>
                </div>
                <div class="info-row">
                    <span class="label">' . translate('rez_tamam_otel') . ':</span>
                    <span class="value">' . htmlspecialchars($bilgi['otel'] ?: translate('email_belirtilmedi')) . '</span>
                </div>
                <div class="info-row">
                    <span class="label">' . translate('rez_tamam_odeme_sekli') . ':</span>
                    <span class="value">' . htmlspecialchars($bilgi['paymentOption']) . '</span>
                </div>
            </div>';
    
    // Yolcu bilgileri
    if (!empty($bilgi['yolcular'])) {
        $html .= '
            <div class="section">
                <h2>👥 ' . translate('email_yolcu_bilgileri') . '</h2>';
        
        foreach ($bilgi['yolcular'] as $index => $yolcu) {
            $html .= '
                <div class="passenger-card">
                    <strong>' . translate('rez_tamam_yolcu_no') . ' ' . ($index + 1) . '</strong><br>
                    <div class="info-row">
                        <span class="label">' . translate('rez_tamam_isim') . ':</span>
                        <span class="value">' . htmlspecialchars($yolcu['yolcu_isim']) . '</span>
                    </div>
                    <div class="info-row">
                        <span class="label">' . translate('rez_tamam_kimlik') . ':</span>
                        <span class="value">' . htmlspecialchars($yolcu['kimlik_no']) . '</span>
                    </div>
                </div>';
        }
        
        $html .= '</div>';
    }
    
    
    // Önemli notlar çevirisi
    $transfer_notlari = translate('email_transfer_notlari');
    $notlar_html = '';
    if (is_array($transfer_notlari)) {
        foreach ($transfer_notlari as $not) {
            $notlar_html .= '• ' . $not . '<br>';
        }
    }
    
    $html .= '
            <div class="important-note">
                <strong>⚠️ ' . translate('email_onemli_notlar') . ':</strong><br>
                ' . $notlar_html . '
            </div>
            
            <div class="footer">
                <p><strong>Antalya Transfer</strong></p>
                <p>📞 +90 (534) 017 28 15 | 📧 info@antalyatransfer.com</p>
                <p>' . translate('email_otomatik_mesaj') . '</p>
            </div>
        </div>
    </body>
    </html>';
    
    return $html;
}

// Admin için bildirim e-postası
function sendAdminNotificationEmail($rezervasyon_bilgileri) {
    $admin_email = "antalya.transfer.tr@gmail.com"; // Admin e-posta adresi
    
    $subject = translate('email_yeni_rezervasyon') . " - " . $rezervasyon_bilgileri['musteri_isim'];
    $message = generateAdminEmailTemplate($rezervasyon_bilgileri);
    
    // Bu eski kod kaldırıldı - RealSMTP kullanacağız
    
    // E-posta gönderim modu kontrolü
    if (TEST_MODE) {
        // Test modunda e-postayı dosyaya kaydet
        return saveEmailToFile($admin_email, $subject, $message, 'admin');
    } elseif (USE_REAL_SMTP) {
        // Gerçek SMTP ile gönder
        $smtp = new RealSMTP();
        $smtp->setAuth(SMTP_USERNAME, SMTP_PASSWORD);
        $smtp->setFrom('sistem@antalyatransfer.com', 'Antalya Transfer Sistem');
        $smtp->setDebug(false); // Debug kapalı
        
        return $smtp->sendMail($admin_email, $subject, $message);
    } else {
        // Hosting sağlayıcısının mail() fonksiyonunu kullan
        return sendWithHostingMail($admin_email, $subject, $message);
    }
}

function generateAdminEmailTemplate($bilgi) {
    $html = '
    <!DOCTYPE html>
    <html lang="tr">
    <head>
        <meta charset="UTF-8">
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .alert { background: #d4edda; border: 1px solid #c3e6cb; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
            .info { background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 10px 0; }
            .label { font-weight: bold; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="alert">
                <h2>🆕 Yeni Rezervasyon Alındı!</h2>
                <p>Aşağıda rezervasyon detayları bulunmaktadır:</p>
            </div>
            
            <div class="info">
                <h3>Müşteri Bilgileri</h3>
                <p><span class="label">Ad Soyad:</span> ' . htmlspecialchars($bilgi['musteri_isim']) . '</p>
                <p><span class="label">E-posta:</span> ' . htmlspecialchars($bilgi['email']) . '</p>
                <p><span class="label">Telefon:</span> ' . htmlspecialchars($bilgi['telno']) . '</p>
            </div>
            
            <div class="info">
                <h3>Transfer Detayları</h3>
                <p><span class="label">Araç:</span> ' . htmlspecialchars($bilgi['araba_ismi']) . '</p>
                <p><span class="label">Rota:</span> ' . htmlspecialchars($bilgi['nereden']) . ' → ' . htmlspecialchars($bilgi['nereye']) . '</p>
                <p><span class="label">Kişi Sayısı:</span> ' . htmlspecialchars($bilgi['kisiler']) . ' kişi</p>
                <p><span class="label">Fiyat:</span> ' . htmlspecialchars($bilgi['fiyat']) . ' €</p>
                <p><span class="label">Uçak Varış:</span> ' . htmlspecialchars($bilgi['ucak_inis']) . '</p>
                <p><span class="label">Uçuş No:</span> ' . htmlspecialchars($bilgi['ucus_no'] ?: 'Belirtilmedi') . '</p>
                <p><span class="label">Otel:</span> ' . htmlspecialchars($bilgi['otel'] ?: 'Belirtilmedi') . '</p>
                <p><span class="label">Ödeme:</span> ' . htmlspecialchars($bilgi['paymentOption']) . '</p>
            </div>';
    
    if (!empty($bilgi['yolcular'])) {
        $html .= '<div class="info"><h3>Yolcu Listesi</h3>';
        foreach ($bilgi['yolcular'] as $index => $yolcu) {
            $html .= '<p><strong>Yolcu ' . ($index + 1) . ':</strong> ' . 
                     htmlspecialchars($yolcu['yolcu_isim']) . ' (' . 
                     htmlspecialchars($yolcu['kimlik_no']) . ')</p>';
        }
        $html .= '</div>';
    }
    
    $html .= '
            <p><strong>Bu rezervasyon için gerekli işlemleri başlatınız.</strong></p>
        </div>
    </body>
    </html>';
    
    return $html;
}

// İletişim formu için e-posta gönderimi
function sendContactFormEmail($contact_data) {
    $admin_email = "antalya.transfer.tr@gmail.com"; // Admin e-posta adresi
    
    $subject = "İletişim Formu Mesajı - " . $contact_data['adsoyad'];
    $message = generateContactEmailTemplate($contact_data);
    
    // E-posta gönderim modu kontrolü
    if (TEST_MODE) {
        // Test modunda e-postayı dosyaya kaydet
        return saveEmailToFile($admin_email, $subject, $message, 'contact');
    } elseif (USE_REAL_SMTP) {
        // Gerçek SMTP ile gönder
        $smtp = new RealSMTP();
        $smtp->setAuth(SMTP_USERNAME, SMTP_PASSWORD);
        $smtp->setFrom('iletisim@antalyatransfer.com', 'Antalya Transfer İletişim');
        $smtp->setDebug(false); // Debug kapalı
        
        return $smtp->sendMail($admin_email, $subject, $message);
    } else {
        // Hosting sağlayıcısının mail() fonksiyonunu kullan
        return sendWithHostingMail($admin_email, $subject, $message);
    }
}

// İletişim formu e-posta şablonu
function generateContactEmailTemplate($data) {
    $html = '
    <!DOCTYPE html>
    <html lang="tr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>İletişim Formu Mesajı</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                color: #333;
                background-color: #f4f4f4;
                margin: 0;
                padding: 20px;
            }
            .container {
                max-width: 600px;
                margin: 0 auto;
                background: white;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 0 20px rgba(0,0,0,0.1);
            }
            .header {
                text-align: center;
                margin-bottom: 30px;
                padding-bottom: 20px;
                border-bottom: 2px solid #007bff;
            }
            .header h1 {
                color: #007bff;
                margin: 0;
                font-size: 28px;
            }
            .contact-info {
                background: #f8f9fa;
                padding: 20px;
                border-radius: 8px;
                border-left: 4px solid #007bff;
                margin-bottom: 20px;
            }
            .contact-info h2 {
                color: #007bff;
                margin-top: 0;
                font-size: 18px;
            }
            .info-row {
                display: flex;
                justify-content: space-between;
                margin-bottom: 10px;
                padding: 8px 0;
                border-bottom: 1px solid #eee;
            }
            .info-row:last-child {
                border-bottom: none;
            }
            .label {
                font-weight: bold;
                color: #555;
            }
            .value {
                color: #333;
            }
            .message-box {
                background: #fff3cd;
                border: 1px solid #ffeaa7;
                padding: 20px;
                border-radius: 8px;
                margin: 20px 0;
            }
            .message-box h3 {
                margin-top: 0;
                color: #856404;
            }
            .footer {
                text-align: center;
                margin-top: 30px;
                padding-top: 20px;
                border-top: 1px solid #eee;
                color: #666;
                font-size: 14px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>📧 İletişim Formu Mesajı</h1>
                <p>Web sitesinden yeni bir iletişim formu mesajı alındı</p>
            </div>
            
            <div class="contact-info">
                <h2>👤 Gönderen Bilgileri</h2>
                <div class="info-row">
                    <span class="label">Ad Soyad:</span>
                    <span class="value">' . htmlspecialchars($data['adsoyad']) . '</span>
                </div>
                <div class="info-row">
                    <span class="label">E-posta:</span>
                    <span class="value">' . htmlspecialchars($data['email']) . '</span>
                </div>
                <div class="info-row">
                    <span class="label">Telefon:</span>
                    <span class="value">' . htmlspecialchars($data['telefon']) . '</span>
                </div>
                <div class="info-row">
                    <span class="label">Gönderim Tarihi:</span>
                    <span class="value">' . date('d.m.Y H:i:s') . '</span>
                </div>
            </div>
            
            <div class="message-box">
                <h3>💬 Mesaj İçeriği</h3>
                <p style="white-space: pre-wrap; margin: 0;">' . htmlspecialchars($data['mesaj']) . '</p>
            </div>
            
            <div class="footer">
                <p><strong>Antalya Transfer İletişim Sistemi</strong></p>
                <p>Bu mesaj web sitesi iletişim formundan otomatik olarak gönderilmiştir.</p>
            </div>
        </div>
    </body>
    </html>';
    
    return $html;
}
?>
