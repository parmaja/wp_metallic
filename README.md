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

Command and macro to change the CSS.

  /wp_metallic//inc/macros.php

When build your css you need to repeat your colors, or make a color depend on another one, lighter of darker or mix it.
then remodifing your css will be so hard, CssMacros read the command started with $ like $get,$mix, and replace it with the real value the set before by $set or with ini block.

Examples:
Set the color and return the same vallue
    color: $set(mycolor, #000);
    
Get the color from the variable
    color: $get(mycolor); 
    color: $color(mycolor); 

Get it and make it lighten or darken by +10, range 0..100
    color: $lighten(mycolor, 10); 
    color: $color(mycolor, 10); make it lighten +10, rabge 100..0..100
    color: $darken(mycolor, 10); make it darken +10, range 0..100
    color: $color(mycolor, -10); range 100..0..100

Mix two of color, the range 100..0..100, 0 meant 50% from mycolor1 and 50% from mycolor2
    color: $mix(mycolor1, mycolor2); mix 2 colors
    color: $mix(mycolor1, mycolor2, 50);

To define the variables directly put $< and > (alone in a line), do not mix it with any text.
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

**Disadvantages**
You can not use nested command like this :(

    color: $lighten($mix(back, fore), 10);
