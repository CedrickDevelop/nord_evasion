import SearchPopin from "./src/SearchPopin";
import { T } from "../common/drupal/drupal";

(function (Drupal) { // closure
    'use strict';

    // Popin
    Drupal.behaviors.searchPopin = {
        attach: (context, settings) => {
            if(T.contextIsRoot(context)) {
                const searchPopin = new SearchPopin();
                searchPopin.init(context);
            }
        }
    };
}(Drupal));