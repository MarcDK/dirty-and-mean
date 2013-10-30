<?php

function echo_memory_usage() {
  $mem_usage = memory_get_usage(true);

  if ($mem_usage < 1024)
    echo $mem_usage . " bytes";
  elseif ($mem_usage < 1048576)
    echo round($mem_usage / 1024, 2) . " kilobytes";
  else
    echo round($mem_usage / 1048576, 2) . " megabytes";
}

if (function_exists('add_image_size')) {
  add_image_size('facebookimage', 403, 403, true); //(cropped) 
}

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

  $teaser .= $prefix;
  $teaser .= '<a class="inverted infobox ' . $additional_classes . '" href="' . $link . '" rel="bookmark">';
  if (!$headline_bottom) {
    $teaser .= '<h2 class="title">' . esc_html(get_the_title($post_id)) . '</h2>';
  }
  if ($show_info) {
    $comment_count = get_comments_number($post_id);

    if ($comment_count == 0) {
      $comment_count = "Keine ";
    }
    else {
      $comment_count = number_format($comment_count);
    }

    $score = get_post_meta($post_id, 'rating');

    if ($extra) {
      $teaser .= '<div class="info">' . $extra . ' </div>';
    }
    else if ($score) {
      $teaser .= '<span class="info">' . $comment_count . ' Kommentare<br><span class="rating">Wertung: ' . $score[0] . '/10</span></span>';
    }
    else {
      $teaser .= '<span class="info">' . $comment_count . ' Kommentare</span>';
    }
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
    default:
      $imgsize = "full";
  }



  if (has_post_thumbnail($post_id)) {
    $img_html = wp_get_attachment_image(get_post_thumbnail_id($post_id), $imgsize);
    $html = preg_replace('/(height)=\"\d*\"\s/', "", $img_html);

    $teaser .= $html;
  }
  else {
    $teaser .= '<img src="/media/dummy.jpg" alt="' . (get_the_title($post_id)) . '" />';
  }

  if ($headline_bottom) {
    $teaser .= '<h2 class="title">' . esc_html(get_the_title($post_id)) . '</h2>';
  }
  

  if ($show_excerpt) {

    $excerpt = get_the_excerpt();

    $teaser .= '<p>' . $excerpt . '</p>';
  }
  
   $teaser .= '</a>';

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
 * Display articles with last commented articles
 * depends on plugin 'filter-by-comments'
 * 
 */
function get_marctv_last_commented_articles() {
  echo date();
  if (get_option('marctv-cache')) {
    $html = get_transient('marctv-purified-lastcom');
  }

  if (!$html) {


    global $wpdb;

    $query = "select wp_posts.*,
    coalesce(
        (
            select max(comment_date)
            from $wpdb->comments wpc
            where wpc.comment_post_id = wp_posts.id
            and comment_approved = '1' AND comment_type = '' AND post_password = ''
        ),
        wp_posts.post_date
    ) as mcomment_date
    from $wpdb->posts wp_posts
    where post_type = 'post'
    and post_status = 'publish' 
    and comment_count > '0'
    order by mcomment_date desc
    limit 6";

    $results = $wpdb->get_results($query);

    $html = '<div class="container docked"><h2 class="supertitle"><a rel="nofollow" href="http://feeds.feedburner.com/marctv/comments">Zuletzt kommentiert</a></h2></div>';
    $html .= '<ul class="container multi">';



    $key = 1;
    foreach ($results as $result) {

      /* first-last classes */
      if ($key == 1) {
        $html .= '<li class="box first">';
      }
      else if ($key % 6 == 0) {
        $html .= '<li class="box last">';
      }
      else if ($key % 3 == 0) {
        $html .= '<li class="box multi-last">';
      }
      else if ($key % 4 == 0) {
        $html .= '<li class="box multi-first">';
      }
      else {
        $html .= '<li class="box">';
      }
      $key++;


      $comments = get_comments
          (array(
        'post_id' => $result->ID,
        'number' => 1
          )
      );



      foreach ($comments as $comment) {
        $comment_url = get_comment_link($comment->comment_ID);
        $comment_user = '<div class="comment-teaser">' . get_avatar($comment->comment_author_email, $size = '32') . '<div class="fn">' . $comment->comment_author . ' </div></div>';
      }

      $html .= get_marctv_teaser($result->ID, true, '', 'medium', true, $comment_user, $comment_url, false, FALSE);
      $html .= '</li>';
    }

    $html .= '</ul>';

    set_transient('marctv-purified-lastcom', $html, 60 * 10);
  }

  return $html;
}

/**
 * Display fav articles
 * 
 */
