<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */
get_header();
?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php
    if (function_exists('yoast_breadcrumb')) {
      yoast_breadcrumb('<div class="section breadcrumbs">', '</div>');
    }
    ?>
    <div class="section entry">
      <h1 class="title entry-title"><span><?php esc_html(the_title()); ?><?php edit_post_link('edit', '<small> ', '</small>'); ?></span></h1>
    </div>
    <div <?php post_class('article section entry'); ?> id="post-<?php the_ID(); ?>">
      <div class="inner">
        <?php the_content(); ?>
      </div>
    </div>
    <?php
  endwhile;
else:
  ?>
  <p>Leider wurde kein Artikel gefunden.</p>
<?php endif; ?>
<div class="section tools">
  <?php
  if (function_exists('marctv_post_tags')) {
    echo marctv_post_tags(get_the_tags());
  }
  ?>

  <ul class="hlist author tags">
    <li class="first">
      <?php wp_link_pages(array('before' => '<div class="nav-paged"><span class="first">Artikelseiten:</span> ', 'after' => '</div>', 'next_or_number' => 'number', 'pagelink' => '<span>%</span>')); ?>
    </li>
    <li class="tag">Veröffentlicht von
      <?php if (get_the_author_meta('user_url') != "") : ?>
        <a rel="author" href="<?php the_author_meta('user_url'); ?>"><?php the_author_meta('first_name'); ?> <?php the_author_meta('last_name'); ?></a> am <?php the_date(); ?></li>
    <?php else: ?>
        <?php the_author_meta('first_name'); ?> <?php the_author_meta('last_name'); ?> am <?php the_date(); ?></li>
      <?php endif ?>
    <li class="nav-article-tool">
      <div class="nav-article">
        <span class="nav-previous">
          <?php previous_post_link(); ?>
        </span>
        <span class="nav-next">
          <?php next_post_link(); ?>
        </span>
      </div>
    </li>
  </ul>
</div>

</div> <!-- /site -->
<div class="commentbox">
  <div class="site">
    <div class="section" id="relatedbox">
      <?php
      if (function_exists('related_posts')) {
        related_posts();
      }
      ?>
    </div>
  </div>
  <div class="site">
    <div class="section" id="comments">

      <?php
      if (function_exists('marctv_promoted_comments')) {
        marctv_promoted_comments();
      }
      ?>
      <?php comments_template(); ?>
    </div>
  </div>
</div> <!-- /site comments -->
<div class="appendix">
  <div class="site"> <!-- site -->

    <div class="section">
      <?php echo get_marctv_last_commented_articles(); ?>

      <?php
      if (get_option('marctv-cache')) {
        $html = get_transient('marctv-teaserblock-single');
      }

      if (!$html) {
        // $html = get_marctv_most_commented_articles();
        // $html .= get_adb_article();
        // 


        $html .= get_marctv_favourite_articles();


        // $html .= get_marctv_teaserblock_single();


        set_transient('marctv-teaserblock-single', $html, 24 * 60 * 60);
      }

      echo $html;
      ?>
      <?php
      echo marctv_get_randompost($postID);
      ?>
    </div>
  </div>
  <?php get_footer(); ?>
