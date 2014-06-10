<!DOCTYPE html>
<html dir="ltr" lang="de-DE" id="marctv">
  <!--

  Grüße an alle Quelltextleser!

  - Marc

  -->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?php
      /*
       * Print the <title> tag based on what is being viewed.
       */
      global $page, $paged;

      wp_title('-', true, 'right');

      // Add the blog name.
      bloginfo('name');

      // Add the blog description for the home/front page.
      $site_description = get_bloginfo('description', 'display');
      if ($site_description && ( is_home() || is_front_page() ))
        echo " - $site_description";

      // Add a page number if necessary:
      if ($paged >= 2 || $page >= 2)
        echo ' - ' . sprintf(__('Seite %s'), max($paged, $page));
      ?></title>
      <?php if (is_singular() && get_option('thread_comments')) wp_enqueue_script('comment-reply'); ?>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <?php wp_enqueue_style('style', get_stylesheet_uri()); ?>
    <?php wp_head(); ?>
    <meta name="viewport" content="user-scalable=0, width=device-width, initial-scale=1, maximum-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>
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

