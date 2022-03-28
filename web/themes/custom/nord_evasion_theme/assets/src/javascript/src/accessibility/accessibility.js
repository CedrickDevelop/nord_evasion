import Accessibility from "./src/Accessibility";

(function (Drupal) { // closure
    'use strict';
    Drupal.behaviors.accessibility = {
        attach: (context, settings) => {
            const accessiblity = new Accessibility(context, settings);
            let menuSearch = context.querySelectorAll(".Menu-search");
            if(menuSearch.length > 0) {
                accessiblity.searchButtonHandler(menuSearch[0]);
            }
        }
    };
}(Drupal));
