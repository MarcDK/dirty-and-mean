<?php get_header(); ?>
<?php if (!is_paged()) : ?>
    <div id="content" class="section">

        <ul class="container docked lead">

            <?php

            $sticky = get_option('sticky_posts');

            if (count($sticky) > 0) {
                $lead_pid = $sticky;
                
            } else {

                $linkcat = get_option("marctv_linkcat");
                $args = array(
                    'numberposts' => '1',
                    'post_status' => 'publish',
                    'category__not_in' => $linkcat
                );

                $recent_arr = wp_get_recent_posts($args);
                $recent_pid = $recent_arr[0]['ID'];

                $lead_pid[] = $recent_pid;
            }


            foreach ($lead_pid as $id) {
                echo '<li class="box docked first">';
                echo get_marctv_teaser($id, true, 'mainteaser', 'large');
                echo '</li>';
            }


            $do_not_duplicate = '';
            $do_not_duplicate[] = $lead_pid;
            update_option('do_not_duplicate', $do_not_duplicate);
            ?>


        </ul>


        <?php
        if (function_exists('get_last_commented_articles')) {
            echo '<div class="container docked"><div class="supertitle"><span><a rel="nofollow" href="/letzte-kommentare/">Zuletzt kommentiert</a></span></div></div>';
            echo get_last_commented_articles(6, 'container last-commented multi nohover showontouch');
        }
        ?>


        <?php echo get_marctv_category_container(get_option("marctv_cat1"), get_option("marctv_cat2"), get_option("marctv_cat3"), FALSE, 'docked'); ?>


        <ul class="container bars">
            <li class="box first cat-more"><a href="<?php echo get_category_link(get_option("marctv_cat1")) ?>">Leben
                    Archiv</a></li>
            <li class="box middle cat-more"><a href="<?php echo get_category_link(get_option("marctv_cat2")) ?>">Spiele
                    Archiv</a></li>
            <li class="box last cat-more"><a href="<?php echo get_category_link(get_option("marctv_cat3")) ?>">Medien
                    Archiv</a></li>
        </ul>


        <?php //echo get_marctv_sticky_posts();  ?>

        <div id="marctvflickrbar"></div>

        <?php echo get_marctv_favourite_articles(); ?>

        <?php echo get_marctv_most_commented_articles(); ?>

        <?php echo get_adb_article(); ?>

        <?php echo marctv_get_randompost(); ?>

    </div>
    <?php wp_reset_query(); ?>
<?php else : ?>
    <div id="content" class="section">
        <?php
        if (function_exists('yoast_breadcrumb')) {
            yoast_breadcrumb('<div class="section breadcrumbs">', '</div>');
        }
        ?>
        <div class="entry">
            <h1 class="title">Blog Archiv</h1>
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
                } else if (($key - 4) % 6 == 0) {
                    echo '<li class="box multi-first">';
                } else if (($key - 3) % 6 == 0) {
                    echo '<li class="box multi-last">';
                } else {
                    echo '<li class="box">';
                }

                echo get_marctv_teaser(get_the_ID(), true, '', 'medium', true, '', '', true);

                echo '</li>';

            endwhile;

            echo '</ul>';
            ?>

            <div class="nav-article">
                <span class="nav-previous"><?php echo get_previous_posts_link('« Vorherige'); ?>&nbsp;</span>
                <span class="nav-next">&nbsp;<?php echo get_next_posts_link('Nächste »'); ?></span>
            </div>

            <?php marctv_pagination(" ", '<div class="nav-paged">', "</div>", "« Vorherige", "Nächste »", 'span', '6'); ?>
    </div>
<?php endif; ?>
<?php get_footer(); ?>