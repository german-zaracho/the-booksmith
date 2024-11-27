var slides = document.querySelectorAll('.homeSlide');
var btns = document.querySelectorAll('.homeSliderBtn');
let currentSlide = 1;

var manualNav = function(manual){

    slides.forEach((slide) => {
        slide.classList.remove('active');

        btns.forEach((btn) => {
            btn.classList.remove('active');
        });
    });

    slides[manual].classList.add('active');
    btns[manual].classList.add('active');
}

btns.forEach((btn, i) => {
    btn.addEventListener("click", () => {
        manualNav(i);
        currentSlide = i;
    });
});