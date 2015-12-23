</div>
<div class="site projects">
<?php

if (is_home()): ?>

    <?php
    $tagcache = false;
    if (get_option('marctv-cache')) {
        $tagcache = get_transient('taghtml');

        // If it wasn't there regenerate the data and save the transient


    }

    if (!$tagcache) {
        $tagcache = wp_tag_cloud(array('smallest' => 10, 'largest' => 18, 'number' => 50, 'format' => 'flat', 'echo' => false));
        set_transient('taghtml', $tagcache, 24 * 60 * 60);
    }

    echo '<div class="section tagcloud"><div class="col_title supertitle"><span>Weitere Themen</span></div>' . $tagcache . '</div>';
    ?>
<?php
endif
?>


    <div class="container section docked ">
        <div class="col_title supertitle"><span>Andere Projekte</span></div>

        <ul class="container showontouch small section">

            <li class="box first"><a class="inverted infobox " href="http://shortscore.org"
                               rel="bookmark">
                    <?php echo get_the_post_thumbnail(20648,'medium'); ?>
                    <h2 class="title">SHORTSCORE.org</h2></a></li>
            <li class="box "><a class="inverted infobox " href="http://verschlichtern.de"
                                     rel="bookmark">
                    <?php echo get_the_post_thumbnail(20695,'medium'); ?>
                    <h2 class="title">verschlichtern.de</h2></a></li>
            <li class="box last"><a class="inverted infobox " href="http://kunstpixel.de"
                                    rel="bookmark">
                    <?php echo get_the_post_thumbnail(21168,'medium'); ?>
                    <h2 class="title">kunstpixel.de</h2></a></li>
        </ul>
    </div>
    </div>



<div id="bottom">
    <div class="inner">


        <ul class="site socialbox container section">
            <li class="box first">

                <ul class="rows">
                    <li>
                        <ul>
                            <li><a class="dashicons dashicons-rss"" rel="nofollow" target="_blank" href="/feed"><span>Abonniere MarcTV als Feed</span></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <ul>
                            <li><a class="dashicons dashicons-twitter" rel="nofollow" target="_blank"
                                   href="http://www.twitter.com/MarcTV"><span>Folge MarcTV auf Twitter</span></a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="box">
                <ul class="rows">
                    <li>
                        <ul>
                            <li><a class="dashicons dashicons-wordpress-alt" rel="nofollow" target="_blank" href="https://profiles.wordpress.org/marcdk/#content-plugins"><span>Wordpress</span></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <ul>
                            <li><a class="dashicons dashicons-video-alt3" rel="nofollow" target="_blank"
                                   href="http://www.youtube.com/MarcDK"><span>Folge MarcTV auf YouTube</span></a></li>

                        </ul>
                    </li>
                </ul>
            </li>
            <li class="box last">
                <ul class="rows">
                    <li>
                        <ul>
                            <li><a class="dashicons dashicons-facebook" rel="nofollow" target="_blank"
                                   href="https://www.facebook.com/MarcTV.de"><span>Folge Marc auf Facebook</span></a>
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
        <a rel="nofollow" href="/netiquette/">Netiquette</a> - <a rel="nofollow" href="/blogfreunde">Blogfreunde</a> -
        <a rel="nofollow" href="/marc-toensing/">Über mich</a>
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