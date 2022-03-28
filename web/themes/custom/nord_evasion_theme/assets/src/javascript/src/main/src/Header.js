import {T} from "../../common/drupal/drupal";
/**
 * Class de gestion du header mobile
 */
class Header {

    constructor() {
        this.$body = document.body;
    }

    /**
     * init
     */
    init(context, settings) {
      

      //******** MOBILE MENU *************//
      const $hamburger = context.getElementById("Hamburger");
      $hamburger.addEventListener("click", (ev) => {
        this.$body.classList.toggle("js-mobile-menu");
      });

      //********** SEARCH POPIN ***********//
      // const $searchButton = context.querySelectorAll(".Menu-search")[0];
      // $searchButton.addEventListener("click", (ev) => {
      //   this.$body.classList.toggle("js-search-open");
      // });

      //************ SCROLL BEHAVIOR ************//
      if (window.pageYOffset > 160) {
        this.$body.classList.add("js-scroll");
        // setTimeout(function() {
        //   document.querySelector("main").style.overflowY = 'initial';
        // }, 500);
      }

      context.addEventListener("scroll", (ev) => {
        if(window.pageYOffset > 160) {
          this.$body.classList.add("js-scroll");
        } else {
          this.$body.classList.remove("js-scroll");
        }
        console.log();
      });

      //*********** BACK TO TOP BUTTON ******************//
      context.getElementById("backToTop").addEventListener("click", (ev) => {
        window.scrollTo({top: 0, behavior: 'smooth'});
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

export let header = new Header();
