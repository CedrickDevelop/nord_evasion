class ShareBlock {

    constructor(context) {
        this.$shareButton = context.getElementById("share");
        this.$shareLinks = this.$shareButton?.nextElementSibling;

        this.handleShareButtonEvent = this.handleShareButtonEvent.bind(this);
        this.handleBlurShareButtonEvent = this.handleBlurShareButtonEvent.bind(this);
    }

    init() {
        this.$shareButton?.addEventListener("click", this.handleShareButtonEvent);
        this.$shareButton?.addEventListener("blur", this.handleBlurShareButtonEvent);
    }

    handleShareButtonEvent(e) {
        if (!this.$shareLinks?.classList.contains("active")) {
            this.$shareLinks?.classList.add("active");
        }
        else {
            this.$shareLinks?.classList.remove("active");
        }
    }

    handleBlurShareButtonEvent(e) {
        this.$shareLinks?.classList.remove("active");
    }
}

export default ShareBlock;