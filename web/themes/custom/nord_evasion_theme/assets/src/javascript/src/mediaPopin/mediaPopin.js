import MediaPopin from "./src/MediaPopin";
import { T } from "../common/drupal/drupal";

(function (Drupal) { // closure
    'use strict';

    // Popin
    Drupal.behaviors.mediaPopin = {
        attach: (context, settings) => {
            if(T.contextIsRoot(context)) {
                const mediaPopin = new MediaPopin();
                mediaPopin.init(context);
            }
        }
    };
}(Drupal));