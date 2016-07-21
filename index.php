<?php get_header(); ?>
<div class="site main-content">
<?php if (!is_paged()) : ?>
    <div id="content" class="section">

        <ul class="container docked lead">

            <?php

            $sticky = get_option('sticky_posts');

            if (count($sticky) > 0) {
                $lead_pid = $sticky;

            } else {

                $linkcat = get_option("marctv_linkcat");

                $tag = get_term_by('slug', 'mini', 'post_tag');

                if($tag){
                $mini_tag_id =  $tag->term_id;
                } else {
                    $mini_tag_id = '';
                }


                $args = array(
                    'numberposts' => '1',
                    'post_status' => 'publish',
                    'category__not_in' => $linkcat,
                    'tag__not_in' => $mini_tag_id
                );

                $recent_arr = wp_get_recent_posts($args);
                $recent_pid = $recent_arr[0]['ID'];

                $lead_pid[] = $recent_pid;
            }


            foreach ($lead_pid as $id) {
                echo '<li class="box docked first">';
                echo get_marctv_teaser($id, true, 'mainteaser', 'legacy_b',true,'','',true );
                echo '</li>';
            }

            $do_not_duplicate = '';
            $do_not_duplicate = $lead_pid;
            update_option('do_not_duplicate', $do_not_duplicate);
            ?>


        </ul>


        <?php
        if (function_exists('get_last_commented_articles')) {
            echo '<div class="container docked"><div class="supertitle"><span><a href="/letzte-kommentare/">Zuletzt kommentiert</a></span><a class="cat-link" href="/letzte-kommentare/">mehr</a></div></div>';
            echo get_last_commented_articles(6, 'container last-commented multi nohover showontouch');
        }
        ?>

        <?php echo get_marctv_category_box(get_option("marctv_cat1"),6); ?>
        <?php echo get_marctv_category_box(get_option("marctv_cat2"),6); ?>
        <?php echo get_marctv_category_box(get_option("marctv_cat3"),6); ?>
        <?php echo get_marctv_category_box(get_option("marctv_cat4"),6); ?>

        <?php echo get_marctv_mini_articles(); ?>

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

            <?php if ( function_exists( 'pgntn_display_pagination' ) ) pgntn_display_pagination( 'posts' ); ?>

    </div>
<?php endif; ?>
 <?php
    $tagcache = false;
    if (get_option('marctv-cache')) {
        $tagcache = get_transient('taghtml');

        // If it wasn't there regenerate the data and save the transient
    }

    if (!$tagcache) {
        $tagcache = wp_tag_cloud(array('smallest' => 10, 'largest' => 18, 'number' => 50, 'format' => 'flat', 'echo' => false));
        set_transient('taghtml', $tagcache, 24 * 60 * 60);
    }

    echo '<div class="section tagcloud"><div class="col_title supertitle"><span>Weitere Themen</span></div><p>' . $tagcache . '</p></div>';
    ?>
</div>
</div>
<?php get_footer(); ?>