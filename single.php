<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */
get_header();
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div id="post-<?php the_ID(); ?>" <?php post_class('entry article section'); ?>>
      <div class="article-wrapper">
        <h1 class="entry-title title "><span><?php esc_html(the_title()); ?><?php edit_post_link('edit', '<small> ', '</small>'); ?></span></h1>
        <div class="content-body">
          <div class="inner entry-content">
            <?php the_content(); ?>
            <div class="tools">
              <ul class="hlist tags">
                <li class="tag tags"><?php
                  if (function_exists('marctv_post_tags')) {
                    echo marctv_post_tags(get_the_tags());
                  }
                  ?>
                </li>
                <?php wp_link_pages(array('before' => ' <li class="article_pagination"><div class="nav-paged"><span class="first">Artikelseiten:</span> ', 'after' => '</div></li>', 'next_or_number' => 'number', 'pagelink' => '<span>%</span>')); ?>
                <li class="date">
                  <?php if (get_the_author_meta('user_url') != "") : ?>
                    Geschrieben von <a class="vcard author" href="<?php the_author_meta('user_url'); ?>"><span class="fn"><?php the_author_meta('first_name'); ?> <?php the_author_meta('last_name'); ?></span></a>
                  <?php else: ?>
                    Geschrieben von <span rel="vcard author"><span class="fn"><?php the_author_meta('first_name'); ?> <?php the_author_meta('last_name'); ?> am <?php the_date(); ?></span></span>
                  <?php endif ?> am <time class="updated" datetime="<?php the_date('c'); ?>"><?php the_time(__('F j, Y')); ?> </time>
                </li>
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
          </div>
        </div>
      </div>
      <?php
    endwhile;
  else:
    ?>
    <p>Leider wurde kein Artikel gefunden.</p>
  <?php endif; ?>
</div> <!-- / hentry -->
</div> <!-- /site -->

<?php
if (function_exists('related_posts')) {
  related_posts();
}
?>

<div class="fullwidth commentbox">
  <div class="site">
    <div class="section" id="comments">

      <?php
      if (function_exists('marctv_promoted_comments')) {
        echo marctv_promoted_comments();
      }
      ?>
      <?php comments_template(); ?>

    </div>
  </div>
</div> <!-- /site comments -->
<div class="appendix">
  <div class="site"> <!-- site -->

    <div class="section">

      <?php
      if (function_exists('get_last_commented_articles')) {
        echo '<div class="container docked"><div class="supertitle"><span><a rel="nofollow" href="/letzte-kommentare">Zuletzt kommentiert</a></span></div></div>';
        echo get_last_commented_articles(6,'container multi last-commented nohover showontouch');
      }
      ?>
      <?php echo get_marctv_sticky_posts(); ?>
      <?php //echo get_marctv_category_container(get_option("marctv_cat1"), get_option("marctv_cat2"), get_option("marctv_cat3"), FALSE, 'docked', FALSE); ?>
      <?php /*
        <ul class="container bars">
        <li class="box first cat-more"><a href="<?php echo get_category_link(get_option("marctv_cat1")) ?>">Leben</a></li>
        <li class="box middle cat-more"><a href="<?php echo get_category_link(get_option("marctv_cat2")) ?>">Spiele</a></li>
        <li class="box last cat-more"><a href="<?php echo get_category_link(get_option("marctv_cat3")) ?>">Medien</a></li>
        </ul>
       */ ?>
      <?php echo get_marctv_favourite_articles(); ?>

      <?php //echo get_marctv_most_commented_articles(); ?>

      <?php echo marctv_get_randompost(); ?>

    </div>
  </div>
  <?php get_footer(); ?>
