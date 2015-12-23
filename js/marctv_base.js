(function ($) {
    $(document).ready(function ($) {


        $('.hamburger-icon').click(
            function () {
                console.debug(2);
                $('#navigation .hamburger').toggle().parent().children('.hamburger-icon').toggleClass('active dashicons-no-alt');
            }
        );


        // detect svg and add body class
        if (document.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#Shape", "1.1")) {
            $("body").addClass("svg");
        }


        if (is_touch_device()) {
            $('body').addClass('is-touch');
        } else if ($(window).width() > 640) {
            $(".header .innerheader").sticky({
                topSpacing: 0
            })

            /*.on('sticky-start', function () {
                $(".header .innerheader").animate({padding: '0.1em 0'});
            }).on('sticky-end', function () {
                $(".header .innerheader").animate({padding: '0.5em 0'});
            });
            */
        }

        // detect touch device
        function is_touch_device() {
            return 'ontouchstart' in window // works on most browsers
                || 'onmsgesturechange' in window; // works on ie10
        }


    });
})(jQuery);