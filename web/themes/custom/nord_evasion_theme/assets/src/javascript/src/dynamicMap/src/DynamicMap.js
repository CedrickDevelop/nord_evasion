import { T } from "../../common/drupal/drupal";

class DynamicMap {


    init(context) {

        const paragraphs = context.querySelectorAll(".ParagraphDynamicMap-slides");

        const sliders = [];
        paragraphs.forEach((paragraph) => {
            const length = paragraph.querySelectorAll(".TermDestinationDynamicMap").length;

            const swiper = new Swiper(paragraph, {
                loop: true,
                navigation: {
                    nextEl: paragraph.querySelector('.swiper-button-next'),
                    prevEl: paragraph.querySelector('.swiper-button-prev'),
                }
            });


            const $allDestinationLinks = paragraph.closest(".ParagraphDynamicMap-content")?.querySelectorAll("a.DynamicMap-link");
            $allDestinationLinks?.forEach(($destinationLink) => {
                $destinationLink.addEventListener("click", function (e) {
                    e.preventDefault();
                    const slideToFocus = paragraph.querySelector(`.TermDestinationDynamicMap[data-destination="${$destinationLink.getAttribute("href").substring(1)}"]`);
                    swiper.slideTo(parseInt(slideToFocus.getAttribute("data-swiper-slide-index")) + 1);

                });
            });

            swiper.on('activeIndexChange', function () {
                const activeSlide = this.slides[this.realIndex + 1];
                let activeDestination = activeSlide.getAttribute('data-destination');
                const paragraphParent = paragraph.closest(".ParagraphDynamicMap-content");
                const destinationLink = paragraphParent.querySelector(`a[*|href="#${activeDestination}"]`);
                let allDestinationLinks = destinationLink.parentNode.querySelectorAll("a");
                allDestinationLinks.forEach((aDestinationLink) => {
                    aDestinationLink.classList.remove("is-active");
                })
                destinationLink.classList.add('is-active');
            });

            let randomSlideIndex = this.getRandomArbitrary(1, length + 1);
            
            swiper.slideTo(randomSlideIndex);
            if(randomSlideIndex === 1) {
                const activeSlide = swiper.slides[1];
                let activeDestination = activeSlide.getAttribute('data-destination');
                const paragraphParent = paragraph.closest(".ParagraphDynamicMap-content");
                const destinationLink = paragraphParent.querySelector(`a[*|href="#${activeDestination}"]`);
                let allDestinationLinks = destinationLink.parentNode.querySelectorAll("a");
                allDestinationLinks.forEach((aDestinationLink) => {
                    aDestinationLink.classList.remove("is-active");
                })
                destinationLink.classList.add('is-active');
            }
            sliders.push(swiper);

        });
    }

    getRandomArbitrary(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min)) + min;
    }


    attach(context, settings) {
        if (T.contextIsRoot(context)) {
            this.init(context);
        }
    }
}

export let dynamicMap = new DynamicMap();