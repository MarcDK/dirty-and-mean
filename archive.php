<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */
get_header();
?>
<div id="content" class="section">


  <?php if (have_posts()) : ?>
   
    <div class="entry">
      <?php /* If this is a category archive */ if (is_category()) {
        ?>
        <h1 class="title"><?php printf('%s', single_cat_title('', false)); ?></h1>
        <?php
        /* If this is a tag archive */
      } elseif (is_tag()) {
        ?>
        <h1 class="title"><?php printf('%s', single_tag_title('', false)); ?></h1>
        <?php
        /* If this is a daily archive */
      } elseif (is_day()) {
        ?>
        <h1 class="title"><?php printf('Archiv für %s | Tagesansicht', get_the_time(__('F jS, Y'))); ?></h1>
        <?php
        /* If this is a monthly archive */
      } elseif (is_month()) {
        ?>
        <h1 class="title"><?php printf('Archiv für %s | Monatsansicht', get_the_time(__('F, Y'))); ?></h1>
        <?php
        /* If this is a yearly archive */
      } elseif (is_year()) {
        ?>
        <h1 class="title"><?php printf('Archiv für %s | Jahresansicht', get_the_time(__('Y'))); ?></h1>
        <?php
        /* If this is an author archive */
      } elseif (is_author()) {
        ?>
        <h1 class="title">Author Archive</h1>
        <?php
        /* If this is a paged archive */
      } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
        ?>
        <h1 class="title">Blog Archives</h1>
      <?php } ?>

      <?php
      global $paged;
      if ($paged == 0) {
        echo tag_description();
      }
      ?>
    </div>

    <ul class="container morph">
      
      <?php
      $key = 0;
      while (have_posts()) : the_post();
        $key++;
        // cfvalue:field 
        if ($key % 6 == 0) {
          echo '<li class="box last">';
        } else if (($key - 1) % 6 == 0) {
          echo '<li class="box first">';
        } else if (($key - 4 ) % 6 == 0) {
          echo '<li class="box multi-first">';
        } else if (($key - 3 ) % 6 == 0) {
          echo '<li class="box multi-last">';
        } else {
          echo '<li class="box">';
        }

        echo get_marctv_teaser(get_the_ID(), true, '', 'medium', true, '', '', true);
        
        echo '</li>';
        
      endwhile;

      echo '</ul>';

    else :
      if (is_category()) { // If this is a category archive
        printf("<h1 class='center'>Sorry, but there aren't any posts in the %s category yet.</h1>", single_cat_title('', false));
      } else if (is_date()) { // If this is a date archive
        echo("<h1>Sorry, but there aren't any posts with this date.</h1>");
      } else if (is_author()) { // If this is a category archive
        $userdata = get_userdatabylogin(get_query_var('author_name'));
        printf("<h1 class='center'>Sorry, but there aren't any posts by %s yet.</h1>", $userdata->display_name);
      } else {
        echo("<h1 class='center'>No posts found.</h1>");
      }
      get_search_form();
    endif;
    ?>


    <div class="nav-article">
      <span class="nav-previous"><?php echo get_previous_posts_link('« Vorherige'); ?>&nbsp;</span>
      <span class="nav-next">&nbsp;<?php echo get_next_posts_link('Nächste »'); ?></span>
    </div>

    <?php marctv_pagination(" ", '<div class="nav-paged">', "</div>", "« Vorherige", "Nächste »", 'span', '6'); ?>

</div>

<?php get_footer(); ?>