function get_marctv_favourite_articles() {

  if (get_option('marctv-cache')) {
    $html = get_transient('marctv-purified-favarea');
  }

  if (!$html) {

    $do_not_duplicate = get_option('do_not_duplicate');

    $tagobj = get_term_by('slug', get_option("marctv_catfav"), 'post_tag');

    if ($tagobj->name) {

      query_posts(array('tag' => get_option("marctv_catfav"), 'showposts' => 2, 'post__not_in' => $do_not_duplicate, 'orderby' => 'rand'));

      $html = '<div class="container docked"><h2 class="supertitle"><a rel="tag" href="/blog/tag/' . get_option("marctv_catfav") . '/">' . $tagobj->name . '</a></h2></div>';
      $html .= '<ul class="container double">';

      $key = 1;
      while (have_posts()) : the_post();

        /* first-last classes */
        if ($key == 1) {
          $html .= '<li class="box first">';
        }
        else if ($key % 2 == 0) {
          $html .= '<li class="box last">';
        }
        else {
          $html .= '<li class="box">';
        }

        $key++;
        $html .= get_marctv_teaser(get_the_ID(), true, '', 'medium', true, '', '', true);
        $html .= '</li>';
      endwhile;
      $html .= '</ul>';
    }
    set_transient('marctv-purified-favarea', $html, 24 * 60 * 60);
  }
  return $html;
}

function marctv_get_randompost($exclude = array(), $cat = "Reviews") {


  if (get_option('marctv-cache')) {
    $html = get_transient('marctv-random');
    // If it wasn't there regenerate the data and save the transient
  }

  if (!$html) {
    query_posts(array(
      'showposts' => 1,
      'orderby' => 'rand',
      'post__not_in' => array($exclude),
      'category_name' => $cat //You can insert any category name
    ));


    $html = '<div class="container docked"><h2 class="supertitle"><a href="' . get_category_link(get_cat_ID($cat)) . '">Spiel doch mal wieder…</a></h2></div> ';
    $html .= '<ul class="container lead nomargin">';
    $html .= '<li class="box first last">';

    while (have_posts()) : the_post();
      $html .= get_marctv_teaser(get_the_ID(), true, '', '', true, '', '', true);
    endwhile;

    $html .= '</li>';
    $html .= '</ul>';

    set_transient('marctv-random', $html, 24 * 60 * 60);
  }

  return $html;
}

/**
 * Display adb articles 
 * 
 */
function get_adb_article() {

  if (get_option('marctv-cache')) {
    $html = get_transient('marctv-purified-adbarea');
  }
  if (!$html) {

    $the_tag = 'art-directed-blogging';
    $do_not_duplicate = get_option('do_not_duplicate');
    $do_not_duplicate[] = 7928;

    $tagobj = get_term_by('slug', $the_tag, 'post_tag');

    if ($tagobj->name) {

      query_posts(array(
        'tag' => $the_tag,
        'showposts' => 2,
        'post__not_in' => $do_not_duplicate,
        'orderby' => 'rand')
      );

      $html = '<div class="container docked"><h2 class="col_title supertitle"><a rel="tag" href="/blog/tag/' . $the_tag . '/">' . $tagobj->name . '</a></h2></div>';
      $html .= '<ul class="container double">';
      $key = 1;
      while (have_posts()) : the_post();

        /* first-last classes */
        if ($key == 1) {
          $html .= '<li class="box first">';
        }
        else if ($key % 2 == 0) {
          $html .= '<li class="box last">';
        }
        else {
          $html .= '<li class="box">';
        }
        $key++;
        $html .= get_marctv_teaser(get_the_ID(), true, '', 'large', true, '', '', true);

        $html .= '</li>';
      endwhile;
      $html .= '</ul>';

      set_transient('marctv-purified-adbarea', $html, 24 * 60 * 60);
    }
    update_option('do_not_duplicate', $do_not_duplicate);
  }

  return $html;
}

/**
 * Display articles most commented articles
 * 
 */
function get_marctv_most_commented_articles() {

  if (get_option('marctv-cache')) {
    $html = get_transient('marctv-purified-mostcom');
  }
  if (!$html) {

    $do_not_duplicate = get_option('do_not_duplicate');

    $html = '<div class="container docked"><h2 class="col_title supertitle"><a rel="nofollow" href="http://feeds.feedburner.com/marctv/comments">Meistkommentiert</a></h2></div>';

    query_posts(array('showposts' => 3, 'post__not_in' => $do_not_duplicate, 'orderby' => 'comment_count'));

    $html .= '<ul class="container">';
    $key = 1;

    while (have_posts()) : the_post();

      /* first-last classes */
      if ($key == 1) {
        $html .= '<li class="box first">';
      }
      else if ($key % 3 == 0) {
        $html .= '<li class="box last">';
      }
      else {
        $html .= '<li class="box">';
      }
      $key++;
      $html .= get_marctv_teaser(get_the_ID(), true, '', 'medium', true, '', '', false);
      $html .= '</li>';
    endwhile;

    $html .= '</ul>';
    set_transient('marctv-purified-mostcom', $html, 24 * 60 * 60);
  }
  return $html;
}

