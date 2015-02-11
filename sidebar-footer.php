<?php
  if (wp_is_mobile())
    $footer = 'Mobile';
  else
    $footer = 'Footer';
  if (get_theme_mod('show_footbar', true) && is_dynamic_sidebar($footer)) { //is_dynamic_sidebar($footer)
?>
<div id="footbar" class="footbar">
  <ul>
  <?php
        dynamic_sidebar($footer);
  ?>
  </ul>
</div>
<?php } ?>