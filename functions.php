<?php
/**
* Wordpress Naked, a very minimal wordpress theme designed to be used as a base for other themes.
*
* @licence LGPL
* @author Darren Beale - http://siftware.co.uk - bealers@gmail.com - @bealers
* 
* Project URL http://code.google.com/p/wordpress-naked/
*/

/**
* register_sidebar()
*
*@desc Registers the markup to display in and around a widget
*/
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
}

function metallic_customize_register($wp_customize) {

	$wp_customize->add_section('metallic_color_scheme', array(
        'title'    => __('Color Scheme', 'metallic'),
        'priority' => 120,
  ));
/*
	$wp_customize->add_setting('metallic_theme_options[checkbox_test]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
    ));

    $wp_customize->add_control('display_header_text', array(
        'settings' => 'metallic_theme_options[checkbox_test]',
        'label'    => __('Display Header Text'),
        'section'  => 'metallic_color_scheme',
        'type'     => 'checkbox',
    ));
*/
		//  =============================
    //  = Select Color Box                =
    //  =============================
     $wp_customize->add_setting('color_scheme', array(
        'default'        => 'Gray',
        'capability'     => 'edit_theme_options',
        'type'           => 'theme_mod', //or 'option' if u want to have a record in database

    ));
    $wp_customize->add_control( 'color_select_box', array(
        'settings' => 'color_scheme',
        'label'   => 'Select Color:',
        'section' => 'metallic_color_scheme',
        'type'    => 'select',
        'choices'    => array(
            'gray' => 'Gray',
            'blue' => 'Blue',
            'pink' => 'Pink',
        ),
    ));
}

add_action('customize_register', 'metallic_customize_register');

function metallic_customize_save(){
	$color = get_theme_mod('color_scheme');
	metallic_generate_css('gray');
}

add_action('customize_save', 'metallic_customize_save');

/*
	Ref: http://aquagraphite.com/2011/11/dynamically-generate-static-css-files-using-php/
*/

include('changer.ini');

function metallic_load_ini($name) {
	$styleini = array();
  $ini = dirname(__FILE__).'\\'.$name.'.style.ini';
  if (file_exists($ini))
		$styleini = parse_ini_file($ini, true);
  else
  	$styleini = array();
  return $styleini;
}

function metallic_replace($matches) {
	global $css_changer;
	return $css_changer->call($matches[1], $matches[2]);
}

function metallic_generate_css($name) {
	global $css_changer;
	$css_changer->ini = metallic_load_ini($name);
  $file= dirname(__FILE__).'\\style.css';
  if (file_exists($file)) {
		$style = file_get_contents($file);
		$css = preg_replace_callback('/\$(.*)\((.*)\)/i', 'metallic_replace', $style);
  	$css_dir = get_stylesheet_directory() . '/css/';
	  file_put_contents($css_dir.'style.css', $css, LOCK_EX);
  }
  else
  	'';
}
?>