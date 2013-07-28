<?php

  /**
  *@desc A single blog post See page.php is for a page layout.
  */

  get_header();

  if (have_posts()) {
    while (have_posts()) {
  		the_post();
  ?>
    <div class="post" id="post-<?php the_ID(); ?>">
      <h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
      <?php echo get_avatar( $comment, 32 ); ?>
			<?php include('author.inc.php'); ?>
      <div class="post"><?php the_content(__('(more...)')); ?></div>

      <ul class="post_info">
      	<li class="category">Category: <?php the_category(', ') ?></li>
        <li class="tags"><?php the_tags(__('Tags: '), ', ', '') ?></li>
        <li class="comments_count"><?php comments_popup_link(__('Comments (0)'), __('Comments (1)'), __('Comments (%)'), ''); ?></li>
      </ul>

    </div>

	<?php

  comments_template();

  } } else { ?>

		<p>Sorry, no posts matched your criteria.</p>

<?php
  }

  get_footer();

?>