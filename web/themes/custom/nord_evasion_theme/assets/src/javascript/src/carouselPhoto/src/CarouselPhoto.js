import { T } from "../../common/drupal/drupal";

class CarouselPhoto {


    init(context) {
        const paragraphs = context.querySelectorAll(".ParagraphCarousel-slides");
        const sliders = [];
        paragraphs.forEach((paragraph) => {
            const swiper = new Swiper(paragraph, {
                pagination: {
                    el: paragraph.querySelector('.swiper-pagination'),
                    clickable: true,
                },
                navigation: {
                    nextEl: paragraph.querySelector('.swiper-button-next'),
                    prevEl: paragraph.querySelector('.swiper-button-prev'),
                }
            });
            sliders.push(swiper);
        });
    }

    attach(context, settings) {
        if (T.contextIsRoot(context)) {
            this.init(context);
        }
    }
}

export let carouselPhoto = new CarouselPhoto();