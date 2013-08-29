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

define(Metallic, 'Metallic');

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

function metallic_customize_register($wp_customize) {

  $wp_customize->add_section('metallic_color_scheme', array(
        'title'    => __('Color Scheme', 'metallic'),
        'priority' => 120,
  ));

  $wp_customize->add_setting('pages_navigator', array(
        'capability' => 'edit_theme_options',
        'type'       => 'theme_mod',
    ));

    $wp_customize->add_control('pages_navigator', array(
        'settings' => 'pages_navigator',
        'label'    => __('Pages Navigator'),
        'section'  => 'metallic_color_scheme',
        'type'     => 'checkbox',
    ));

    //  =============================
    //  = Select Color Box                =
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
                $shemes[$name] = __($title);
            }
        }
        closedir($handle);
    }

    $wp_customize->add_control( 'color_select_box', array(
        'settings' => 'color_scheme',
        'label'   => 'Select Color:',
        'section' => 'metallic_color_scheme',
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

include('inc/macros.php');

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

function metallic_activation_settings($theme)
{
    if ($theme==Metallic)
    {
      metallic_generate_css_cache();
    }
    return;
}

add_action('customize_save_after', 'metallic_customize_save_after');
add_action("switch_theme", 'metallic_activation_settings');

/* set_current_user */

add_action('set_current_user', 'metallic_set_current_user');

function metallic_set_current_user() {
  if (!current_user_can('edit_posts')) {
    show_admin_bar(false);
  }
}

add_action("switch_theme", $fn);

/**************/

/*
add_action('wp_enqueue_scripts', 'prefix_add_my_stylesheet');

function prefix_add_my_stylesheet() {
    wp_register_style( 'custom-supersized-styles', get_template_directory_uri(). '/css/style.css', array('style','supersized'));
    wp_enqueue_style( 'custom-supersized-styles' );
}
*/
?>