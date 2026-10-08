<?php
/** 
 * WordPress classic theme
 * archive.php
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
  <h2 id="archive-title"><?php the_archive_title(); ?></h2>
  <?php if ( have_posts() ) :
	while ( have_posts() ) : the_post(); ?>
	  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
		  <?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '"  title="' . esc_attr__( 'Click to visit the post', 'bootcms' ) . '" >', '</a></h3>' ); ?>
		</header>
		<div>				
	<p class="entry-meta">
		  <?php if ( ! is_date() && get_theme_mod( 'published_date_post', true ) ) : ?>
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
		  <?php endif; 
		  if ( get_theme_mod( 'modified_date_post', false ) ) : ?>
			<span class="modified-on">
			  <?php printf(
				'<span id="modified-title">%s</span> %s',
				esc_html__( 'Modified:', 'bootcms' ),
				esc_html( get_the_modified_date() )
			  ); ?>
			</span>
		  <?php endif; 
		  if ( ! is_author() && get_theme_mod( 'author_of_post', true ) ) : ?>
			<span class="posted-by">
			  <span id="author-title"><?php esc_html_e( 'Author: ', 'bootcms' ); ?></span>
			  <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
				<?php the_author(); ?>
			  </a>
			</span>
		  <?php endif;
		  $category_archive = false;
		  if ( is_category() ) { $category_archive = get_queried_object_id(); }
		  if ( get_theme_mod( 'category_of_post', true ) ) :
			$categories = get_the_category();
			if ( $categories ) :
			  $category_links = array();
			  foreach ( $categories as $category ) :
				// On a category archive, skip the current archive category.
				if ( $category_archive && $category->term_id == $category_archive ) { continue; }
				$category_links[] = '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>';
			  endforeach;
			  if ( ! empty( $category_links ) ) : ?>
				<span class="posted-in"><span id="category-title">
				<?php if ( is_category() ) { esc_html_e( 'Other Categories:', 'bootcms' ); }
				  else { esc_html_e( 'Categories:', 'bootcms' ); }
				?></span>
				<?php echo implode( ', ', $category_links ); ?>
				</span>
			  <?php
			  endif;
			endif;
		  endif;
		  $tag_archive = false;
		  if ( is_tag() ) { $tag_archive = get_queried_object_id(); }
		  if ( get_theme_mod( 'post_tags', false ) ) :
			$tags = get_the_tags();
			if ( $tags ) :
			  $tag_links = array();
			  foreach ( $tags as $tag ) :
				// On a tag archive, skip the current archive tag.
				if ( $tag_archive && $tag->term_id == $tag_archive ) { continue; }
				$tag_links[] = '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '">' . esc_html( $tag->name ) . '</a>';
			  endforeach;
			  if ( ! empty( $tag_links ) ) : ?>
				<span class="posted-tags"><span id="tags-title">
				<?php if ( is_tag() ) { esc_html_e( 'Other Tags:', 'bootcms' ); }
				else { esc_html_e( 'Tags:', 'bootcms' ); }
				?></span>
				<?php echo implode( ', ', $tag_links ); ?>
				</span>
			  <?php
			  endif;
			endif;
		  endif; 
		  if ( get_theme_mod( 'comments_count', false ) ) : ?>
			<span class="comments-count">
			  <?php printf(
				'<span id="comments-title">%s</span> <a href="%s">%s</a>',
				esc_html__( 'Comments:', 'bootcms' ),
				esc_url( get_comments_link() ),
				esc_html( get_comments_number() )
			  ); ?>
			</span>
		  <?php endif; 
		  if ( get_theme_mod( 'discussion_status', false ) ) : ?>
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
		</div>				
		<div class="entry-content">
		  <?php the_excerpt(); ?>
		</div>
	  </article>
	<?php endwhile; ?>
	<div id="call2action">
	<?php
	  $cta_html = get_theme_mod( 'post_cta_html', '' );
	  if ( ! empty( $cta_html ) ) : ?>
	  <hr id="cta-hr">	  
	<?php	echo $cta_html; 
	  endif; ?>	
	</div>	
	<!-- the pagination -->
	  <?php the_posts_navigation(); ?>
	<?php else : ?>
	<p><?php esc_html_e( 'No posts found.', 'bootcms' ); ?></p>
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