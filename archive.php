<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */
get_header();
?>
    <div class="site main-content">
    <div id="content" class="section">

        <?php if (have_posts()) : ?>

        <div class="entry">
            <?php the_archive_title('<h1 class="title">', '</h1>'); ?>
            <?php
            global $paged;
            if ($paged == 0 || empty($paged)) {
                the_archive_description('', '');
            }

            ?>
        </div>
        <?php
        if ($paged == 0 || empty($paged)) {
            echo '<p>';
            $menu_args = array(
                'walker' => new sub_nav_walker(),
                'container' => '',
                'menu_class' => 'sister-pages',
            );
            wp_nav_menu($menu_args);
            echo '</p>';
        }
        ?>
        <ul class="container six docked">

            <?php
            $key = 0;
            while (have_posts()) : the_post();
                $key++;
                // cfvalue:field
                if ($key == 1) {
                    echo '<li class="box first">';
                } else if ($key % 6 == 0) {
                    echo '<li class="box last">';
                } else if ($key == 3) {
                    echo '<li class="box multi-last">';
                } else if ($key == 4) {
                    echo '<li class="box multi-first">';
                } else {
                    echo '<li class="box">';
                }

                echo get_marctv_teaser(get_the_ID(), true, '', 'thumbnail', true, '', '', true);

                echo '</li>';
            endwhile;

            echo '</ul>';


            else :
                if (is_category()) { // If this is a category archive
                    printf("<h1 class='center'>Sorry, but there aren't any posts in the %s category yet.</h1>", single_cat_title('', false));
                } else if (is_date()) { // If this is a date archive
                    echo("<h1>Sorry, but there aren't any posts with this date.</h1>");
                } else if (is_author()) { // If this is a category archive
                    $userdata = get_user_by('login', get_query_var('author_name'));
                    printf("<h1 class='center'>Sorry, but there aren't any posts by %s yet.</h1>", $userdata->display_name);
                } else {
                    echo("<h1 class='center'>No posts found.</h1>");
                }
                get_search_form();
            endif;
            ?>
            <div>
                <?php if (function_exists('pgntn_display_pagination')) pgntn_display_pagination('posts'); ?>
            </div>

            <!-- <div class="nav-article">
        <?php //the_posts_navigation(); ?>
    </div> -->


    </div>
    </div>

<?php get_footer(); ?>