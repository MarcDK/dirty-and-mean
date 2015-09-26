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
        $tagcache = wp_tag_cloud(array('smallest' => 8, 'largest' => 14, 'number' => 50, 'format' => 'flat', 'echo' => false));
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
            <li class="box first"><a class="inverted infobox " href="http://verschlichtern.de"
                                     rel="bookmark">
                    <img src="http://marctv.de/media/2015/03/verschlichtern-960x418.jpg" alt="verschlichtern" width="960" height="418" class="alignnone size-large wp-image-20704" srcset="http://marctv.de/media/2015/03/verschlichtern-130x57.jpg 130w, http://marctv.de/media/2015/03/verschlichtern-300x130.jpg 300w, http://marctv.de/media/2015/03/verschlichtern-960x418.jpg 960w, http://marctv.de/media/2015/03/verschlichtern.jpg 1920w, http://marctv.de/media/2015/03/verschlichtern-460x200.jpg 460w" sizes="(max-width: 960px) 100vw, 960px">

                    <h2 class="title">verschlichtern.de</h2></a></li>
            <li class="box"><a class="inverted infobox " href="http://shortscore.org"
                               rel="bookmark">
                    <img src="http://marctv.de/media/2015/01/shortscore-logo-960x418.png" alt="Alle Spiele, Deine Scores. Dein Spielebewertungsportal" width="960" height="418" class="size-large wp-image-20650" srcset="http://marctv.de/media/2015/01/shortscore-logo-130x57.png 130w, http://marctv.de/media/2015/01/shortscore-logo-300x130.png 300w, http://marctv.de/media/2015/01/shortscore-logo.png 960w, http://marctv.de/media/2015/01/shortscore-logo-460x200.png 460w" sizes="(max-width: 960px) 100vw, 960px" />

                    <h2 class="title">SHORTSCORE.org</h2></a></li>
            <li class="box last"><a class="inverted infobox " href="http://kunstpixel.de"
                                    rel="bookmark">
                    <img src="http://marctv.de/media/2015/03/kunstpixel-960x418.jpg" alt="kunstpixel" width="960" height="418" class="alignnone size-large wp-image-20740" srcset="http://marctv.de/media/2015/03/kunstpixel-130x57.jpg 130w, http://marctv.de/media/2015/03/kunstpixel-300x130.jpg 300w, http://marctv.de/media/2015/03/kunstpixel-960x418.jpg 960w, http://marctv.de/media/2015/03/kunstpixel.jpg 1920w, http://marctv.de/media/2015/03/kunstpixel-460x200.jpg 460w" sizes="(max-width: 960px) 100vw, 960px" />

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
                            <li><a class="dashicons dashicons-rss"" rel="nofollow" target="_blank" href="http://marctv.de/feed"><span>Abonniere MarcTV als Feed</span></a>
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