// Dil değiştirme fonksiyonu
function changeLanguage(lang) {
    // AJAX ile dil değiştir
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'includes/change_language.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Sayfayı yeniden yükle
            location.reload();
        }
    };
    
    xhr.send('lang=' + encodeURIComponent(lang));
}

// Dropdown menü toggle
document.addEventListener('DOMContentLoaded', function() {
    const dropdownToggle = document.getElementById('dropdown-toggle');
    const dropdownMenu = document.getElementById('dropdown-menu');
    
    if (dropdownToggle && dropdownMenu) {
        dropdownToggle.addEventListener('click', function(e) {
            e.preventDefault();
            dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
        });
        
        // Dışarı tıklandığında menüyü kapat
        document.addEventListener('click', function(e) {
            if (!dropdownToggle.contains(e.target)) {
                dropdownMenu.style.display = 'none';
            }
        });
        
        // Dil seçeneklerine click listener ekle
        const langLinks = dropdownMenu.querySelectorAll('a');
        langLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const lang = this.getAttribute('data-lang');
                if (lang) {
                    changeLanguage(lang);
                }
            });
        });
    }
});
