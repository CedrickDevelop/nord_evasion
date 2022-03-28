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

  var DynamicMap = /*#__PURE__*/function () {
    function DynamicMap() {
      _classCallCheck(this, DynamicMap);
    }

    _createClass(DynamicMap, [{
      key: "init",
      value: function init(context) {
        var _this = this;

        var paragraphs = context.querySelectorAll(".ParagraphDynamicMap-slides");
        paragraphs.forEach(function (paragraph) {
          var _paragraph$closest;

          var length = paragraph.querySelectorAll(".TermDestinationDynamicMap").length;
          var swiper = new Swiper(paragraph, {
            loop: true,
            navigation: {
              nextEl: paragraph.querySelector('.swiper-button-next'),
              prevEl: paragraph.querySelector('.swiper-button-prev')
            }
          });
          var $allDestinationLinks = (_paragraph$closest = paragraph.closest(".ParagraphDynamicMap-content")) === null || _paragraph$closest === void 0 ? void 0 : _paragraph$closest.querySelectorAll("a.DynamicMap-link");
          $allDestinationLinks === null || $allDestinationLinks === void 0 ? void 0 : $allDestinationLinks.forEach(function ($destinationLink) {
            $destinationLink.addEventListener("click", function (e) {
              e.preventDefault();
              var slideToFocus = paragraph.querySelector(".TermDestinationDynamicMap[data-destination=\"".concat($destinationLink.getAttribute("href").substring(1), "\"]"));
              swiper.slideTo(parseInt(slideToFocus.getAttribute("data-swiper-slide-index")) + 1);
            });
          });
          swiper.on('activeIndexChange', function () {
            var activeSlide = this.slides[this.realIndex + 1];
            var activeDestination = activeSlide.getAttribute('data-destination');
            var paragraphParent = paragraph.closest(".ParagraphDynamicMap-content");
            var destinationLink = paragraphParent.querySelector("a[*|href=\"#".concat(activeDestination, "\"]"));
            var allDestinationLinks = destinationLink.parentNode.querySelectorAll("a");
            allDestinationLinks.forEach(function (aDestinationLink) {
              aDestinationLink.classList.remove("is-active");
            });
            destinationLink.classList.add('is-active');
          });

          var randomSlideIndex = _this.getRandomArbitrary(1, length + 1);

          swiper.slideTo(randomSlideIndex);

          if (randomSlideIndex === 1) {
            var activeSlide = swiper.slides[1];
            var activeDestination = activeSlide.getAttribute('data-destination');
            var paragraphParent = paragraph.closest(".ParagraphDynamicMap-content");
            var destinationLink = paragraphParent.querySelector("a[*|href=\"#".concat(activeDestination, "\"]"));
            var allDestinationLinks = destinationLink.parentNode.querySelectorAll("a");
            allDestinationLinks.forEach(function (aDestinationLink) {
              aDestinationLink.classList.remove("is-active");
            });
            destinationLink.classList.add('is-active');
          }
        });
      }
    }, {
      key: "getRandomArbitrary",
      value: function getRandomArbitrary(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min)) + min;
      }
    }, {
      key: "attach",
      value: function attach(context, settings) {
        if (T.contextIsRoot(context)) {
          this.init(context);
        }
      }
    }]);

    return DynamicMap;
  }();

  var dynamicMap = new DynamicMap();

  (function (Drupal) {

    Drupal.behaviors.dynamicMap = dynamicMap;
  })(Drupal);

})();
//# sourceMappingURL=dynamicMap.js.map
