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

  var CarouselPhoto = /*#__PURE__*/function () {
    function CarouselPhoto() {
      _classCallCheck(this, CarouselPhoto);
    }

    _createClass(CarouselPhoto, [{
      key: "init",
      value: function init(context) {
        var paragraphs = context.querySelectorAll(".ParagraphCarousel-slides");
        paragraphs.forEach(function (paragraph) {
          new Swiper(paragraph, {
            pagination: {
              el: paragraph.querySelector('.swiper-pagination'),
              clickable: true
            },
            navigation: {
              nextEl: paragraph.querySelector('.swiper-button-next'),
              prevEl: paragraph.querySelector('.swiper-button-prev')
            }
          });
        });
      }
    }, {
      key: "attach",
      value: function attach(context, settings) {
        if (T.contextIsRoot(context)) {
          this.init(context);
        }
      }
    }]);

    return CarouselPhoto;
  }();

  var carouselPhoto = new CarouselPhoto();

  (function (Drupal) {

    Drupal.behaviors.carouselPhoto = carouselPhoto;
  })(Drupal);

})();
//# sourceMappingURL=carouselPhoto.js.map
