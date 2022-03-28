import {carouselPhoto} from "./src/CarouselPhoto";

(function (Drupal) { // closure
    'use strict';
    Drupal.behaviors.carouselPhoto = carouselPhoto;
}(Drupal));