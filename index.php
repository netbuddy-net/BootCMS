<?php
/** 
 * WordPress classic theme
 * index.php
 * @link https://github/...
 * @package BootCMS
 * @since 2.0
 */
 
get_header(); 
?>

<?php if ( is_active_sidebar( 'user1-sidebar' ) ) : ?>
<aside id="front-presentation" class="front-presentation" aria-label="Home page presentation" itemprop="hasPart" itemscope itemtype="https://schema.org/WPAdBlock">
  <?php dynamic_sidebar( 'user1-sidebar' ); ?>
</aside>
<?php endif; ?>

<div class="frontpage-main-section">
<main id="main" itemprop="mainContentOfPage" itemscope itemtype="https://schema.org/WebPageElement">
  <?php if ( have_posts() ) :
	while ( have_posts() ) : the_post();
	  the_content();
	endwhile;
    else : ?>
	  <p><?php esc_html_e( 'Sorry, no posts matched your criteria.', 'BootCMS' ); ?></p>
  <?php endif; ?>
</main>

<?php if ( is_active_sidebar( 'right-sidebar' ) ) : ?>
<aside class="right-sidebar" aria-label="Page sidebar" itemprop="hasPart" itemscope itemtype="https://schema.org/WPSideBar">
  <?php dynamic_sidebar( 'right-sidebar' ); ?>
</aside>
<?php endif; ?>
</div>

<?php get_footer(); ?>