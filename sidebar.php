<ul>
<?php
    if (function_exists('dynamic_sidebar')) {
      if (wp_is_mobile()) {
        dynamic_sidebar('Mobile');
      } else {
        if (!dynamic_sidebar('Sidebar')) {
          wp_list_bookmarks('title_after=&title_before=');
          wp_list_categories('title_li=0&orderby=name&show_count=0');
        }
      }
    }
?>
</ul>