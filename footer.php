
<div class="site projects">

    <div class="container section ">
        <div class="col_title supertitle"><span>Andere Projekte</span></div>

        <ul class="container showontouch small section">

            <li class="box first"><a class="inverted infobox " href="http://shortscore.org"
                                     rel="bookmark">
                    <?php echo get_the_post_thumbnail(20648, 'thumbnail'); ?>
                    <h2 class="title">SHORTSCORE.org</h2></a></li>
            <li class="box "><a class="inverted infobox " href="http://verschlichtern.de"
                                rel="bookmark">
                    <?php echo get_the_post_thumbnail(20695, 'thumbnail'); ?>
                    <h2 class="title">verschlichtern.de</h2></a></li>
            <li class="box last"><a class="inverted infobox " href="http://kunstpixel.de"
                                    rel="bookmark">
                    <?php echo get_the_post_thumbnail(21168, 'thumbnail'); ?>
                    <h2 class="title">kunstpixel.de</h2></a></li>
        </ul>
    </div>
</div>


<div id="bottom">
    <div class="inner">
        <div class="section">
            <div class="title">MarcTV abonnieren und folgen:</div>
        </div>
        <ul class="site socialbox container section">
            <li class="box first">
                <ul class="rows">
                    <li>
                        <ul>
                            <li><a class="dashicons dashicons-rss"" target="_blank" href="/feed"><span>Abonniere MarcTV als Feed</span></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <ul>
                            <li><a class="dashicons dashicons-twitter" target="_blank"
                                   href="http://www.twitter.com/MarcTV"><span>Folge MarcTV auf Twitter</span></a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="box">
                <ul class="rows">
                    <li>
                        <ul>
                            <li><a class="dashicons dashicons-facebook" target="_blank"
                                   href="https://www.facebook.com/MarcTV.de"><span>Folge Marc auf Facebook</span></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <ul>
                            <li><a class="dashicons dashicons-video-alt3" target="_blank"
                                   href="http://www.youtube.com/MarcDK"><span>Folge MarcTV auf YouTube</span></a></li>

                        </ul>
                    </li>
                </ul>
            </li>
            <li class="box last">
                <ul class="rows">
                    <li>
                        <ul>
                            <li><a class="dashicons dashicons-wordpress-alt" target="_blank"
                                   href="https://profiles.wordpress.org/marcdk/#content-plugins"><span>Wordpress</span></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <ul>
                            <li><a class="dashicons dashicons-googleplus" target="_blank"
                                   href="https://plus.google.com/113333812119791259931?rel=author"><span>Folge Marc auf Google Plus</span></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>

        <p class="imprint"><a href="/impressum/">Impressum</a> -
            <a href="/netiquette/">Netiquette</a> - <a href="/blogfreunde">Blogfreunde</a>
            -
            <a href="/marc-toensing/">Über mich</a>
    </div>
    <?php
    wp_reset_query();
    ?>

</div>
<?php wp_footer(); ?>
</body>
</html>
<!-- <?php
printf(__('%d queries. %s seconds. '), get_num_queries(), timer_stop(0, 3));
echo_memory_usage();
?> -->