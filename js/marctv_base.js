(function($) {
  $(document).ready(function($) {
    $("p > img").parent().addClass('childIMG');
    $("p > .jqvideo").parent().addClass('childIMG');
    $("#nav > ul").addClass("hamburger");
    $('<a class="hamburger-icon"></a>').prependTo('#nav').click(
            function() {
              $('#nav .hamburger').fadeToggle('fast');
            }
    );

    // detect svg and add body class
    if (document.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#Shape", "1.1")) {
      $("body").addClass("svg");
    }

    if (is_touch_device()) {
      $('body').addClass('is-touch');
    }

    $(".header .innerheader").sticky({
      topSpacing: 0,
      redocked_callback: redocked,
      undocked_callback: undocked
    });

    // detect touch device and adds body class
    function is_touch_device() {
      return 'ontouchstart' in window // works on most browsers 
              || 'onmsgesturechange' in window; // works on ie10
    }

    function undocked(el) {
      el.css('background', $('body').css('background-color')).css('box-shadow', '0 2px 6px #333');
    }

    function redocked(el) {
      el.css('background', 'transparent').css('box-shadow', 'none');
    }

  });
})(jQuery); 