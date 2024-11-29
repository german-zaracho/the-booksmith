import KeenSlider from 'https://cdn.jsdelivr.net/npm/keen-slider@6.8.6/+esm'

const keenSliderActive = document.getElementById('keen-slider-active');
const keenSliderCount = document.getElementById('keen-slider-count');

console.log('esta funcionando el reviews');

const keenSlider = new KeenSlider(
    '#keen-slider',
    {
        loop: true,
        defaultAnimation: {
            duration: 750,
        },
        slides: {
            origin: 'center',
            perView: 1,
            spacing: 16,
        },
        breakpoints: {
            '(min-width: 640px)': {
                slides: {
                    origin: 'center',
                    perView: 1.5,
                    spacing: 16,
                },
            },
            '(min-width: 768px)': {
                slides: {
                    origin: 'center',
                    perView: 1.75,
                    spacing: 16,
                },
            },
            '(min-width: 1024px)': {
                slides: {
                    origin: 'center',
                    perView: 3,
                    spacing: 16,
                },
            },
        },
        created(slider) {
            slider.slides[slider.track.details.rel].classList.remove('opacity-40')

            keenSliderActive.innerText = slider.track.details.rel + 1
            keenSliderCount.innerText = slider.slides.length
        },
        slideChanged(slider) {
            updateSlideOpacity(slider);
            keenSliderActive.innerText = slider.track.details.rel + 1;
        },
    },
    []
)

function updateSlideOpacity(slider) {
    const slideCount = slider.slides.length;
    const activeIndex = slider.track.details.rel; // active slide index

    // reset opacities
    slider.slides.forEach((slide, index) => {
        slide.classList.remove('opacity-40', 'opacity-0'); // remove existing classes
        slide.classList.add('opacity-40'); // add opacity-40
    });

    // remove opacity-40 so that it has normal opacity (1)
    slider.slides[activeIndex].classList.remove('opacity-40');

    // applies opacity-0 to the end slides
    const slideAtMinus2 = (activeIndex - 2 + slideCount) % slideCount; // left slide
    const slideAtPlus2 = (activeIndex + 2) % slideCount; // right slide

    slider.slides[slideAtMinus2].classList.add('opacity-0');
    slider.slides[slideAtPlus2].classList.add('opacity-0');
}

const keenSliderPrevious = document.getElementById('keen-slider-previous')
const keenSliderNext = document.getElementById('keen-slider-next')

keenSliderPrevious.addEventListener('click', () => keenSlider.prev())
keenSliderNext.addEventListener('click', () => keenSlider.next())