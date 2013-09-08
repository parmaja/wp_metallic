<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
  <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
  <!-- Tell the browser to use the same width of the device -->
  <meta name="HandheldFriendly" content="true"/>
  <meta name="viewport" content="width=device-width; initial-scale=1.0" />
  <?php
    global $wp_customize;
    $header_font_name = get_theme_mod('header_font_name', 'Arial');
    $header_font_size = get_theme_mod('header_font_size', '16');
    $logo_file = get_theme_mod('logo_url', '');
    if (empty($logo_file)) {
      if (file_exists(get_stylesheet_directory().'/images/logo.png'))
        $logo_file = get_stylesheet_directory_uri().'/images/logo.png';
      else
        $logo_file = get_stylesheet_directory_uri().'/images/wp_logo.png';
    }

    /* if Debug is enabled or using theme customize we need on the fly css */
    if (WP_DEBUG || isset($wp_customize) || isset($_GET['scheme'])) {
      $gradients = get_theme_mod('gradients', true);
      $pass = '?gradients=';
      if ($gradients)
        $pass .= '1';
      else
        $pass .= '0';

      if (isset($_GET['scheme']))
        $scheme = $_GET['scheme'];
      else
        $scheme = get_theme_mod('color_scheme', 'gray');

      if (!empty($scheme))
        $pass.='&scheme='.$scheme;

      if (empty($scheme)) {
        if (isset($_GET['user_color']) and !empty($_GET['user_color']))
          $user_color = $_GET['user_color'];
        else
          $user_color = get_theme_mod('user_color', '');

        if (!empty($user_color)) {
          if (substr($user_color, 0, 1) === '#')
            $user_color = substr($user_color, 1);
          $pass .= '&user_color='.$user_color;
        }
      }
    }
  ?>
  <title><?php if (!is_home()) { the_title(); print ' - '; } bloginfo('name'); ?></title>
  <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
  <link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
  <link rel="alternate" type="application/atom+xml" title="Atom 1.0" href="<?php bloginfo('atom_url'); ?>" />
  <?php if (empty($pass)) { ?>
  <link rel='stylesheet' href="<?php print get_stylesheet_directory_uri(); ?>/css/style.css" type='text/css' />
  <?php } else { ?>
  <link rel='stylesheet' href="<?php print get_stylesheet_directory_uri(); ?>/style.php<?php echo $pass; ?>" type='text/css' />
  <?php } ?>
  <?php if (wp_is_mobile()) { ?>
  <link rel='stylesheet' href="<?php print get_stylesheet_directory_uri(); ?>/mobile.css" type='text/css' />
  <?php } else  { ?>
    <?php if (get_theme_mod('wide_header', true)) { ?>
  <link rel='stylesheet' href="<?php print get_stylesheet_directory_uri(); ?>/wide-screen.css" type='text/css' />
  <?php } else  { ?>
  <link rel='stylesheet' href="<?php print get_stylesheet_directory_uri(); ?>/screen.css" type='text/css' />
  <?php } ?>
    <?php if (get_theme_mod('show_sidebar', true)) { ?>
  <link rel='stylesheet' href="<?php print get_stylesheet_directory_uri(); ?>/sidebar.css" type='text/css' />
    <?php } ?>
  <?php } ?>
  <?php if (is_rtl()) { ?>
  <link rel='stylesheet' href="<?php print get_stylesheet_directory_uri(); ?>/style_rtl.css" type='text/css' />
  <?php } else  { ?>
  <link rel='stylesheet' href="<?php print get_stylesheet_directory_uri(); ?>/style_ltr.css" type='text/css' />
  <?php } ?>
  <link rel="pingback" href="<?php print bloginfo('pingback_url'); ?>" />
  <?php
    wp_get_archives('type=monthly&format=link');
    if ( is_singular() ) wp_enqueue_script( "comment-reply" );
    wp_head();
  ?>
</head>

<body <?php body_class(); ?>>
  <?php if (!get_theme_mod('wide_header', true)) { ?>
  <div id="container">
  <?php } ?>
    <div id="header">
      <div id="head">
        <div id="logo-header">
          <?php if (get_theme_mod('show_logo', true)) { ?>
          <a href="<?php print home_url(); ?>"><img id="logo-image" src="<?php print $logo_file ?>" alt="" /></a>
          <?php } ?>
          <?php if (get_theme_mod('show_title', true)) { ?>
          <div id="logo-text">
            <p class="title" id="title"><strong><a href=<?php print '"'.home_url().'">'.get_bloginfo('name'); ?></a></strong></p>
            <p id="description"><?php print get_bloginfo('description') ?></p>
          </div>
          <?php } ?>
        </div>

        <?php if (get_theme_mod('pages_navigator', true)) { ?>
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
    <?php if (get_theme_mod('wide_header', true)) { ?>
    <div id="container">
    <?php } ?>
    <div id="content">
      <div id="main">
        <div id="inside">