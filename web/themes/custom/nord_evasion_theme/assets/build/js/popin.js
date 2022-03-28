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

  function _toConsumableArray(arr) {
    return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread();
  }

  function _arrayWithoutHoles(arr) {
    if (Array.isArray(arr)) return _arrayLikeToArray(arr);
  }

  function _iterableToArray(iter) {
    if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter);
  }

  function _unsupportedIterableToArray(o, minLen) {
    if (!o) return;
    if (typeof o === "string") return _arrayLikeToArray(o, minLen);
    var n = Object.prototype.toString.call(o).slice(8, -1);
    if (n === "Object" && o.constructor) n = o.constructor.name;
    if (n === "Map" || n === "Set") return Array.from(o);
    if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen);
  }

  function _arrayLikeToArray(arr, len) {
    if (len == null || len > arr.length) len = arr.length;

    for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i];

    return arr2;
  }

  function _nonIterableSpread() {
    throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
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

  var PopinDefault = /*#__PURE__*/function () {
    function PopinDefault() {
      _classCallCheck(this, PopinDefault);

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


    _createClass(PopinDefault, [{
      key: "init",
      value: function init() {
        var _this = this,
            _this$$popinWrappers;

        var that = this;
        this.$body = document.body;
        this.$popins = document.querySelectorAll(this.popinSelector);
        this.$popinWrappers = [];
        this.$popins.forEach(function (popin) {
          _this.$popinWrappers.push(popin === null || popin === void 0 ? void 0 : popin.querySelector(_this.popinWrapperSelector));
        });
        this.$triggers = document.querySelectorAll(this.popinTriggerSelector);
        this.$triggers.forEach(function (trigger) {
          trigger.addEventListener("click", function (ev) {
            _this.triggerClick(ev);
          });
        });
        var closePopinElement = this.createCloseButton();
        (_this$$popinWrappers = this.$popinWrappers) === null || _this$$popinWrappers === void 0 ? void 0 : _this$$popinWrappers.forEach(function (popinWrapper) {
          var clonedCloseButton = closePopinElement.cloneNode(true);
          popinWrapper.appendChild(clonedCloseButton);
          _this.closePopinElement = clonedCloseButton;
          clonedCloseButton.addEventListener("click", function (ev) {
            _this.closePopins();
          });
        });
        this.$popins.forEach(function (popin) {
          popin.addEventListener("click", function (ev) {
            if (ev.target === this) {
              that.closePopins();
            }
          });
        });
      }
    }, {
      key: "addTabIndex",
      value: function addTabIndex(popin) {
        var firstTabIndex = document.createElement("div");
        var lastTabIndex = document.createElement("div");
        firstTabIndex.setAttribute("tabindex", 0);
        lastTabIndex.setAttribute("tabindex", 0);
        popin.insertBefore(firstTabIndex, popin.firstChild);
        popin.appendChild(lastTabIndex);
      }
    }, {
      key: "removeTabIndex",
      value: function removeTabIndex(popin) {
        var tabsIndex = popin.querySelectorAll("div[tabindex='0']");

        for (var i = 0; i < tabsIndex.length; i++) {
          tabsIndex[i].remove();
        }
      }
      /**
       * Open modal when click on trigger
       */

    }, {
      key: "triggerClick",
      value: function triggerClick(ev) {
        var _this$$body$classList;

        this.closePopins();
        var target = ev.currentTarget.dataset.popinTarget;
        var popin = document.querySelector(target);
        this.addTabIndex(popin);
        popin.classList.add("open");
        document.addEventListener("keypress", this.handleEscape); // freeze body to prevent scroll

        (_this$$body$classList = this.$body.classList).add.apply(_this$$body$classList, ["no-scroll"].concat(_toConsumableArray(this.specificClasses)));
      }
      /**
       * Close all popins
       */

    }, {
      key: "closePopins",
      value: function closePopins() {
        var _this2 = this,
            _this$$body$classList2;

        document.removeEventListener("keypress", this.handleEscape);
        this.$popins.forEach(function (popin) {
          popin.classList.remove("open");

          _this2.removeTabIndex(popin);
        }); //REMOVE FROZEN STATE OF BODY

        (_this$$body$classList2 = this.$body.classList).remove.apply(_this$$body$classList2, ["no-scroll"].concat(_toConsumableArray(this.specificClasses)));
      }
    }, {
      key: "createCloseButton",
      value: function createCloseButton() {
        var closeButton = document.createElement("button");
        closeButton.classList.add("Popin-close", "icon-cross", "fa-thin", "fa-times");
        closeButton.setAttribute("role", "button");
        closeButton.setAttribute("title", this.closePopinButtonTitle);
        return closeButton;
      }
    }, {
      key: "handleEscape",
      value: function handleEscape(event) {
        if (event.keyCode === 27) {
          this.closePopins();
        }
      }
      /**
       * Attach.
       * @param context
       */

    }, {
      key: "attach",
      value: function attach(context) {
        if (T.contextIsRoot(context)) {
          this.init(context);
        }
      }
    }]);

    return PopinDefault;
  }();
  var popinDefault = new PopinDefault();

  (function (Drupal) {

    Drupal.behaviors.popinDefault = popinDefault;
  })(Drupal);

})();
//# sourceMappingURL=popin.js.map
