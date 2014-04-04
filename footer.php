<?php if (is_home()) : ?>

  <?php
  $tagcache = false;
  if (get_option('marctv-cache')) {
    $tagcache = get_transient('taghtml');
    // If it wasn't there regenerate the data and save the transient
  }

  if (!$tagcache) {
    $tagcache = wp_tag_cloud(array(
      'smallest' => 8,
      'largest' => 14,
      'number' => 50,
      'format' => 'flat',
      'echo' => false));
    set_transient('taghtml', $tagcache, 24 * 60 * 60);
  }

  echo '<div class="section tagcloud">' . $tagcache . '</div>';
  ?>
<?php endif ?>
<?php wp_footer(); ?>
</div> <!-- /site -->
<div id="bottom">
  <div class="inner">
    <nav class="site">
      <ul class="container section">
        <li class="box first">
          <div class="supertitle">Suche</div>
          <?php get_search_form(); ?>
        </li>
        <li class="box">
          <div class="supertitle">Abonnieren</div>
          <ul class="rows">
            <li>
              <ul>
                <li><a rel="nofollow" target="_blank" href="https://www.facebook.com/MarcTV.de">Facebook</a></li>
                <li><a rel="nofollow" target="_blank" href="https://twitter.com/marctv">Twitter</a></li>
                <li><a rel="nofollow" target="_blank" href=" http://cloud.feedly.com/#subscription%2Ffeed%2Fhttp%3A%2F%2Fmarctv.de%2Ffeed">Feedly</a></li>
              </ul>
            </li>
            <li>
              <ul>
                <li><a rel="nofollow" target="_blank" href="http://www.youtube.com/MarcDK">YouTube</a></li>
                <li><a rel="nofollow" target="_blank" href="https://twitch.tv/marctvde">Twitch.TV</a></li>
                <li><a target="_blank" href="https://plus.google.com/113333812119791259931?rel=author">Google+</a></li>
                <li><a target="_blank" rel="publisher" href="https://plus.google.com/+MarctvDe/">Google+ Page</a></li>
              </ul>
            </li>
          </ul>
        </li>
        <li class="box last">
          <div class="supertitle">Wichtiges</div>
          <ul class="rows">
            <li>
              <ul>
                <li><a href="http://marctv.de/marc-toensing/#impressum">Impressum</a></li>
                <li><a href="http://marctv.de/blogfreunde/">Blogfreunde</a></li>
              </ul>
            </li>
          </ul>
        </li>

      </ul>
    </nav>
  </div>
  <?php
  wp_reset_query();
  ?>
  <div class="lastwords">Dirty and Mean - MarcTV <?php echo date('Y'); ?></div>
</div>

</body>
</html>
<!-- <?php
  printf(__('%d queries. %s seconds. '), get_num_queries(), timer_stop(0, 3));
  echo_memory_usage();
  ?> -->