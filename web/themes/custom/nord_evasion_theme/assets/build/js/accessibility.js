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

  var Accessibility = /*#__PURE__*/function () {
    function Accessibility(context, settings) {
      var _this = this,
          _this$$buttonIncrease,
          _this$$buttonDecrease,
          _this$$buttonsToggleD;

      _classCallCheck(this, Accessibility);

      this.context = context;
      this.$buttons = this.context.querySelectorAll("button"); //ARIA PRESSED HANDLER ON BUTTON

      Array.from(this.$buttons).map(function ($button) {
        $button.removeEventListener("click", _this.ariaPressedHandler);
        $button.addEventListener("click", _this.ariaPressedHandler);
      }); //ACCESSIBILITY FONT SIZES

      this.currentFontSize = sessionStorage.getItem("fontSize");

      if (this.currentFontSize && this.currentFontSize <= 5 && this.currentFontSize >= 1) {
        this.context.children[0].classList.add("font-size-".concat(this.currentFontSize));
      } else {
        sessionStorage.setItem("fontSize", 3);
        this.currentFontSize = 3;
        this.context.children[0].classList.add("font-size-3");
      }

      this.$buttonIncreaseFontSize = document.querySelectorAll("button[data-font-size='increase']")[0];
      this.handleClickIncreaseFontSize = this.handleClickIncreaseFontSize.bind(this);
      (_this$$buttonIncrease = this.$buttonIncreaseFontSize) === null || _this$$buttonIncrease === void 0 ? void 0 : _this$$buttonIncrease.addEventListener("click", this.handleClickIncreaseFontSize);

      if (this.currentFontSize > 3) {
        this.$buttonIncreaseFontSize.classList.add("is-active");
      }

      this.$buttonDecreaseFontSize = document.querySelectorAll("button[data-font-size='decrease']")[0];
      this.handleClickDecreaseFontSize = this.handleClickDecreaseFontSize.bind(this);
      (_this$$buttonDecrease = this.$buttonDecreaseFontSize) === null || _this$$buttonDecrease === void 0 ? void 0 : _this$$buttonDecrease.addEventListener("click", this.handleClickDecreaseFontSize);

      if (this.currentFontSize < 3) {
        this.$buttonDecreaseFontSize.classList.add("is-active");
      } //ACCESSIBILITY DYSLEXIA


      this.currentFont = sessionStorage.getItem("fontFamily");

      if (this.currentFont === 'dyslexia') {
        this.context.children[0].classList.add("dyslexia");
      } else {
        sessionStorage.setItem("fontFamily", "classic");
      }

      this.$buttonsToggleDylsexiaFont = document.querySelectorAll("button[data-font-toggle='dyslexia']");
      this.handleClickDyslexia = this.handleClickDyslexia.bind(this);
      (_this$$buttonsToggleD = this.$buttonsToggleDylsexiaFont) === null || _this$$buttonsToggleD === void 0 ? void 0 : _this$$buttonsToggleD.forEach(function ($buttonsToggleDylsexiaFont) {
        $buttonsToggleDylsexiaFont.addEventListener("click", _this.handleClickDyslexia);

        if (_this.currentFont === "dyslexia") {
          $buttonsToggleDylsexiaFont.classList.add("is-active");
        }
      }); //ACCESSIBILITY FAST LINKS

      this.$fastLinkToMenu = document.querySelectorAll("a[href='#menu']")[0];
      this.$fastLinkToMenu.addEventListener("click", function (e) {
        e.preventDefault();
        document.querySelector(".Menu-main ul>li:first-of-type a").focus();
      });
      this.$fastLinkToSearch = document.querySelectorAll("a[href='#search']")[0];
      this.$fastLinkToSearch.addEventListener("click", function (e) {
        e.preventDefault();
        var $buttonTriggerSearch = document.querySelectorAll("button.Menu-search")[0];
        $buttonTriggerSearch.click();
      });
      this.$fastLinkToContent = document.querySelectorAll("a[href='#content'")[0];
      this.$fastLinkToContent.addEventListener("click", function (e) {
        e.preventDefault();
        var toolbarHeight = settings !== null && settings !== void 0 && settings.toolbar ? 90 : 0;
        var content = document.getElementById("content");
        window.scrollTo({
          top: content.offsetTop - toolbarHeight,
          behavior: 'smooth'
        });
        content.focus();
      });
    }

    _createClass(Accessibility, [{
      key: "ariaPressedHandler",
      value: function ariaPressedHandler(ev) {
        var ariaPressedValue = ev.currentTarget.getAttribute("aria-pressed");

        if (!ariaPressedValue || ariaPressedValue === 'false') {
          ev.currentTarget.setAttribute("aria-pressed", true);
        } else {
          ev.currentTarget.setAttribute("aria-pressed", !ariaPressedValue);
        }
      }
    }, {
      key: "handleClickIncreaseFontSize",
      value: function handleClickIncreaseFontSize(ev) {
        ev.currentTarget.classList.add("is-active");
        ev.currentTarget.setAttribute("aria-pressed", true);
        this.$buttonDecreaseFontSize.classList.remove("is-active");
        this.$buttonDecreaseFontSize.removeAttribute("aria-pressed", false);

        if (this.currentFontSize < 5) {
          this.currentFontSize++;
          sessionStorage.setItem("fontSize", this.currentFontSize);
          this.context.children[0].classList.replace("font-size-".concat(this.currentFontSize - 1), "font-size-".concat(this.currentFontSize));
        }
      }
    }, {
      key: "handleClickDecreaseFontSize",
      value: function handleClickDecreaseFontSize(ev) {
        ev.currentTarget.classList.add("is-active");
        ev.currentTarget.setAttribute("aria-pressed", true);
        this.$buttonIncreaseFontSize.classList.remove("is-active");
        this.$buttonIncreaseFontSize.removeAttribute("aria-pressed", false);

        if (this.currentFontSize > 1) {
          this.currentFontSize--;
          sessionStorage.setItem("fontSize", this.currentFontSize);
          this.context.children[0].classList.replace("font-size-".concat(this.currentFontSize + 1), "font-size-".concat(this.currentFontSize));
        }
      }
    }, {
      key: "handleClickDyslexia",
      value: function handleClickDyslexia(ev) {
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
    }, {
      key: "searchButtonHandler",
      value: function searchButtonHandler(target) {
        target.addEventListener("click", function (ev) {
          ev.currentTarget.setAttribute("aria-expanded", true);
        });
      }
    }]);

    return Accessibility;
  }();

  HTMLButtonElement.prototype.applyAccessibilityAriaPressed = function () {
    this.addEventListener("click", function (ev) {
      var ariaPressedValue = ev.currentTarget.getAttribute("aria-pressed");

      if (!ariaPressedValue || ariaPressedValue === 'false') {
        ev.currentTarget.setAttribute("aria-pressed", true);
      } else {
        ev.currentTarget.setAttribute("aria-pressed", !ariaPressedValue);
      }
    });
  };

  (function (Drupal) {

    Drupal.behaviors.accessibility = {
      attach: function attach(context, settings) {
        var accessiblity = new Accessibility(context, settings);
        var menuSearch = context.querySelectorAll(".Menu-search");

        if (menuSearch.length > 0) {
          accessiblity.searchButtonHandler(menuSearch[0]);
        }
      }
    };
  })(Drupal);

})();
//# sourceMappingURL=accessibility.js.map
