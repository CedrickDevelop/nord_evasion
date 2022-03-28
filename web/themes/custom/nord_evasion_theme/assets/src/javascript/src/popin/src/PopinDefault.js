import { T } from "../../common/drupal/drupal";

class PopinDefault {

    constructor() {
        this.popinSelector = ".Popin";
        this.popinWrapperSelector = ".Popin-wrapper";
        this.popinTriggerSelector = ".Popin-trigger";
        this.closePopinButtonTitle = Drupal.t("Fermer la popin");
        this.specificClasses = [];
        this.closePopinElement;
        this.handleEscape = this.handleEscape.bind(this);
    }
    /**
     * Initialize event listeners
     */
    init() {
        const that = this;
        this.$body = document.body;
        this.$popins = document.querySelectorAll(this.popinSelector);
        this.$popinWrappers = [];
        this.$popins.forEach((popin) => { 
            this.$popinWrappers.push(popin?.querySelector(this.popinWrapperSelector));
        });
        this.$triggers = document.querySelectorAll(this.popinTriggerSelector);

        this.$triggers.forEach((trigger) => {
            trigger.addEventListener("click", (ev) => {
                this.triggerClick(ev);
            });
        });

        let closePopinElement = this.createCloseButton();

        this.$popinWrappers?.forEach((popinWrapper) => {
            let clonedCloseButton = closePopinElement.cloneNode(true);
            popinWrapper.appendChild(clonedCloseButton);
            this.closePopinElement = clonedCloseButton;
            clonedCloseButton.addEventListener("click", (ev) => {
                this.closePopins();
            })
        })

        this.$popins.forEach((popin) => {
            popin.addEventListener("click", function (ev) {
                if(ev.target === this) {
                    that.closePopins();
                }
            });
        });


    }

    addTabIndex(popin) {
        var firstTabIndex = document.createElement("div");
        var lastTabIndex = document.createElement("div");
        firstTabIndex.setAttribute("tabindex", 0);
        lastTabIndex.setAttribute("tabindex", 0);
        popin.insertBefore(firstTabIndex, popin.firstChild);
        popin.appendChild(lastTabIndex);
    }

    removeTabIndex(popin) {
        var tabsIndex = popin.querySelectorAll("div[tabindex='0']");
        for (var i = 0; i < tabsIndex.length; i++) {
            tabsIndex[i].remove();
        }
    }

    /**
     * Open modal when click on trigger
     */
    triggerClick(ev) {

        this.closePopins();


        let target = ev.currentTarget.dataset.popinTarget;
        let popin = document.querySelector(target);
        this.addTabIndex(popin);
        popin.classList.add("open");

        document.addEventListener("keypress", this.handleEscape);

        // freeze body to prevent scroll
        this.$body.classList.add("no-scroll", ...this.specificClasses);
    }

    /**
     * Close all popins
     */
    closePopins() {
        document.removeEventListener("keypress", this.handleEscape);

        this.$popins.forEach((popin) => {
            popin.classList.remove("open");
            this.removeTabIndex(popin);
        })


        //REMOVE FROZEN STATE OF BODY
        this.$body.classList.remove("no-scroll", ...this.specificClasses);
    }

    createCloseButton() {
        let closeButton = document.createElement("button");
        closeButton.classList.add("Popin-close", "icon-cross", "fa-thin", "fa-times");
        closeButton.setAttribute("role", "button");
        closeButton.setAttribute("title", this.closePopinButtonTitle);
        return closeButton;
    }

    handleEscape(event) {
        if(event.keyCode === 27) {
            this.closePopins();
        }
    }

    /**
     * Attach.
     * @param context
     */
    attach(context) {
        if (T.contextIsRoot(context)) {
            this.init(context);
        }
    }
}

export default PopinDefault;
export let popinDefault = new PopinDefault();
