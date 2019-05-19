  <?php
    get_template_part('post', 'inc');
  ?>

  <ul id="pagination" class="pagination">
    <li class="previous-posts"><?php previous_posts_link('&laquo; Previous', 'metallic') ?></li>
    <li class="next-posts"><?php next_posts_link(__('Next &raquo;', 'metallic')) ?></li>
  </ul>
  <?php
    get_footer();
  ?>
