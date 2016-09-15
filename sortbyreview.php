<?php
/**
 * Template Name: Top Games
 *
 * Description: A custom top game
 *
 */
get_header();
?>
<div class="site main-content">
<div id="content" class="section">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <div class="entry">
        <h1 class="title entry-title"><span><?php esc_html(the_title()); ?><?php edit_post_link('edit', '<small> ', '</small>'); ?></span></h1>
        <?php the_content(); ?>
      </div>
      <?php
    endwhile;
  endif;
  ?>

  <ul class="container morph showontouch docked">
    <?php
    $args = array(
      'post_type' => 'post',
      'meta_key' => "_shortscore_user_rating",
      'orderby' => 'meta_value_num',
      'posts_per_page' => '200',
      'cat' => get_option("marctv_cat2"),
      'nopaging' => false,
      'order' => 'DESC'
    );

    $the_query = new WP_Query($args);

    $key = 0;
    
    
    while ($the_query->have_posts()) :
      $the_query->the_post();
      $key++;
      // cfvalue:field 
      if ($key % 6 == 0) {
        echo '<li class="box last">';
      }
      else if (($key - 1) % 6 == 0) {
        echo '<li class="box first">';
      }
      else if (($key - 4 ) % 6 == 0) {
        echo '<li class="box multi-first">';
      }
      else if (($key - 3 ) % 6 == 0) {
        echo '<li class="box multi-last">';
      }
      else {
        echo '<li class="box">';
      }

      echo get_marctv_teaser(get_the_ID(), true, '', 'medium', true, '', '', false);

      if ($key % 6 == 0) {
        echo '</ul><ul class="container morph showontouch docked">';
      }
      ?>
      </li>
    <?php endwhile; ?>
  </ul>

  <?php
  /* Restore original Post Data 
   * NB: Because we are using new WP_Query we aren't stomping on the 
   * original $wp_query and it does not need to be reset.
   */
  wp_reset_postdata();
  ?>
</ul>
<?php marctv_pagination(" ", '<span class="pagenav">', "</span>", "« Vorherige", "Nächste »", 'span', '9'); ?>
</div><!-- #primary -->
</div>

<?php get_footer(); ?>

