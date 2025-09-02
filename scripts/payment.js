 // DOM yüklendikten sonra kodu çalıştır
document.addEventListener('DOMContentLoaded', function() {
    // Çeviri metinlerini PHP'den al
    function getTranslations() {
        try {
            // AJAX ile çevirileri al
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'includes/get_translations.php', false); // Senkron istek
            xhr.send();
            
            if (xhr.status === 200) {
                // Yanıtın JSON olup olmadığını kontrol et
                const responseText = xhr.responseText.trim();
                if (responseText.startsWith('{') && responseText.endsWith('}')) {
                    return JSON.parse(responseText);
                } else {
                    console.warn('API yanıtı geçerli JSON değil:', responseText.substring(0, 200));
                    throw new Error('Invalid JSON response');
                }
            } else {
                console.warn('API isteği başarısız:', xhr.status, xhr.statusText);
                throw new Error(`HTTP ${xhr.status}: ${xhr.statusText}`);
            }
        } catch (error) {
            console.warn('Çeviriler alınamadı, varsayılan metinler kullanılacak:', error.message);
            
            // Hata detaylarını kullanıcıya göster (sadece geliştirme aşamasında)
            if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
                console.error('Çeviri API hatası:', error);
            }
        }
        
        // Fallback - varsayılan metinler
        return {
            'odeme_eft': 'EFT / Havale',
            'odeme_nakit': 'Nakit Öde',
            'odeme_eft_aciklama': 'Rezervasyonunuz onaylandıktan sonra EFT/Havale ile ödeme yapmak için IBAN numarası tarafınıza iletilecektir.',
            'odeme_nakit_aciklama': 'Ödemenizi, transferin gerçekleşeceği tarih ve saatte aracınızın şoförüne elden teslim edebilirsiniz.'
        };
    }
      
    const translations = getTranslations();
    const radios = document.querySelectorAll('input[name="pay-option"]');
    const header = document.getElementById('info-header');
    const info = document.getElementById('info');

    // Elementlerin var olup olmadığını kontrol et
    if (!radios || radios.length === 0) {
        console.error('Ödeme seçenekleri bulunamadı!');
        return;
    }
    
    if (!header || !info) {
        console.error('Bilgi elementleri bulunamadı!');
        return;
    }

    // Her radio button için event listener ekle
    radios.forEach(radio => {
        radio.addEventListener('change', function() {
            console.log('Ödeme seçeneği değişti:', this.id); // Debug için
            
            if (this.checked) {
                if (this.id === "EFT") {
                    header.innerHTML = "<i id='card' class='fa-solid fa-credit-card'></i> " + translations.odeme_eft;
                    info.textContent = translations.odeme_eft_aciklama;
                } else if (this.id === "cash") {
                    header.innerHTML = "<i class='fa-solid fa-wallet'></i> " + translations.odeme_nakit;
                    info.textContent = translations.odeme_nakit_aciklama;
                }
            }
        });
    });

    // Sayfa yüklendiğinde varsayılan olarak seçili olan seçeneği göster
    const checkedRadio = document.querySelector('input[name="pay-option"]:checked');
    if (checkedRadio) {
        checkedRadio.dispatchEvent(new Event('change'));
    }
    

    
})