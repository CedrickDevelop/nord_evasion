import ShareBlock from "./src/ShareBlock";
import { T } from "../common/drupal/drupal";

(function (Drupal) { // closure
    'use strict';

    // Popin
    Drupal.behaviors.shareBlock = {
        attach: (context, settings) => {
            if(T.contextIsRoot(context)) {
                const shareBlock = new ShareBlock(context);
                shareBlock.init();
            }
        }
    };
}(Drupal));