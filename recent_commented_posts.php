<?php
/**
 * Template Name: Letzte Kommentare
 *
 * Description: A custom top game
 *
 */
get_header();
?>

<div class="site ">
    <div id="content" class="section">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <div class="entry">
                <h1 class="title entry-title">
                    <span><?php esc_html(the_title()); ?><?php edit_post_link('edit', '<small> ', '</small>'); ?></span>
                </h1>
                <?php the_content(); ?>
            </div>
            <?php
        endwhile;
        endif;

        if (function_exists('get_last_commented_articles')) {
            //echo '<div class="container docked"><div class="supertitle"><span><a  href="/letzte-kommentare">Zuletzt kommentiert</a></span></div></div>';
            echo get_last_commented_articles(18, 'container last-commented multi nohover showontouch');
        }


        /* Restore original Post Data
         * NB: Because we are using new WP_Query we aren't stomping on the
         * original $wp_query and it does not need to be reset.
         */
        wp_reset_postdata();
        ?>

    </div><!-- #primary -->
</div>
<?php get_footer(); ?>

