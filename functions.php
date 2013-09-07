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

add_theme_support( 'automatic-feed-links' );

if (!isset($content_width)) {
  if (wp_is_mobile()) {
    $content_width = 300; //70%
  } if (get_theme_mod('show_sidebar', true))
    $content_width = 600; //70%
  else
    $content_width = 900;
}

function metallic_link_pages(){
    wp_link_pages(
      array(
        'before' => '<ul class="page-numbers">',
        'after' => '</ul>',
        'link_before' => '<li class="page-number">',
        'link_after' => '</li>',
        'pagelink'         => '%',
        'nextpagelink'     => __('Next page', 'default'),
        'previouspagelink' => __('Previous page', 'default')
        )
    );
}

/* set_current_user */

add_action('set_current_user', 'metallic_set_current_user');

function metallic_set_current_user() {
  if (!current_user_can('edit_posts')) {
    show_admin_bar(false);
  }
}

/** Register sidebar */

if ( function_exists('register_sidebar') )
{
  register_sidebars(1, array(
    'name' => 'Sidebar',
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget' => '</li>',
    'before_title' => '<div class="title">',
    'after_title' => '</div>',
  ));

  register_sidebars(1, array(
    'name' => 'Mobile',
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget' => '</li>',
    'before_title' => '<div class="title">',
    'after_title' => '</div>',
  ));

  register_sidebars(1, array(
    'name' => 'Footer',
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget' => '</li>',
    'before_title' => '<div class="title">',
    'after_title' => '</div>',
  ));
}

/** Register customize */

function metallic_add_option($wp_customize, $name, $title, $type = 'checkbox', $default = 'true') {
    $wp_customize->add_setting($name, array(
        'capability' => 'edit_theme_options',
        'default' => $default,
        'type'       => 'theme_mod',
    ));

    $wp_customize->add_control($name, array(
        'settings' => $name,
        'label'    => $title,
        'section'  => 'metallic_options',
        'type'     => $type,
    ));
}

function metallic_customize_register($wp_customize) {

  $wp_customize->add_section('metallic_options', array(
        'title'    => __('Options', 'metallic'),
        'priority' => 120,
  ));

    metallic_add_option($wp_customize, 'pages_navigator', __('Navigation Menus', 'default'));
    metallic_add_option($wp_customize, 'wide_header', __('Wide Header', 'metallic'));
    metallic_add_option($wp_customize, 'show_sidebar', __('Show Sidebar', 'default'));
    metallic_add_option($wp_customize, 'show_footbar', __('Show Footbar', 'default'));
    metallic_add_option($wp_customize, 'show_title', __('Show Title', 'default'));
    metallic_add_option($wp_customize, 'gradients', __('Gradients', 'metallic'));
    metallic_add_option($wp_customize, 'show_logo', __('Show Logo', 'default'));
    metallic_add_option($wp_customize, 'logo_url', __('Logo URL', 'metallic'), 'text');
    //  =============================
    //  Select Scheme
    //  =============================
     $wp_customize->add_setting('color_scheme', array(
        'default'        => 'Gray',
        'capability'     => 'edit_theme_options',
        'type'           => 'theme_mod', //or 'option' if u want to have a record in database

    ));

    $shemes = array();

    $dir = dirname(__FILE__).'/schemes';

    if ($handle = opendir($dir)) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                $ini = parse_ini_file($dir.'/'.$entry, false);
                $name = strstr($entry, '.', true);//explode('.', $entry);
                $title = $ini['name'];
                $shemes[$name] = __($title, 'default');//It is a color name we can translate it //TODO use own gettext domain
            }
        }
        closedir($handle);
    }

    $wp_customize->add_control( 'color_select_box', array(
        'settings' => 'color_scheme',
        'label'   => 'Select Color:',
        'section' => 'metallic_options',
        'type'    => 'select',
        'choices' => $shemes
        )
    );
}

add_action('customize_register', 'metallic_customize_register');

/** Save after */

/*
  Ref:
        http://aquagraphite.com/2011/11/dynamically-generate-static-css-files-using-php/
        http://stackoverflow.com/questions/14802251/hook-into-the-wordpress-theme-customizer-save-action
*/

require('inc/macros.php');

function metallic_generate_css_cache(){
  global $wp_customize;
  $scheme = get_theme_mod('color_scheme', 'gray');
  $css_macro = new CssMacro;
  $css_macro->load_values(dirname(__FILE__).'/default.scheme.ini');
  $css_macro->load_values(dirname(__FILE__).'/schemes/'.$scheme.'.scheme.ini');
  $file= dirname(__FILE__).'/style.css';
  if (file_exists($file)) {
    $style = file_get_contents($file);
    $css_dir = get_stylesheet_directory() . '/css/';
    $css = $css_macro->generate($style);
    file_put_contents($css_dir.'style.css', $css, LOCK_EX);
  }
}

function metallic_customize_save_after(){
  metallic_generate_css_cache();
}

function metallic_activation($old_theme)
{
  metallic_generate_css_cache();
  return;
}

add_action('customize_save_after', 'metallic_customize_save_after');
add_action("after_switch_theme", 'metallic_activation');

/*  */
/*
add_action('wp_enqueue_scripts', 'prefix_add_my_stylesheet');

function prefix_add_my_stylesheet() {
    wp_register_style( 'custom-supersized-styles', get_template_directory_uri(). '/css/style.css', array('style','supersized'));
    wp_enqueue_style( 'custom-supersized-styles' );
}
*/

?>