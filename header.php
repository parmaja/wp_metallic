<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
  <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
  <!-- Tell the browser to use the same width of the device -->
  <meta name="HandheldFriendly" content="true"/>
  <meta name="viewport" content="width=device-width; initial-scale=1.0" />
  <?php
    global $wp_customize;
    /** Init Options variables */
    $wide_header = get_theme_mod('wide_header', true);
    $show_logo = get_theme_mod('show_logo', true);
    $show_title = get_theme_mod('show_title', true);
    $show_navigator = get_theme_mod('show_navigator', true);

    $logo_file = get_theme_mod('logo_url', '');

    if (empty($logo_file)) {
      if (file_exists(get_stylesheet_directory().'/images/logo.png'))
        $logo_file = get_stylesheet_directory_uri().'/images/logo.png';
      else
        $logo_file = get_stylesheet_directory_uri().'/images/wp_logo.png';
    }
  ?>
  <title><?php if (!is_home()) { the_title(); print ' - '; } bloginfo('name'); ?></title>
  <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
  <link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
  <link rel="alternate" type="application/atom+xml" title="Atom 1.0" href="<?php bloginfo('atom_url'); ?>" />
  <link rel="pingback" href="<?php print bloginfo('pingback_url'); ?>" />
  <link rel="shortlink" href="<?php print wp_get_shortlink(); ?>" />
  <?php
    wp_get_archives('type=monthly&format=link');
    if ( is_singular() ) wp_enqueue_script( "comment-reply" );
    wp_head();
  ?>
</head>

<body <?php body_class(); ?>>
  <?php if (!$wide_header) { ?>
  <div id="container">
  <?php } ?>
    <div id="header">
      <div id="logo">
        <div id="logo-header">
          <?php if ($show_logo) { ?>
          <a href="<?php print home_url(); ?>"><img id="logo-image" src="<?php print $logo_file ?>" alt="" /></a>
          <?php } ?>
          <?php if ($show_title) { ?>
          <div id="logo-text">
            <p class="title" id="title"><strong><a href=<?php print '"'.home_url().'">'.get_bloginfo('name'); ?></a></strong></p>
            <p id="description"><?php print get_bloginfo('description') ?></p>
          </div>
          <?php } ?>
        </div>

        <?php if ($show_navigator) { ?>
        <div id="nav">
        <?php
          $output = "";
          $subpage = "";
          $params = "title_li=&depth=1&echo=0";

          // Top level page
          $output .= '<ul id="nav-page">';
          $output .= wp_list_pages($params);
          $output .= '</ul>';

          // second level?
          if (get_theme_mod('show_subpages', true)) {
            if($post->post_parent)
            {
              $params .= "&child_of=" . $post->post_parent;
            }
            else
            {
              $params .= "&child_of=" . $post->ID;
            }
            $subpage = wp_list_pages($params);

            if ($subpage)
            {
              $output .= '<ul id="nav-subpage">';
              $output .= $subpage;
              $output .= '</ul>';
            }
          }
          print $output;
        ?>
        </div>
      <?php } ?>
      </div>
    </div>
    <?php if ($wide_header) { ?>
    <div id="container">
    <?php } ?>
    <div id="wrapper">
      <div id="main">
        <div id="contents">