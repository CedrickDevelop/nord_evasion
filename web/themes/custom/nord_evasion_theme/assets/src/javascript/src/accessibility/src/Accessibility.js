class Accessibility {
    constructor(context, settings) {
        this.context = context;
        this.$buttons = this.context.querySelectorAll("button");
        //ARIA PRESSED HANDLER ON BUTTON
        Array.from(this.$buttons).map($button => {
            $button.removeEventListener("click", this.ariaPressedHandler);
            $button.addEventListener("click", this.ariaPressedHandler);
        });

        //ACCESSIBILITY FONT SIZES
        this.currentFontSize = sessionStorage.getItem("fontSize");
        if (this.currentFontSize && this.currentFontSize <= 5 && this.currentFontSize >= 1) {
            this.context.children[0].classList.add(`font-size-${this.currentFontSize}`);
        } else {
            sessionStorage.setItem("fontSize", 3);
            this.currentFontSize = 3;
            this.context.children[0].classList.add(`font-size-3`);
        }
        this.$buttonIncreaseFontSize = document.querySelectorAll("button[data-font-size='increase']")[0];
        this.handleClickIncreaseFontSize = this.handleClickIncreaseFontSize.bind(this);
        this.$buttonIncreaseFontSize?.addEventListener("click", this.handleClickIncreaseFontSize);
        if (this.currentFontSize > 3) {
            this.$buttonIncreaseFontSize.classList.add("is-active");
        }

        this.$buttonDecreaseFontSize = document.querySelectorAll("button[data-font-size='decrease']")[0];
        this.handleClickDecreaseFontSize = this.handleClickDecreaseFontSize.bind(this);
        this.$buttonDecreaseFontSize?.addEventListener("click", this.handleClickDecreaseFontSize);
        if (this.currentFontSize < 3) {
            this.$buttonDecreaseFontSize.classList.add("is-active");
        }


        //ACCESSIBILITY DYSLEXIA
        this.currentFont = sessionStorage.getItem("fontFamily");
        if (this.currentFont === 'dyslexia') {
            this.context.children[0].classList.add(`dyslexia`);
        } else {
            sessionStorage.setItem("fontFamily", "classic");
        }
        this.$buttonsToggleDylsexiaFont = document.querySelectorAll("button[data-font-toggle='dyslexia']");
        this.handleClickDyslexia = this.handleClickDyslexia.bind(this);
        this.$buttonsToggleDylsexiaFont?.forEach(($buttonsToggleDylsexiaFont) => {
            $buttonsToggleDylsexiaFont.addEventListener("click", this.handleClickDyslexia);
            if (this.currentFont === "dyslexia") {
                $buttonsToggleDylsexiaFont.classList.add("is-active");
            }
        });

        //ACCESSIBILITY FAST LINKS
        this.$fastLinkToMenu = document.querySelectorAll("a[href='#menu']")[0];
        this.$fastLinkToMenu.addEventListener("click", (e) => {
            e.preventDefault();
            document.querySelector(".Menu-main ul>li:first-of-type a").focus();
        });

        this.$fastLinkToSearch = document.querySelectorAll("a[href='#search']")[0];
        this.$fastLinkToSearch.addEventListener("click", (e) => {
            e.preventDefault();
            let $buttonTriggerSearch = document.querySelectorAll("button.Menu-search")[0];
            $buttonTriggerSearch.click();
        });
        this.$fastLinkToContent = document.querySelectorAll("a[href='#content'")[0];
        this.$fastLinkToContent.addEventListener("click", (e) => {
            e.preventDefault();
            let toolbarHeight = settings?.toolbar ? 90 : 0;
            let content = document.getElementById("content");
            window.scrollTo({ top: content.offsetTop - toolbarHeight, behavior: 'smooth' });
            content.focus();
        })
    }

    ariaPressedHandler(ev) {
        let ariaPressedValue = ev.currentTarget.getAttribute("aria-pressed");
        if (!ariaPressedValue || ariaPressedValue === 'false') {
            ev.currentTarget.setAttribute("aria-pressed", true);
        } else {
            ev.currentTarget.setAttribute("aria-pressed", !ariaPressedValue);
        }
    }

    handleClickIncreaseFontSize(ev) {
        ev.currentTarget.classList.add("is-active");
        ev.currentTarget.setAttribute("aria-pressed", true);
        this.$buttonDecreaseFontSize.classList.remove("is-active");
        this.$buttonDecreaseFontSize.removeAttribute("aria-pressed", false);
        if (this.currentFontSize < 5) {
            this.currentFontSize++;
            sessionStorage.setItem("fontSize", this.currentFontSize);
            this.context.children[0].classList.replace(`font-size-${this.currentFontSize - 1}`, `font-size-${this.currentFontSize}`);
        }
    }

    handleClickDecreaseFontSize(ev) {
        ev.currentTarget.classList.add("is-active");
        ev.currentTarget.setAttribute("aria-pressed", true);
        this.$buttonIncreaseFontSize.classList.remove("is-active");
        this.$buttonIncreaseFontSize.removeAttribute("aria-pressed", false);
        if (this.currentFontSize > 1) {
            this.currentFontSize--;
            sessionStorage.setItem("fontSize", this.currentFontSize);
            this.context.children[0].classList.replace(`font-size-${this.currentFontSize + 1}`, `font-size-${this.currentFontSize}`);
        }
    }

    handleClickDyslexia(ev) {
        console.log(this.currentFont);
        if (this.currentFont === "classic") {
            ev.currentTarget.classList.add("is-active");
            ev.currentTarget.setAttribute("aria-pressed", true);
            sessionStorage.setItem("fontFamily", "dyslexia");
            this.context.children[0].classList.add("dyslexia");
            this.currentFont = "dyslexia";
        } else {
            ev.currentTarget.classList.remove("is-active");
            ev.currentTarget.removeAttribute("aria-pressed", true);
            sessionStorage.setItem("fontFamily", "classic");
            this.context.children[0].classList.remove("dyslexia");
            this.currentFont = "classic";
        }
    }

    searchButtonHandler(target) {
        target.addEventListener("click", (ev) => {
            ev.currentTarget.setAttribute("aria-expanded", true);
        });
    }

}

export default Accessibility;

HTMLButtonElement.prototype.applyAccessibilityAriaPressed = function () {
    this.addEventListener("click", (ev) => {
        let ariaPressedValue = ev.currentTarget.getAttribute("aria-pressed");
        if (!ariaPressedValue || ariaPressedValue === 'false') {
            ev.currentTarget.setAttribute("aria-pressed", true);
        } else {
            ev.currentTarget.setAttribute("aria-pressed", !ariaPressedValue);
        }
    });
}