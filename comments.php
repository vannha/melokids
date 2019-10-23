<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package ZookaStudio
 * @subpackage MeloKids
 * @author Chinh Duong Manh
 * @since 1.0.0
 *
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area"><?php
	if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			$comments_number = get_comments_number();
			printf(
				_nx(
					'Comment (%2$s)',
					'Comments (%2$s)',
					$comments_number,
					$comments_number,
					'comment',
					'melokids'
				),
				number_format_i18n( $comments_number ),
				number_format_i18n( $comments_number )
			);
			?>
		</h2>

		<div class="commentlist">
			<?php
				wp_list_comments( array(
					'avatar_size' => 90,
					'style'       => 'div',
					'short_ping'  => true,
					'callback'	  => 'melokids_comment_template'	
				) );
			?>
		</div>

		<?php 
		the_comments_pagination();

	endif; 

	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'melokids' ); ?></p>
	<?php
	endif;
	//$args = array();
	//comment_form($args);
?></div>
