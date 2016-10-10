<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */
get_header();

$godmode = false;

/* check if this is an adb post */
$adb = get_post_meta(get_the_ID(), 'extraCss', true);

if( ($adb == false)) {
    $godmode = true;
}

?>

<?php if (have_posts()) : while (have_posts()) :
the_post(); ?>
<div class="hentry">
<?php if ($godmode == true) { echo get_marctv_header(); } ?>
<div class="site main-content">
    <div id="post-<?php the_ID(); ?>" <?php post_class('entry article section'); ?>>
        <div class="article-wrapper">
            <?php if ($godmode != true) { ?>
                <?php echo get_marctv_meta(); ?>
                <h1 class="entry-title title "><span><?php esc_html(the_title()); ?></span></h1>
            <?php } ?>
            <div class="content-body">
                <div class="inner entry-content">
                    <?php the_content(); ?>
                    <div class="tools">
                        <ul class="hlist">
                            <li class="tag tags"><?php
                                if (function_exists('marctv_post_tags')) {
                                    echo marctv_post_tags(get_the_tags());
                                }
                                ?>
                            </li>
                            <?php wp_link_pages(array('before' => ' <li class="article_pagination"><div class="nav-paged"><span class="first">Artikelseiten:</span> ', 'after' => '</div></li>', 'next_or_number' => 'number', 'pagelink' => '<span>%</span>')); ?>
                            <!-- <li class="nav-article-tool">
                            <div class="nav-article">
                    <span class="nav-previous">
                      <?php previous_post_link(); ?>
                    </span>
                    <span class="nav-next">
                      <?php next_post_link(); ?>
                    </span>
                            </div>
                        </li> -->
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
</div>
<?php
if (function_exists('related_posts')) {
    related_posts();
}
?>

<div id="commentbox" class="fullwidth commentbox">
    <div class="site">
        <div class="section" id="comments">
            <?php comments_template(); ?>
        </div>
    </div>
</div> <!-- /site comments -->
<div class="appendix">
    <div class="site"> <!-- site -->
        <div class="section">
            <?php
            if (function_exists('get_last_commented_articles')) {
                echo '<div class="container docked"><div class="supertitle"><span><a href="/letzte-kommentare">Zuletzt kommentiert</a></span></div></div>';
                echo get_last_commented_articles(6, 'container multi last-commented nohover showontouch');
            }
            echo get_marctv_recent_articles();
            echo get_marctv_favourite_articles();
            echo marctv_get_randompost(); ?>
        </div>
    </div>
</div>


<?php echo display_facebook_box(); ?>

<?php get_footer(); ?>
