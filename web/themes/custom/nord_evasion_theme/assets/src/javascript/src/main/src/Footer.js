import {$, T} from "../../common/drupal/drupal";
/**
 * Class exemple de gestion du footer
 */
class Footer {

    /**
     * init
     */
    init(){
        
    }

    /**
     * Attach.
     * @param context
     */
    attach(context) {
        if (T.contextIsRoot(context)) {
            this.init();
        }
    }
}

export let footer = new Footer();
