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

        <div class="tools section">
          <ul class="hlist author tags">


            <?php
            if (function_exists('marctv_post_tags')) {
              echo marctv_post_tags(get_the_tags());
            }
            ?>

            <?php wp_link_pages(array('before' => ' <li class="article_pagination"><div class="nav-paged"><span class="first">Artikelseiten:</span> ', 'after' => '</div></li>', 'next_or_number' => 'number', 'pagelink' => '<span>%</span>')); ?>


            <li>Veröffentlicht von
              <?php if (get_the_author_meta('user_url') != "") : ?>
                <a rel="author" href="<?php the_author_meta('user_url'); ?>"><?php the_author_meta('first_name'); ?> <?php the_author_meta('last_name'); ?></a> am <?php the_date(); ?>
              <?php else: ?>
                <?php the_author_meta('first_name'); ?> <?php the_author_meta('last_name'); ?> am <?php the_date(); ?>
              <?php endif ?>
            </li>



            <?php /*
              <!--
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
              -->
             */ ?>


          </ul>
        </div>
      </div>
    </div>
    <?php
  endwhile;
else:
  ?>
  <p>Leider wurde kein Artikel gefunden.</p>
<?php endif; ?>


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
        marctv_promoted_comments();
      }
      ?>
      <?php comments_template(); ?>
      
      <?php echo get_marctv_last_commented_articles(); ?>
      
    </div>
  </div>
</div> <!-- /site comments -->
<div class="appendix">
  <div class="site"> <!-- site -->

    <div class="section">
    
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
