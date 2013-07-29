	<?php include('post.inc.php'); ?>

  <?php if (will_paginate()) { ?>
    <ul id="pagination">
      <li class="previous"><?php posts_nav_link('','','&laquo; Previous Entries') ?></li>
      <li class="future"><?php posts_nav_link('','Next Entries &raquo;','') ?></li>
    </ul>
  <?php } ?>

  <?php	get_footer(); ?>