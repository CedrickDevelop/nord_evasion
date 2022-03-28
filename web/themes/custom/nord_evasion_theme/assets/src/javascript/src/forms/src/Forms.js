import {T} from "../../common/drupal/drupal"

class Forms {
    init(context, settings) {
        //Add contact
        const $forms = context.querySelectorAll("form.user-login-form, form.webform-submission-contact-form-form");
        console.log($forms);
        Array.from($forms).map(($form) => {
            const $textInputs = $form.querySelectorAll("input[type='text'], input[type='email'], input[type='password']");
            Array.from($textInputs).map(($textInput) => {
                if($textInput === context.activeElement) {
                    const $inputWrapper = $textInput.parentNode;
                    $inputWrapper.classList.add("focusing");
                }
                $textInput.addEventListener("focus", (e) => {
                    const $inputWrapper = e.target.parentNode;
                    $inputWrapper.classList.add("focusing");
                });
                $textInput.addEventListener("blur", (e) => {
                    const $inputWrapper = e.target.parentNode;
                    $inputWrapper.classList.remove("focusing");
                });
            })
        });
    }

    /**
     * Attach.
     * @param context
     */
    attach(context, settings) {
        if (T.contextIsRoot(context)) {
            this.init(context, settings);       
        }
    }

}

export let forms = new Forms();