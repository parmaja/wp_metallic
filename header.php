<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
<?php
  global $wp_customize;

  $metallic_is_tablet = strpos($_SERVER['HTTP_USER_AGENT'], 'Tablet') !== false;

  if (wp_is_mobile())
  { ?>
    <!-- Tell the browser to use the same width of the device -->
  <meta name="HandheldFriendly" content="true"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
  <?php
    }

    /** Init Options variables */

    $show_logo = get_theme_mod('show_logo', true);
    $show_title = display_header_text();
    $show_navigator = get_theme_mod('show_navigator', true);

    $logo_image = get_site_icon_url(32);
    if (empty($logo_image)) {
      if (file_exists(get_stylesheet_directory().'/images/logo.png'))
        $logo_image = get_stylesheet_directory_uri().'/images/logo.png';
      else
        $logo_image = get_stylesheet_directory_uri().'/images/wp_logo.png';
    }
  ?>
  <title><?php wp_title('') ?></title>
  <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
  <link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
  <link rel="alternate" type="application/atom+xml" title="Atom 1.0" href="<?php bloginfo('atom_url'); ?>" />
  <link rel="pingback" href="<?php print bloginfo('pingback_url'); ?>" />
  <link rel="shortlink" href="<?php print wp_get_shortlink(); ?>" />
  <?php
/*  <link rel='prev' title='' href=''/>
  <link rel='next' title='' href=''/>*/
//    wp_get_archives( array( 'type' => 'monthly', 'format' => 'link', 'limit' => 12 ) );
    if ( is_singular() ) wp_enqueue_script( "comment-reply" );
    wp_head();
    if (get_header_image()) {
  ?>
<style type="text/css" media="screen">
  #header {
    background-image: url("<?php header_image(); ?>");
  }
</style>
<?php
}
?>
</head>

<body <?php body_class(); ?>>
    <header id="header">
      <div id="headerbar">
        <div id="logo-header">
          <?php if ($show_logo) { ?>
          <a id="logo-image" href="<?php print home_url(); ?>"><img src="<?php print $logo_image ?>" alt="" /></a>
          <?php } ?>
          <?php if ($show_title) { ?>
          <div id="logo-text">
            <h1 id="title"><a href=<?php print '"'.home_url().'">'.get_bloginfo('name'); ?></a></h1>
            <p id="description"><?php print get_bloginfo('description') ?></p>
          </div>
          <?php } ?>
        </div>

        <?php if ($show_navigator) { ?>
        <nav id="nav">
        <?php
          $output = "";
          $subpage = "";
          $params = "title_li=&depth=1&echo=0";

          // Top level page
          $output .= '<ul id="nav-page">';
          $output .= wp_list_pages($params);
          $output .= '</ul>';
          print $output;

          // second level?
          
          if (get_theme_mod('show_subpages', true)) {

            $sub_params = "";

            if(isset($post->post_parent) and ($post->post_parent > 0))
            {
              $sub_params .= "&child_of=" . $post->post_parent;
            }
            else
            {
              if (isset($post->ID) and ($post->ID > 0))
                $sub_params .= "&child_of=" . $post->ID;
            }

            get_template_part('nav', 'inc');

            if (!empty($sub_params))
            {
                $output = '';
                $subpage = wp_list_pages($params.$sub_params);

                if (!empty($subpage))
                {
                  $output .= '<ul id="nav-subpage">';
                  $output .= $subpage;
                  $output .= '</ul>';
                }
                print $output;
            }
          }
        ?>
        </nav>
      <?php
      } ?>
      </div>
    </header>
    <div id="container">
    <div id="wrapper">
      <div id="mainbar">
        <div id="contents">
