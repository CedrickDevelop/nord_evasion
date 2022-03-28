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

  function _inherits(subClass, superClass) {
    if (typeof superClass !== "function" && superClass !== null) {
      throw new TypeError("Super expression must either be null or a function");
    }

    subClass.prototype = Object.create(superClass && superClass.prototype, {
      constructor: {
        value: subClass,
        writable: true,
        configurable: true
      }
    });
    Object.defineProperty(subClass, "prototype", {
      writable: false
    });
    if (superClass) _setPrototypeOf(subClass, superClass);
  }

  function _getPrototypeOf(o) {
    _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) {
      return o.__proto__ || Object.getPrototypeOf(o);
    };
    return _getPrototypeOf(o);
  }

  function _setPrototypeOf(o, p) {
    _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) {
      o.__proto__ = p;
      return o;
    };

    return _setPrototypeOf(o, p);
  }

  function _isNativeReflectConstruct() {
    if (typeof Reflect === "undefined" || !Reflect.construct) return false;
    if (Reflect.construct.sham) return false;
    if (typeof Proxy === "function") return true;

    try {
      Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {}));
      return true;
    } catch (e) {
      return false;
    }
  }

  function _assertThisInitialized(self) {
    if (self === void 0) {
      throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
    }

    return self;
  }

  function _possibleConstructorReturn(self, call) {
    if (call && (typeof call === "object" || typeof call === "function")) {
      return call;
    } else if (call !== void 0) {
      throw new TypeError("Derived constructors may only return object or undefined");
    }

    return _assertThisInitialized(self);
  }

  function _createSuper(Derived) {
    var hasNativeReflectConstruct = _isNativeReflectConstruct();

    return function _createSuperInternal() {
      var Super = _getPrototypeOf(Derived),
          result;

      if (hasNativeReflectConstruct) {
        var NewTarget = _getPrototypeOf(this).constructor;

        result = Reflect.construct(Super, arguments, NewTarget);
      } else {
        result = Super.apply(this, arguments);
      }

      return _possibleConstructorReturn(this, result);
    };
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
  new PopinDefault();

  var SearchPopin = /*#__PURE__*/function (_PopinDefault) {
    _inherits(SearchPopin, _PopinDefault);

    var _super = _createSuper(SearchPopin);

    function SearchPopin() {
      var _this;

      _classCallCheck(this, SearchPopin);

      _this = _super.call(this);
      _this.popinSelector = ".PopinSearch";
      _this.specificClasses = ["js-search-open"];
      _this.closePopinButtonTitle = Drupal.t("Fermer la modale de recherche");
      _this.popinTriggerSelector = ".Search-popin-trigger";
      _this.$inputCheckbox;
      _this.$inputSubmit;
      _this.$inputToFocus;
      _this.handleKeyDown = _this.handleKeyDown.bind(_assertThisInitialized(_this));
      return _this;
    }
    /**
    * Open modal when click on trigger
    */


    _createClass(SearchPopin, [{
      key: "triggerClick",
      value: function triggerClick(ev) {
        var _this2 = this,
            _this$$body$classList;

        var target = ev.currentTarget.dataset.popinTarget;
        ev.currentTarget.blur();
        var popin = document.querySelector(target);
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
        setTimeout(function () {
          _this2.$inputToFocus.focus();
        }, 100); // ********** PREVENT ENTER FROM SUBMITTING FORM ******** //

        window.addEventListener("keydown", this.handleKeyDown); // freeze body to prevent scroll

        (_this$$body$classList = this.$body.classList).add.apply(_this$$body$classList, ["no-scroll"].concat(_toConsumableArray(this.specificClasses)));
      }
    }, {
      key: "handleKeyDown",
      value: function handleKeyDown(event) {
        console.log(event.keyCode);

        if (event.keyCode === 13 && document.activeElement === this.$inputCheckbox) {
          event.preventDefault();
          this.$inputCheckbox.checked = !this.$inputCheckbox.checked;
        }
      }
    }, {
      key: "handleEscape",
      value: function handleEscape(event) {
        if (event.keyCode === 27) {
          this.closePopins();
        }
      }
      /**
       * Close all popins
       */

    }, {
      key: "closePopins",
      value: function closePopins() {
        var _this3 = this,
            _this$$body$classList2;

        window.removeEventListener("keydown", this.handleKeyDown);
        this.$popins.forEach(function (popin) {
          popin.classList.remove("open");
          popin.removeEventListener("keydown", _this3.handleEscape);

          _this3.removeTabIndex(popin);
        });
        this.$inputToFocus.blur();
        this.$inputToFocus.removeAttribute("tabindex");
        this.$inputCheckbox.removeAttribute("tabindex"); //REMOVE FROZEN STATE OF BODY

        (_this$$body$classList2 = this.$body.classList).remove.apply(_this$$body$classList2, ["no-scroll"].concat(_toConsumableArray(this.specificClasses)));
      }
    }]);

    return SearchPopin;
  }(PopinDefault);

  (function (Drupal) {

    Drupal.behaviors.searchPopin = {
      attach: function attach(context, settings) {
        if (T.contextIsRoot(context)) {
          var searchPopin = new SearchPopin();
          searchPopin.init(context);
        }
      }
    };
  })(Drupal);

})();
//# sourceMappingURL=searchPopin.js.map
