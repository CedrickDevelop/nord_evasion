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

  var ShareBlock = /*#__PURE__*/function () {
    function ShareBlock(context) {
      var _this$$shareButton;

      _classCallCheck(this, ShareBlock);

      this.$shareButton = context.getElementById("share");
      this.$shareLinks = (_this$$shareButton = this.$shareButton) === null || _this$$shareButton === void 0 ? void 0 : _this$$shareButton.nextElementSibling;
      this.handleShareButtonEvent = this.handleShareButtonEvent.bind(this);
      this.handleBlurShareButtonEvent = this.handleBlurShareButtonEvent.bind(this);
    }

    _createClass(ShareBlock, [{
      key: "init",
      value: function init() {
        var _this$$shareButton2, _this$$shareButton3;

        (_this$$shareButton2 = this.$shareButton) === null || _this$$shareButton2 === void 0 ? void 0 : _this$$shareButton2.addEventListener("click", this.handleShareButtonEvent);
        (_this$$shareButton3 = this.$shareButton) === null || _this$$shareButton3 === void 0 ? void 0 : _this$$shareButton3.addEventListener("blur", this.handleBlurShareButtonEvent);
      }
    }, {
      key: "handleShareButtonEvent",
      value: function handleShareButtonEvent(e) {
        var _this$$shareLinks;

        if (!((_this$$shareLinks = this.$shareLinks) !== null && _this$$shareLinks !== void 0 && _this$$shareLinks.classList.contains("active"))) {
          var _this$$shareLinks2;

          (_this$$shareLinks2 = this.$shareLinks) === null || _this$$shareLinks2 === void 0 ? void 0 : _this$$shareLinks2.classList.add("active");
        } else {
          var _this$$shareLinks3;

          (_this$$shareLinks3 = this.$shareLinks) === null || _this$$shareLinks3 === void 0 ? void 0 : _this$$shareLinks3.classList.remove("active");
        }
      }
    }, {
      key: "handleBlurShareButtonEvent",
      value: function handleBlurShareButtonEvent(e) {
        var _this$$shareLinks4;

        (_this$$shareLinks4 = this.$shareLinks) === null || _this$$shareLinks4 === void 0 ? void 0 : _this$$shareLinks4.classList.remove("active");
      }
    }]);

    return ShareBlock;
  }();

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

  (function (Drupal) {

    Drupal.behaviors.shareBlock = {
      attach: function attach(context, settings) {
        if (T.contextIsRoot(context)) {
          var shareBlock = new ShareBlock(context);
          shareBlock.init();
        }
      }
    };
  })(Drupal);

})();
//# sourceMappingURL=shareBlock.js.map
