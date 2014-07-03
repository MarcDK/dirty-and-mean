<?php

function echo_memory_usage() {
  $mem_usage = memory_get_usage(true);

  if ($mem_usage < 1024)
    echo $mem_usage . " bytes";
  elseif ($mem_usage < 1048576)
    echo round($mem_usage / 1024, 2) . " kilobytes";
  else {
    echo round($mem_usage / 1048576, 2) . " megabytes";
  }
}

if (function_exists('add_image_size')) {
  add_image_size('facebookimage', 403, 403, true);
  //(cropped)
  add_image_size('fullhd', 1920, 836);
  add_image_size('legacy_m', 460, 200);
  add_image_size('legacy_s', 300, 130);
  add_image_size('4k', 3840, 1680);
  add_image_size('EOS', 4000, 1750);
}

add_filter('image_size_names_choose', 'my_custom_sizes');

function my_custom_sizes($sizes) {
  return array_merge($sizes, array('4k' => __('4k Resolution'), 'EOS' => __('EOS Full'),));
}

// img unautop
function img_unautop($pee) {
  $pee = preg_replace('/<p>\\s*?(<a .*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '<div class="figure">$1</div>', $pee);
  return $pee;
}

add_filter('the_content', 'img_unautop', 30);

function marctv_posted_on() {
  printf('<span class="%1$s">Veröffentlicht am</span> %2$s <span class="meta-sep">', 'meta-prep', sprintf('<span class="entry-date">%3$s</span>', get_permalink(), esc_attr(get_the_time()), get_the_date()));
}

/**
 * Display the marctv teaser
 *
 * @since 0.71
 *
 * @param integer $post_id Optional. The post_id of the post to display the teaser.
 * @param bool $show_info Optional. Show the infoboxt. Default is true.
 * @param string $additional_classes Optional. additional classes on a element.
 * @param string $imgsize image size: org, medium, small, default.
 * @param string $extra Extra html into box.
 * @param string $link override link.
 * @param bool $exerpt show exerpt.
 */
function get_marctv_teaser($post_id, $show_info = true, $additional_classes = '', $imgsize = false, $headline_bottom = true, $extra = '', $link = false, $show_excerpt = true) {

  if (!$post_id) {
    $post_id = get_the_ID();
  }

  if (is_sticky($post_id)) {
    $additional_classes = $additional_classes . " sticky";
  }

  if (!$link) {
    $link = get_permalink($post_id);
  }

  $teaser = '<a class="inverted infobox ' . $additional_classes . '" href="' . $link . '" rel="bookmark">';
  if (!$headline_bottom) {
    $teaser.= '<div class="title">' . esc_html(get_the_title($post_id)) . '</div>';
  }

  switch ($imgsize) {
    case "org":
      $imgsize = "full";
      break;

    case "medium":
      $imgsize = "medium";
      break;

    case "small":
      $imgsize = "thumbnail";
      break;

    case "large":
      $imgsize = "large";
      break;

    default:
      $imgsize = "full";
  }

  if (has_post_thumbnail($post_id)) {
    $img_html = wp_get_attachment_image(get_post_thumbnail_id($post_id), $imgsize);
    $html = preg_replace('/(height)=\"\d*\"\s/', "", $img_html);

    $teaser.= $html;
  }
  else {
    $teaser.= '<img src="/media/dummy.jpg" alt="' . (get_the_title($post_id)) . '" />';
  }

  if ($headline_bottom) {
    $teaser.= '<h2 class="title">' . esc_html(get_the_title($post_id)) . '</h2>';
  }

  if ($show_excerpt) {

    $excerpt = marctv_get_the_excerpt($post_id);

    /*
      $post_categories = wp_get_post_categories( $post_id, array('orderby' => 'term_order', 'order' => 'ASC'));

      $cats = array();
      $catlinks = '';

      foreach ($post_categories as $c) {
      $cat = get_category($c);
      $cats[] = array('name' => $cat->name, 'slug' => $cat->slug);
      $catlinks .= '<strong><a href = "' . get_category_link($c) . '">' . get_cat_name($c) . '</a></strong> ';
      }
     */

    $teaser.= '<p>' . $excerpt . '</p>';
  }

  if ($show_info) {
    $comment_count = get_comments_number($post_id);

    if ($comment_count == 0) {
      $comment_count = "Keine ";
    }

    $score = get_post_meta($post_id, 'rating');

    if ($extra) {
      $teaser.= '<div class="info">' . $extra . ' </div>';
    }
    else if ($score) {

      //$teaser .= '<span class="info comment-count">' . $comment_count . ' Kommentare</span>';
      $teaser.= '<span class="info rating">' . $score[0] . '/10</span>';
    }
    else {

      //$teaser .= '<span class="info comment-count">' . $comment_count . ' Kommentare</span>';
    }
  }

  $teaser.= '</a>';

  return $teaser;
}

function display_max_pages($posts_per_page) {
  if (!$posts_per_page) {
    $posts_per_page = 1;
  }

  global $wp_query;
  $numposts = $wp_query->found_posts;
  $max_num_pages = ceil($numposts / $posts_per_page);
  return $max_num_pages;
}






/**
 * Display fav articles
 *
 */
function get_marctv_favourite_articles() {
  $html = false;

  if (get_option('marctv-cache')) {
    $html = get_transient('marctv-purified-favarea');
  }

  if (!$html) {

    $do_not_duplicate = get_option('do_not_duplicate');

    $tagobj = get_term_by('slug', get_option("marctv_catfav"), 'post_tag');

    if ($tagobj->name) {

      query_posts(array('tag' => get_option("marctv_catfav"), 'showposts' => 2, 'post__not_in' => $do_not_duplicate, 'orderby' => 'rand'));

      $html = '<div class="container docked"><div class="supertitle"><span><a rel="tag" href="/blog/tag/' . get_option("marctv_catfav") . '/">' . $tagobj->name . '</a></span></div></div>';
      $html.= '<ul class="container double">';

      $key = 1;
      while (have_posts()):
        the_post();

        /* first-last classes */
        if ($key == 1) {
          $html.= '<li class="box first">';
        }
        else if ($key % 2 == 0) {
          $html.= '<li class="box last">';
        }
        else {
          $html.= '<li class="box">';
        }

        $key++;
        $html.= get_marctv_teaser(get_the_ID(), true, '', 'large', true, '', '', true);
        $html.= '</li>';
      endwhile;
      $html.= '</ul>';
    }
    set_transient('marctv-purified-favarea', $html, 24 * 60 * 60);
  }
  return $html;
}

function marctv_get_randompost($exclude = array(), $cat = "Reviews") {

  $html = false;

  if (get_option('marctv-cache')) {
    $html = get_transient('marctv-random');

    // If it wasn't there regenerate the data and save the transient
  }

  if (!$html) {
    query_posts(array('showposts' => 1, 'orderby' => 'rand', 'post__not_in' => $exclude, 'category_name' => $cat

        //You can insert any category name
    ));

    $html = '<div class="container docked"><div class="supertitle"><span><a href="' . get_category_link(get_cat_ID($cat)) . '">Spiel doch mal wieder…</a></span></div></div> ';
    $html.= '<ul class="container lead nomargin">';
    $html.= '<li class="box first last">';

    while (have_posts()):
      the_post();
      $html.= get_marctv_teaser(get_the_ID(), true, '', '', true, '', '', false);
    endwhile;

    $html.= '</li>';
    $html.= '</ul>';

    set_transient('marctv-random', $html, 24 * 60 * 60);
  }

  return $html;
}

/**
 * Display adb articles
 *
 */
function get_adb_article() {
  $html = '';
  if (get_option('marctv-cache')) {
    $html = get_transient('marctv-purified-adbarea');
  }
  if (!$html) {

    $the_tag = 'art-directed-blogging';
    $do_not_duplicate = get_option('do_not_duplicate');
    $do_not_duplicate[] = 7928;

    $tagobj = get_term_by('slug', $the_tag, 'post_tag');

    if ($tagobj->name) {

      query_posts(array('tag' => $the_tag, 'showposts' => 2, 'post__not_in' => $do_not_duplicate, 'orderby' => 'rand'));

      $html = '<div class="container docked"><div class="col_title supertitle"><span><a rel="tag" href="/blog/tag/' . $the_tag . '/">' . $tagobj->name . '</a></span></div></div>';
      $html.= '<ul class="container double">';
      $key = 1;
      while (have_posts()):
        the_post();

        /* first-last classes */
        if ($key == 1) {
          $html.= '<li class="box first">';
        }
        else if ($key % 2 == 0) {
          $html.= '<li class="box last">';
        }
        else {
          $html.= '<li class="box">';
        }
        $key++;
        $html.= get_marctv_teaser(get_the_ID(), true, '', 'large', true, '', '', true);

        $html.= '</li>';
      endwhile;
      $html.= '</ul>';

      set_transient('marctv-purified-adbarea', $html, 24 * 60 * 60);
    }
    update_option('do_not_duplicate', $do_not_duplicate);
  }

  return $html;
}

function get_marctv_tags($ids) {

  $args = array('numberposts' => 1, 'offset' => '', 'orderby' => '', 'order' => 'DESC', 'tax_query' => array('taxonomy' => 'tags', 'field' => 'slug', 'terms' => 'bestof'), 'meta_key' => '', 'meta_value' => '', 'post_type' => 'post', 'post_status' => 'publish');

  $postlist = get_posts($args);

  return $html;
}

function get_marctv_sticky_posts() {

  $html = '<div class="container docked"><div class="col_title supertitle"><span>Aktuelle Themen</span></div></div>';

  $do_not_duplicate = get_option('do_not_duplicate');

  $args = array('numberposts' => 3, 'offset' => '', 'orderby' => '', 'order' => 'DESC', 'include' => get_option('sticky_posts'), 'post__not_in' => $do_not_duplicate, 'meta_key' => '', 'meta_value' => '', 'post_type' => 'post', 'post_status' => 'publish');

  $postlist = get_posts($args);
  $html.= '<ul class="container">';
  $key = 1;

  foreach ($postlist as $post) {

    /* first-last classes */
    if ($key == 1) {
      $html.= '<li class="box first">';
    }
    else if ($key % 3 == 0) {
      $html.= '<li class="box last">';
    }
    else {
      $html.= '<li class="box">';
    }
    $key++;
    $html.= get_marctv_teaser($post->ID, true, '', 'medium', true, '', '', true);
    $html.= '</li>';
    $do_not_duplicate[] = $post->ID;
  }

  $html.= '</ul>';

  update_option('do_not_duplicate', $do_not_duplicate);

  return $html;
}

/**
 * Display articles most commented articles
 *
 */
function get_marctv_most_commented_articles() {

  $html = false;

  if (get_option('marctv-cache')) {
    $html = get_transient('marctv-purified-mostcom');
  }
  if (!$html) {

    $do_not_duplicate = get_option('do_not_duplicate');

    $html = '<div class="container most-commented docked"><div class="col_title supertitle"><span><a rel="nofollow" href="http://feeds.feedburner.com/marctv/comments">Meistkommentiert</a></span></div></div>';

    $args = array('numberposts' => 3, 'offset' => '', 'orderby' => 'comment_count', 'order' => 'DESC', 'include' => '', 'post__not_in' => array($do_not_duplicate), 'meta_key' => '', 'meta_value' => '', 'post_type' => 'post', 'post_status' => 'publish');

    $postlist = get_posts($args);

    $html.= '<ul class="container showontouch">';
    $key = 1;

    foreach ($postlist as $post) {

      /* first-last classes */
      if ($key == 1) {
        $html.= '<li class="box first">';
      }
      else if ($key % 3 == 0) {
        $html.= '<li class="box last">';
      }
      else {
        $html.= '<li class="box">';
      }
      $key++;
      $html.= get_marctv_teaser($post->ID, true, '', 'medium', true, '', '', false);
      $html.= '</li>';
    }

    $html.= '</ul>';
    set_transient('marctv-purified-mostcom', $html, 24 * 60 * 60);
  }
  return $html;
}

function get_marctv_teaserblock() {

  if (get_option('marctv-cache')) {
    $html1 = get_transient('marctv-purified-teaserblock');
    $html3 = get_transient('marctv-purified-teaserblock-cont');
  }

  if (!$html1) {
    $html1 = get_adb_article();
    $html1.= get_marctv_most_commented_articles();
    set_transient('marctv-purified-teaserblock', $html1, 24 * 60 * 60);
  }

  if (!$html3) {
    $html3 = get_marctv_favourite_articles();
    set_transient('marctv-purified-teaserblock-cont', $html3, 24 * 60 * 60);
  }
  $html = $html1 . $html3;
  return $html;
}

/**
 * Display the marctv category category
 *
 * @since 0.71
 *
 * @param integer $cat_id2 The first post_id of the post to display the teaser.
 * @param integer $cat_id2 The second post_id of the post to display the teaser.
 * @param integer $cat_id3 The third post_id of the post to display the teaser.
 * @param integer $offset Optional. The offset to the next post
 */
function get_marctv_category_container($cat_id1, $cat_id2, $cat_id3, $offset = false, $classes, $check_duplicates = true) {

  $teaser = '<ul class="container morph ' . $classes . '">';
  $teaser.= get_marctv_category_container_box($cat_id1, 'first ', 0, $check_duplicates);
  $teaser.= get_marctv_category_container_box($cat_id2, '', 0, $check_duplicates);
  $teaser.= get_marctv_category_container_box($cat_id3, 'multi-last', 0, $check_duplicates);

  $teaser.= get_marctv_category_container_box($cat_id1, 'multi-first', 0, $check_duplicates);
  $teaser.= get_marctv_category_container_box($cat_id2, '', 0, $check_duplicates);
  $teaser.= get_marctv_category_container_box($cat_id3, 'last', 0, $check_duplicates);

  $teaser.= '</ul>';

  return $teaser;
}

function get_marctv_category_container_box($cat_id, $class, $offset = false, $check_duplicates = true) {

  $do_not_duplicate = get_option('do_not_duplicate');

  $teaser = '<li class="box ' . $class . '">';

  $args = array('numberposts' => 1, 'offset' => $offset, 'category' => $cat_id, 'orderby' => 'post_date', 'order' => 'DESC', 'include' => '', 'post__not_in' => $do_not_duplicate, 'meta_key' => '', 'meta_value' => '', 'post_type' => 'post', 'post_status' => 'publish', 'suppress_filters' => true);

  $postlist = get_posts($args);

  $teaser.= '<div class="supertitle"><span><a href="' . get_category_link($cat_id) . '">' . get_cat_name($cat_id) . '</a></span></div>';

  foreach ($postlist as $post) {
    $teaser.= get_marctv_teaser($post->ID, true, '', 'medium', true, '', '', true);
    $do_not_duplicate[] = $post->ID;
    update_option('do_not_duplicate', $do_not_duplicate);
  }
  $teaser.= '</li>';

  return $teaser;
}

function get_parent_category_id($post_ID) {

  $categories = get_the_category($post_ID);

  foreach ($categories as $category) {

    // Retrieve first occurence of category without a parent
    if ($category->parent == 0) {
      $category_id = $category->cat_ID;
    }
  }

  return $category_id;
}

function get_marctv_selected_categories($cat1, $cat2, $cat3) {

}

function get_marctv_posts_container($duplicates = true, $docked = true) {

  $html = '';

  if ($duplicates) {
    $do_not_duplicate = get_option('do_not_duplicate');
  }

  $args = array('numberposts' => 3, 'offset' => '', 'category' => '', 'orderby' => 'post_date', 'order' => 'DESC', 'post__not_in' => $do_not_duplicate, 'meta_key' => '', 'meta_value' => '', 'post_type' => 'post', 'post_status' => 'publish', 'suppress_filters' => true);

  $postlist = get_posts($args);

  $key = 0;

  foreach ($postlist as $post) {

    $key++;

    if ($key == 1) {
      $docked_class = '';
      if ($docked) {
        $docked_class = 'docked';
      }
      $html.= '<ul class="container bars ' . $docked_class . '">';
    }

    switch ($key) {
      case 1:
        $class = "odd first";
        break;

      case 2:
        $class = "middle even";
        break;

      case 3:
        $class = "odd last";
        break;

      default:
        $class = "";
    }

    $html.= '<li class="box ' . $class . '">';
    $html.= '<div class="supertitle"><span><a href="' . get_category_link(get_parent_category_id($post->ID)) . '">' . get_cat_name(get_parent_category_id($post->ID)) . '</a></span></div>';

    $html.= get_marctv_teaser($post->ID, true, '', 'medium', true, '', '', true);
    $do_not_duplicate[] = $post->ID;

    $html.= '</li>';

    if ($key % 3 == 0) {
      $html.= '</ul>';
    }
  }

  update_option('do_not_duplicate', $do_not_duplicate);

  return $html;
}

function marctv_comment($comment, $args, $depth) {
  $GLOBALS['comment'] = $comment;
  ?>
  <span class="skiplink" id="comment-<?php comment_ID(); ?>"></span>
  <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
    <div>
      <div class="comment-author vcard">
        <?php echo get_avatar($comment, $size = '100') ?>

        <?php printf(__('<cite class="fn">%s</cite> <span class="says">sagt:</span>'), get_comment_author_link()) ?>
      </div>
      <?php if ($comment->comment_approved == '0'): ?>
        <em><?php _e('Your comment is awaiting moderation.') ?></em>
        <br />
      <?php endif;
      ?>
      <div class="comment-meta commentmetadata"><?php do_action('flag_comment_link'); ?> <a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)) ?>"><span><?php printf(__('%1$s'), get_comment_date('j. M Y')); ?></span></a><?php edit_comment_link(__('(Edit)'), '  ', ''); ?></div>
      <?php comment_text(); ?>
      <div class="reply">
        <?php comment_reply_link(array_merge($args, array('reply_text' => 'Antworten', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
      </div>
    </div>
    <?php
  }

  function marctv_pagination($seperator = ' | ', $after_previous = '&nbsp;&nbsp;', $before_next = '&nbsp;&nbsp;', $prelabel = 'Vorherige', $nxtlabel = 'Nächste', $current_page_tag = 'strong', $posts_per_page = '9') {
    global $paged, $wp_query;
    if ($paged == '') {
      $paged = 1;
    }

    $pagination = $after_previous;

    $numposts = $wp_query->found_posts;

    $max_num_pages = ceil($numposts / $posts_per_page);

    if ($max_num_pages > 1) {

      $offset = "3";

      for ($cnt = 1; $cnt <= $max_num_pages; $cnt++) {
        $classname = "hidden";

        if ($cnt == 1 OR $cnt == $max_num_pages) {
          $classname = '';
        }

        if ($cnt > ($paged - $offset) AND $cnt < ($paged + $offset)) {
          $classname = '';
        }
        else {
          if ($cnt == "2" OR $cnt == $max_num_pages - 1) {
            $x[] = "…";
          }
        }

        if ($current_page_tag && $paged == $cnt) {
          $begin_link = "<$current_page_tag>";
          $end_link = "</$current_page_tag>";
          $x[] = '<a class="current ' . $classname . '" href="' . get_pagenum_link($cnt) . '">' . $begin_link . $cnt . $end_link . '</a>';
        }
        else {
          $begin_link = "<$current_page_tag>";
          $end_link = "</$current_page_tag>";
          $x[] = '<a class="' . $classname . '" href="' . get_pagenum_link($cnt) . '">' . $begin_link . $cnt . $end_link . '</a>';
        }
      }

      $pagination.= join($seperator, $x);
    }
    $pagination.= $before_next;

    echo $pagination;
  }

  /* Admin menu */

  function marctv_theme_menu() {
    add_theme_page('Options', 'Category Options', 'manage_options', 'marctv-theme-simple-and-clean', 'marctv_theme_options');
  }

  function marctv_theme_options() {
    if (!current_user_can('manage_options')) {
      wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    $msg = '';
    if (isset($_POST['marctv-settings'])) {

      check_admin_referer('marctv-settings' . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);

      if (update_option('marctv_cat1', trim(stripslashes($_POST['marctv-cat1'])))) {
        $msg = '<p> cat1 saved.</p>';
      }
      if (update_option('marctv_cat2', trim(stripslashes($_POST['marctv-cat2'])))) {
        $msg = '<p> cat2 saved.</p>';
      }
      if (update_option('marctv_cat3', trim(stripslashes($_POST['marctv-cat3'])))) {
        $msg = '<p> cat3 saved.</p>';
      }
      if (update_option('marctv_catfav', trim(stripslashes($_POST['marctv-catfav'])))) {
        $msg = '<p> catfav saved.</p>';
      }
      if (update_option('marctv_linkcat', trim(stripslashes($_POST['marctv-linkcat'])))) {
        $msg = '<p> linkcat saved.</p>';
      }
      if (update_option('marctv-cache', trim(stripslashes($_POST['marctv-cache'])))) {
        $msg = '<p>Cache setting saved.</p>';
      }
    }

    echo '<div class="wrap">';
    echo '<div>Dirty & Mean Theme</div>';
    echo '<form method="post" action="">';
    echo '<input type="hidden" value="1" name="marctv-settings" id="marctv-settings" />';

    wp_nonce_field('marctv-settings' . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);

    echo '<p>Category ID 1:  <input  value="' . htmlentities(trim(stripslashes(get_option('marctv_cat1')))) . '" name="marctv-cat1" id="marctv-cat1" class="form_elem" size="30" type="text" /></p>';
    echo '<p>Category ID 2:  <input  value="' . htmlentities(trim(stripslashes(get_option('marctv_cat2')))) . '" name="marctv-cat2" id="marctv-cat2" class="form_elem" size="30" type="text" /></p>';
    echo '<p>Category ID 3:  <input  value="' . htmlentities(trim(stripslashes(get_option('marctv_cat3')))) . '" name="marctv-cat3" id="marctv-cat3" class="form_elem" size="30" type="text" /></p>';
    echo '<p>Category Linkcat:  <input  value="' . htmlentities(trim(stripslashes(get_option('marctv_linkcat')))) . '" name="marctv-linkcat" id="marctv-linkcat" class="form_elem" size="30" type="text" /></p>';
    echo '<p>Cache  <input  value="' . htmlentities(trim(stripslashes(get_option('marctv-cache')))) . '" name="marctv-cache" id="marctv-cache" class="form_elem" size="30" type="text" /></p>';
    echo '<p>Favorite tag slug (optional): <input  value="' . htmlentities(trim(stripslashes(get_option('marctv_catfav')))) . '" name="marctv-catfav" id="marctv-catfav" class="form_elem" size="30" type="text" /></p>';
    echo '<p class="submit"><input class="button-primary" type="submit" name="submit" value="Abspeichern" /></p>';
    echo '</form>';

    if (empty($msg)) {
      $msg.= '<p>no changes</p>';
    }
    if (!empty($msg)) {
      echo '<div id="message">' . $msg . '</div>';
    }
    echo '</div>';
  }

  function marctv_custom_login_logo() {
    echo '<style type="text/css">
    h1 a { background-image:url(' . get_bloginfo('template_directory') . '/images/wp_login.png) !important; }
  </style>';
  }

  function register_marctv_menus() {
    register_nav_menus(array('mainnav' => __('Main Navigation')));
  }

  function marctv_post_tags($posttags) {
    if (is_array($posttags)) {
      $the_tags = 'Weitere Artikel zu ';

      $i = 0;
      $divider = '';
      foreach ($posttags as $tag) {
        $i++;
        if ($i === count($posttags) && count($posttags) != 1) {
          $divider = ' und ';
        }
        else if ($i > 1) {
          $divider = ', ';
        }
        $the_tags.= $divider . '<a rel="tag" href="' . get_tag_link($tag->term_id) . '"><strong>' . $tag->name . '</strong></a>';
      }

      return $the_tags;
    }
  }

  add_action('init', 'register_marctv_menus');

  add_action('login_head', 'marctv_custom_login_logo');

  add_action('admin_menu', 'marctv_theme_menu');

  add_theme_support('automatic-feed-links');

  add_theme_support('post-thumbnails');

  function marctv_load_basejs() {
    wp_enqueue_script("marctv.base", get_template_directory_uri() . "/js/marctv_base.js", array("jquery"), "1.1", 0);
    wp_enqueue_script("jquery.sticky", get_template_directory_uri() . "/js/jquery.sticky.js", array("jquery"), "1.1", 0);
  }

  add_action('wp_enqueue_scripts', 'marctv_load_basejs');

  add_filter('next_posts_link_attributes', 'get_next_posts_link_attributes');
  add_filter('previous_posts_link_attributes', 'get_previous_posts_link_attributes');

  if (!function_exists('get_next_posts_link_attributes')) {

    function get_next_posts_link_attributes($attr) {
      $attr = 'rel="next" title="Next Page"';
      return $attr;
    }

  }
  if (!function_exists('get_previous_posts_link_attributes')) {

    function get_previous_posts_link_attributes($attr) {
      $attr = 'rel="prev" title="Previous Page"';
      return $attr;
    }

  }

  /**
   * Convert Yoast breadcrumbs to use Microdata
   *
   * @params string $breadcrumbs Breadcrumb HTML
   * @return string
   * @author Jaik Dean
   *
   */
  function convertBreadcrumbsToMicrodata($breadcrumbs) {

    // remove the XML namespace
    $breadcrumbs = str_replace(' xmlns:v="http://rdf.data-vocabulary.org/#"', '', $breadcrumbs);

    // convert each breadcrumb
    $breadcrumbs = preg_replace('/<span typeof="v:Breadcrumb"><a href="([^"]+)" rel="v:url" property="v:title">([^<]+)<\\/a><\\/span>/', '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="$1" itemprop="url"><span itemprop="title">$2</span></a></span>', $breadcrumbs);

    $breadcrumbs = preg_replace('/<span typeof="v:Breadcrumb"><span class="breadcrumb_last" property="v:title">([^<]+)<\\/span><\\/span>/', '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span class="breadcrumb_last" itemprop="title">$1</span></span>', $breadcrumbs);

    return $breadcrumbs;
  }

  add_filter('wpseo_breadcrumb_output', 'convertBreadcrumbsToMicrodata');

  function custom_excerpt_length() {
    return 20;
  }

  add_filter('excerpt_length', 'custom_excerpt_length', 999);

  function marctv_get_the_excerpt($id = false) {
    global $post;

    $old_post = $post;
    if ($id != $post->ID) {
      $post = get_page($id);
    }

    if (!$excerpt = trim($post->post_excerpt)) {
      $excerpt = $post->post_content;
      $excerpt = strip_shortcodes($excerpt);
      $excerpt = apply_filters('the_content', $excerpt);
      $excerpt = str_replace(']]>', ']]&gt;', $excerpt);
      $excerpt = strip_tags($excerpt);
      $excerpt_length = apply_filters('excerpt_length', 55);
      $excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');

      $words = preg_split("/[\n\r\t ]+/", $excerpt, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
      if (count($words) > $excerpt_length) {
        array_pop($words);
        $excerpt = implode(' ', $words);
        $excerpt = $excerpt . $excerpt_more;
      }
      else {
        $excerpt = implode(' ', $words);
      }
    }

    $post = $old_post;

    return $excerpt;
  }

  function my_theme_add_editor_styles() {
    add_editor_style('custom-editor-style.css');
  }

  add_action('init', 'my_theme_add_editor_styles');

  add_filter('wp_get_attachment_link', 'remove_img_width_height', 10, 4);

  function remove_img_width_height($html, $post_id, $post_image_id, $post_thumbnail) {

    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);

    return $html;
  }

//add this to your functions.php

  add_action('wp_print_styles', 'lm_dequeue_header_styles');

  function lm_dequeue_header_styles() {
    wp_dequeue_style('yarppWidgetCss');
  }

  add_action('get_footer', 'lm_dequeue_footer_styles');

  function lm_dequeue_footer_styles() {
    wp_dequeue_style('yarppRelatedCss');
  }
  ?>