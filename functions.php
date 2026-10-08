<?php
/** 
 * WordPress classic theme
 * functions.php
 * @link https://github/...
 * @package BootCMS
 * @since 2.0
 */
 
/* Disable the block widget editor (fixes errors) */
add_filter( 'use_widgets_block_editor', '__return_false' ); 
/*
 * Theme Setup
 */
function bootcms_setup() {
  // Enable theme title 
  add_theme_support( 'title-tag' );
  // Add feed links
  add_theme_support( 'automatic-feed-links' );
  // Enable main navigation menu
  register_nav_menus( array(
	'primary' => __( 'Primary Navigation', 'bootcms' ),
  ) );
  // Add language support
  load_theme_textdomain(
	'bootcms',
	get_template_directory() . '/languages'
  );
}
add_action( 'after_setup_theme', 'bootcms_setup' );
/* Document title */
function bootcms_document_title_parts( $title ) {
  unset( $title['tagline'] );
    return array(
        'site'  => get_bloginfo( 'name' ),
        'title' => get_the_title(),
    );  
  return $title;
}
add_filter( 'document_title_parts', 'bootcms_document_title_parts' );
/* Document title separator */
function bootcms_document_title_separator( $separator ) {
  return '|';
}
add_filter( 'document_title_separator', 'bootcms_document_title_separator' );
/*
 * Enqueue JS Scripts
 */ 
function bootcms_enqueue_js_scripts() {
  $bootcms_js_dependencies = array();	
  if ( get_theme_mod( 'bootcms_enable_jquery', false ) ) {
	wp_enqueue_script( 'jquery',);
	$bootcms_js_dependencies[] = 'jquery';
  }
  if ( get_theme_mod( 'bootcms_enable_react', false ) ) {
	wp_enqueue_script( 'wp-element' );
    wp_enqueue_script(
	  'frontend-react-app',
	  get_template_directory_uri() . '/js/react-app.js',
	  array( 'wp-element' ), null, true
    );
    $bootcms_js_dependencies[] = 'frontend-react-app';	
  }  
  if ( get_theme_mod( 'bootcms_enable_vue', false ) ) {
    wp_enqueue_script(
	  'bootcms-vue',
	  get_template_directory_uri() . '/frameworks/vue/3.5.43/vue.global.prod.js',
	  array(), null, true
    );
    wp_enqueue_script(
	  'frontend-vue-app',
	  get_template_directory_uri() . '/js/vue-app.js',
	  array( 'bootcms-vue' ), null, true
    );
	$bootcms_js_dependencies[] = 'frontend-vue-app';
  }
  wp_enqueue_script(
    'bootcms-template',
    get_template_directory_uri() . '/js/script.js',
    $bootcms_js_dependencies, null, true
  );
/** 
  * Enqueue Frameworks 
 **/
  $bootcms_css_framework = get_theme_mod( 'bootcms_css_framework', 'bootcms' );
// BootCMS
  if ( $bootcms_css_framework === 'bootcms' ) {
	wp_enqueue_style(
	  'bootcms-bootcms',
	  get_template_directory_uri() . '/frameworks/bootcms/2.0/bootcms.css',
	  array(),
	  '2.0'
  ); }
// Bootstrap 
  if ( $bootcms_css_framework === 'bootstrap' ) {
    $bootstrap_version = get_theme_mod( 'bootcms_bootstrap_version', '5.3.8' );
    wp_enqueue_style(
	  'bootcms-bootstrap',
	  get_template_directory_uri() . '/frameworks/bootstrap/' . $bootstrap_version . '/bootstrap.min.css',
	  array(), $bootstrap_version );	  
    // Bootstrap 5.3.8 RTL
    if ( $bootstrap_version === '5.3.8' ) {
	  wp_enqueue_style(
		'bootcms-bootstrap-rtl',
		get_template_directory_uri() . '/frameworks/bootstrap/5.3.8/bootstrap.rtl.min.css',
		array( 'bootcms-bootstrap' ),
		$bootstrap_version
	); }	    
    $bootstrap_js_dependencies = array();
    if ( version_compare( $bootstrap_version, '5.0.0', '<' ) ) {
	  wp_enqueue_script( 'jquery' );
	  $bootstrap_js_dependencies[] = 'jquery'; 
	  // Bootstrap 4 Navwalker
      require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';
	}
    wp_enqueue_script(
	  'bootcms-bootstrap',
	  get_template_directory_uri() . '/frameworks/bootstrap/' . $bootstrap_version . '/bootstrap.bundle.min.js',
	  $bootstrap_js_dependencies, $bootstrap_version, true
    );
  }
// Bootwatch 
  if ( $bootcms_css_framework === 'bootswatch' ) {
    $bootswatch_theme = get_theme_mod( 'bootcms_bootswatch_theme', 'slate' );
    wp_enqueue_style(
      'bootcms-bootswatch',
	  get_template_directory_uri() . '/frameworks/bootswatch/' . $bootswatch_theme . '.min.css',
	  array(), '5.3.8' );
    wp_enqueue_script(
	  'bootcms-bootstrap',
	  get_template_directory_uri() . '/frameworks/bootstrap/5.3.8/bootstrap.bundle.min.js',
	  array(), '5.3.8', true );
  }
// Foundation 
  if ( $bootcms_css_framework === 'foundation' ) {
    $foundation_version = get_theme_mod( 'bootcms_foundation_version', '6.9.0' );
    wp_enqueue_style(
	  'bootcms-foundation',  
	   get_template_directory_uri() . '/frameworks/foundation/' . $foundation_version . '/foundation.min.css',
	  array(), $foundation_version );
	wp_enqueue_script( 'jquery' );
    wp_enqueue_script(
	  'bootcms-foundation',
	  get_template_directory_uri() . '/frameworks/foundation/' . $foundation_version . '/foundation.min.js',
	  array( 'jquery' ), $foundation_version, true
    );
	wp_add_inline_script(
	  'bootcms-foundation',
	  'jQuery(function($) { $(document).foundation(); });'
    );
  } 
// Bulma 
  if ( $bootcms_css_framework === 'bulma' ) {
	wp_enqueue_style(
	  'bootcms-bulma',
	  get_template_directory_uri() . '/frameworks/bulma/1.0.4/bulma.min.css',
	  array(),
	  '1.0.4'
	);
  }
}
add_action( 'wp_enqueue_scripts', 'bootcms_enqueue_js_scripts' );
/*
 * Enqueue Styles
 */ 
