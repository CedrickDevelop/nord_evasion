import PopinDefault from "../../popin/src/PopinDefault"

class SearchPopin extends PopinDefault {
    constructor() {
        super();
        this.popinSelector = ".PopinSearch";
        this.specificClasses = ["js-search-open"];
        this.closePopinButtonTitle = Drupal.t("Fermer la modale de recherche");
        this.popinTriggerSelector = ".Search-popin-trigger";
        this.$inputCheckbox;
        this.$inputSubmit;
        this.$inputToFocus;

        this.handleKeyDown = this.handleKeyDown.bind(this);
    }

    /**
    * Open modal when click on trigger
    */
    triggerClick(ev) {
        
        let target = ev.currentTarget.dataset.popinTarget;
        ev.currentTarget.blur();
        let popin = document.querySelector(target);

        this.$inputToFocus = popin.querySelector("input[name='search_api_fulltext']");
        this.$inputCheckbox = popin.querySelector("input[name='include_events[event]']");
        this.$inputSubmit = popin.querySelector("input[type='submit']");

        this.closePopins();

        popin.addEventListener("keydown", this.handleEscape);

        this.addTabIndex(popin);
        popin.classList.add("open");

        this.$inputToFocus.setAttribute("tabindex", "1");
        this.$inputCheckbox.setAttribute("tabindex", "2");
        this.$inputSubmit.setAttribute("tabindex", "3");
        this.closePopinElement.setAttribute("tabindex", "4");

        setTimeout(() => {
            this.$inputToFocus.focus();
        }, 100);

        // ********** PREVENT ENTER FROM SUBMITTING FORM ******** //
        window.addEventListener("keydown", this.handleKeyDown);

        // freeze body to prevent scroll
        this.$body.classList.add("no-scroll", ...this.specificClasses);
    }

    handleKeyDown(event) {
        console.log(event.keyCode);
        if(event.keyCode === 13 && document.activeElement === this.$inputCheckbox) {
            event.preventDefault();
            this.$inputCheckbox.checked = !this.$inputCheckbox.checked;
        }
    }

    handleEscape(event) {
        if(event.keyCode === 27) {
            this.closePopins();
        }
    }

    /**
     * Close all popins
     */
    closePopins() {
        window.removeEventListener("keydown", this.handleKeyDown);
        this.$popins.forEach((popin) => {
            popin.classList.remove("open");
            popin.removeEventListener("keydown", this.handleEscape);
            this.removeTabIndex(popin);
        })
        this.$inputToFocus.blur();
        this.$inputToFocus.removeAttribute("tabindex");
        this.$inputCheckbox.removeAttribute("tabindex");

        //REMOVE FROZEN STATE OF BODY
        this.$body.classList.remove("no-scroll", ...this.specificClasses);
    }

}

export default SearchPopin;