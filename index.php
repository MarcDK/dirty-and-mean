<?php get_header(); ?>
<?php if (!is_paged()) : ?>
  <div id="content" class="section">

    <ul class="container lead">

      <?php
      $sticky = get_option('sticky_posts');

      $linkcat = get_option("marctv_linkcat");
      $args = array(
        'numberposts' => '1',
        'post_status' => 'publish',
        'category__not_in' => $linkcat
      );

      $recent_arr = wp_get_recent_posts($args);
      $recent_pid = $recent_arr[0]['ID'];


      $lead_pid = $recent_pid;


      $do_not_duplicate = '';

      $do_not_duplicate[] = $lead_pid;
      update_option('do_not_duplicate', $do_not_duplicate);
      ?>

      <li class="box first last">
        <?php echo get_marctv_teaser($lead_pid, true, '', 'default'); ?>
      </li>
    </ul>

    <?php echo get_marctv_category_container(get_option("marctv_cat1"), get_option("marctv_cat2"), get_option("marctv_cat3"), FALSE, 'docked'); ?>
    <?php echo get_marctv_category_container(get_option("marctv_cat1"), get_option("marctv_cat2"), get_option("marctv_cat3"), 1, 'docked'); ?>



    <ul class="container bars">
      <li class="box first cat-more"><a href="<?php echo get_category_link(get_option("marctv_cat1")) ?>">Leben</a></li>
      <li class="box middle cat-more"><a href="<?php echo get_category_link(get_option("marctv_cat2")) ?>">Spiele</a></li>
      <li class="box last cat-more"><a href="<?php echo get_category_link(get_option("marctv_cat3")) ?>">Medien</a></li>
    </ul>

    <?php echo get_marctv_sticky_posts(); ?>

    <?php echo get_marctv_teaserblock(); ?>

    <?php echo marctv_get_randompost(); ?>

    <div id="marctvflickrbar"></div>

  </div>
  <?php wp_reset_query(); ?>
<?php else : ?>
  <?php wp_redirect("http://marctv.de/paged", 404) ?>
<?php endif; ?>
<?php get_footer(); ?>