<?php
/**
 * WordPress classic theme
 * header.php 
 * @link https://github/...
 * @package bootcms
 * @since bootcms 2.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php $description = get_post_meta( get_the_ID(), 'description', true );
  if ( $description ) : ?>
	<meta name="description" content="<?php echo esc_attr( $description ); ?>">
<?php else : ?>	
	<?php if ( get_bloginfo( 'description' ) ) : ?>
	<meta name="description" content="<?php echo get_the_title() . ', ' . esc_html( get_bloginfo( 'description' ) ); ?>">
	<?php endif; ?>	
<?php endif; ?>  
<?php  wp_head(); ?>
</head>

<?php $body_tag_classes = get_theme_mod( 'body_tag_classes', '' ); ?>
<body <?php body_class( $body_tag_classes ); ?> itemscope itemtype="https://schema.org/WebPage"><!-- closes in footer -->
<?php wp_body_open(); ?>
<?php $name = get_post_meta( get_the_ID(), 'name', true );
  if ( $name ) : ?>
    <meta itemprop="name" content="<?php echo esc_attr( $name ); ?>">
<?php endif; ?>
<?php $description = get_post_meta( get_the_ID(), 'description', true );
  if ( $description ) : ?>
  <meta itemprop="description" content="<?php echo esc_attr( $description ); ?>">
<?php endif; ?> 
<?php $keywords = get_post_meta( get_the_ID(), 'keywords', true );
  if ( $keywords ) : ?> 
  <meta itemprop="keywords" content="<?php echo esc_attr( $keywords ); ?>">
<?php endif; ?>
<?php $inLanguage = get_post_meta( get_the_ID(), 'inLanguage', true );
  if ( $inLanguage ) : ?>
  <meta itemprop="inLanguage" content="<?php echo esc_attr( $inLanguage ); ?>">
<?php endif; ?>
<?php $author = get_post_meta( get_the_ID(), 'author', true );
  if ( $author ) : ?> 
  <meta itemprop="author" content="<?php echo esc_attr( $author ); ?>">
<?php endif; ?> 
<?php $datePublished = get_post_meta( get_the_ID(), 'datePublished', true );
  if ( $datePublished ) : ?>
    <meta itemprop="datePublished" content="<?php echo esc_attr( $datePublished ); ?>">
<?php endif; ?> 
<?php $dateModified = get_post_meta( get_the_ID(), 'dateModified', true );
  if ( $dateModified ) : ?>
    <meta itemprop="dateModified" content="<?php echo esc_attr( $dateModified ); ?>">
<?php endif; ?>
  <link itemprop="isPartOf" href="<?php echo get_site_url(); ?>">
<?php $bootcms_css_framework = get_theme_mod( 'bootcms_css_framework', 'bootcms' );
$bootcms_top_container_type = get_theme_mod( 'bootcms_top_container_type', 'bootcms-container-fluid' ); 
$container_tag_classes = get_theme_mod( 'top_container_classes', '' );
if ( $bootcms_css_framework === 'bootcms' ){ $top_container_class = $bootcms_top_container_type; } else {
if ( $container_tag_classes ) { $top_container_class = $container_tag_classes;} else {$top_container_class = $bootcms_top_container_type;
}}?>
<div id ="top-container" class="<?php echo esc_attr( $top_container_class ); ?>" ><!-- top container - closes in footer -->
<?php $header_tag_classes = get_theme_mod( 'header_tag_classes', '' ); ?>
<header <?php if ($header_tag_classes) : ?> class="<?php echo esc_attr( $header_tag_classes ); ?>"<?php endif; ?> itemprop="hasPart" itemscope itemtype="https://schema.org/WPHeader" >
  <?php if ( is_active_sidebar( 'header-custom' ) ) : 
	dynamic_sidebar( 'header-custom' ); ?>
  <?php else :
	$header_image_id = get_theme_mod( 'header_image', '' );
	$header_image_background = get_theme_mod( 'header_image_background', false );
	$hd_image_ratio = bootcms_header_image_ratio();
	$bootcms_logo_exists = get_theme_mod( 'bootcms_logo', false );
	$bootcms_logo_image = get_theme_mod( 'bootcms_logo_image', false );
  if ($bootcms_logo_exists && $bootcms_logo_image) : 
 	if (is_active_sidebar( 'header-sidebar' )){$header_class = 'image-left-sidebar';} else {$header_class = 'image-left-no-sidebar';}
  	$logoalt = get_post_meta( $bootcms_logo_exists, '_wp_attachment_image_alt', true ); ?>
  <div class="bootcms-header <?php echo esc_attr( $header_class ); ?>"><!-- header 1A -->
	<div class="header-image">
	  <img id="logo_img" src="<?php echo esc_url( wp_get_attachment_image_url( $bootcms_logo_exists, 'full' ) ); ?>" alt="<?php echo esc_attr( $logoalt ); ?>" title="<?php echo esc_attr( $logoalt ); ?>">
	</div>
  <?php else :
	$header_class = bootcms_header_class($header_image_id, $header_image_background, $hd_image_ratio); ?>
	<div class="bootcms-header <?php echo esc_attr( $header_class ); ?>"><!-- header 1A -->	
	<?php $alt = get_post_meta( $header_image_id, '_wp_attachment_image_alt', true );
	if ( $header_image_id && ! $header_image_background ) : ?>
	<div class="header-image">
	  <!-- <a href="<?php /* echo esc_url( home_url( '/' ) ); */ ?>"> -->
	  <img id="header_img" src="<?php echo esc_url( wp_get_attachment_image_url( $header_image_id, 'full' ) ); ?>" alt="<?php echo esc_attr( $alt ); ?>" title="<?php echo esc_attr( $alt ); ?>">
	</div>
    <?php endif; ?> 
  <?php endif; ?>
	<div class="header-content">
	<h1>
	<?php   echo esc_html( get_bloginfo( 'name' ) . ' '); ?>
	<?php if ( get_bloginfo( 'description' ) ) : ?>
	  <br>
	  <small><?php echo esc_html( get_bloginfo( 'description' ) ); ?></small>
	<?php endif; ?>
	</h1>
	</div>
	<?php if ( is_active_sidebar( 'header-sidebar' ) ) : ?>
      <div class="header-sidebar">
		<?php dynamic_sidebar( 'header-sidebar' ); ?>
      </div>
	<?php endif; ?>
  </div><!-- / header 1A -->
  <?php endif; ?>
