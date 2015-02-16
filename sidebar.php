<?php
    if (get_theme_mod('show_sidebar', true)) {
      if (!wp_is_mobile()) {
?>
<aside id="sidebar">
  <ul>
  <?php
        if (!dynamic_sidebar('Sidebar')) {
          wp_list_bookmarks('title_after=&title_before=');
          wp_list_categories('title_li=0&orderby=name&show_count=0');
        }
  ?>
  </ul>
</aside>
<?php
    }
  }
?>