function get_marctv_teaserblock() {

  if (get_option('marctv-cache')) {
    $html1 = get_transient('marctv-purified-teaserblock');
    $html3 = get_transient('marctv-purified-teaserblock-cont');
  }

  $html2 = get_marctv_last_commented_articles();

  if (!$html1) {

    $html1 = get_adb_article();
    $html1 .= get_marctv_most_commented_articles();
    set_transient('marctv-purified-teaserblock', $html1, 24 * 60 * 60);
  }

  if (!$html3) {
    $html3 = get_marctv_favourite_articles();
    set_transient('marctv-purified-teaserblock-cont', $html3, 24 * 60 * 60);
  }
  $html = $html2 . $html1 . $html3;
  return $html;
}

function get_marctv_category_container_box( $cat_id, $class, $offset = false ) {
  query_posts(array(
    'category__in' => array($cat_id),
    'showposts' => 1,
    'offset' => $offset
  ));
  $teaser .= '<li class="box ' . $class . '">';


  while (have_posts()) : the_post();
    if (!$offset) {
      $teaser .= '<h2 class="supertitle"><a href="' . get_category_link($cat_id) . '">' . get_cat_name($cat_id) . '</a></h2>';
    }
    
    $teaser .= get_marctv_teaser(get_the_ID(), true, '', 'medium', true, '', '', true);
    
    $do_not_duplicate[] = get_the_ID();
    update_option('do_not_duplicate', $do_not_duplicate);
  endwhile;
  
  $teaser .= '</li>';
  return $teaser;
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
function get_marctv_category_container($cat_id1, $cat_id2, $cat_id3, $offset = false, $classes) {

  $teaser .= '<ul class="container bars ' . $classes . '">';
  $teaser .= get_marctv_category_container_box($cat_id1, 'first odd', $offset);
  $teaser .= get_marctv_category_container_box($cat_id2, 'middle even', $offset);
  $teaser .= get_marctv_category_container_box($cat_id3, 'last odd', $offset);
  $teaser .= '</ul>';
  return $teaser;
}

/**
 * Display the marctv category list2
 *
 * @since 0.71
 *
 * @param integer $cat_id Optional. The post_id of the post to display the teaser.
 * @param integer $offset Optional. The offset to the next post
 */
function get_marctv_category_list2($cat_id, $offset = false) {

  $teaser = '<h2 class="supertitle"><a href="' . get_category_link($cat_id) . '">' . get_cat_name($cat_id) . '</a></h2>';
  $teaser .= '<ul class="">';

  query_posts(array(
    'category__in' => array($cat_id),
    'showposts' => 2
  ));


  while (have_posts()) : the_post();
    $i++;
    $teaser .= '<li>';
    $teaser .= get_marctv_teaser($post->ID, true, '', 'medium', true, '', '', true);

    $teaser .= '</li>';
    $do_not_duplicate[] = $post->ID;
  endwhile;



  $teaser .= '<li class="cat-more"><a href="' . get_category_link($cat_id) . '">' . get_cat_name($cat_id) . '</a></li>';
  $teaser .= '</ul>';
  return $teaser;
}

/**
 * Display the marctv category bar
 *
 * @since 0.71
 *
 * @param integer $cat_id Optional. The post_id of the post to display the teaser.
 * @param bool $show_info Optional. Show the infoboxt. Default is true.
 * @param string $additional_classes Optional. additional classes on a element.
 * @param string image size: org, medium, small, default.
 */
function get_marctv_category_list($cat_id, $reset_loop = false) {


  $do_not_duplicate = get_option('do_not_duplicate');
  $stickys = get_option('sticky_posts');
  $sticky = array_diff($stickys, array($stickys[0]));

  $teaser .= '<h2 class="supertitle"><a href="' . get_category_link($cat_id) . '">' . get_cat_name($cat_id) . '</a></h2>';
  $teaser .= '<ul>';
  $i = 0;

  if (count($sticky) > 0) :

    $args = array(
      'category__in' => array($cat_id),
      'showposts' => 2,
      'post__in' => $sticky,
    );

    $posts = get_posts($args);

    foreach ($posts as $post) {
      $i++;
      $teaser .= '<li>';
      $teaser .= get_marctv_teaser($post->ID, true, '', 'medium', true, '', '', true);
      $teaser .= '</li>';
      $do_not_duplicate[] = $post->ID;
    }

  endif;

  $count = 2 - $i;

  if ($reset_loop) {
    $do_not_duplicate = '';
  }

  $args = array(
    'category__in' => array($cat_id),
    'showposts' => $count,
    'post__not_in' => $do_not_duplicate,
  );

  $posts = get_posts($args);

  foreach ($posts as $post) {
    $do_not_duplicate[] = $post->ID;
    $teaser .= '<li>';
    $teaser .= get_marctv_teaser($post->ID, true, '', 'medium', true, '', '', true);
    $teaser .= '</li>';
  }

  if (!$reset_loop) {
    update_option('do_not_duplicate', $do_not_duplicate);
  }

  $teaser .= '<li class="cat-more"><a href="' . get_category_link($cat_id) . '">alle</a></li>';
  $teaser .= '</ul>';
  return $teaser;
}

function marctv_comment($comment, $args, $depth) {
  $GLOBALS['comment'] = $comment;
  ?>
  <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
    <div id="comment-<?php comment_ID(); ?>">
      <div class="comment-author vcard">
        <?php echo get_avatar($comment, $size = '100') ?>

        <?php printf(__('<cite class="fn">%s</cite> <span class="says">sagt:</span>'), get_comment_author_link()) ?>
      </div>
      <?php if ($comment->comment_approved == '0') : ?>
        <em><?php _e('Your comment is awaiting moderation.') ?></em>
        <br />
      <?php endif; ?>
      <div class="comment-meta commentmetadata"><?php do_action('flag_comment_link'); ?> <a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)) ?>"><?php printf(__('%1$s'), get_comment_date('j. M Y')); ?></a><?php edit_comment_link(__('(Edit)'), '  ', ''); ?></div>
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

    $pagination .= $after_previous;

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

      $pagination .= join($seperator, $x);
    }
    $pagination .= $before_next;


    echo $pagination;
  }

  function post_elements($cat_id) {
    ?>
  <li class="grid_4">
    <h2 class="headline"><a href="<?php echo get_category_link(get_option($cat_id)); ?>"><?php echo get_cat_name(get_option($cat_id)) ?></a></h2>
    <ul class="box">
      <?php
      query_posts(array(
        'cat' => get_option($cat_id),
        'showposts' => 4,
        'post__not_in' => $do_not_duplicate
      ));
      while (have_posts()) : the_post();
        ?>
        <li>
          <small class="grey"><?php the_time('j. F Y') ?> - <a href="<?php the_permalink() ?>#respond" rel="nofollow"><?php comments_number('Kommentieren &#187;', '1 Kommentar &#187;', '% Kommentare &#187;'); ?></a>  <?php edit_post_link('Edit', ' | ', '  '); ?></small>
          <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanenter Link zu <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
          <p><?php the_content_rss('', TRUE, '', 100); ?></p>
        </li>
      <?php endwhile; ?>
    </ul>
  </li>

  <?php
}

