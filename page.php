<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */
get_header();
?>
<div class="site main-content">
    <div id="content" class="section">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <div class="entry">
                <h1 class="title entry-title">
                    <span><?php esc_html(the_title()); ?><?php edit_post_link('edit', '<small> ', '</small>'); ?></span>
                </h1>
                <?php the_content(); ?>
            </div>
        <?php endwhile;
        endif;
        ?>
    </div>
</div>
<?php get_footer(); ?>
