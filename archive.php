  <?php
    get_template_part('post', 'inc');
  ?>
  <ul class="pagination">
    <li class="previous-posts"><?php previous_posts_link('&laquo; Previous', 'default') ?></li>
    <li class="next-posts"><?php next_posts_link(__('Next &raquo;', 'default')) ?></li>
  </ul>
  <?php	get_footer(); ?>