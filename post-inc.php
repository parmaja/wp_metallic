<?php get_header(); ?>
<ol id="posts">
<?php	if (!have_posts()) { ?>
    <p><?php __('Sorry, no posts matched your criteria.', 'default'); ?></p>
<?php	} else {
        $count = 0;
        while (have_posts()) {
          the_post(); ?>

  <li class="post" id="post-<?php the_ID(); ?>">
    <h2 class="title<?php if ($count>0) print(' pagebreak') ?>"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
    <ul class="infobar">
      <!-- li class="avatar"><?php echo get_avatar( $comment, 32 ); ?></li -->
      <li class="author"><?php the_author(); ?></li>
      <li class="date"><?php the_date(); ?></li>
      <li class="edit"><?php edit_post_link(__('Edit', 'default')); ?></li>
    </ul>
    <div class="post-content"><?php the_content(__('More...', 'default')); ?></div>
    <ul class="infobar">
      <li class="category"><?php print __('Category', 'default').': '; print the_category(', ') ?></li>
      <li class="tags"><?php the_tags(__('Tags: ', 'default'), ', ', '') ?></li>
      <li class="comments_count"><?php comments_popup_link(__('No Comments', 'default'), __('1 Comment', 'default'), __('% Comments', 'default'), ''); ?></li>
    </ul>
    <hr class="skip" />
  </li>
  <?php
      $count++;
    } ?>
</ol>
<?php
    comments_template();
  }
?>