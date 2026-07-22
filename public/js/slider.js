document.addEventListener("DOMContentLoaded", () => {
  const slider = document.querySelector(".slide-container");
  const slides = slider.querySelectorAll("img");
  let currentIndex = 0;

  // Asegura que el contenedor tenga el ancho correcto
  function setSliderWidth() {
    slider.style.width = `${slides.length * 100}%`;
    slides.forEach(slide => {
      slide.style.width = `${100 / slides.length}%`;
      slide.style.flexShrink = "0";
    });
  }

  function showSlide(index) {
    const offset = -index * (100 / slides.length);
    slider.style.transform = `translateX(${offset}%)`;
    slider.style.transition = "transform 0.8s ease-in-out";
  }

  function nextSlide() {
    currentIndex = (currentIndex + 1) % slides.length;
    showSlide(currentIndex);
  }

  // Inicializa el slider
  setSliderWidth();
  showSlide(currentIndex);
  setInterval(nextSlide, 5000); // Cambia cada 5 segundos
});
