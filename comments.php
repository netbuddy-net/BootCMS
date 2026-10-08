<?php
/** 
 * WordPress classic theme
 * comments.php
 * @link https://github/...
 * @package BootCMS
 * @since 2.0
 */

  if ( post_password_required() ) {
	return;
  }
  ?>
  <div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
	<h2 class="comments-title">
	<?php
	printf(
	  esc_html(
		_n( 'One Comment', '%1$s Comments', get_comments_number(), 'bootcms' )
	  ),
	  number_format_i18n( get_comments_number() )
	 );
	?>
	</h2>
	<ol class="comment-list">
	<?php
	  wp_list_comments(
		array( 'style' => 'ol', )
	  );
	?>
	</ol>
	  <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav class="comment-navigation">
		  <div class="nav-previous">
			<?php previous_comments_link( esc_html__( 'Older Comments', 'bootcms' ) ); ?>
		  </div>
		  <div class="nav-next">
			<?php next_comments_link( esc_html__( 'Newer Comments', 'bootcms' ) ); ?>
		  </div>
		</nav>
	  <?php endif; ?>
	<?php endif; ?>
	<?php if ( ! comments_open() && get_comments_number() ) : ?>
	  <p class="no-comments">
		<?php esc_html_e( 'Comments are closed.', 'bootcms' ); ?>
	  </p>
	<?php endif; ?>
	<?php comment_form(); ?>
  </div>