import PopinDefault from "../../popin/src/PopinDefault"

class MediaPopin extends PopinDefault {
    constructor() {
        super();
        this.specificClasses = ["js-media-popin-open"];
        this.popinSelector = ".PopinMedia";
        this.closePopinButtonTitle = Drupal.t("Fermer la modale Media");
        this.popinTriggerSelector = ".Media-popin-trigger";
    }

    /**
    * Open modal when click on trigger
    */
    triggerClick(ev) {
        let target = ev.currentTarget.dataset.popinTarget;
        let popin = document.querySelector(target);
        this.closePopins();

        document.addEventListener("keydown", this.handleEscape);

        this.addTabIndex(popin);
        popin.classList.add("open");
        let mediaId = ev.currentTarget.getAttribute("data-popin-media-id");
        let path = '/ajax/m_enhance/display/';

        //let bundle = $trigger.data('popin-media-bundle');
        //if(bundle === 'video') {}

        Drupal.ajax({ "url": path + mediaId }).execute().done(
            (commands, statusString, ajaxObject) => {
                let newClose = this.createCloseButton();
                popin.querySelector('.Popin-wrapper').prepend(newClose);
                newClose.addEventListener("click", (ev) => {
                    this.closePopins();
                })
            }
        );


        // freeze body to prevent scroll
        this.$body.classList.add("no-scroll", ...this.specificClasses);
    }

}

export default MediaPopin;