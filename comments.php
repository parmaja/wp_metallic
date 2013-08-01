<?php

  /**
  *@desc Included at the bottom of post.php and single.php, deals with all comment layout
  */
/* Check if protected*/
if ( !empty($post->post_password) && $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {
	?>
		<p><?php _e('Enter your password to view comments.'); ?></p>
	<?php return; }
//-------------------------------------
?>

<?php if ( comments_open() ) { ?>
	<!-- a href="#postcomment"><?php _e("Leave a comment"); ?></a -->
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
	<p><?php _e('No comments yet.'); ?></p>
<?php } ?>

<?php if ( comments_open() ) { ?>

<?php if ( get_option('comment_registration') && !$user_ID ) { ?>
<p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.'), get_option('siteurl')."/wp-login.php?redirect_to=".urlencode(get_permalink()));?></p>
<?php } else { ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) { ?>

<p class="infobar"><?php printf(__('Logged in as %s.'), '<a href="'.get_option('siteurl').'/wp-admin/profile.php">'.$user_identity.'</a>'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account') ?>"><?php _e('Logout &raquo;'); ?></a></p>

<?php } else { ?>

<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
<label for="author"><small><?php _e('Name'); ?> <?php if ($req) _e('(required)'); ?></small></label></p>

<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
<label for="email"><small><?php _e('Mail (will not be published)');?> <?php if ($req) _e('(required)'); ?></small></label></p>

<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
<label for="url"><small><?php _e('Website'); ?></small></label></p>

<?php } ?>

<!--<p><small><strong>XHTML:</strong> <?php printf(__('You can use these tags: %s'), allowed_tags()); ?></small></p>-->

<p><textarea name="comment" id="comment-area" cols="100%" rows="10" tabindex="4"></textarea></p>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="<?php echo attribute_escape(__('Submit Comment')); ?>" />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
</p>
<?php do_action('comment_form', $post->ID); ?>

</form>
<p class="infobar"><?php comments_rss_link(__('<abbr title="Really Simple Syndication">RSS</abbr> Feed for comments.')); ?>
<?php if ( pings_open() ) { ?>
	<a href="<?php trackback_url() ?>" rel="trackback"><?php _e('TrackBack <abbr title="Universal Resource Locator">URL</abbr>'); ?></a>
<?php } ?>
</p>

<?php } // If registration required and not logged in ?>

<?php } else { // Comments are closed ?>
<p><?php _e('Sorry, the comment form is closed at this time.'); ?></p>
<?php } ?>