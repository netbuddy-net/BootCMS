<?php
/**
 * WordPress classic theme
 * footer.php 
 * @link https://github.com/netbuddy-net/BootCMS
 * @package bootcms
 * @since bootcms 2.1
 */
?>
<?php $footer_tag_classes = get_theme_mod( 'bootcms_footer_tag_classes', '' ); ?>
<footer <?php if ($footer_tag_classes) : ?> class="<?php echo esc_attr( $footer_tag_classes ); ?>"<?php endif; ?> itemprop="hasPart" itemscope itemtype="https://schema.org/WPFooter">
<?php if ( is_active_sidebar( 'footer-custom' ) ) :
	dynamic_sidebar( 'footer-custom' );
  else : ?>
  <div class="bootcms-footer"><!-- footer 1Z -->
 
  <?php $bootcms_logo_exists = get_theme_mod( 'custom_logo', '' );
		$footer_logo_image   = get_theme_mod( 'bootcms_footer_logo_image', false );
	if ( $bootcms_logo_exists && $footer_logo_image ) : ?>
    <div class="footer-left">
	  <?php echo wp_get_attachment_image(
		$bootcms_logo_exists, 'full', false, array(
		  'id'    => 'foot_logo_img',
		  'title' => get_the_title( $bootcms_logo_exists ),
		) ); ?>
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
	  <?php if ( get_bloginfo( 'bootcms_copyright-name' ) ) : ?>
	  <span itemprop="copyrightHolder" itemscope itemtype="https://schema.org/Organization">
		<span itemprop="name"> <?php echo esc_html( get_theme_mod( 'bootcms_copyright_name', '' ) ); ?> </span>
	  </span>
	  <?php endif; ?>
	  <?php if ( get_bloginfo( 'bootcms_copyright-notice' ) ) : ?>
	  <span itemprop="copyrightNotice"> <?php echo esc_html( get_theme_mod( 'bootcms_copyright_notice', '' ) ); ?> </span>
	  <?php endif; ?>
	</div>	
  </div><!-- / footer 1Z -->
<?php endif; ?>
</footer>

</div><!-- / top container - opens in header -->
<?php wp_footer(); ?>
</body><!-- / opens in header -->
</html>
