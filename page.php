<?php

  /**
  *@desc A page. See single.php is for a blog post layout.
  */

  get_header();

  if (have_posts()) : while (have_posts()) : the_post();
  ?>

    <div class="post" id="post-<?php the_ID(); ?>">

      <h1 class="title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>
      <div id=""><small><?php the_date(); ?> :: <?php the_author(); ?></small></div>
      <?php echo get_avatar( $comment, 32 ); ?>  
      
      <div class="post"><?php the_content(__('(more...)')); ?></div>
      <p class="post_meta"><?php edit_post_link(__('Edit'), ''); ?></p>
    </div>

  <?php
  comments_template();

  endwhile; else: ?>

    <p>Sorry, no pages matched your criteria.</p>

<?php
  endif;

  get_footer();
?>