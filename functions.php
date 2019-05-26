<?php
/**
*  This file is part of the "Metallic Theme" for wordpress
*
* @license   LGPL (http://www.gnu.org/licenses/gpl.html)
* @url			 http://www.github.com/parmaja/wp_metallic
* @author    Zaher Dirkey <zaher at parmaja dot com>
*
*
* Based on Naked project URL http://code.google.com/p/wordpress-naked/
*/

define('Metallic', 'Metallic');

const IS_MSH_META = '_wpcom_is_msh';

$is_tablet = strpos($_SERVER['HTTP_USER_AGENT'], 'Tablet') !== false;

function metallic_setup() {
    load_theme_textdomain( 'metallic' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );

    $args = array(
        'width'         => 1600,
        'height'        => 120,
        'flex-width'    => true,
        'flex-height'    => true
    );
    add_theme_support('custom-header', $args );

    //add_theme_support('custom-background', array()); //nop we dont have background
}

add_action('after_setup_theme', 'metallic_setup');

function metallic_title($title, $sep) {
    global $paged, $page;

    if (is_feed())
        return $title;

    // Add the site name.
    if ($title <> '')
        $title = $title . ' - ' . ' ';
    $title = $title . get_bloginfo( 'name' );

    // Add the site description for the home/front page.
    if ( ( is_home() || is_front_page() ) ) {
        $site_description = get_bloginfo( 'description', 'display' );
        if ($site_description)
            $title = $title . ' - ' .$site_description;
    }

    // Add a page number if necessary.
    if ( $paged >= 2 || $page >= 2 )
        $title = $title .' ' . $sep . ' ' . sprintf( __( 'Page %s', 'metallic' ), max( $paged, $page ) );

    return $title;
}
add_filter( 'wp_title', 'metallic_title', 10, 2 );


if (!isset($content_width)) {
  if (wp_is_mobile()) {
    $content_width = 900;//idk
  } if (get_theme_mod('show_sidebar', true))
    $content_width = 600; //70%
  else
    $content_width = 900;
}

if ( version_compare( $GLOBALS['wp_version'], '5.0', '<' ) ) {
}

function metallic_link_pages(){
    wp_link_pages(
      array(
        'before' => '<ul class="page-numbers">',
        'after' => '</ul>',
        'link_before' => '<li class="page-number">',
        'link_after' => '</li>',
        'pagelink'         => '%',
        'nextpagelink'     => __('Next page', 'metallic'),
        'previouspagelink' => __('Previous page', 'metallic')
        )
    );
}

function metallic_widgets_init() {

    /** Register sidebar */

  register_sidebar(array(
    'name' => __('Sidebar', 'metallic'),
    'id'            => 'sidebar-1',
    'description'   => __('Left or Right sidebar', 'metallic'),
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget' => '</li>',
    'before_title' => '<div class="title">',
    'after_title' => '</div>',
  ));

  register_sidebar(array(
    'name' => __('Mobile', 'metallic'),
    'id'            => 'sidebar-2',
    'description'   => __('Popup bar only show in mobile devices', 'metallic'),
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget' => '</li>',
    'before_title' => '<div class="title">',
    'after_title' => '</div>',
  ));

  register_sidebar(array(
    'name' => __('Footer' , 'metallic'),
    'id'            => 'sidebar-3',
    'description'   => __('Footer Side bar', 'metallic'),
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget' => '</li>',
    'before_title' => '<div class="title">',
    'after_title' => '</div>',
  ));
}

add_action( 'widgets_init', 'metallic_widgets_init' );

/** Register customize */

function metallic_add_option($wp_customize, $section, $name, $title, $type = 'checkbox', $default = 'true') {
    $wp_customize->add_setting($name, array(
        'default' => $default,
        'capability' => 'edit_theme_options',
        'type'       => 'theme_mod',
        'sanitize_callback' => 'sanitize_value'
    ));

    $wp_customize->add_control($name, array(
        'settings' => $name,
        'label'    => $title,
        'section'  => $section,
        'type'     => $type,
    ));
}

function sanitize_color_style($color) {
    return $color;
}

function sanitize_value($value) {
    return $value;
}

