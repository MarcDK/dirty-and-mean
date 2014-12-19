<!DOCTYPE html>
<html dir="ltr" lang="de-DE" id="marctv">
  <!--

  Grüße an alle Quelltextleser!

  - Marc

  -->
  <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <?php if (is_singular() && get_option('thread_comments')) wp_enqueue_script('comment-reply'); ?>
      <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
      <?php wp_enqueue_style('style', get_stylesheet_uri()); ?>
      <?php wp_head(); ?>
      <meta name="viewport" content="user-scalable=0, width=device-width, initial-scale=1, maximum-scale=1">
  </head>

  <body <?php body_class(); ?>>
    <div id=fig1><div class="figure"><div></div></div></div>
    <div id=fig2><div class="figure"><div></div></div></div>
    <div class="header">
      <div id="header" class="innerheader">
        <div class="site">
          <div class="section">
            <?php if (is_home()) : ?>
              <h1 class="sitelogo"><a href="<?php echo get_option('home'); ?>"><?php bloginfo('name'); ?></a></h1>
            <?php else : ?>
              <div class="sitelogo"><a href="<?php echo get_option('home'); ?>"><?php bloginfo('name'); ?></a></div>
            <?php endif ?>
            <nav id="primary-navigation"><div id="navigation"><?php wp_nav_menu(array('theme_location' => 'mainnav', 'container' => '')); ?></div></nav>
            <?php get_search_form(); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="site main-content">

