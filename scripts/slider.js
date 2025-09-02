const slider = document.querySelector('.slider');
  const images = document.querySelectorAll('.slider img');
  let index = 0;

  function updateSlider() {
    slider.style.transform = `translateX(-${index * 100}vw)`;
  }

  function nextSlide() {
    if (index < images.length - 1) {
      index++;
      updateSlider();
    }
  }

  function prevSlide() {
    if (index > 0) {
      index--;
      updateSlider();
    }
  }

  
  const whatsapp = document.getElementById("whatsapp-float");

   window.addEventListener("scroll", () => {
    // sadece mobil için uygula
    if (window.innerWidth <= 768) {
      if (window.scrollY > 150) { 
        whatsapp.style.right = "20px";
        whatsapp.style.bottom = "20px";
      } else {
        whatsapp.style.right = "20px";
        whatsapp.style.bottom = "170px";
      }
    }
  });
  