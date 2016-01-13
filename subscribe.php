<?php
/**
 * Template Name: Subscribe
 *
 * Description: social
 *
 */
get_header();
?>


<div id="fb-root"></div>
<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/de_DE/sdk.js#xfbml=1&version=v2.5&appId=325002757651257";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>


<div id="content" class="section">
    <div class="entry">
        <h1 class="title entry-title">
            <span><?php esc_html(the_title()); ?><?php edit_post_link('edit', '<small> ', '</small>'); ?></span></h1>
        <?php the_content(); ?>
    </div>
    <ul class="container social-buttons showontouch">
        <li class="box first">

            <div class="fb-like" data-href="https://www.facebook.com/MarcTV.de" data-width="960" data-layout="button"
                 data-action="like" data-show-faces="true" data-share="true"></div>

        </li>
        <li class="box"><a href="https://twitter.com/MarcTV" class="twitter-follow-button" data-show-count="false"
                           data-size="large" data-dnt="true">Follow @MarcTV</a>
            <script>!function (d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                    if (!d.getElementById(id)) {
                        js = d.createElement(s);
                        js.id = id;
                        js.src = p + '://platform.twitter.com/widgets.js';
                        fjs.parentNode.insertBefore(js, fjs);
                    }
                }(document, 'script', 'twitter-wjs');</script>
        </li>
        <li class="box last">
            <!-- Füge dieses Tag in den head-Abschnitt oder direkt vor dem schließenden body-Tag ein. -->
            <script src="https://apis.google.com/js/platform.js" async defer>
                {lang: 'de'}
            </script>

            <!-- Füge dieses Tag an der Stelle ein, an der die Widget erscheinen soll. -->
            <div class="g-follow" data-annotation="bubble" data-height="24" data-href="https://plus.google.com/115994269084957841104" data-rel="publisher"></div>
        </li>
    </ul>

</div><!-- #primary -->

<?php get_footer(); ?>

