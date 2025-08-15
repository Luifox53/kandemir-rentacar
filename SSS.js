(function(){
      const root = document.getElementById('faq-root');
      const items = Array.from(root.querySelectorAll('.item'));

      function closeItem(item) {
        const btn = item.querySelector('.question');
        const panel = item.querySelector('.panel');
        item.setAttribute('aria-expanded', 'false');
        btn.setAttribute('aria-expanded', 'false');
        panel.setAttribute('aria-hidden', 'true');
        panel.style.maxHeight = '0px';
      }

      function openItem(item) {
        const btn = item.querySelector('.question');
        const panel = item.querySelector('.panel');
        item.setAttribute('aria-expanded', 'true');
        btn.setAttribute('aria-expanded', 'true');
        panel.setAttribute('aria-hidden', 'false');
        // İçerik yüksekliğini ölç ve animasyon için ata
        panel.style.maxHeight = panel.scrollHeight + 'px';
      }

      function toggleItem(item) {
        const isOpen = item.getAttribute('aria-expanded') === 'true';
        // Önce tümünü kapat
        items.forEach(closeItem);
        // Son tıkladığını aç (eğer zaten açıksa hepsi kapalı kalır)
        if(!isOpen) openItem(item);
      }

      // Olay bağlama
      items.forEach(item => {
        const btn = item.querySelector('.question');
        const panel = item.querySelector('.panel');

        btn.addEventListener('click', () => toggleItem(item));

        // Geçiş sonrasında yüksekliği otomatikle güncelle (içerik değişirse taşma olmasın)
        const ro = new ResizeObserver(() => {
          if(item.getAttribute('aria-expanded') === 'true') {
            panel.style.maxHeight = panel.scrollHeight + 'px';
          }
        });
        ro.observe(panel);
      });


    })();