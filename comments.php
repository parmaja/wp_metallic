<?php
/**
 * @ported from Twenty Thirteen
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() )
  return;

function metallic_comment($comment, $args, $depth) {
?>
  <li <?php comment_class() ?> id="comment-<?php comment_ID() ?>">
    <?php if (!get_theme_mod('hide_mata', false)) { ?>
    <div class="avatar"><?php echo get_avatar($comment, $args['avatar_size']); ?></div>
      <ul class="infobar">
        <li class="entry-author"><?php comment_author_link(); ?></li>
        <li class="entry-date"><?php comment_date(); ?> <?php comment_time(); ?></li>
        <li class="entry-type"><?php comment_type('', __('Trackback', 'default'), __('Pingback', 'default')); ?></li>
        <li class="entry-edit"><?php edit_comment_link(__('Edit', 'default')); ?></li>
      </ul>
      <?php } ?>
      <div class="comment-body">
      <?php comment_text() ?>
      </div>
    <hr class="skip" />
  </li>
<?php
}
?>
<div id="comments" class="comments-area">

  <?php if (have_comments()) { ?>
    <ol class="comment-list">
      <?php
        wp_list_comments(
          array(
            'callback' => 'metallic_comment',
            'avatar_size' => 32,
            'style'       => 'ol',
            'short_ping'  => true
          )
        );
      ?>
    </ol><!-- .comment-list -->

    <?php
      // Are there comments to navigate through?
      if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) {
    ?>
    <nav class="navigation comment-navigation" role="navigation">
      <div class="nav-previous"><?php previous_comments_link(__( '&laquo; Older Comments', 'default' ) ); ?></div>
      <div class="nav-next"><?php next_comments_link(__('Newer Comments &raquo;', 'default')); ?></div>
    </nav><!-- .comment-navigation -->
    <?php } // Check for comment navigation ?>

    <?php if (!comments_open() && get_comments_number() ) { ?>
    <p class="no-comments"><?php __( 'Comments are closed.' , 'default' ); ?></p>
    <?php } ?>

  <?php } // have_comments() ?>
  <?php comment_form();
  ?>
</div><!-- #comments -->