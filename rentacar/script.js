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