/* These functions are needed to extract  the thumbail-urls from the text */

function getMiddleImg($the_content) {
  /* Rausfiltern der Bild-URL */
  $anfang = strpos($the_content, '"http:');

  $ab_http = substr($the_content, $anfang + 1);
  $ende = strpos($ab_http, "\"");
  $http_string = substr($ab_http, 0, $ende);
  $img_arr = (split("/", $http_string));
  $path_to_image = implode('/', array_slice($img_arr, 0, -1));
  $filename = (split("[.]", $img_arr[count($img_arr) - 1]));
  $filename_str = str_replace('-620x270', "", $filename[0]);
  $thumbnail_image = $path_to_image . "/" . $filename_str . "-300x130." . $filename[1];

  if ($http_string == "") {
    return false;
  }
  else {
    return $thumbnail_image;
  }
}

function getThumbImg($the_content) {
  /* Rausfiltern der ThumbBild-URL */
  $anfang = strpos($the_content, '"http:');
  $ab_http = substr($the_content, $anfang + 1);
  $ende = strpos($ab_http, "\"");
  $http_string = substr($ab_http, 0, $ende);
  $img_arr = (split("/", $http_string));
  $path_to_image = implode('/', array_slice($img_arr, 0, -1));
  $filename = (split("[.]", $img_arr[count($img_arr) - 1]));
  $filename_str = str_replace('-620x270', "", $filename[0]);
  $thumbnail_image = $path_to_image . "/" . $filename_str . "-150x65." . $filename[1];

  if ($http_string == "") {
    return false;
  }
  else {
    return $thumbnail_image;
  }
}

