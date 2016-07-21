(function ($) {
    $(document).ready(function ($) {

        $('.hamburger-icon').click(
            function () {
                $('#navigation .hamburger').toggle().parent().children('.hamburger-icon').toggleClass('active dashicons-no-alt');
            }
        );

        // detect svg and add body class
        if (document.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#Shape", "1.1")) {
            $("body").addClass("svg");
        }

        $( '.gallery a').addClass('infobox').append('<span class="info comment-count"><span class="dashicons dashicons-images-alt2"></span></span>');

        $('#submit').on("click", function () {
            if( $('#author').length != 0  && window._gaq != 0 && _gaq.push != 0 ) {
                var author = $('#author').val();
                _gaq.push(['_trackEvent', 'comment', 'submit', author]);
            }
        });

    });
})(jQuery);