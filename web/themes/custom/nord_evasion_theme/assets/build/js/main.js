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

  /**
   * Class exemple de gestion du footer
   */

  var Footer = /*#__PURE__*/function () {
    function Footer() {
      _classCallCheck(this, Footer);
    }

    _createClass(Footer, [{
      key: "init",
      value:
      /**
       * init
       */
      function init() {}
      /**
       * Attach.
       * @param context
       */

    }, {
      key: "attach",
      value: function attach(context) {
        if (T.contextIsRoot(context)) {
          this.init();
        }
      }
    }]);

    return Footer;
  }();

  var footer = new Footer();

  /**
   * Class de gestion du header mobile
   */

  var Header = /*#__PURE__*/function () {
    function Header() {
      _classCallCheck(this, Header);

      this.$body = document.body;
    }
    /**
     * init
     */


    _createClass(Header, [{
      key: "init",
      value: function init(context, settings) {
        var _this = this;

        //******** MOBILE MENU *************//
        var $hamburger = context.getElementById("Hamburger");
        $hamburger.addEventListener("click", function (ev) {
          _this.$body.classList.toggle("js-mobile-menu");
        }); //********** SEARCH POPIN ***********//
        // const $searchButton = context.querySelectorAll(".Menu-search")[0];
        // $searchButton.addEventListener("click", (ev) => {
        //   this.$body.classList.toggle("js-search-open");
        // });
        //************ SCROLL BEHAVIOR ************//

        if (window.pageYOffset > 160) {
          this.$body.classList.add("js-scroll"); // setTimeout(function() {
          //   document.querySelector("main").style.overflowY = 'initial';
          // }, 500);
        }

        context.addEventListener("scroll", function (ev) {
          if (window.pageYOffset > 160) {
            _this.$body.classList.add("js-scroll");
          } else {
            _this.$body.classList.remove("js-scroll");
          }

          console.log();
        }); //*********** BACK TO TOP BUTTON ******************//

        context.getElementById("backToTop").addEventListener("click", function (ev) {
          window.scrollTo({
            top: 0,
            behavior: 'smooth'
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

    return Header;
  }();

  var header = new Header();

  (function (Drupal) {

    Drupal.behaviors.footer = footer;
    Drupal.behaviors.header = header;
  })(Drupal);

})();
//# sourceMappingURL=main.js.map
