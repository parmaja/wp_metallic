<?php get_header(); ?>
<ol id="posts">
<?php	if (!have_posts()) { ?>
    <p><?php __('Sorry, no posts matched your criteria.', 'default'); ?></p>
<?php	} else {
        $posts_count = 0;
        while (have_posts()) {
          the_post();
?>
  <li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <h2 class="title<?php if ($posts_count > 0) print(' pagebreak') ?>"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
    <ul class="infobar">
      <?php if (get_theme_mod('show_post_avatar', false)) { ?><li class="avatar"><?php echo get_avatar( get_the_author_meta( 'ID' ), 32 ); ?></li> <?php } ?>
      <li class="entry-author"><?php the_author_posts_link(); ?></li>
      <li class="entry-date"><?php print get_the_date(); ?></li>
      <li class="entry-edit"><?php edit_post_link(__('Edit', 'default')); ?></li>
    </ul>
    <div class="post-content"><?php the_content(__('More...', 'default')); ?></div>
    <ul class="infobar">
      <li class="category"><?php print __('Category', 'default').': '; print the_category(', ') ?></li>
      <li class="tags"><?php the_tags(__('Tags: ', 'default'), ', ', '') ?></li>
      <li class="comments-count"><?php comments_popup_link(__('No Comments', 'default'), __('1 Comment', 'default'), __('% Comments', 'default'), ''); ?></li>
    </ul>
    <hr class="skip" />
  </li>
  <?php
      $posts_count++;
    } ?>
</ol>
<?php
    comments_template();
  }
?>