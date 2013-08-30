<?php
/**
*@desc Included at the bottom of post.php and single.php, deals with all comment layout
*/

/* Check if protected*/
if (post_password_required())
  return;
?>

<?php if ( comments_open() ) { ?>
  <!-- a href="#postcomment"><?php __("Leave a comment", 'default'); ?></a -->
<?php } ?>

<?php if ( $comments ) { ?>
<ol id="commentlist">

<?php foreach ($comments as $comment) { ?>
  <li id="comment-<?php comment_ID() ?>">
    <div class="comment">
      <div class="avatar"><?php echo get_avatar( $comment, 48); ?></div>
      <ul class="infobar">
        <li class="author"><?php comment_author_link(); ?></li>
        <li class="date"><?php comment_date(); ?> <?php comment_time(); ?></li>
        <li class="info_type"><?php comment_type(__(''), __('Trackback'), __('Pingback')); ?></li>
        <li class="edit"><?php edit_comment_link(__('Edit')); ?></li>
      </ul>
      <?php comment_text() ?>
    </div>
    <hr class="skip" />
  </li>

<?php } ?>

</ol>

<?php } else { // If there are no comments yet ?>
  <p><?php __('No comments yet.', 'default'); ?></p>
<?php } ?>

<?php if ( comments_open() ) { ?>

<?php if ( get_option('comment_registration') && !$user_ID ) { ?>
<p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.'), get_option('siteurl')."/wp-login.php?redirect_to=".urlencode(get_permalink()));?></p>
<?php } else { ?>
<?php comment_form(); ?>

<?php } // If registration required and not logged in ?>

<?php } else { // Comments are closed ?>
<p><?php __('Sorry, the comment form is closed at this time.', 'default'); ?></p>
<?php } ?>