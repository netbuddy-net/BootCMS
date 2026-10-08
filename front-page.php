<?php
/**
 * WordPress classic theme
 * front-page.php 
 * @link https://github/...
 * @package bootcms
 * @since bootcms 2.0
 */
// Comply with WP Reading Setting 
if ( 'posts' === get_option( 'show_on_front' ) ) {
    include get_theme_file_path( 'home.php' );
    exit;
}

get_header(); 
?>

<?php if ( is_active_sidebar( 'hero-unit-sidebar' ) ) : ?>
<aside id="hero-unit" class="hero-unit" aria-label="Homepage presentation" itemprop="hasPart" itemscope itemtype="https://schema.org/WPAdBlock">
  <?php dynamic_sidebar( 'hero-unit-sidebar' ); ?>
</aside>
<?php endif; ?>

<div class="frontpage-main-section">
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

<?php if ( is_active_sidebar( 'home-right-sidebar' ) ) : ?>
<aside class="home-right-sidebar" aria-label="Homepage sidebar" itemprop="hasPart" itemscope itemtype="https://schema.org/WPSideBar">
  <?php dynamic_sidebar( 'home-right-sidebar' ); ?>
</aside>
<?php endif; ?>
</div>
</div>

<?php get_footer(); ?>