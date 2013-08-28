WP Metallic Theme and CSS Macros
===========

This project have two projects,

WordPress Metallic Theme: a very simple and light theme for wordpress work for desktop and mobile

CSS Macros, small engine css_macros.php used by this theme, so you can take the theme as good exapmple how to write css

WP Metallic Theme
-----------------

**Advantages**

* CSS3, Modern styling
* No images at all, only your logo at corner
* Mobile style, if you open your site/blog in a mobile, it will show for small screen
* Right To Left support
* Multi colors
* //Custom Logo

**Disadvantages**

* CSS3, not all browsers can show it, but it still works

**Install**

Need PHP 5.3 or above
Put all file here \wp-content\themes\metallic

CSS Macros
----------

Command and macro to change the CSS 

When build your css you need to repeat your colors, or make a color depend on another color lighter of darker or mix.
remodifiing your css will be so hard, so CssMacros read the command started with $ like $get and replace it.


    color: $set(mycolor, #000);

    color: $get(mycolor); get the color without any change
    color: $color(mycolor); same

    color: $lighten(mycolor, 10); make it lighten +10, rabge 0..100
    color: $color(mycolor, 10); make it lighten +10, rabge 100..0..100

    color: $darken(mycolor, 10); make it darken +10, range 0..100
    color: $color(mycolor, -10); range 100..0..100

    color: $mix(mycolor1, mycolor2); mix 2 colors
    color: $mix(mycolor1, mycolor2, 50); mix 2 colors but put more mycolor2 ranged 100..0..100

  To define the variables directly put $< and > alone in a line do not mix it with any text.
  notice it is not a css it just like the ini file
  Examples:

    $<
      back=#fff
      border=$mix(canvas_back, base, 80)
      background=$mix(canvas_back, base, 90)
      use_gradient=false
    >

  Also you can define a confition to execlude a bock of css the

    $if(use_gradient)<
      border=$mix(canvas_back, base, 80)
      background: $mix(canvas_back, base, 90);
    >

//Next example not tested yet//

   $if(back, #fff)<
     border=$mix(canvas_back, base, 80)
     background: $mix(canvas_back, base, 90);
   >
