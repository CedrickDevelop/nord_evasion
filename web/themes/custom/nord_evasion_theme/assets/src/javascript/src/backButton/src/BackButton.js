import { T } from "../../common/drupal/drupal";

class BackButton {

    constructor() {
        this.handleBackButton = this.handleBackButton.bind(this);
        this.refferer;
    }

    init(context) {
        const $backButton = context.getElementById("back");
        if(document.referrer.split('/')[2] !== location.hostname) {
            $backButton.classList.add('visually-hidden');
            $backButton.removeEventListener("click", this.handleBackButton);
        } else {
            this.referrer = document.referrer;
            $backButton.addEventListener("click", this.handleBackButton);
        }
    }

    handleBackButton(ev) {
        window.location.href = this.referrer;
    }

    attach(context, settings) {
        if (T.contextIsRoot(context)) {
            this.init(context);
        }
    }
}

export let backButton = new BackButton();