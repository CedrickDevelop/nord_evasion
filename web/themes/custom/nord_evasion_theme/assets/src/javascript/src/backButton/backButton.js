import {backButton} from "./src/BackButton";

(function (Drupal) { // closure
    'use strict';
    Drupal.behaviors.backButton = backButton;
}(Drupal));