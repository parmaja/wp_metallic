<?php get_header(); ?>

  <ol id="posts">
  <?php	if (!have_posts()) { ?>
		  <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
  <?php	} else {
		    	while (have_posts()) {
          	the_post(); ?>

	    <li class="post" id="post-<?php the_ID(); ?>">

      <h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<?php include('author.inc.php'); ?>

      <div class="post_content"><p><?php the_content(__('(more...)')); ?></p></div>

      <ul class="post_info">
      	<li class="category">Category: <?php the_category(', ') ?></li>
        <li class="tags"><?php the_tags(__('Tags: '), ', ', '') ?></li>
        <li class="comments_count"><?php comments_popup_link(__('Comments (0)'), __('Comments (1)'), __('Comments (%)'), ''); ?></li>
      </ul>
      <hr class="skip" />
    </li>

   	<?php comments_template(); } ?>

  </ol>
	<?php } ?>

  <?php if (will_paginate()){ ?>
  
    <ul id="pagination">
      <li class="previous"><?php posts_nav_link('','','&laquo; Previous Entries') ?></li>
      <li class="future"><?php posts_nav_link('','Next Entries &raquo;','') ?></li>
    </ul>
    
  <?php } ?>

  <?php	get_footer(); ?>