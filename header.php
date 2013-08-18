<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
  <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
  <!-- Tell the browser to use the same width of the device -->
  <meta name="HandheldFriendly" content="true"/>
  <meta name="viewport" content="width=device-width; initial-scale=1.0" />
  <?php if (wp_is_mobile()) { ?>
  <?php } ?>
  <title><?php if(is_home()) bloginfo('name'); else wp_title(''); ?></title>
  <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
  <link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
  <link rel="alternate" type="application/atom+xml" title="Atom 1.0" href="<?php bloginfo('atom_url'); ?>" />
  <link rel='stylesheet' href="<?php print get_stylesheet_directory_uri(); ?>/style.php" type='text/css' />
  <!-- link rel='stylesheet' href="<?php print get_stylesheet_directory_uri(); ?>/css/style.css" type='text/css' /-->
  <?php if (wp_is_mobile()) { ?>
  <link rel='stylesheet' href="<?php print get_stylesheet_directory_uri(); ?>/mobile.css" type='text/css' />
  <?php } else  { ?>
  <link rel='stylesheet' href="<?php print get_stylesheet_directory_uri(); ?>/screen.css" type='text/css' />
  <?php } ?>
  <link rel="pingback" href="<?php print bloginfo('pingback_url'); ?>" />
  <?php
    wp_get_archives('type=monthly&format=link');
    wp_head();
  ?>
</head>

<body>
  <div id="container">
    <div id="header">
      <div id="logo_header">
        <img id="logo_image" src="<?php bloginfo('stylesheet_directory'); ?>/images/logo.png" alt="" />
        <div id="logo_text">
          <p class="title" id="title"><strong><a href=<?php print '"'.get_bloginfo('url').'">'.get_bloginfo('name'); ?></a></strong></p>
          <p id="description"><?php print get_bloginfo('description') ?></p>
        </div>
      </div>

      <div id="nav">
      <?php
        $output = "";
        $subpage = "";
        $params = "title_li=&depth=1&echo=0";

        // Top level page
        $output .= '<ul id="nav_page">';
        $output .= wp_list_pages($params);
        $output .= '</ul>';

        // second level?
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
          $output .= '<ul id="nav_subpage">';
          $output .= $subpage;
          $output .= '</ul>';
        }
        print $output;
      ?>
      </div>
<!--    <li id="search">
      <label for="s"><?php _e('Search:'); ?></label>
      <form id="searchform" method="get" action="<?php bloginfo('home'); ?>">
      <div>
        <input type="text" name="s" id="s" size="15" /><br />
        <input type="submit" value="<?php _e('Search'); ?>" />
      </div>
      </form>
    </li>
-->
    </div>
    <div id="content">
      <div id="main">
        <div id="inside">