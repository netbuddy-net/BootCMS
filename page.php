<?php
/**
 * WordPress classic theme
 * page.php 
 * @link https://github/...
 * @package bootcms
 * @since bootcms 2.0
 */
 
get_header(); 
?>

<div class="pages-main-section">
<div class="section-wrapper">
<?php $main_tag_classes = get_theme_mod( 'main_tag_classes', '' );
  if ( $main_tag_classes ) { $main_tag_class = $main_tag_classes;} else {$main_tag_class = 'main-tag';} ?>
<main id="main" class="<?php echo esc_attr( $main_tag_class ); ?>" itemprop="mainContentOfPage" itemscope itemtype="https://schema.org/WebPageElement">
  <?php if ( have_posts() ) :
	while ( have_posts() ) : the_post();
	  the_content();
	endwhile;
    else : ?>
	  <p><?php esc_html_e( 'Sorry, no posts matched your criteria.', 'BootCMS' ); ?></p>
  <?php endif; ?>
</main>

<?php if ( is_active_sidebar( 'pages-right-sidebar' ) ) : ?>
<aside class="pages-right-sidebar" aria-label="Page sidebar" itemprop="hasPart" itemscope itemtype="https://schema.org/WPSideBar">
  <?php dynamic_sidebar( 'pages-right-sidebar' ); ?>
</aside>
<?php endif; ?>
</div>
</div>

<?php get_footer(); ?>