function bootcms_enqueue_styles() {
  wp_enqueue_style('bootcms-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ));
  if ( is_rtl() ) {
    wp_enqueue_style( 'bootcms-rtl', get_template_directory_uri() . '/rtl.css', array( 'bootcms-style' ), wp_get_theme()->get( 'Version' ) );
  }
}
add_action( 'wp_enqueue_scripts', 'bootcms_enqueue_styles' );

/*  -----------------------
 * Enable Widgets
 */
function bootcms_widgets_init() {
  register_sidebar( array(
	'name'          => __( 'Custom Header Sidebar', 'bootcms' ),
	'id'            => 'header-custom',
	'description'   => __( 'Fully Custom Header.', 'bootcms' ),
	'before_widget' => '',
	'after_widget'  => '',
	'before_title'  => '<h2 class="title-custom-header">',
	'after_title'   => '</h2>'
  ) );
  register_sidebar( array(
	'name'          => __( 'Header Right Sidebar', 'bootcms' ),
	'id'            => 'header-sidebar',
	'description'   => __( 'Optional widget area in the header (right).', 'bootcms' ),
	'before_widget' => '',
	'after_widget'  => '',
	'before_title'  => '<h2 class="title-widget-header">',
	'after_title'   => '</h2>'
  ) );
  register_sidebar( array(
	'name'          => __( 'Customised Nav Menu', 'bootcms' ),
	'id'            => 'customised_nav_menu',
	'description'   => __( 'Add a custom or framework navbar menu here. The nav tag already wraps this widget. If needed, add classes to the nav tag in the Simple Styles section of the Customizer.', 'bootcms' ),
	'before_widget' => '',
	'after_widget'  => '',
	'before_title'  => '<h2 class="title-widget-navbar">',
	'after_title'   => '</h2>'
  ) );
  register_sidebar( array(
	'name'          => __( 'Homepage Hero Unit', 'bootcms' ),
	'id'            => 'hero-unit-sidebar',
	'description'   => __( 'Space on Homepage for promotional content or a key introduction to the site.', 'bootcms' ),
	'before_widget' => '',
	'after_widget'  => '',
	'before_title'  => '<h2 class="title-hero-unit">',
	'after_title'   => '</h2>'
  ) );
  register_sidebar( array(
	'name'          => __( 'Homepage Right Sidebar', 'bootcms' ),
	'id'            => 'home-right-sidebar',
	'description'   => __( 'Homepage\'s right sidebar for widgets.', 'bootcms' ),
	'before_widget' => '',
	'after_widget'  => '',
	'before_title'  => '<h2 class="title-right-sidebar">',
	'after_title'   => '</h2>'
  ) );
  register_sidebar( array(
	'name'          => __( 'Pages Right Sidebar', 'bootcms' ),
	'id'            => 'pages-right-sidebar',
	'description'   => __( 'Pages right sidebar for widgets.', 'bootcms' ),
	'before_widget' => '',
	'after_widget'  => '',
	'before_title'  => '<h2 class="title-right-sidebar">',
	'after_title'   => '</h2>'
  ) );
  register_sidebar( array(
	'name'          => __( 'Custom Footer Sidebar', 'bootcms' ),
	'id'            => 'footer-custom',
	'description'   => __( 'Fully Custom Footer.', 'bootcms' ),
	'before_widget' => '',
	'after_widget'  => '',
	'before_title'  => '<h2 class="title-custom-footer">',
	'after_title'   => '</h2>'
  ) );
  register_sidebar( array(
	'name'          => __( 'Footer Left', 'bootcms' ),
	'id'            => 'footer-left',
	'description'   => __( 'Optional widget area on the left side of the footer.', 'bootcms' ),
	'before_widget' => '',
	'after_widget'  => '',
	'before_title'  => '<h2 class="title-widget-footer-left">',
	'after_title'   => '</h2>'
  ) );
  register_sidebar( array(
	'name'          => __( 'Footer Main', 'bootcms' ),
	'id'            => 'footer-main',
	'description'   => __( 'Optional widget area in the middle of the footer.', 'bootcms' ),
	'before_widget' => '',
	'after_widget'  => '',
	'before_title'  => '<h2 class="title-widget-footer-main">',
	'after_title'   => '</h2>'
  ) );   
  register_sidebar( array(
	'name'          => __( 'Footer Sidebar', 'bootcms' ),
	'id'            => 'footer-sidebar',
	'description'   => __( 'Optional widget area on the right side of the footer.', 'bootcms' ),
	'before_widget' => '',
	'after_widget'  => '',
	'before_title'  => '<h2 class="title-widget-footer-right">',
	'after_title'   => '</h2>'
  ) );  
}
add_action( 'widgets_init', 'bootcms_widgets_init' );
/* Link to Back End Code ------------------------------- */
add_action( 'after_setup_theme', function() {
 if ( is_customize_preview() ) {
	require_once get_template_directory() . '/inc/back-end.php';
 }
} );
/* Link to large HTML editor and Help ------------------ */
	require_once get_template_directory() . '/inc/bootcms-editor.php';
	require_once get_template_directory() . '/bootcms-help/help.php';
// Apply the Excerpt Length from Customizer to WP
add_filter( 'excerpt_length', function( $length ) {
  $excerpt_length = get_theme_mod( 'post_excerpt_length', 55 );
  if ( $excerpt_length < 1 ) { $excerpt_length = 55; }
  return $excerpt_length;
} );
/* BootCMS JS Script for Navbar Toggle */
function mytheme_mobile_nav_script() {
?>
<script>
  const navbar = document.querySelector('.bootcms-navbar');
  const toggle = document.querySelector('.navbar-toggle');
  const menu = document.querySelector('.menu-main-navigation-container');
  if (navbar && toggle && menu) {
	toggle.addEventListener('click', function (event) {
	  event.stopPropagation();
	  const isOpen = menu.classList.toggle('is-open');
	  toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
	});
	document.addEventListener('click', function (event) {
	  if (!navbar.contains(event.target)) {
		menu.classList.remove('is-open');
		toggle.setAttribute('aria-expanded', 'false');
	  }
	});
	document.addEventListener('keydown', function (event) {
	  if (event.key === 'Escape') {
		menu.classList.remove('is-open');
		toggle.setAttribute('aria-expanded', 'false');
	  }
	});	
  }
</script>
<?php
}
add_action( 'wp_footer', 'mytheme_mobile_nav_script' );

/* Display Custom fields section on theme activation */
function bootcms_enable_custom_fields() {
  update_user_meta( get_current_user_id(), 'enable_custom_fields', 1 );
}
add_action( 'after_switch_theme', 'bootcms_enable_custom_fields' );
/* Add custom fields for SEO and search engines */
function bootcms_add_page_fields( $post_id, $post, $update ) {
  if ( ! metadata_exists( 'post', $post_id, 'dateModified' ) ) {
    add_post_meta( $post_id, 'dateModified', $post->post_modified ); } 
  if ( ! metadata_exists( 'post', $post_id, 'datePublished' ) ) {
    add_post_meta( $post_id, 'datePublished', $post->post_date_gmt ); }
  if ( ! metadata_exists( 'post', $post_id, 'author' ) ) {
    add_post_meta( $post_id, 'author', '' ); }
  if ( ! metadata_exists( 'post', $post_id, 'inLanguage' ) ) {
    add_post_meta( $post_id, 'inLanguage', '' ); }
  if ( ! metadata_exists( 'post', $post_id, 'keywords' ) ) {
    add_post_meta( $post_id, 'keywords', '' ); }
  if ( ! metadata_exists( 'post', $post_id, 'description' ) ) {
    add_post_meta( $post_id, 'description', '' ); }
  if ( $post->post_status !== 'auto-draft' && ! metadata_exists( 'post', $post_id, 'name' )) {
	add_post_meta( $post_id, 'name', $post->post_title ); }	
}
add_action( 'save_post_page', 'bootcms_add_page_fields', 10, 3 );

/**
 * Disable WordPress Block Editor and block styles.
 */
if ( get_theme_mod( 'bootcms_disable_block_editor', false ) ) {
// Remove global styles and block layouts from the front end
function bootcms_disable_global_styles() {
    remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
    remove_action('wp_footer', 'wp_enqueue_global_styles', 1);
}
add_action('init', 'bootcms_disable_global_styles');
// Dequeue the core Gutenberg block library styles
function bootcms_dequeue_block_styles() {
    wp_dequeue_style('wp-block-library');        // WordPress core block styles
    wp_dequeue_style('wp-block-library-theme');  // WordPress core block theme styles
    wp_dequeue_style('global-styles');            // Inline global styles fallback
	wp_dequeue_style( 'wp-block-paragraph' );
}
add_action('wp_enqueue_scripts', 'bootcms_dequeue_block_styles', 100);
}
/*
// Prevent WordPress from rendering separate inline styles for core blocks
add_filter( 'should_load_separate_core_block_assets', '__return_false', 99 );
*/
// Remove function for emoji
if ( get_theme_mod( 'bootcms_disable_emojis', false ) ) {
	add_action( 'init', function() {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		remove_filter( 'wp_check_invalid_utf8', 'wp_staticize_emoji' );
	} );
}

/* =========================================================
   Frameworks
   ========================================================= */

$franework_menu_option = get_theme_mod( 'bootcms_css_framework', 'bootcms' );
/*
 * Bootstrap Menu Filters 
 */
if ($franework_menu_option === 'bootstrap' || $franework_menu_option === 'bootswatch') {
// 1. Add '.nav-item' to the <li> tags, and '.dropdown' if it has children
add_filter( 'nav_menu_css_class', 'bootstrap5_menu_li_classes', 10, 4 );
function bootstrap5_menu_li_classes( $classes, $item, $args, $depth ) {
    if ( isset( $args->theme_location ) && $args->theme_location === 'primary' ) {
        $classes[] = 'nav-item';
        if ( in_array( 'menu-item-has-children', $classes ) ) {
            $classes[] = 'dropdown';
        }
    }
    return $classes;
}
// 2. Add '.nav-link' or '.dropdown-toggle' attributes to the <a> tags
add_filter( 'nav_menu_link_attributes', 'bootstrap5_menu_anchor_attributes', 10, 4 );
function bootstrap5_menu_anchor_attributes( $atts, $item, $args, $depth ) {
    if ( isset( $args->theme_location ) && $args->theme_location === 'primary' ) {
        $atts['class'] = 'nav-link';        
        // If it's a dropdown toggle item
        if ( in_array( 'menu-item-has-children', $item->classes ) ) {
            $atts['class'] .= ' dropdown-toggle';
            $atts['data-bs-toggle'] = 'dropdown';
            $atts['aria-expanded'] = 'false';
        }       
        // Add active class to current page link
        if ( in_array( 'current-menu-item', $item->classes ) ) {
            $atts['class'] .= ' active';
        }
    }
    return $atts;
}
// 3. Change the default '.sub-menu' class to Bootstrap's '.dropdown-menu'
add_filter( 'nav_menu_submenu_css_class', 'bootstrap5_menu_sub_menu_class', 10, 3 );
function bootstrap5_menu_sub_menu_class( $classes, $args, $depth ) {
    if ( isset( $args->theme_location ) && $args->theme_location === 'primary' ) {
        $classes = array( 'dropdown-menu' );
		$use_navtag_classes = get_theme_mod( 'nav_tag_classes', '' );
        if ( preg_match( '/(?:^|\s)(bg-[\w-]+)/', $use_navtag_classes, $match ) ) {
            $classes[] = $match[1];
        }
    }
    return $classes;
}
}
/*
 * Foundation Menu Filters 
 */
if ($franework_menu_option === 'foundation') {
// 1. Add the site name at start
add_filter( 'wp_nav_menu_items', 'bootcms_foundation_menu_item', 10, 2 );
function bootcms_foundation_menu_item( $items, $args ) {
  if ( isset( $args->theme_location ) && $args->theme_location === 'primary' ) {
	$items = '<li class="menu-text">' . esc_html( get_bloginfo( 'name' ) ) . '</li>' . $items;
  }
  return $items;
}
// 2. Add 'is-dropdown-submenu-parent' to the <li> tags if they have children
add_filter( 'nav_menu_css_class', 'foundation6_menu_li_classes', 10, 4 );
function foundation6_menu_li_classes( $classes, $item, $args, $depth ) {
    if ( isset( $args->theme_location ) && $args->theme_location === 'primary' ) {
        // If the item has a submenu, Foundation requires a specific parent indicator
        if ( in_array( 'menu-item-has-children', $classes ) ) {
            $classes[] = 'is-accordion-submenu-parent';
        }
		/* Current page
        if ( in_array( 'current-menu-item', $classes ) ) {
            $classes[] = 'is-active';
        }*/
    }
    return $classes;
}
// 3. Format the <a> tags (add active state if needed)
add_filter( 'nav_menu_link_attributes', 'foundation6_menu_anchor_attributes', 10, 4 );
function foundation6_menu_anchor_attributes( $atts, $item, $args, $depth ) {
    if ( isset( $args->theme_location ) && $args->theme_location === 'primary' ) {
        // Add Foundation active styling for the current page link
        if ( in_array( 'current-menu-item', $item->classes ) ) {
            $atts['class'] = isset($atts['class']) ? $atts['class'] . ' is-active' : 'is-active';
        }
    }
    return $atts;
}
// 4. Change the sub-menu <ul> class to Foundation's format
add_filter( 'nav_menu_submenu_css_class', 'foundation6_menu_sub_menu_class', 10, 3 );
function foundation6_menu_sub_menu_class( $classes, $args, $depth ) {
    if ( isset( $args->theme_location ) && $args->theme_location === 'primary' ) {
        // Foundation expects nested sub-menus to have 'menu vertical submenu'
        $classes = array( 'menu', 'vertical', 'submenu', 'is-accordion-submenu' );
    }
    return $classes;
} 
}
/*
 * Bulma Menu Nav Walker 
 */
if ($franework_menu_option === 'bulma') { 
  class BootCMS_Bulma_Walker extends Walker_Nav_Menu {
	/* Start the top-level menu */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
	  $indent = str_repeat( "\t", $depth );
	  if ( $depth === 0 ) {
		$output .= "\n$indent<div class=\"navbar-dropdown\">\n";
	  }
	}
	/* End the submenu */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
	  $indent = str_repeat( "\t", $depth );
	  if ( $depth === 0 ) {
		$output .= "$indent</div>\n";
	  }
	}
	/* Start each menu item */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
	  $classes = empty( $item->classes ) ? array() : (array) $item->classes;
	  $has_children = in_array( 'menu-item-has-children', $classes, true );
	  $indent = str_repeat( "\t", $depth );
	  /* Top-level item with children */
	  if ( $depth === 0 && $has_children ) {
		$output .= $indent . '<div class="navbar-item has-dropdown is-hoverable">' . "\n";
		$output .= $indent . ' <a class="navbar-link" href="' . esc_url( $item->url ) . '">'
				. esc_html( $item->title )
				. '</a>' . "\n";
	  }
	/* Top-level item without children */
	  elseif ( $depth === 0 ) {
		$output .= $indent . '<a class="navbar-item" href="' . esc_url( $item->url ) . '">'
				. esc_html( $item->title )
				. '</a>' . "\n";
	  }
	/* Dropdown item */
	  else {
		$output .= $indent . '<a class="navbar-item" href="' . esc_url( $item->url ) . '">'
				. esc_html( $item->title )
				. '</a>' . "\n";
	  }
	}
	/* End each menu item */
	public function end_el( &$output, $item, $depth = 0, $args = null ) {
	  $classes = empty( $item->classes ) ? array() : (array) $item->classes;
	  $has_children = in_array( 'menu-item-has-children', $classes, true );
	  if ( $depth === 0 && $has_children ) {
		$output .= "</div>\n";
	  }
	}
  }
  function bootcms_bulma_scripts() {
?>
<script>	  
  // Bulma Framework: Toggle hidden navbar
  const navbarBurgers = Array.prototype.slice.call(
		document.querySelectorAll('.navbar-burger'),
		0 );
  navbarBurgers.forEach( el => {
	el.addEventListener('click', () => {
	  const target = el.dataset.target;
	  const targetMenu = document.getElementById(target);
	  el.classList.toggle('is-active');
	  targetMenu.classList.toggle('is-active');
	  const isOpen = el.classList.contains('is-active');
	  el.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
	});
  });
</script>
<?php 
  }
  add_action( 'wp_footer', 'bootcms_bulma_scripts' );
}

