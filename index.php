<?php get_header(); ?>
<?php if (!is_paged()) : ?>
  <div id="content" class="section">

    <ul class="container docked lead">

      <?php
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

    <?php echo get_marctv_sticky_posts(); ?>

    <?php echo get_marctv_posts_container(true,true); ?>
   <?php echo get_marctv_posts_container(true,false); ?>


    <?php echo get_marctv_teaserblock(); ?>

    <?php echo marctv_get_randompost(); ?>

    <div id="marctvflickrbar"></div>

  </div>
  <?php wp_reset_query(); ?>
<?php else : ?>
  <?php wp_redirect("http://marctv.de/paged", 404) ?>
<?php endif; ?>
<?php get_footer(); ?>