function getImgURL($the_content) {
  /* Rausfiltern der Bild-URL */
  $anfang = strpos($the_content, '"http:');
  $ab_http = substr($the_content, $anfang + 1);
  $ende = strpos($ab_http, "\"");
  $http_string = substr($ab_http, 0, $ende);

  if ($http_string == "") {
    return false;
  }
  else {
    return $http_string;
  }
}

function getOrgImgURL($the_content) {
  /* Rausfiltern der Bild-URL */
  $anfang = strpos($the_content, '"http:');
  $ab_http = substr($the_content, $anfang + 1);
  $ende = strpos($ab_http, "\"");
  $http_string = substr($ab_http, 0, $ende);
  $img_arr = (split("/", $http_string));
  $path_to_image = implode('/', array_slice($img_arr, 0, -1));
  $filename = (split("[.]", $img_arr[count($img_arr) - 1]));
  $filename_str = str_replace('-620x270', "", $filename[0]);
  $orgimgurl = $path_to_image . "/" . $filename_str . "." . $filename[1];

  if ($http_string == "") {
    return false;
  }
  else {
    return $orgimgurl;
  }
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
  echo '<h2>Dirty & Mean Theme</h2>';
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
    $msg .= '<p>no changes</p>';
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
  register_nav_menus(array(
    'mainnav' => __('Main Navigation')
  ));
}

function marctv_post_tags($posttags) {
  if (is_array($posttags)) {
    $the_tags = '<ul class="hlist tags"><li class="tag">Weitere Artikel zu ';

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
      $the_tags .= $divider . '<a rel="tag" href="' . get_tag_link($tag->term_id) . '"><strong>' . $tag->name . '</strong></a>';
    }
    $the_tags .= '.</li></ul>';
    return $the_tags;
  }
}

add_action('init', 'register_marctv_menus');



add_action('login_head', 'marctv_custom_login_logo');

add_action('admin_menu', 'marctv_theme_menu');

add_theme_support('automatic-feed-links');

add_theme_support('post-thumbnails');

remove_action('wp_head', 'parent_post_rel_link', 10, 0); // prev link

remove_action('wp_head', 'rsd_link');

wp_enqueue_script("marctv.base", get_bloginfo('template_directory') . "/js/marctv_base.js", array("jquery"), "1.1", 0);

register_sidebar(array(
  'name' => 'MarcTV Top',
  'id' => 'marctv_top',
  'description' => 'On top of the world',
  'before_title' => '<h2 class="title">',
  'after_title' => '</h2>'
));

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
 * */
function convertBreadcrumbsToMicrodata($breadcrumbs) {
  // remove the XML namespace
  $breadcrumbs = str_replace(' xmlns:v="http://rdf.data-vocabulary.org/#"', '', $breadcrumbs);

  // convert each breadcrumb
  $breadcrumbs = preg_replace(
      '/<span typeof="v:Breadcrumb"><a href="([^"]+)" rel="v:url" property="v:title">([^<]+)<\\/a><\\/span>/', '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="$1" itemprop="url"><span itemprop="title">$2</span></a></span>', $breadcrumbs
  );

  $breadcrumbs = preg_replace(
      '/<span typeof="v:Breadcrumb"><span class="breadcrumb_last" property="v:title">([^<]+)<\\/span><\\/span>/', '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span class="breadcrumb_last" itemprop="title">$1</span></span>', $breadcrumbs
  );

  return $breadcrumbs;
}

add_filter('wpseo_breadcrumb_output', 'convertBreadcrumbsToMicrodata');

function robots_comment_pages() {
  if (get_query_var('cpage') >= 1 || get_query_var('cpage') < get_comment_pages_count())
    echo "<meta name=\"robots\" content=\"noindex\" />\n";
}

add_action('wp_head', 'robots_comment_pages');


function custom_excerpt_length() {
  return 20;
}

add_filter('excerpt_length', 'custom_excerpt_length', 999);


// Replaces the excerpt "more" text by a link
function new_excerpt_more() {
       global $post;
	return ' […] <a class="moretag" href="'. get_permalink($post->ID) . '">mehr…</a>';
}
//add_filter('excerpt_more', 'new_excerpt_more');

 wp_enqueue_script(
          "jquery.sticky", get_template_directory_uri() . "/js/jquery.sticky.js", array("jquery"), "1.1", 0);

?>