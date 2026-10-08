<?php
/** 
 * WordPress classic theme
 * single.php
 * @link https://github/...
 * @package BootCMS
 * @since 2.0
 */

get_header();
?>

<div class="pages-main-section">
<div class="section-wrapper">
<?php
  $main_tag_classes = get_theme_mod( 'main_tag_classes', '' );
  if ( $main_tag_classes ) { $main_tag_class = $main_tag_classes;} else {$main_tag_class = 'main-tag';} ?>
  <main id="main" class="<?php echo esc_attr( $main_tag_class ); ?>" itemprop="mainContentOfPage" itemscope itemtype="https://schema.org/WebPageElement">
	<?php if ( have_posts() ) :
	  while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
		  <header class="entry-header">
			<h2 class="entry-title">
			  <?php the_title(); ?>
			</h2>
		  <p class="entry-meta">
		  <?php if ( get_theme_mod( 'published_date_post', true ) ) : ?>
			<span class="posted-on">
			  <?php printf(
				'<span id="published-title">%s</span> <a href="%s">%s</a>',
				esc_html__( 'Published:', 'bootcms' ),
				esc_url( get_day_link(
				  get_the_date( 'Y' ),
				  get_the_date( 'm' ),
				  get_the_date( 'd' )
				) ),
				esc_html( get_the_date() )
			  ); ?>
			</span>
		  <?php endif; ?>
		  <?php if ( get_theme_mod( 'modified_date_post', false ) ) : ?>
			<span class="modified-on">
			  <?php printf(
				'<span id="modified-title">%s</span> %s',
				esc_html__( 'Modified:', 'bootcms' ),
				esc_html( get_the_modified_date() )
			  ); ?>
			</span>
		  <?php endif; ?>
		  <?php if ( get_theme_mod( 'author_of_post', true ) ) : ?>
			<span class="posted-by">
			  <span id="author-title"><?php esc_html_e( 'Author: ', 'bootcms' ); ?></span>
			  <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
				<?php the_author(); ?>
			  </a>
			</span>
		  <?php endif; ?>
		  <?php if ( get_theme_mod( 'category_of_post', true ) ) : ?>
			<span class="posted-in">
			  <?php printf(
				'<span id="category-title">%s</span> %s',
				esc_html__( 'Category:', 'bootcms' ),
				get_the_category_list( ', ' )
			  ); ?>
			</span>
		  <?php endif; ?>
		  <?php if ( get_theme_mod( 'post_tags', false ) ) : ?>
			<span class="posted-tags">
			  <?php printf(
				'<span id="tags-title">%s</span> %s',
				esc_html__( 'Tags:', 'bootcms' ),
				get_the_tag_list( '', ', ' )
			  ); ?>
			</span>
		  <?php endif; ?>
		  <?php if ( get_theme_mod( 'comments_count', false ) ) : ?>
			<span class="comments-count">
			  <?php printf(
				'<span id="comments-title">%s</span> <a href="%s">%s</a>',
				esc_html__( 'Comments:', 'bootcms' ),
				esc_url( get_comments_link() ),
				esc_html( get_comments_number() )
			  ); ?>
			</span>
		  <?php endif; ?>
		  <?php if ( get_theme_mod( 'discussion_status', false ) ) : ?>
			<span class="discussion-status">
			  <span id="discussion-title"><?php esc_html_e( 'Discussion: ', 'bootcms' ); ?></span>
			  <?php if ( comments_open() ) : ?>
				<?php esc_html_e( 'Open', 'bootcms' ); ?>
			  <?php else : ?>
				<?php esc_html_e( 'Closed', 'bootcms' ); ?>
			  <?php endif; ?>
			</span>
		  <?php endif; ?>
		  </p>
		  </header>
		  <div class="entry-content">
			<?php global $page, $numpages; 
			if ( $page > 1 ) { ?>
			<p class="post-continuation"><?php echo esc_html__( '... more', 'bootcms' ); ?></p>
			<?php }			
			the_content();			
			if ( $page < $numpages ) { ?>
			<p class="post-continuation"><?php echo esc_html__( 'more ...', 'bootcms' ); ?></p>
			<?php }	?>
		  </div>
		  <div id="call2action">
			<?php
			  $cta_html = get_theme_mod( 'post_cta_html', '' );
			  if ( ! empty( $cta_html ) ) :
				echo $cta_html; 
			  endif; 
			?>		
		  </div>		  
		  <?php
			wp_link_pages(
			  array(
				'before' => '<div class="page-links">' . esc_html__( 'PAGES:', 'bootcms' ),
				'after'  => '</div>',
			  )
			);
		  ?>
		</article>
		<?php the_post_navigation(
		  array(
			'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'PREVIOUS POST:', 'bootcms' ) . '</span> %title',
			'next_text' => '<span class="nav-subtitle">' . esc_html__( 'NEXT POST:', 'bootcms' ) . '</span> %title',
		  )
		);
		comments_template(); ?>
	  <?php endwhile; ?>
	<?php endif; ?>
</main>

<?php if ( is_active_sidebar( 'pages-right-sidebar' ) ) : ?>
<aside class="right-sidebar" aria-label="Page sidebar" itemprop="hasPart" itemscope itemtype="https://schema.org/WPSideBar">
  <?php dynamic_sidebar( 'pages-right-sidebar' ); ?>
</aside>
<?php endif; ?>
</div>
</div>
<?php
get_footer();