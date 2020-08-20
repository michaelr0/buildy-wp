import Siema from 'siema';

let sliderClass = '.testimonial-slider'
let testiSlider = e => e

if (document.querySelector(sliderClass)) {


    testiSlider = () => {
        let currentIndex;
        let boxContent = document.querySelectorAll('.testimonial-slider__content')

        const prev = document.querySelectorAll('.arrow-left');
        const next = document.querySelectorAll('.arrow-right');

        const testiSlider = new Siema({
            selector: sliderClass,
            duration: 200,
            easing: 'ease-out',
            perPage: 1,
            startIndex: 0,
            draggable: false,
            multipleDrag: true,
            threshold: 20,
            loop: true,
            rtl: false,
            onInit: function () {
                currentIndex = this.currentSlide
                if (boxContent[currentIndex]) {
                    boxContent[currentIndex].classList.add('is-visible')
                }
            },
            onChange: function () {
                if (boxContent) {

                    boxContent.forEach(el => el.classList.replace("is-visible", "is-hidden"))

                    if (boxContent[this.currentSlide] && boxContent[this.currentSlide].classList.contains('is-hidden')) {
                        boxContent[this.currentSlide].classList.replace('is-hidden', 'is-visible')
                    }
                }
            },
        });

        prev.forEach((el) => el.addEventListener('click', () => testiSlider.prev()))
        next.forEach((el) => el.addEventListener('click', () => testiSlider.next()))
    }

}

export { testiSlider }
