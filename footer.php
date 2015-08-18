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
        $tagcache = wp_tag_cloud(array('smallest' => 8, 'largest' => 14, 'number' => 50, 'format' => 'flat', 'echo' => false));
        set_transient('taghtml', $tagcache, 24 * 60 * 60);
    }

    echo '<div class="section tagcloud"><div class="col_title supertitle"><span>Weitere Themen</span></div>' . $tagcache . '</div>';
    ?>
<?php
endif
?>


    <div class="container section docked">
        <div class="col_title supertitle"><span>Andere Projekte</span></div>

        <ul class="container showontouch section">
            <li class="box first"><a class="inverted infobox " href="http://verschlichtern.de"
                                     rel="bookmark">
                    <img width="300" alt="Verschlichtern" src="http://marctv.de/media/2015/03/verschlichtern-300x131.jpg">

                    <h2 class="title">verschlichtern.de</h2></a></li>
            <li class="box"><a class="inverted infobox " href="http://shortscore.org"
                               rel="bookmark">
                    <img width="300" alt="Shortscore" src="http://marctv.de/media/2015/01/shortscore-logo-300x131.png">

                    <h2 class="title">SHORTSCORE.org</h2></a></li>
            <li class="box last"><a class="inverted infobox " href="http://kunstpixel.de"
                                    rel="bookmark">
                    <img width="300" alt="Kunstpixel.de" src="http://marctv.de/media/2015/03/kunstpixel-300x130.jpg">

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
                            <li><a class="icon-feed" rel="nofollow" target="_blank" href="http://marctv.de/feed"><span>Abonniere MarcTV als Feed</span></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <ul>
                            <li><a class="icon-twitter" rel="nofollow" target="_blank"
                                   href="http://www.twitter.com/MarcTV"><span>Folge mir auf Twitter</span></a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="box">
                <ul class="rows">
                    <li>
                        <ul>
                            <li><a class="icon-twitch" rel="nofollow" target="_blank" href="https://twitch.tv/marctvde"><span>Folge mir auf Twitch</span></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <ul>
                            <li><a class="icon-youtube" rel="nofollow" target="_blank"
                                   href="http://www.youtube.com/MarcDK"><span>Folge mir auf YouTube</span></a></li>

                        </ul>
                    </li>
                </ul>
            </li>
            <li class="box last">
                <ul class="rows">
                    <li>
                        <ul>
                            <li><a class="icon-facebook" rel="nofollow" target="_blank"
                                   href="https://www.facebook.com/MarcTV.de"><span>Folge mir auf Facebook</span></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <ul>
                            <li><a class="icon-googleplus" target="_blank"
                                   href="https://plus.google.com/113333812119791259931?rel=author"><span>Folge mir auf Google Plus</span></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>

        <p class="imprint">MarcTV <?php echo date('Y'); ?> - <a href="/marc-toensing/#impressum">Impressum</a> - <a
                rel="nofollow" href="/netiquette/">Netiquette</a> - <a rel="nofollow"
                                                                       href="/blogfreunde">Blogfreunde</a> - Theme: <a
                rel="nofollow" href="https://github.com/MarcDK/dirty-and-mean/">MarcTV's Dirty and Mean</a> - <a
                rel="nofollow" href="/blog/marctv-wordpress-plugins/">MarcTV Wordpress Plugins</a></p>
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