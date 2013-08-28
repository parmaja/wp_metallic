WP Metallic Theme and CSS Macros
===========

This project have two projects,

WordPress Metallic Theme: is a very simple and light theme for wordpress work for desktop and mobile.

CSS Macros, small engine macros.php used by this theme, so you can take the theme as good exapmple how to write css with macro.

WP Metallic Theme
-----------------

**Advantages**

* CSS3, Modern styling
* No images at all, only your logo at corner
* Mobile style, if you open your site/blog in a mobile, it will show for small screen
* Right To Left support
* Multi colors
* Custom Logo (logo.png)

**Disadvantages**

* CSS3, not all browsers can show it, but it still works

**Install**

Need PHP 5.3 or above to work

Put all file here \wp-content\themes\metallic
Put your logo in \wp-content\themes\metallic\images\logo.png
Sorry only logo.png we accept, and be careful about the size.

CSS Macros
----------

Commands and macros to change the CSS.

  /wp_metallic//inc/macros.php

When build your css you need to repeat your colors, or make a color depend on another one, lighter, darker or mix it.
then remodifing your css will be so hard, CssMacros read the commands that started with $ like $get, $mix, and replace it with the real value that set before by $set or $def or with ini block.

Examples:
Set the color and return the same value.

    color: $set(mycolor, #000);
    
You can use $def instead of $set but $def not return any value.

    $def(mycolor, #000)
    
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

To define the variables directly put it in $< and > (alone in a line), do not mix it with any text.
notice that it is not a css it just like the ini file
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

You can not use nested commands like this :(

    color: $lighten($mix(back, fore), 10);
