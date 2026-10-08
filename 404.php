<?php
/**
 * WordPress classic theme
 * 404.php 
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
<?php
$_404_page_title = get_theme_mod( '404_page_title', '' );
if ( $_404_page_title ) : ?>
    <h2><?php echo esc_html( $_404_page_title ); ?></h2>
<?php else : ?>
	<h2 class="A404-title"><?php esc_html_e( 'Page Not Found (404 Error)', 'BootCMS' ); ?></h2>	
<?php endif;
$html_404_page = get_theme_mod( 'html_404_page', '' );
if ( ! empty( $html_404_page ) ) : ?>
	<div class="A404-content"><?php echo $html_404_page; ?></div>
<?php else : ?>
<div class="A404-content">
<p class="A404-paragraph"><strong><?php esc_html_e( 'This is somewhat embarrassing, isn\'t it?', 'BootCMS' ); ?></strong></p>
<p class="A404-paragraph"><strong><?php esc_html_e( 'It seems we can\'t find what you\'re looking for.', 'BootCMS' ); ?></strong></p>
</div>
<?php endif; 
$_404_page_image = get_theme_mod( '404_page_image', '' );
  if ($_404_page_image) : 	
$_404_page_image_alt = get_post_meta( $_404_page_image, '_wp_attachment_image_alt', true ); 
?>
<img class="bootcms-404-image" src="<?php echo esc_url( wp_get_attachment_image_url( $_404_page_image, 'full' ) ); ?>" alt="<?php echo esc_attr( $_404_page_image_alt ); ?>" >	
<?php else : ?>	
<svg class="bootcms-404-image" version="1.1" width="50%" viewBox="0 0 156 144" xmlns="http://www.w3.org/2000/svg"><title>Warning sign</title><g transform="matrix(.991 0 0 .991 187 2.44)"><path d="m-109 7.23c-0.137 0.0017-0.273 0.0174-0.406 0.0469-3.19 0.0295-6.18 1.69-7.79 4.48l-62.5 108h2e-3c-3.42 5.92 1.02 13.6 7.86 13.6h125c6.84-3.2e-4 11.3-7.69 7.86-13.6l-62.5-108c-1.47-2.54-4.08-4.16-6.98-4.45-0.145-0.0428-0.294-0.069-0.445-0.0781h-4e-3c-0.0312-0.00138-0.0625-0.00203-0.0937-0.00195z" style="color:#000000;solid-color:#000000"/><path d="m-109 9.23c-2.64-0.125-5.14 1.24-6.46 3.53l-62.5 108c-2.67 4.63 0.777 10.6 6.12 10.6h125c5.35-2.5e-4 8.8-5.98 6.12-10.6l-62.5-108c-1.2-2.08-3.39-3.42-5.79-3.53h-2e-3z" style="color:#000000;fill:#fff;solid-color:#000000"/><path d="m-109 11.2c-1.9-0.0896-3.68 0.887-4.63 2.53l-62.5 108c-1.95 3.38 0.488 7.61 4.39 7.61h125c3.91-1.8e-4 6.35-4.23 4.39-7.61l-62.5-108c-0.863-1.5-2.43-2.45-4.15-2.53z" style="color:#000000;solid-color:#000000"/><path d="m-47 125h-62.5-62.5l62.5-108 31.3 54.1z" style="fill:#fc0"/><g transform="translate(-188)"><circle cx="78.6" cy="111" r="8.82"/><path d="m78.6 43c-4.87-5.59e-4 -8.82 3.95-8.82 8.82l3.16 37.5c8.93e-4 3.13 2.54 5.66 5.66 5.66 3.13 1.86e-4 5.66-2.53 5.66-5.66 3.15-37.5 0 0 3.15-37.5-5.2e-4 -4.87-3.95-8.82-8.82-8.82z"/></g></g></svg>
<?php endif; ?>
</main>
</div>
</div>

<?php get_footer(); ?>