function metallic_customize_register($wp_customize) {

  $wp_customize->remove_control( 'header_textcolor' );

  $wp_customize->add_section('metallic_layout', array(
        'title'    => __('Layout', 'metallic'),
        'priority' => 120,
  ));

  $wp_customize->add_section('metallic_options', array(
        'title'    => __('Options', 'metallic'),
        'priority' => 121,
  ));

  $wp_customize->add_section('metallic_colors', array(
        'title'    => __('Colors', 'metallic'),
        'priority' => 121,
  ));


    metallic_add_option($wp_customize, 'metallic_layout', 'show_navigator', __('Show Navigation', 'metallic'));
    metallic_add_option($wp_customize, 'metallic_options', 'hide_mata', __('Hide Meta', 'metallic'), 'checkbox', 'false');
    metallic_add_option($wp_customize, 'metallic_options', 'hide_post_avatar', __('Hide Posts Avatar', 'metallic'), 'checkbox', 'false');
    metallic_add_option($wp_customize, 'metallic_layout', 'show_sidebar', __('Show Sidebar', 'metallic'));
    metallic_add_option($wp_customize, 'metallic_layout', 'show_subpages', __('Show SubPages', 'metallic'));
    metallic_add_option($wp_customize, 'metallic_layout', 'show_footbar', __('Show Footbar', 'metallic'));
    metallic_add_option($wp_customize, 'metallic_layout', 'show_title', __('Show Title', 'metallic'));
    metallic_add_option($wp_customize, 'metallic_options', 'gradients', __('Gradients', 'metallic'));
    metallic_add_option($wp_customize, 'metallic_options', 'show_logo', __('Show Logo', 'metallic'));

    metallic_add_option($wp_customize, 'metallic_options', 'desktop_font_size', __('Desktop Font Size', 'metallic'), 'number', '');
    metallic_add_option($wp_customize, 'metallic_options', 'tablet_font_size', __('Tablet Font Size', 'metallic'), 'number', '');
    metallic_add_option($wp_customize, 'metallic_options', 'mobile_font_size', __('Mobile Font Size', 'metallic'), 'number', '');
//    metallic_add_option($wp_customize, 'user_font_name', __('Font Name', 'metallic'), 'text', '');

    //  =============================
    //  Select style
    //  =============================

    $styles = array();
    $styles[''] = ''; //add empty default style
    $dir = __DIR__.'/styles';

    if ($handle = opendir($dir)) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..")
            {
                $ext = pathinfo($entry, PATHINFO_EXTENSION);
                if ($ext == "ini") {
                  $ini = parse_ini_file($dir.'/'.$entry, false);
                  $name = strstr($entry, '.', true);//explode('.', $entry);
                  $title = $ini['name'];
                  $styles[$name] = $title;//It is a color name we can translate it //TODO use own gettext domain
                }
            }
        }
        closedir($handle);
    }

    $wp_customize->add_setting('color_style', array(
      'default'        => '',
      'capability'     => 'edit_theme_options',
      'type'           => 'theme_mod', //or 'option' if u want to have a record in database
      'sanitize_callback' => 'sanitize_color_style'
    ));

    $wp_customize->add_control('color_select_box', array(
        'settings' => 'color_style',
        'label'    => __('Select style', 'metallic'),
        'section'  => 'metallic_colors',
        'type'     => 'select',
        'choices'  => $styles
        )
    );

    //  =============================
    //  = Color Picker              =
    //  =============================

    $wp_customize->add_setting('user_color', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
        'capability'        => 'edit_theme_options',
        'type'              => 'theme_mod',
        'sanitize_callback' => 'sanitize_color_style'

    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'user_color', array(
          'settings' => 'user_color',
          'label'    => __('User Color', 'metallic'),
          'section'  => 'metallic_colors'
        )
      )
    );
}

add_action('customize_register', 'metallic_customize_register');

/** Save after */

//Increase version of style to purge any cache of style

function metallic_customize_save_after()
{
  $ver = get_theme_mod('style_ver', 1);
  $ver = $ver + 1;
  set_theme_mod('style_ver', $ver);
}

function metallic_activation($old_theme)
{
  return;
}

add_action('customize_save_after', 'metallic_customize_save_after');
add_action("after_switch_theme", 'metallic_activation');

function mettalic_styles()
{
  global $is_tablet;

  $gradients = get_theme_mod('gradients', true);

  $params = '?gradients=';
  if ($gradients)
    $params .= '1';
  else
    $params .= '0';

  if (wp_is_mobile()) {
    if ($is_tablet)
      $font_size = get_theme_mod('tablet_font_size', '');
    else
      $font_size = get_theme_mod('mobile_font_size', '');
  }
  else
    $font_size = get_theme_mod('desktop_font_size', '');

  if (!empty($font_size)) {
    $params .= '&font_size='.$font_size;
  }

  if (wp_is_mobile())
    $params .= '&is_mobile=1';

  if (isset($_GET['style']))
    $style = $_GET['style'];
  else
    $style = get_theme_mod('color_style', '');

  if (!empty($style))
    $params.='&style='.$style;

  if (isset($_GET['color']))
      $user_color = $_GET['color'];
  else if (empty($user_color))
      $user_color = get_theme_mod('user_color', '');

  if (!empty($user_color)) {
    if (substr($user_color, 0, 1) === '#')
      $user_color = substr($user_color, 1);

    $params .= '&user_color='.$user_color;
  }

  $ver = get_theme_mod('style_ver', 1);

  wp_register_style('metallic_layout', get_stylesheet_directory_uri().'/css/layout.css');
  wp_enqueue_style('metallic_layout');

  wp_register_style('metallic_style', get_stylesheet_directory_uri().'/style.php'.$params, array(), $ver);
  wp_enqueue_style('metallic_style');

  if (isset($_GET['sidebar']))
    $show_sidebar = $_GET['sidebar'];
  else
    $show_sidebar = get_theme_mod('show_sidebar', true);

  if (wp_is_mobile())
  {
    wp_register_style('metallic_mobile', get_stylesheet_directory_uri().'/css/mobile.css');
    wp_enqueue_style('metallic_mobile');
  } else
  {
    wp_register_style('metallic_screen', get_stylesheet_directory_uri().'/css/screen.css');
    wp_enqueue_style('metallic_screen');

    if ($show_sidebar) {
      wp_register_style('metallic_sidebar', get_stylesheet_directory_uri().'/css/sidebar.css');
      wp_enqueue_style('metallic_sidebar');
    }
  }

  if (is_rtl())
    wp_register_style('metallic_bidi', get_stylesheet_directory_uri().'/css/style_rtl.css');
  else
    wp_register_style('metallic_bidi', get_stylesheet_directory_uri().'/css/style_ltr.css');

  wp_enqueue_style('metallic_bidi');
}

add_action('wp_enqueue_scripts', 'mettalic_styles');
?>
