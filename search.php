<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
get_header();
?>

<div id="content" class="section">

  <div class="entry">
    <h1 class="title">Suchergebnisse für '<span><?php echo get_search_query(); ?></span>'</h1>
  </div>
  <ul class="container oneline">
    <?php if (have_posts()) : ?>
      <?php
      $key = 0;
      while (have_posts()) : the_post();
        $key++;
        // cfvalue:field 
        if ($key % 3 == 0) {
          echo '<li class="box last">';
        }
        else if (($key - 1) % 3 == 0) {
          echo '<li class="box first">';
        }
        else {
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
  <?php else : ?>

    <article id="post-0" class="post no-results not-found">
      <h1 class="entry-title">Nichts gefunden</h1>
      <div class="entry-content">
        <p>Entschuldige, aber es konnte nichts gefunden werden. Versuche es mit anderen Schlüsselwörtern erneut.</p>
        <?php get_search_form(); ?>
      </div><!-- .entry-content -->
    </article><!-- #post-0 -->

  <?php endif; ?>

  <?php //marctv_pagination(" ", '<div class="nav-paged">', "</div>", "« Vorherige", "Nächste »", 'span', '6'); ?>
</div>
<?php get_footer(); ?>