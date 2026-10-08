<?php
/**
 * WordPress classic theme
 * footer.php 
 * @link https://github/...
 * @package bootcms
 * @since bootcms 2.0
 */
?>
<?php $footer_tag_classes = get_theme_mod( 'footer_tag_classes', '' ); ?>
<footer <?php if ($footer_tag_classes) : ?> class="<?php echo esc_attr( $footer_tag_classes ); ?>"<?php endif; ?> itemprop="hasPart" itemscope itemtype="https://schema.org/WPFooter">
<?php if ( is_active_sidebar( 'footer-custom' ) ) :
	dynamic_sidebar( 'footer-custom' );
  else : ?>
  <div class="bootcms-footer"><!-- footer 1Z -->
 
	<?php $bootcms_logo_exists = get_theme_mod( 'bootcms_logo', false );
	$footer_logo_image = get_theme_mod( 'footer_logo_image', false );
	$logoalt = get_post_meta( $bootcms_logo_exists, '_wp_attachment_image_alt', true );
	if ( $bootcms_logo_exists && $footer_logo_image ) : ?>
	<div class="footer-left">
	  <img id="foot_logo_img" src="<?php echo esc_url( wp_get_attachment_image_url( $bootcms_logo_exists, 'full' ) ); ?>" alt="<?php echo esc_attr( $logoalt ); ?>" title="<?php echo esc_attr( $logoalt ); ?>">	  
	</div>
	<?php else : ?>
	  <?php if ( is_active_sidebar( 'footer-left' ) ) : ?>
		<div class="footer-left">
		<?php dynamic_sidebar( 'footer-left' ); ?>
		</div>
	  <?php endif; ?>
	<?php endif; ?>			
	<?php if ( is_active_sidebar( 'footer-main' ) ) : ?>
	<div class="footer-main">
	  <?php dynamic_sidebar( 'footer-main' ); ?>
	</div>
	<?php endif; ?>
	<?php if ( is_active_sidebar( 'footer-sidebar' ) ) : ?>
	<div class="footer-sidebar">
	  <?php dynamic_sidebar( 'footer-sidebar' ); ?>
	</div>
	<?php endif; ?>
	<div class="footer-baseline">
      <span class="bootcms-copyright">&copy; <span itemprop="copyrightYear" class="nbyear"> <?php echo esc_html( wp_date( 'Y' ) ); ?> </span></span>
	  <?php if ( get_bloginfo( 'copyright-name' ) ) : ?>
	  <span itemprop="copyrightHolder" itemscope itemtype="https://schema.org/Organization">
		<span itemprop="name"> <?php echo esc_html( get_theme_mod( 'copyright_name', '' ) ); ?> </span>
	  </span>
	  <?php endif; ?>
	  <?php if ( get_bloginfo( 'copyright-notice' ) ) : ?>
	  <span itemprop="copyrightNotice"> <?php echo esc_html( get_theme_mod( 'copyright_notice', '' ) ); ?> </span>
	  <?php endif; ?>
	</div>	
  </div><!-- / footer 1Z -->
<?php endif; ?>
</footer>

</div><!-- / top container - opens in header -->
<?php wp_footer(); ?>
</body><!-- / opens in header -->
</html>
