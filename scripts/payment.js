  const radios = document.querySelectorAll('input[name="pay-option"]');
  const header = document.getElementById('info-header');
  const info = document.getElementById('info');

  radios.forEach(radio => {
    radio.addEventListener('change', () => {
      if (radio.checked) {
        if (radio.id === "EFT") {
          header.innerHTML = "<i id='card' class='fa-solid fa-credit-card'></i> EFT / Havale";
          info.textContent = "Rezervasyonunuz onaylandıktan sonra EFT/Havale ile ödeme yapmak için IBAN numarası tarafınıza iletilecektir.";
        } else if (radio.id === "cash") {
          header.innerHTML = "<i class='fa-solid fa-wallet'></i> Nakit Öde";
          info.textContent = "Ödemenizi, transferin gerçekleşeceği tarih ve saatte aracınızın şoförüne elden teslim edebilirsiniz.";
        }
      }
    });
  });