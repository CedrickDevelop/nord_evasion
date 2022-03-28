import {dynamicMap} from "./src/DynamicMap";

(function (Drupal) { // closure
    'use strict';
    Drupal.behaviors.dynamicMap = dynamicMap;
}(Drupal));
