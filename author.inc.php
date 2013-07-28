  <?php echo get_avatar( $comment, 32 ); ?>
  <ul class="post_info">
  	<li class="date"><?php the_date(); ?></li><li class="author"><?php the_author(); ?></li>
	  <li class="post_edit"><?php edit_post_link(__('Edit')); ?></li>
  </ul>