</header>

<?php if ( has_nav_menu( 'primary' ) ) : ?> 
<a href="#main" class="skip-link">Skip to content</a>
<?php $nav_tag_classes = get_theme_mod( 'nav_tag_classes', '' );
  if ($nav_tag_classes) {
	$nav_tag_class = $nav_tag_classes; } else { $nav_tag_class = 'bootcms-navbar';}  
  if ( is_active_sidebar( 'customised_nav_menu')) : ?>
	<nav class="<?php echo esc_attr( $nav_tag_class ); ?>" aria-label="main navigation" itemprop="hasPart" itemscope itemtype="https://www.schema.org/SiteNavigationElement">
	  <?php dynamic_sidebar( 'customised_nav_menu' ); ?>
	</nav>
  <?php else : ?>
  <?php if ( $bootcms_css_framework === 'bootstrap' || $bootcms_css_framework === 'bootswatch' ) : 
	$nav_tag_class = preg_replace( '/\bbootcms-navbar\b/', '', $nav_tag_class );
	$nav_tag_class = trim( $nav_tag_class );
	if ( ! preg_match( '/\bnavbar\b/', $nav_tag_class ) ) {
      $nav_tag_class .= ' navbar '; } ?>
	  <nav class="<?php echo esc_attr( $nav_tag_class ); ?>" aria-label="Main navigation" itemprop="hasPart" itemscope itemtype="https://www.schema.org/SiteNavigationElement">
		<div class="container-fluid">
		  <?php if ( has_site_icon() ) : ?>
			<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			  <img src="<?php echo esc_url( get_site_icon_url() ); ?>" alt="Site Icon" width="32" height="32" class="d-inline-block">
			</a>
		  <?php else : ?>
			<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
		  <?php endif; 
		  $bootstrap_version = get_theme_mod( 'bootcms_bootstrap_version', '5.3.8' );
		  $bs_prefix = version_compare( $bootstrap_version, '5.0.0', '>=' ) ? 'bs-' : ''; ?>		  
		  <button class="navbar-toggler" type="button" data-<?php echo $bs_prefix; ?>toggle="collapse" data-<?php echo $bs_prefix; ?>target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		  </button>   
		  <div class="collapse navbar-collapse" id="navbarNav">
			<?php
			$menu_args = array(
			  'theme_location' => 'primary',
			  'container'      => false,
			  'menu_class'     => 'navbar-nav me-auto mr-auto my-2 my-lg-0',
			  'fallback_cb'    => '__return_false',
			  'depth'          => 2 );
			if ( version_compare( $bootstrap_version, '5.0.0', '<' ) && $bootcms_css_framework !== 'bootswatch' ) {
			  $menu_args['walker'] = new WP_Bootstrap_Navwalker(); }
			wp_nav_menu( $menu_args );
			?>
		  </div>
		</div>
	  </nav>	
	<?php elseif ( $bootcms_css_framework === 'foundation' ) : 	 
	if ( $nav_tag_class === 'bootcms-navbar' ) { $nav_tag_class = ''; } ?>
	<nav class="<?php echo esc_attr( $nav_tag_class ); ?>"  aria-label="Main navigation" itemprop="hasPart" itemscope itemtype="https://www.schema.org/SiteNavigationElement">
	  <div class="title-bar" data-responsive-toggle="responsive-menu" data-hide-for="medium">
		<button class="menu-icon" type="button" aria-label="Toggle navigation" data-toggle="responsive-menu"></button>
		<div class="title-bar-title">Menu</div>
		<?php if ( has_site_icon() ) : ?>
		  <div style="margin-left:auto;">
			<img src="<?php echo esc_url( get_site_icon_url() ); ?>" alt="Site Icon" width="32" height="32">
		  </div>
		<?php else : ?>
		<div style="margin-left:auto;">
		  <?php echo esc_html( get_bloginfo( 'name' ) ); ?>
		</div>
		<?php endif; ?>		
	  </div>	  	  
	  <div class="top-bar" id="responsive-menu">
		<div class="top-bar-left">	
		<?php
		  wp_nav_menu( array(
			'theme_location' => 'primary',
			'container'      => false, // Removes WP's div wrapper
			'items_wrap'     => '<ul id="%1$s" class="%2$s" data-responsive-menu="accordion medium-dropdown">%3$s</ul>',
			'menu_class'     => 'vertical medium-horizontal menu',
			'fallback_cb'    => '__return_false',
			'depth'          => 2 // Keeps layout restricted to one level drop-downs
		  ) );
		?>
		</div>
	  </div>
	</nav>
	<?php elseif ( $bootcms_css_framework === 'bulma' ) : 
	if ( $nav_tag_class === 'bootcms-navbar' ) { $nav_tag_class = ''; } ?>
	<nav class="navbar <?php echo esc_attr( $nav_tag_class ); ?>" aria-label="Main navigation" itemprop="hasPart" itemscope itemtype="https://www.schema.org/SiteNavigationElement">
	  <div class="navbar-brand">
	  <?php if ( has_site_icon() ) : ?>
		<a class="navbar-item" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		  <img src="<?php echo esc_url( get_site_icon_url() ); ?>" alt="Site Icon" width="32" height="32">	
		</a>
		<?php else :  echo esc_html( get_bloginfo( 'name' ) ); 
		endif; ?>
		<a role="button" class="navbar-burger" aria-label="Toggle navigation" aria-expanded="false" data-target="bulmaNavbar">
		  <span aria-hidden="true"></span>
		  <span aria-hidden="true"></span>
		  <span aria-hidden="true"></span>
		  <span aria-hidden="true"></span>
		</a>
	  </div>
	  <div id="bulmaNavbar" class="navbar-menu">
		<div class="navbar-start"></div>
		<div class="navbar-end">
		  <?php
			wp_nav_menu( array(
			  'theme_location' => 'primary',
			  'container'      => false,
			  'items_wrap'     => '%3$s',
			  'fallback_cb'    => false,
			  'walker'         => new BootCMS_Bulma_Walker(),
			) );
		  ?>      
		</div>
	  </div>
	</nav>
	<?php else : 
	$nav_tag_class = $nav_tag_classes;
	if ( strpos( ' ' . $nav_tag_class . ' ', ' bootcms-navbar ' ) === false ) {
	  $nav_tag_class .= ' bootcms-navbar'; } ?>
	<nav class="<?php echo esc_attr( $nav_tag_class ) ?>" aria-label="Main navigation" itemprop="hasPart" itemscope itemtype="https://www.schema.org/SiteNavigationElement">
	  <div class="navbar-mobile-bar">
		<?php if ( has_site_icon() ) : ?>
		  <div class="navbar-mobile-icon">
			<img src="<?php echo esc_url( get_site_icon_url() ); ?>" alt="Site Icon" width="32" height="32">
		  </div>
		<?php else : ?>
		  <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
		<?php endif; ?>
		<?php if ( get_the_title() || get_bloginfo( 'name' ) ) : ?>
		  <div class="navbar-mobile-title">
			<span><?php echo esc_html( get_the_title() ?: get_bloginfo( 'name' ) ); ?></span>
		  </div>
		<?php endif; ?>
		<button class="navbar-toggle" type="button" aria-label="Toggle navigation" aria-expanded="false">
		  <span></span>
		  <span></span>
		  <span></span>
		</button>
	  </div>    
	  <?php
	  wp_nav_menu( array(
        'theme_location' => 'primary',
		'fallback_cb'    => false,
	  ) );
	  ?>
	</nav> 
  <?php endif; ?>	
<?php endif;  /* widget test */ ?>  
<?php endif; /* primary menu test */ ?> 