/* =========================================================
   Shortcodes
   ========================================================= */

// Search form : [bootcms_search] 
function bootcms_search_form() {
  ob_start(); ?>
  <form id="form-bootcms-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input
	  type="search"
	  id="bootcms-search"
	  name="s"
	  value="<?php echo esc_attr( get_search_query() ); ?>" >
	<button type="submit">
	  <?php esc_html_e( 'Search', 'bootcms' ); ?>
	</button>
  </form>
<?php
  return ob_get_clean();
}
add_shortcode( 'bootcms_search', 'bootcms_search_form' );

/* =========================================================
   BootCMS Simple Styles - Dynamic CSS
   ========================================================= */

/* Calculate the header image ratio */
function bootcms_header_image_ratio() {
  $header_image_id = get_theme_mod( 'header_image', '' );
  $hdimg_ratio = 0;
  if ( $header_image_id ) {
	$hdimg_metadata = wp_get_attachment_metadata( $header_image_id );
	if ( $hdimg_metadata && ! empty( $hdimg_metadata['width'] ) && ! empty( $hdimg_metadata['height'] ) ) {
	  $hdimg_ratio = $hdimg_metadata['width'] / $hdimg_metadata['height'];
	}
  }
  return $hdimg_ratio;
}
/* Get class names for header */
function bootcms_header_class($header_image_id, $header_image_background, $hd_image_ratio) {
  $hdimg_ratio = bootcms_header_image_ratio();
  $hd_image = ( $header_image_id && ! $header_image_background );
  $hd_sidebar = is_active_sidebar( 'header-sidebar' );  
  if ( ! $hd_image && ! $hd_sidebar ) {
	return 'no-image-no-sidebar';
  } elseif ( ! $hd_image && $hd_sidebar ) {
	return 'no-image-sidebar';
  } elseif ( $hd_image && ! $hd_sidebar ) {
	if ( $hd_image_ratio <= 1.5 ) {
	  return 'image-left-no-sidebar';
	} else {
	  return 'image-top-no-sidebar';
	}
  } elseif ( $hd_image && $hd_sidebar ) {
	if ( $hd_image_ratio <= 1.5 ) {
	  return 'image-left-sidebar';
	} else {
	  return 'image-top-sidebar'; 
	}
  }
}
/** Function to create conditional classes **/
function bootcms_simple_styles_css() {
if ( get_theme_mod( 'bootcms_css_framework', 'bootcms' ) !== 'bootcms' ) {
		return;
	}		
  $header_text_color       = get_theme_mod( 'header_text_color', '' );
  $header_background_color = get_theme_mod( 'header_background_color', '' );

  $header_image            = get_theme_mod( 'header_image', '' );
  $header_image_background = get_theme_mod( 'header_image_background', false );
  $header_title_position   = get_theme_mod( 'bootcms_title_tagline_position', 'bootcms-title-left' );  

  $bootcms_logo            = get_theme_mod( 'bootcms_logo', '' );
  $bootcms_logo_image      = get_theme_mod( 'bootcms_logo_image', false );
  $footer_logo_image       = get_theme_mod( 'footer_logo_image', false );  
   
  $navbar_text_color           = get_theme_mod( 'navbar_text_color', '' );
  $navbar_background_color     = get_theme_mod( 'navbar_background_color', '' );
  $navbar_position_choice      = get_theme_mod( 'navbar_position_choice', '' ); 
  $navbar_horizontal_position  = get_theme_mod( 'navbar_horizontal_position', 'bootcms-navbar-left' );
  
  $main_text_color           = get_theme_mod( 'main_text_color', '' );
  $main_background_color     = get_theme_mod( 'main_background_color', '' );
  $main_background_image     = get_theme_mod( 'main_background_image', '' ); 
  $main_background_watermark = get_theme_mod( 'main_background_watermark', false );
  
  $aside_text_color       = get_theme_mod( 'aside_text_color', '' );
  $aside_background_color = get_theme_mod( 'aside_background_color', '' );
  $right_sidebar_width    = get_theme_mod( 'right_sidebar_width', '' );  

  $footer_text_color       = get_theme_mod( 'footer_text_color', '' );
  $footer_background_color = get_theme_mod( 'footer_background_color', '' );

  $page_background_color     = get_theme_mod( 'page_background_color', '' );
  $page_background_image     = get_theme_mod( 'page_background_image', '' ); 
  $page_background_tiles     = get_theme_mod( 'page_background_tiles', false );
  $background_tiles_position = get_theme_mod( 'background_tiles_position', 'top-left' );  
  
  $main_background_watermark = get_theme_mod( 'main_background_watermark', false );
  if ( $main_background_watermark && $main_background_image ) {
    $wrmark_metadata = wp_get_attachment_metadata( $main_background_image );
    if ( $wrmark_metadata && ! empty( $wrmark_metadata['width'] ) && ! empty( $wrmark_metadata['height'] ) ) {
	  $wrmark_width = $wrmark_metadata['width']; $wrmark_height = $wrmark_metadata['height']; $wrmark_min_width  = round($wrmark_width / 2); $wrmark_max_width  = $wrmark_width;
    }
  }
  if (($bootcms_logo && $bootcms_logo_image) || ($bootcms_logo && $footer_logo_image)) {
	$logo_metadata = wp_get_attachment_metadata( $bootcms_logo );  
    if ( $logo_metadata && ! empty( $logo_metadata['width'] ) && ! empty( $logo_metadata['height'] ) ) {
	  $logo_width = $logo_metadata['width']; $logo_height = $logo_metadata['height']; $logo_min_width  = round($logo_width / 2); $logo_max_width  = round($logo_width * 1.2);
    } 
  }  
?>
<style id="bootcms-simple-styles">
  <?php if (! $header_image_background ) :
  $sq_image_ratio = bootcms_header_image_ratio();  
  $hdr_image_sq = get_theme_mod( 'header_image', '' );
  if ( $hdr_image_sq ) {
	$hdrsq_width = 0;	  
  	$hdrsq_metadata = wp_get_attachment_metadata( $hdr_image_sq );
	if ( $hdrsq_metadata && ! empty( $hdrsq_metadata['width'] )) {
		$hdrsq_width = $hdrsq_metadata['width'];
	}} 
  if ( $hdr_image_sq && $sq_image_ratio <= 1.5 ) : ?>
  .header-image > img {
	min-width: <?php echo round($hdrsq_width / 2); ?>px;	  
  }
  <?php endif; ?>
  <?php else : ?>
	.bootcms-header {
      background-image: url('<?php echo esc_url( wp_get_attachment_image_url( $header_image, 'full' ) ); ?>');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;	
	}
  <?php endif; ?>
  <?php if ( $header_text_color ) : ?>
	.bootcms-header {
	  color: <?php echo esc_html( $header_text_color ); ?>;
	}
  <?php endif; ?>
  <?php if ( $header_background_color ) : ?>
	.bootcms-header {
	  background-color: <?php echo esc_html( $header_background_color ); ?>;
	}
  <?php endif; ?> 
  <?php if ( $header_title_position ) : ?> 
	.header-content h1 {
	  text-align: <?php echo esc_attr( str_replace( 'bootcms-title-', '', $header_title_position ) ); ?>;
	}
  <?php endif; ?> 
  <?php if ( $bootcms_logo_image || $footer_logo_image ) : ?>
	#logo_img,
	#foot_logo_img	{
	  min-width: <?php echo esc_html( $logo_min_width ); ?>px; 
	  max-width: <?php echo esc_html( $logo_max_width ); ?>px;
	}
  <?php endif; ?>   
  <?php if ( $navbar_text_color ) : ?>
	.bootcms-navbar .sub-menu,
	.bootcms-navbar {
	  color: <?php echo esc_html( $navbar_text_color ); ?>;
	}
  <?php endif; ?>
  <?php if ( $navbar_background_color ) : ?>
	.bootcms-navbar .sub-menu,
	.bootcms-navbar {
	  background-color: <?php echo esc_html( $navbar_background_color ); ?>;
	}
  <?php endif; ?> 
  <?php if ( $navbar_position_choice === 'placed-normal' ) : ?>   
	nav.bootcms-navbar {  
      position: static;  
	}
  <?php elseif ( $navbar_position_choice === 'placed-top' ) : ?>  
	nav.bootcms-navbar {
      position: absolute;
      top: 0;
      right: 0;
      left: 0;
      z-index: 9999;
	}
	.bootcms-container-fluid header::before {
      content: "";
      display: block;
      height: 55px;
	  width: 100%;
	}  
  <?php elseif ( $navbar_position_choice === 'fixed-top' ) : ?>  
	nav.bootcms-navbar {
      position: fixed;
      top: 0;
      right: 0;
      left: 0;
      z-index: 9999;
	}
	.bootcms-container-fluid header::before {
      content: "";
      display: block;
      height: 55px;
	  width: 100%;
	} 
  <?php elseif ( $navbar_position_choice === 'sticky-top' ) : ?>   
	nav.bootcms-navbar {
      position: sticky;
      top: 0;
      z-index: 9999;
	}  
  <?php endif; ?>
  <?php if ( $navbar_horizontal_position ) : ?> 
	nav ul.menu {
	  justify-content: <?php echo esc_attr( str_replace( 'bootcms-navbar-', '', $navbar_horizontal_position ) ); ?>;
	}
  <?php endif; ?>  
  <?php if ( $main_text_color ) : ?>
	main {
	  color: <?php echo esc_html( $main_text_color ); ?>;
	}
  <?php endif; ?>
  <?php if ( $main_background_color ) : ?>
	main {
	  background-color: <?php echo esc_html( $main_background_color ); ?>;
	}
  <?php endif; ?>
  <?php if ( $main_background_image && ! $main_background_watermark ) : ?>
	main {
      background-image: url('<?php echo esc_url( wp_get_attachment_image_url( $main_background_image, 'full' ) ); ?>');
      background-size: 100% auto;
      background-position: center;
      background-repeat: no-repeat; 		  
	}
  <?php endif; ?>
  <?php if ( $main_background_image && $main_background_watermark ) : ?>
	main {
      background-image: url('<?php echo esc_url( wp_get_attachment_image_url( $main_background_image, 'full' ) ); ?>');
      background-size: clamp( <?php echo esc_attr( $wrmark_max_width ); ?>px, 75%, <?php echo esc_attr( $wrmark_min_width ); ?>px)  auto;
      background-position: center;
      background-repeat: no-repeat; 		  
	}
  <?php endif; ?> 
  <?php if ( $aside_text_color ) : ?>
	.home-right-sidebar,
	.right-sidebar {
	  color: <?php echo esc_html( $aside_text_color ); ?>;
	}
  <?php endif; ?>
  <?php if ( $aside_background_color ) : ?>
	.home-right-sidebar,
	.right-sidebar	{
	  background-color: <?php echo esc_html( $aside_background_color ); ?>;
	}
  <?php endif; ?>

  <?php if ( $right_sidebar_width ) : ?>
	.frontpage-main-section main,
	.pages-main-section main {
	  width: <?php echo esc_html( ( 100 - (int) $right_sidebar_width ) . '%' ); ?>;
	}
	.frontpage-main-section aside,
	.pages-main-section aside {
	  width: <?php echo esc_html( (int) $right_sidebar_width . '%' ); ?>;
	}
  <?php endif; ?>

  <?php if ( $footer_text_color ) : ?>
	.bootcms-footer {
	  color: <?php echo esc_html( $footer_text_color ); ?>;
	}
  <?php endif; ?>
  <?php if ( $footer_background_color ) : ?>
	.bootcms-footer {
	  background-color: <?php echo esc_html( $footer_background_color ); ?>;
	}
  <?php endif; ?>
  <?php if ( $page_background_color ) : ?>
	html {
	  background-color: <?php echo esc_html( $page_background_color ); ?>;
	}
  <?php endif; ?>
  <?php if ( $page_background_image ) : ?>
	html {
      background-image: url('<?php echo esc_url( wp_get_attachment_image_url( $page_background_image, 'full' ) ); ?>');     
	  <?php if ( ! $page_background_tiles ) : ?>  
	  background-size: cover;
	  background-position: center;
	  background-repeat: no-repeat;
	  <?php else : ?>
background-position: <?php echo $background_tiles_position === 'center' ? 'center center' : 'top left'; ?>;
	  background-repeat: repeat;
	  <?php endif; ?>	  	
	}	
  <?php endif; ?>
</style>
<?php
}
add_action( 'wp_head', 'bootcms_simple_styles_css' );
