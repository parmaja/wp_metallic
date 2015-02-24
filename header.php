<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
<?php
  global $wp_customize;

  $is_tablet = strpos($_SERVER['HTTP_USER_AGENT'], 'Tablet') !== false;

  if (wp_is_mobile())
  { ?>
  <!-- Tell the browser to use the same width of the device -->
  <meta name="HandheldFriendly" content="true"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
  <?php
    }
//    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    /** Init Options variables */
    if (isset($_GET['wide']))
      $wide_header = $_GET['wide'];
    else
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
//    wp_get_archives( array( 'type' => 'monthly', 'format' => 'link', 'limit' => 12 ) );
    if ( is_singular() ) wp_enqueue_script( "comment-reply" );
    wp_head();
  ?>
</head>

<body <?php body_class(); ?>>
  <?php if (!$wide_header) { ?>
  <div id="container">
  <?php } ?>
    <header id="header">
      <div id="logo">
        <div id="logo-header">
          <?php if ($show_logo) { ?>
          <a id="logo-image" href="<?php print home_url(); ?>"><img src="<?php print $logo_file ?>" alt="" /></a>
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

          if (wp_is_mobile() && get_theme_mod('show_sidebar', true)){
        ?>
          <a id="drawer" class="drawer-closed" href = "#">
             <div id="drawer-button">
               <span></span>
            </div>
          </a>
<script>
  isMobile = <?php if (wp_is_mobile) echo "true"; else echo "false"; ?>;
  isTablet = <?php if ($is_tablet) echo "true"; else echo "false"; ?>;
  document.getElementById("drawer").addEventListener("click", drawerClick);

  function drawerClick(e) {
    t = document.getElementById("drawer");//e.currentTarget;
    sidebar = document.getElementById("sidebar");
    main = document.getElementById("main");
    if (sidebar.style.display != "block")
    {
      if (isTablet) {
        sidebar.style.width = "30%";
        main.style.width = "70%";
      }
      else {
        sidebar.style.width = "100%";
        main.style.display = "none";
      }
      sidebar.style.display = "block";
      t.className = "drawer-opened";
    }
    else {
      sidebar.style.display = "none";
      main.style.width = "100%";
      main.style.display = "block";
      t.className = "drawer-closed";
    }
    return true;
  }
</script>
        </nav>
      <?php
        }
      } ?>
      </div>
    </header>
    <?php if ($wide_header) { ?>
    <div id="container">
    <?php } ?>
    <div id="wrapper">
      <div id="main">
        <div id="contents">