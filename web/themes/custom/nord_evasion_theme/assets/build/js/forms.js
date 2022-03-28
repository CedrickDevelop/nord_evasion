(function () {
  'use strict';

  function _classCallCheck(instance, Constructor) {
    if (!(instance instanceof Constructor)) {
      throw new TypeError("Cannot call a class as a function");
    }
  }

  function _defineProperties(target, props) {
    for (var i = 0; i < props.length; i++) {
      var descriptor = props[i];
      descriptor.enumerable = descriptor.enumerable || false;
      descriptor.configurable = true;
      if ("value" in descriptor) descriptor.writable = true;
      Object.defineProperty(target, descriptor.key, descriptor);
    }
  }

  function _createClass(Constructor, protoProps, staticProps) {
    if (protoProps) _defineProperties(Constructor.prototype, protoProps);
    if (staticProps) _defineProperties(Constructor, staticProps);
    Object.defineProperty(Constructor, "prototype", {
      writable: false
    });
    return Constructor;
  }

  var T = {
    /**
     * Renvoie vrai si le context est root (document)
     * @param context
     */
    contextIsRoot: function contextIsRoot(context) {
      return 'HTML' === context.children[0].tagName;
    },

    /**
     * Retourne vrai si la variable est définie.
     * @param variable
     * @returns {boolean}
     */
    isDefined: function isDefined(variable) {
      return 'undefined' !== typeof variable;
    },

    /**
     * Retourne la taille de la fenêtre dans un objet avec .width et .height
     * @returns object
     */
    viewport: function viewport() {
      var e = window,
          a = 'inner';

      if (!('innerWidth' in window)) {
        a = 'client';
        e = document.documentElement || document.body;
      }

      return {
        width: e[a + 'Width'],
        height: e[a + 'Height']
      };
    }
  };

  var Forms = /*#__PURE__*/function () {
    function Forms() {
      _classCallCheck(this, Forms);
    }

    _createClass(Forms, [{
      key: "init",
      value: function init(context, settings) {
        //Add contact
        var $forms = context.querySelectorAll("form.user-login-form, form.webform-submission-contact-form-form");
        console.log($forms);
        Array.from($forms).map(function ($form) {
          var $textInputs = $form.querySelectorAll("input[type='text'], input[type='email'], input[type='password']");
          Array.from($textInputs).map(function ($textInput) {
            if ($textInput === context.activeElement) {
              var $inputWrapper = $textInput.parentNode;
              $inputWrapper.classList.add("focusing");
            }

            $textInput.addEventListener("focus", function (e) {
              var $inputWrapper = e.target.parentNode;
              $inputWrapper.classList.add("focusing");
            });
            $textInput.addEventListener("blur", function (e) {
              var $inputWrapper = e.target.parentNode;
              $inputWrapper.classList.remove("focusing");
            });
          });
        });
      }
      /**
       * Attach.
       * @param context
       */

    }, {
      key: "attach",
      value: function attach(context, settings) {
        if (T.contextIsRoot(context)) {
          this.init(context, settings);
        }
      }
    }]);

    return Forms;
  }();

  var forms = new Forms();

  (function (Drupal) {

    Drupal.behaviors.forms = forms;
  })(Drupal);

})();
//# sourceMappingURL=forms.js.map
