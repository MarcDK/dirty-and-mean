<?php
/**
 * Template Name: Top Games
 *
 * Description: A custom top game
 *
 */
get_header();
?>


<div id="content" class="section">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <?php
      if (function_exists('yoast_breadcrumb')) {
        yoast_breadcrumb('<div class="section breadcrumbs">', '</div>');
      }
      ?>
      <div class="entry">
        <h1 class="title entry-title"><span><?php esc_html(the_title()); ?><?php edit_post_link('edit', '<small> ', '</small>'); ?></span></h1>
        <?php the_content(); ?>
      </div>
    <?php
    endwhile;
  endif;
  ?>

  <ul class="container">
    <?php
    $args = array(
      'post_type' => 'post',
      'meta_key' => 'rating',
      'orderby' => 'meta_value_num',
      'posts_per_page' => '99',
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
      if ($key % 3 == 0) {
        echo '<li class="box last">';
      } else if (($key - 1) % 3 == 0) {
        echo '<li class="box first">';
      } else {
        echo '<li class="box">';
      }

      echo get_marctv_teaser(get_the_ID(), true, '', 'medium', true, '', '', false);

      if ($key % 3 == 0) {
        echo '</ul><ul class="container">';
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

<?php get_footer(); ?>

