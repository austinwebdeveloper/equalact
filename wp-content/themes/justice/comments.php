<?php
/**
 * Comments Template
 *
 * This template file used to display comments, pingbacks, trackbacks and comment form.
 *
 * @package TemplatePath
 */

// Do not delete these lines
if( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) ) { 
	die ( __( 'Please do not load this page directly. Thanks!', 'Templatepath' ) ); 
}
 
if( post_password_required() ) { ?>
	<p class="tpath-no-comments">
		<?php esc_html_e( 'This post is password protected. Enter the password to view comments.', 'Templatepath' ); ?>
	</p>
	<?php return;	
} ?>

<div id="comments" class="comments-section">

	<?php if ( have_comments() ) {
		$post_id = get_the_ID(); ?>
	
		<div class="comments-title">
			<h5><?php printf( _n( '1 Comment', '%1$s Comments', get_comments_number(), 'Templatepath' ), number_format_i18n( get_comments_number() ) ); ?></h5>
			
			<?php if ( !is_user_logged_in() ) {
			echo '<p class="comment-login-msg">' . sprintf( __('You are not signed in. <a href="%s">Sign in</a> to post comments.', 'Templatepath'), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>';
		} ?>
		</div>
			
		<ul class="tpath-all-comments list-unstyled">
			<?php
				wp_list_comments( array(
					'style'       => 'li',
					'avatar_size' => 130,
					'callback'    => 'justice_custom_comments'
				) );
			?>
		</ul><!-- .comment-list -->
		
		<?php // Comment pagination.
		 	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { ?>
			<div class="navigation comment-nav">
				<ul class="pager comment-pager">
					<li class="previous"><?php previous_comments_link( __( '&larr; Older Comments', 'Templatepath' ) ); ?></li>
                	<li class="next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'Templatepath' ) ); ?></li>
				</ul>				
			</div><!-- .navigation -->
		<?php } ?>	
		
	<?php } // have_comments()

	else { 
	
		if ( comments_open() ) {
			// Comments are open ?>
			<h5 class="no-comments"><?php esc_html_e( 'No comments yet.', 'Templatepath' ); ?></h5>
		 <?php } else { 
			// Comments are closed ?>
			<h5 class="no-comments"><?php esc_html_e('Comments are closed.', 'Templatepath'); ?></h5>
	
		<?php }
		
	} ?>
		
</div><!-- #comments -->

<?php
$commenter = '';
$commenter = wp_get_current_commenter();
$req = get_option( 'require_name_email' );
$aria_req = ( $req ? " aria-required='true'" : '' );
$required_text = '';

$args = array(
  'id_form'           => 'commentform',
  'id_submit'         => 'submit',
  'title_reply'       => esc_html__( 'Leave a Reply', 'Templatepath' ),
  'title_reply_to'    => esc_html__( 'Leave a Reply to %s', 'Templatepath' ),
  'cancel_reply_link' => esc_html__( 'Cancel Reply', 'Templatepath' ),
  'label_submit'      => esc_html__( 'Post Comment', 'Templatepath' ),

  'comment_field' =>  '<p class="comment-form-comment form-group">'.
    '<textarea id="comment" class="form-control" name="comment" cols="45" rows="5" placeholder="Write your commment here" aria-required="true">' .
    '</textarea></p>',

  'must_log_in' => '<p class="must-log-in">' .
    sprintf(
      __( 'You must be <a href="%s">logged in</a> to post a comment.', 'Templatepath' ),
      esc_url( wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) )
    ) . '</p>',

  'logged_in_as' => '<p class="logged-in-as">' .
    sprintf(
    __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'Templatepath' ),
      esc_url( admin_url( 'profile.php' ) ),
      $user_identity,
      esc_url( wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) )
    ) . '</p>',

  'comment_notes_before' => '<p class="comment-notes">' .
    __( 'Your email address will not be published.', 'Templatepath' ) . ( $req ? $required_text : '' ) .
    '</p>',

  'comment_notes_after' => '',

  'fields' => apply_filters( 'comment_form_default_fields', array(

    'author' =>
      '<p class="comment-form-author form-group"><input id="author" class="form-control" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
      '" placeholder="'. __('Full Name', 'Templatepath') . ( $req ? '*' : '' ).'" size="30"' . $aria_req . ' /></p>',

    'email' =>
      '<p class="comment-form-email form-group"><input id="email" class="form-control" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
      '" placeholder="'. __('Email', 'Templatepath') . ( $req ? '*' : '' ).'" size="30"' . $aria_req . ' /></p>',

    'url' =>
      '<p class="comment-form-url form-group"><input id="url" class="form-control" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
      '" placeholder="'. __('Website', 'Templatepath') .'" size="30" /></p>'
    )
  ),
);

comment_form( $args ); ?>