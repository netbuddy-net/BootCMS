<?php
/**
 * WordPress classic theme
 * inc/back-end.php
 * @link https://github/...
 * @package BootCMS
 * @since 2.0
 */
defined( 'ABSPATH' ) || exit; // Exit if accessed directly 
/* ========================================================
   Add BootCMS fields in existing WP sections 
   ========================================================= */ 

/*** Site Identity Section ***/
/* Add copyright fields and Logo */
function bootcms_customize_register( $wp_customize ) {
// Logo
  $wp_customize->add_setting( 'bootcms_logo', array(
	'default'           => '',
	'sanitize_callback' => 'absint',
  ) );
  $wp_customize->add_control( new WP_Customize_Media_Control(
	  $wp_customize, 'bootcms_logo', array(
		'label'       => __( 'Site Logo', 'bootcms' ),
		'section'     => 'title_tagline',
		'mime_type'   => 'image',
		'priority'	  => 70,
		'description' => __( 'Upload a logo. Enable it in the "<strong>Simple Styles</strong>" section.', 'bootcms' ),
	  )
	)
  );
// Copyright Name
  $wp_customize->add_setting( 'copyright_name', array(
	'default'           => '',
	'sanitize_callback' => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'copyright_name', array(
	'label'    => __( 'Copyright Name', 'bootcms' ),
	'section'  => 'title_tagline',
	'type'     => 'text',
	'priority' => 80,
  ) );
// Copyright Notice
  $wp_customize->add_setting( 'copyright_notice', array(
	'default'           => '',
	'sanitize_callback' => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'copyright_notice', array(
	'label'    => __( 'Copyright Notice', 'bootcms' ),
	'section'  => 'title_tagline',
	'type'     => 'text',
	'priority' => 90,
  ) );
  
/*** Menu Section ***/
/* Add classes instructions into Menu section */
  $wp_customize->add_section( 'bootcms_menu_section', array(
    'title'       => __( 'BootCMS Menu Classes', 'bootcms' ),
    'panel'       => 'nav_menus',
	'priority'    => 1,
  ) );
  $wp_customize->add_setting( 'bootcms_menu_classes', array(
    'default'           => ' ',
    'sanitize_callback' => 'sanitize_key',
  ) );
  $wp_customize->add_control( 'bootcms_menu_classes', array(
	'title'       => __( 'BootCMS Added Classes', 'bootcms' ), 
    'type'        => 'hidden',
    'section'     => 'bootcms_menu_section',
    'description' => __( '<strong>Disabled Link</strong><br>To make a link appear disabled, add a <b>Custom Link</b> item, enter "<code>#</code>" in URL, a title in Navigation Label and "<code>menu-disabled</code>" in CSS Classes.<br>&nbsp;<br><strong>Divider Line</strong><br>To add a divider line above a link in a <u>dropdown menu</u>, enter "<code>menu-divider</code>" in CSS Classes.', 'bootcms' ),
  ) ); 
}
add_action( 'customize_register', 'bootcms_customize_register' );
 
/* =========================================================
   Simple Styles Customizer
   ========================================================= */ 

function simple_styles_customize_register( $wp_customize ) {
// Simple Styles Section Title
  $wp_customize->add_section( 'simple_styles', array(
	'title'    => __( 'Simple Styles', 'bootcms' ),
	'priority' => 30,
  ) );
// Widgets description
  $wp_customize->add_setting( 'widgets_description', array(
    'default'           => ' ',
    'sanitize_callback' => 'sanitize_key',
  ) );
  $wp_customize->add_control( 'widgets_description', array(
	'description' => __( 'To add content or HTML code to sections such as the <strong>Header, Navigation Bar</strong>, Homepage\'s <strong>Hero Unit, Right Sidebar</strong>, or <strong>Footer</strong>, add a widget to the corresponding sidebar in the <strong>Widgets</strong> section.<br>&nbsp;', 'bootcms' ),
    'type'        => 'hidden', 
    'section'     => 'simple_styles',
  ) ); 
// Global section  ------------------
  $wp_customize->add_setting( 'title_global_section', array(
    'default'           => ' ',
    'sanitize_callback' => 'sanitize_key',
  ) );
  $wp_customize->add_control( 'title_global_section', array(
  	'label'       => __( 'GLOBAL SECTION', 'bootcms' ),
	'description' => __( 'These settings apply to all frameworks.<br>&nbsp;', 'bootcms' ),
    'type'        => 'hidden', 
    'section'     => 'simple_styles',
  ) );
// Body classes
  $wp_customize->add_setting( 'body_tag_classes', array(
    'default'           => '',
    'sanitize_callback' => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'body_tag_classes', array(
    'label'       => __( 'Body Classes - Global', 'bootcms' ),
    'description' => __( 'Add classes to the <strong>Body</strong> tag. Multiple classes can be separated by spaces. You can use classes from an installed CSS Framework, or define custom classes under the "Additional CSS" section.', 'bootcms' ),
    'section'     => 'simple_styles',
    'type'        => 'text',
  ) ); 
// Top container classes
  $wp_customize->add_setting( 'top_container_classes', array(
    'default'           => '',
    'sanitize_callback' => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'top_container_classes', array(
    'label'       => __( 'Top Container - Framework Classes', 'bootcms' ),
    'description' => __( 'Add classes to the <strong>Top Container (div)</strong> tag. Multiple classes can be separated by spaces. You can use classes from an installed CSS Framework, or define custom classes under the "Additional CSS" section.', 'bootcms' ),
    'section'     => 'simple_styles',
    'type'        => 'text',
  ) ); 
// Header's description
  $wp_customize->add_setting( 'header_description', array(
    'default'           => ' ',
    'sanitize_callback' => 'sanitize_key',
  ) );
  $wp_customize->add_control( 'header_description', array(
	'label'       => __( 'Header Section - Global', 'bootcms' ),
	'description' => __( 'By default, the Header content includes the <strong>Site Title</strong> in an "h1" tag, with the <strong>Site Tagline</strong> displayed underneath in a "small" tag as part of the "h1". There is also a <strong>Right Sidebar</strong> where widgets can be used to add content and HTML code. To replace the default Header layout, add a widget to the <strong>Custom Header Sidebar</strong>.<br>&nbsp;', 'bootcms' ),
    'type'        => 'hidden', 
    'section'     => 'simple_styles',
  ) );  
// Header classes
  $wp_customize->add_setting( 'header_tag_classes', array(
    'default'           => '',
    'sanitize_callback' => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'header_tag_classes', array(
    'label'       => __( 'Header Classes - Global', 'bootcms' ),
    'description' => __( 'Add classes to the <strong>Header</strong> tag. Multiple classes can be separated by spaces. You can use classes from an installed CSS Framework, or define custom classes under the "Additional CSS" section.', 'bootcms' ),
    'section'     => 'simple_styles',
    'type'        => 'text',
  ) );  
// Header Image
  $wp_customize->add_setting( 'header_image', array(
	'default'           => '',
	'sanitize_callback' => 'absint',
  ) );
  $wp_customize->add_control(
	new WP_Customize_Media_Control(
	  $wp_customize,
	  'header_image',
	  array(
		'label'       => __( 'Header Image - Global', 'bootcms' ),
		'section'     => 'simple_styles',
		'mime_type'   => 'image',
		'description' => __( 'Upload an image for the header. The image layout is adjusted automatically: near-square images appear on the left with the title and tagline on the right, while wide rectangular images appear above the title and tagline.', 'bootcms' ),
	  )
  ) );  
// Logo Image
  $wp_customize->add_setting( 'title_bootcms_logo', array(
    'default'           => ' ',
    'sanitize_callback' => 'sanitize_key',
  ) );
  $wp_customize->add_control( 'title_bootcms_logo', array(
  	'label'       => __( 'Display the Logo - Global', 'bootcms' ),
	'description' => __( 'Upload the logo in the <strong>Site Identity</strong> section.', 'bootcms' ),
    'type'        => 'hidden', 
    'section'     => 'simple_styles',
  ) );
  $wp_customize->add_setting( 'bootcms_logo_image', array(
	'default'           => false,
	'sanitize_callback' => 'wp_validate_boolean',
  ) );
  $wp_customize->add_control( 'bootcms_logo_image', array(
	'section'  => 'simple_styles',
	'type'     => 'checkbox',
	'label'    => __( 'Display the Logo in the header instead of the Header Image.', 'bootcms' ),
  ) );
  $wp_customize->add_setting( 'footer_logo_image', array(
	'default'           => false,
	'sanitize_callback' => 'wp_validate_boolean',
  ) );
  $wp_customize->add_control( 'footer_logo_image', array(
	'section'  => 'simple_styles',
	'type'     => 'checkbox',
	'label'    => __( 'Display the Logo in the footer.', 'bootcms' ),
  ) );  
// Navbar Menu
  $navbar_status = is_active_sidebar( 'customised_nav_menu' )
	? __( '<span class="framework-nav-text">Widget navigation menu is enabled. The <strong>Customised Nav Menu</strong> widget can be used with any supported framework menu or as a custom menu. The Nav tag is already included as a wrapper, just add classes below.</span>', 'bootcms' )
	: __( '<span class="bootcms-nav-text"><strong>WordPress Menu</strong> is currently used for the main navigation bar. <br>&nbsp;<br>Add a widget to the <strong>Customised Nav Menu</strong> widget area when a custom navigation menu or framework-specific menu needs to be <u>hard-coded</u>.
</span>', 'bootcms' );
  $wp_customize->add_setting( 'navbar_info', array(
    'default'           => ' ',
    'sanitize_callback' => 'sanitize_key',
  ) );
  $wp_customize->add_control( 'navbar_info', array(
	'label'       => __( 'Navigation Menu - Global', 'bootcms' ),  
	'section'     => 'simple_styles',
	'type'        => 'hidden',
	'description' => $navbar_status,
  ) ); 
// Nav tag classes
  $wp_customize->add_setting( 'nav_tag_classes', array(
    'default'           => '',
    'sanitize_callback' => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'nav_tag_classes', array(
    'label'       => __( 'Nav Tag Classes - Global', 'bootcms' ),
    'description' => __( 'Add, remove or replace CSS classes for the <strong>Nav</strong> tag. Multiple classes can be separated by spaces. You can use classes from an installed CSS Framework, or define custom classes under the "Additional CSS" section.', 'bootcms' ),
    'section'     => 'simple_styles',
    'type'        => 'text',
  ) );
// Main Tag Classes
  $wp_customize->add_setting( 'main_tag_classes', array(
    'default'           => '',
    'sanitize_callback' => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'main_tag_classes', array(
    'label'       => __( '"Main" Tag Classes - Global', 'bootcms' ),
    'description' => __( 'Add, remove or replace CSS classes for the "Main" tag. Multiple classes can be separated by spaces. You can define custom classes to use here under "Additional CSS" in Theme Customise.', 'bootcms' ),
    'section'     => 'simple_styles',
    'type'        => 'text',
  ) ); 
// Footer's description
  $wp_customize->add_setting( 'footer_description', array(
    'default'           => ' ',
    'sanitize_callback' => 'sanitize_key',
  ) );
  $wp_customize->add_control( 'footer_description', array(
	'label'       => __( 'Footer Section - Global', 'bootcms' ),
	'description' => __( 'By default, the Footer includes two sections: "<strong>Main</strong>" and the  "<strong>Sidebar</strong>" on the right. Use widgets to add content and HTML code. It also includes a bottom section that displays copyright information, which is not editable. To replace the Footer\'s default layout, add a widget to the "<strong>Custom Footer Sidebar</strong>".', 'bootcms' ),
    'type'        => 'hidden', 
    'section'     => 'simple_styles',
  ) );
// Body classes
  $wp_customize->add_setting( 'footer_tag_classes', array(
    'default'           => '',
    'sanitize_callback' => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'footer_tag_classes', array(
    'label'       => __( 'Footer Classes - Global', 'bootcms' ),
    'description' => __( 'Add classes to the <strong>Footer</strong> tag. Multiple classes can be separated by spaces. You can use classes from an installed CSS Framework, or define custom classes under the "Additional CSS" section.', 'bootcms' ),
    'section'     => 'simple_styles',
    'type'        => 'text',
  ) );  
/** 
  * BootCMS section ------------------ 
**/
  $wp_customize->add_setting( 'title_bootcms_section', array(
    'default'           => ' ',
    'sanitize_callback' => 'sanitize_key',
  ) );
  $wp_customize->add_control( 'title_bootcms_section', array(
  	'label'       => __( 'BOOTCMS SECTION', 'bootcms' ),
	'description' => __( 'These settings apply to BootCMS framework.<br>&nbsp;', 'bootcms' ),
    'type'        => 'hidden', 
    'section'     => 'simple_styles',
  ) ); 
/*** Top Container ***/
  $wp_customize->add_setting( 'bootcms_top_container_type', array(
    'default'           => 'bootcms-container-fluid',
    'sanitize_callback' => 'sanitize_key',
  ) );
  $wp_customize->add_control( 'bootcms_top_container_type', array(
    'label'   => __( 'Top Container - BootCMS Classes', 'bootcms' ),
    'section' => 'simple_styles',
    'type'    => 'radio',
    'choices' => array(
		'bootcms-container-fluid' => __( 'Fluid Container (always 100% wide)', 'bootcms' ),
        'bootcms-container'       => __( 'Container with Breakpoints', 'bootcms' ),
    ),
  ) );
  $wp_customize->add_setting( 'container_description', array(
    'default'           => ' ',
    'sanitize_callback' => 'sanitize_key',
  ) );
  $wp_customize->add_control( 'container_description', array(
    'type'        => 'hidden', 
    'section'     => 'simple_styles',
    'description' => __( 'Breakpoints are at: 576px, 768px, 992px, 1200px and 1400px. <br>&nbsp;', 'bootcms' ), 
  ) );
/*** Header ***/
// Header Text Color
  $wp_customize->add_setting( 'header_text_color', array(
	'default'           => '',
	'sanitize_callback' => 'sanitize_hex_color',
  ) );
  $wp_customize->add_control(
	new WP_Customize_Color_Control(
	  $wp_customize,
	  'header_text_color',
	  array(
		'label'   => __( 'BootCMS Header Text Color', 'bootcms' ),
		'section' => 'simple_styles',
	  )
  ) );  
// Header Background Color
  $wp_customize->add_setting( 'header_background_color', array(
	'default'           => '',
	'sanitize_callback' => 'sanitize_hex_color',
  ) );
  $wp_customize->add_control(
	new WP_Customize_Color_Control(
	  $wp_customize,
	  'header_background_color',
	  array(
		'label'   => __( 'BootCMS Header Background Color', 'bootcms' ),
		'section' => 'simple_styles',
	  )
	) );
// Site Title / Tagline Position
  $wp_customize->add_setting( 'bootcms_title_tagline_position', array(
    'default'           => 'bootcms-title-left',
    'sanitize_callback' => 'sanitize_key',
  ) );
  $wp_customize->add_control( 'bootcms_title_tagline_position', array(
    'label'   => __( 'BootCMS Title & Tagline Position', 'bootcms' ),
    'section' => 'simple_styles',
    'type'    => 'radio',
    'choices' => array(
		'bootcms-title-left'   => __( 'Left (default)', 'bootcms' ),
        'bootcms-title-center' => __( 'Center', 'bootcms' ),
		'bootcms-title-right'  => __( 'Right', 'bootcms' ),
    ),
  ) );  
// Header Image as Background
  $wp_customize->add_setting( 'title_header_image', array(
    'default'           => ' ',
    'sanitize_callback' => 'sanitize_key',
  ) );
  $wp_customize->add_control( 'title_header_image', array(
  	'label'       => __( 'Use Header Image as background', 'bootcms' ),
    'type'        => 'hidden', 
    'section'     => 'simple_styles',
  ) ); 
  $wp_customize->add_setting( 'header_image_background', array(
	'default'           => false,
	'sanitize_callback' => 'wp_validate_boolean',
  ) );
  $wp_customize->add_control( 'header_image_background', array(
	'label'   => __( 'BootCMS Header Image as Background', 'bootcms' ),
	'section' => 'simple_styles',
	'type'    => 'checkbox',
  ) );
/*** Navigation Bar **/
// Navbar Text Color
  $wp_customize->add_setting( 'navbar_text_color', array(
	'default'           => '',
	'sanitize_callback' => 'sanitize_hex_color',
  ) );
  $wp_customize->add_control( new WP_Customize_Color_Control(
	  $wp_customize,
	  'navbar_text_color', array(
		'label'   => __( 'BootCMS Navbar Text Color', 'bootcms' ),
		'section' => 'simple_styles', 
	  )
	) );
// Navbar Background Color
  $wp_customize->add_setting( 'navbar_background_color', array(
	'default'           => '',
	'sanitize_callback' => 'sanitize_hex_color',
  ) );
  $wp_customize->add_control( new WP_Customize_Color_Control(
	  $wp_customize,
	  'navbar_background_color', array(
		'label'   => __( 'BootCMS Navbar Background Color', 'bootcms' ),
		'section' => 'simple_styles', 
	  )
    ) ); 
// BootCMS Nav position styles 
  $wp_customize->add_setting( 'navbar_position_choice', array(
    'default'           => 'placed-normal',
    'sanitize_callback' => 'sanitize_key',
  ) );
  $wp_customize->add_control( 'navbar_position_choice', array(
	'label'   => __( 'BootCMS Navbar Position Styles', 'bootcms' ),  
    'section' => 'simple_styles',
    'type'    => 'radio', 
    'choices' => array(
	  'placed-normal' => __( 'Placed after Header', 'bootcms' ),	
	  'placed-top'    => __( 'Placed on Top', 'bootcms' ),
	  'fixed-top'     => __( 'Fixed on Top', 'bootcms' ),
	  'sticky-top'    => __( 'Sticky on Top', 'bootcms' ),
    ),
  ) );
// BootCMS Nav Horizontal Position
  $wp_customize->add_setting( 'navbar_horizontal_position', array(
    'default'           => 'bootcms-navbar-left',
    'sanitize_callback' => 'sanitize_key',
  ) );
  $wp_customize->add_control( 'navbar_horizontal_position', array(
    'label'   => __( 'BootCMS Nav Tag Horizontal Position', 'bootcms' ),
    'section' => 'simple_styles',
    'type'    => 'radio',
    'choices' => array(
		'bootcms-navbar-left'   => __( 'Left (default)', 'bootcms' ),
        'bootcms-navbar-center' => __( 'Center', 'bootcms' ),
		'bootcms-navbar-right'  => __( 'Right', 'bootcms' ),
    ),
  ) );   
/*** Main Section ***/
// Main Text Color
  $wp_customize->add_setting( 'main_text_color', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
  ) );
  $wp_customize->add_control( new WP_Customize_Color_Control(
	  $wp_customize,
	  'main_text_color', array(
		'label'   => __( 'BootCMS Main Content Text Color', 'bootcms' ),
		'section' => 'simple_styles', 
	  )
	) );
// Main Background Color
  $wp_customize->add_setting( 'main_background_color', array(
	'default'           => '',
	'sanitize_callback' => 'sanitize_hex_color',
  ) );
  $wp_customize->add_control( new WP_Customize_Color_Control(
	  $wp_customize,
	  'main_background_color', array(
		'label'   => __( 'BootCMS Main Content Background Color', 'bootcms' ),
		'section' => 'simple_styles', 
	  )
	) );
// Main Content Background Image
  $wp_customize->add_setting( 'main_background_image', array(
	'default'           => '',
	'sanitize_callback' => 'absint',
  ) );
  $wp_customize->add_control( new WP_Customize_Media_Control(
	  $wp_customize,
	  'main_background_image', array(
		'label'       => __( 'BootCMS Main Content Background Image', 'bootcms' ),
		'section'     => 'simple_styles',
		'mime_type'   => 'image',
		'description' => __( 'Upload a background image for the main section.', 'bootcms' ),
	  )
	) );
// Main Background Image as Watermark
  $wp_customize->add_setting( 'main_background_watermark', array(
	'default'           => false,
	'sanitize_callback' => 'wp_validate_boolean',
  ) );
  $wp_customize->add_control( 'main_background_watermark', array(
	'label'   => __( 'Background Image as Watermark', 'bootcms' ),
	'section' => 'simple_styles',
	'type'    => 'checkbox', 
  ) );
/*** Aside Right Sidebar ***/
// Aside Text Color
  $wp_customize->add_setting( 'aside_text_color', array(
	'default'           => '',
	'sanitize_callback' => 'sanitize_hex_color',
  ) );
  $wp_customize->add_control( new WP_Customize_Color_Control(
	  $wp_customize,
	  'aside_text_color',
	  array(
		'label'   => __( 'BootCMS Right Sidebar Text Color', 'bootcms' ),
		'section' => 'simple_styles',
	  )
	) );
// Aside Background Color
  $wp_customize->add_setting( 'aside_background_color', array(
	'default'           => '',
	'sanitize_callback' => 'sanitize_hex_color',
  ) );
  $wp_customize->add_control(
	new WP_Customize_Color_Control(
	  $wp_customize,
	  'aside_background_color',
	  array(
		'label'   => __( 'BootCMS Right Sidebar Background Color', 'bootcms' ),
		'section' => 'simple_styles',
	  )
  ) );
// Right Sidebar Width
  $wp_customize->add_setting( 'right_sidebar_width', array(
    'default'           => '25',
    'sanitize_callback' => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'right_sidebar_width', array(
    'type'        => 'select',
    'label'       => __( 'BootCMS Right Sidebar Width', 'bootcms' ),
    'section'     => 'simple_styles',
    'choices'     => array(
      '50' => '50%',
      '40' => '40%',
      '33' => '33%',
      '30' => '30%',
      '27' => '27%',
      '25' => '25%',
      '22' => '22%',
	  '20' => '20%',
    ),
  ) );
/*** Footer ***/
// Footer Text Color
  $wp_customize->add_setting( 'footer_text_color', array(
	'default'           => '',
	'sanitize_callback' => 'sanitize_hex_color',
  ) );
  $wp_customize->add_control(
	new WP_Customize_Color_Control(
	  $wp_customize,
	  'footer_text_color',
	  array(
		'label'   => __( 'BootCMS Footer Text Color', 'bootcms' ),
		'section' => 'simple_styles',
	  )
	)
  );
// Footer Background Color
  $wp_customize->add_setting( 'footer_background_color', array(
	'default'           => '',
	'sanitize_callback' => 'sanitize_hex_color',
  ) );
  $wp_customize->add_control(
	new WP_Customize_Color_Control(
	  $wp_customize,
	  'footer_background_color',
	  array(
		'label'   => __( 'BootCMS Footer Background Color', 'bootcms' ),
		'section' => 'simple_styles',
	  )
	)
  );
/*** Page Backgrounds ***/
// Page Background Color
  $wp_customize->add_setting( 'page_background_color', array(
	'default'           => '',
	'sanitize_callback' => 'sanitize_hex_color',
  ) );
  $wp_customize->add_control(
	new WP_Customize_Color_Control(
	  $wp_customize,
	  'page_background_color',
	  array(
		'label'   => __( 'BootCMS Page Background Color', 'bootcms' ),
		'section' => 'simple_styles',
	  )
	)
  );
// Page Background Image
  $wp_customize->add_setting( 'page_background_image', array(
	'default'           => '',
	'sanitize_callback' => 'absint',
  ) );
  $wp_customize->add_control(
	new WP_Customize_Media_Control(
	  $wp_customize,
	  'page_background_image',
	  array(
		'label'       => __( 'BootCMS Page Background Image', 'bootcms' ),
		'section'     => 'simple_styles',
		'mime_type'   => 'image',
		'description' => __( 'Upload a background image for the page.', 'bootcms' ),
	  )
	)
  );
// Page Background Image Tiles
  $wp_customize->add_setting( 'page_background_tiles', array(
	'default'           => false,
	'sanitize_callback' => 'wp_validate_boolean',
  ) );
  $wp_customize->add_control( 'page_background_tiles', array(
	'label'   => __( 'Enable Image as Tiles', 'bootcms' ),
	'section' => 'simple_styles',
	'type'    => 'checkbox', 
  ) );
// Page Background Tiles Position
  $wp_customize->add_setting( 'background_tiles_position', array(
    'default'           => 'top-left',
    'sanitize_callback' => 'sanitize_key',
  ) );
  $wp_customize->add_control( 'background_tiles_position', array(
    'section' => 'simple_styles',
    'type'    => 'radio',
	'description' => __( 'Background tiles starting position:', 'bootcms' ),
    'choices' => array(
	  'top-left' => __( 'Top Left', 'bootcms' ),
	  'center'   => __( 'Center', 'bootcms' ),
    ),
  ) );
}
add_action( 'customize_register', 'simple_styles_customize_register' );

/* =========================================================
   Advanced Settings Customizer
   ========================================================= */ 
   
function advanced_settings_customize_register( $wp_customize ) {
  $wp_customize->add_section( 'bootcms_advanced_settings', array(
	'title'    => __( 'Advanced Settings', 'bootcms' ),
	'priority' => 30,
  ) );
  $wp_customize->add_setting( 'js_support', array(
    'default'           => ' ',
    'sanitize_callback' => 'sanitize_key',
  ) );
  $wp_customize->add_control( 'js_support', array(
	'label'   => __( 'JS Libraries & Frameworks', 'bootcms' ),  
	'section'     => 'bootcms_advanced_settings',
	'type'        => 'hidden',
	'description' => __( 'Enable only what you need to use.', 'bootcms' ),
  ) );
  $wp_customize->add_setting( 'bootcms_enable_jquery', array(
	'default'           => false,
	'sanitize_callback' => 'rest_sanitize_boolean',
  ) );
  $wp_customize->add_control( 'bootcms_enable_jquery', array(
	'label'       => __( 'Enable WordPress jQuery', 'bootcms' ),
	'section'     => 'bootcms_advanced_settings',
	'type'        => 'checkbox',
  ) );
  $wp_customize->add_setting( 'bootcms_enable_react', array(
	'default'           => false,
	'sanitize_callback' => 'rest_sanitize_boolean',
    )
  );
  $wp_customize->add_control( 'bootcms_enable_react', array(
	'label'       => __( 'Enable WordPress React (wp.element)', 'bootcms' ),
	'section'     => 'bootcms_advanced_settings',
	'type'        => 'checkbox',
  ) );
  $wp_customize->add_setting( 'bootcms_enable_vue', array(
	'default'           => false,
	'sanitize_callback' => 'rest_sanitize_boolean',
  ) );
  $wp_customize->add_control( 'bootcms_enable_vue', array(
	'label'       => __( 'Enable Vue v3.5.x', 'bootcms' ),
	'section'     => 'bootcms_advanced_settings',
	'type'        => 'checkbox',
  ) );
  $wp_customize->add_setting( 'bootcms_css_framework', array(
	'default'           => 'bootcms',
	'sanitize_callback' => 'sanitize_key',
    ) );
  $wp_customize->add_control( 'bootcms_css_framework', array(
	'label'       => __( 'CSS Libraries & Frameworks', 'bootcms' ),
	'description' => __( 'Choose one of the CSS frameworks. Several versions included.', 'bootcms' ),
	'section'     => 'bootcms_advanced_settings',
	'type'        => 'radio',
	'choices'     => array(
	  'bootcms'    => __( 'BootCMS 2.0 (native)', 'bootcms' ),
	  'bootstrap'  => __( 'Bootstrap', 'bootcms' ),
	  'bootswatch' => __( 'Bootswatch', 'bootcms' ),
	  'foundation' => __( 'Foundation', 'bootcms' ),
	  'bulma'      => __( 'Bulma 1.0.4', 'bootcms' ),
	),
  ) );  
  $wp_customize->add_setting( 'bootcms_bootstrap_version', array(
	'default'           => '5.3.8',
	'sanitize_callback' => 'sanitize_text_field',
    ) );
  $wp_customize->add_control( 'bootcms_bootstrap_version', array(
	'label'           => __( 'Bootstrap Version', 'bootcms' ),
	'description'     => __( 'Note: For the Bootstrap menu to work, first enter the required classes for the Nav tag in the Simple Styles section.', 'bootcms' ),
	'section'         => 'bootcms_advanced_settings',
	'type'            => 'select',
	'choices'         => array(
	  '3.4.1' => __( 'Bootstrap 3.4.1', 'bootcms' ),
	  '4.6.2' => __( 'Bootstrap 4.6.2', 'bootcms' ),
	  '5.3.8' => __( 'Bootstrap 5.3.8', 'bootcms' ),
	),
	'active_callback' => function() {
	  return get_theme_mod( 'bootcms_css_framework', 'bootcms' ) === 'bootstrap';
	},
  ) );
  $wp_customize->add_setting( 'bootcms_bootswatch_theme', array(
	'default'           => 'slate',
	'sanitize_callback' => 'sanitize_text_field',
	) );
  $wp_customize->add_control(
    'bootcms_bootswatch_theme',
    array(
      'label'           => __( 'Bootswatch Six Themes', 'bootcms' ),
      'description'     => __( 'Choose one of the six themes.<br>Note: For the Bootswatch menu to work, first enter the required classes for the Nav Bar in the Simple Styles section.', 'bootcms' ),
      'section'         => 'bootcms_advanced_settings',
      'type'            => 'select',
	  'choices'         => array(
	  'brite'     => __( 'Brite 5.3.8', 'bootcms' ),
	  'cerulean'  => __( 'Cerulean 5.3.8', 'bootcms' ),
	  'darkly'    => __( 'Darkly 5.3.8', 'bootcms' ),
	  'quartz'    => __( 'Quartz 5.3.8', 'bootcms' ),
	  'slate'     => __( 'Slate 5.3.8', 'bootcms' ),
	  'superhero' => __( 'Superhero 5.3.8', 'bootcms' ),
	  ),
      'active_callback' => function() {
		return get_theme_mod( 'bootcms_css_framework', 'bootcms' ) === 'bootswatch';
      },
  ) );
  $wp_customize->add_setting( 'bootcms_foundation_version', array(
	'default'           => '6.9.0',
	'sanitize_callback' => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'bootcms_foundation_version', array(
	'label'           => __( 'Foundation Version', 'bootcms' ),
	'description'     => __( 'Note: The Foundation menu works only with version 6.x!', 'bootcms' ),
	'section'         => 'bootcms_advanced_settings',
	'type'            => 'select',
	'choices'         => array(
		'6.3.1' => __( 'Foundation 6.3.1', 'bootcms' ),	
		'6.9.0' => __( 'Foundation 6.9.0', 'bootcms' ),
	),
	'active_callback' => function() {
		return get_theme_mod( 'bootcms_css_framework', 'bootcms' ) === 'foundation';
	},
  ) );
/* disable block support and emoji */
  $wp_customize->add_setting( 'wp_modules', array(
    'default'           => ' ',
    'sanitize_callback' => 'sanitize_key',
  ) );
  $wp_customize->add_control( 'wp_modules', array(
	'label'   => __( 'Disable WP Modules', 'bootcms' ),  
	'section'     => 'bootcms_advanced_settings',
	'type'        => 'hidden',
  ) );
  $wp_customize->add_setting( 'bootcms_disable_block_editor', array(
	'default'           => false,
	'sanitize_callback' => 'wp_validate_boolean',
  ) );
  $wp_customize->add_control( 'bootcms_disable_block_editor', array(
	'label'       => __( 'Disable Block Editor', 'bootcms' ),
	'description' => __( 'Disable the WordPress Block Editor and its front-end block styles.', 'bootcms' ),
	'section'     => 'bootcms_advanced_settings',
	'type'        => 'checkbox',
  ) );  
  $wp_customize->add_setting( 'bootcms_disable_emojis', array(
	'default'           => false,
	'sanitize_callback' => 'wp_validate_boolean',
  ) );
  $wp_customize->add_control( 'bootcms_disable_emojis', array(
	'label'       => __( 'Disable WordPress Emojis', 'bootcms' ),
	'section'     => 'bootcms_advanced_settings',
	'type'        => 'checkbox',
  ) );  
// 404 page title
  $wp_customize->add_setting( '404_page_title', array(
    'default'           => '',
    'sanitize_callback' => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( '404_page_title', array(
    'label'       => __( '404 Page (Not Found) Title', 'bootcms' ),
    'description' => __( 'Enter a custom title', 'bootcms' ),
    'section'     => 'bootcms_advanced_settings',
    'type'        => 'text',
  ) );
// 404 page text  
  $wp_customize->add_setting( 'html_404_page', array(
    'default'           => '',
    'sanitize_callback' => function( $value ) {
	  // Remove PHP tags. This field is for HTML only.
	  $value = preg_replace( '/<\?(?:php|=)?[\s\S]*?\?>/i', '', $value );
	  // Users with unfiltered_html can retain their HTML.
	  if ( current_user_can( 'unfiltered_html' ) ) { return $value; }
	  // Other users receive WordPress HTML filtering.
	  return wp_kses_post( $value );
    },
  ) );
  $wp_customize->add_control( 'html_404_page', array(
    'label'       => __( 'Custom HTML 404 content', 'bootcms' ),
    'description' => __( 'Enter custom HTML content for the Not Found page (404 error). Up to 500 characters.', 'bootcms' ),
    'section'     => 'bootcms_advanced_settings',
    'type'        => 'textarea',
    'input_attrs' => array(
        'maxlength' => 500,
    ),
  ) );
// 404 page image
  $wp_customize->add_setting( '404_page_image', array(
	'default'           => '',
	'sanitize_callback' => 'absint',
  ) );
  $wp_customize->add_control( new WP_Customize_Media_Control(
	  $wp_customize, '404_page_image', array(
		'label'       => __( '404 Page Image', 'bootcms' ),
		'section'     => 'bootcms_advanced_settings',
		'mime_type'   => 'image',
		'description' => __( 'Upload an image for the 404 page.', 'bootcms' ),
	  )
  ) );    
}	
add_action( 'customize_register', 'advanced_settings_customize_register' );

/* =========================================================
   Post Settings Customizer
   ========================================================= */ 

function posts_customize_register( $wp_customize ) {
  $wp_customize->add_section( 'bootcms_post_settings', array(
	'title'    => __( 'Posts Settings', 'bootcms' ),
	'priority' => 40,
  ) );
  // Copyright Name
  $wp_customize->add_setting( 'posts_home_title', array(
	'default'           => '',
	'sanitize_callback' => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'posts_home_title', array(
	'label'       => __( 'Posts Homepage Title', 'bootcms' ),
	'description' => __( 'Enter a title for the Posts Homepage to replace the default.', 'bootcms' ),
	'section'     => 'bootcms_post_settings',
	'type'        => 'text',
  ) );  
  $wp_customize->add_setting( 'posts_meta_data', array(
    'default'           => ' ',
    'sanitize_callback' => 'sanitize_key',
  ) );
  $wp_customize->add_control( 'posts_meta_data', array(
 	'label'   => __( 'Post Metadata', 'bootcms' ),
	'description' => __( 'Choose the ones to display.', 'bootcms' ),	
	'section'     => 'bootcms_post_settings',
	'type'        => 'hidden',
  ) );
  $wp_customize->add_setting( 'published_date_post', array(
	'default'           => true,
	'sanitize_callback' => 'wp_validate_boolean',
  ) );
  $wp_customize->add_control( 'published_date_post', array(
	'label'       => __( 'Published date', 'bootcms' ),
	'section'     => 'bootcms_post_settings',
	'type'        => 'checkbox',
  ) );
  $wp_customize->add_setting( 'modified_date_post', array(
	'default'           => false,
	'sanitize_callback' => 'wp_validate_boolean',
  ) );
  $wp_customize->add_control( 'modified_date_post', array(
	'label'       => __( 'Modified date', 'bootcms' ),
	'section'     => 'bootcms_post_settings',
	'type'        => 'checkbox',
  ) );
  $wp_customize->add_setting( 'author_of_post', array(
	'default'           => true,
	'sanitize_callback' => 'wp_validate_boolean',
  ) );
  $wp_customize->add_control( 'author_of_post', array(
	'label'       => __( 'Author', 'bootcms' ),
	'section'     => 'bootcms_post_settings',
	'type'        => 'checkbox',
  ) );
  $wp_customize->add_setting( 'category_of_post', array(
	'default'           => true,
	'sanitize_callback' => 'wp_validate_boolean',
  ) );
  $wp_customize->add_control( 'category_of_post', array(
	'label'       => __( 'Category', 'bootcms' ),
	'section'     => 'bootcms_post_settings',
	'type'        => 'checkbox',
  ) );
  $wp_customize->add_setting( 'post_tags', array(
	'default'           => false,
	'sanitize_callback' => 'wp_validate_boolean',
  ) );
  $wp_customize->add_control( 'post_tags', array(
	'label'       => __( 'Tags', 'bootcms' ),
	'section'     => 'bootcms_post_settings',
	'type'        => 'checkbox',
  ) );
  $wp_customize->add_setting( 'comments_count', array(
	'default'           => false,
	'sanitize_callback' => 'wp_validate_boolean',
  ) );
  $wp_customize->add_control( 'comments_count', array(
	'label'       => __( 'Comments count', 'bootcms' ),
	'section'     => 'bootcms_post_settings',
	'type'        => 'checkbox',
  ) );
   $wp_customize->add_setting( 'discussion_status', array(
	'default'           => false,
	'sanitize_callback' => 'wp_validate_boolean',
  ) );
  $wp_customize->add_control( 'discussion_status', array(
	'label'       => __( 'Discussion status', 'bootcms' ),
	'section'     => 'bootcms_post_settings',
	'type'        => 'checkbox',
  ) );
  $wp_customize->add_setting( 'post_content_display', array(
    'default'           => 'excerpt',
    'sanitize_callback' => 'sanitize_key',
  ) );
  $wp_customize->add_control( 'post_content_display', array(
    'label'       => __( 'Post Content', 'bootcms' ),
    'description' => __( 'Choose whether the main <strong>Posts</strong> page and other pages listing posts display the full content or an excerpt.', 'bootcms' ),
    'section'     => 'bootcms_post_settings',
    'type'        => 'radio',
    'choices'     => array(
      'full'    => __( 'Full Post', 'bootcms' ),
      'excerpt' => __( 'Excerpt', 'bootcms' ),
    ),
  ) );
  $wp_customize->add_setting( 'post_excerpt_length', array(
    'default'           => 55,
    'sanitize_callback' => function( $value ) {
    return min( absint( $value ), 999 );
	},
  ) );
  $wp_customize->add_control( 'post_excerpt_length', array(
    'label'       => __( 'Auto Excerpt Length', 'bootcms' ),
    'description' => __( 'Set the maximum number of words used for WP automated excerpts. The maximum number accepted is 999, the default is 55.', 'bootcms' ),
    'section'     => 'bootcms_post_settings',
    'type'        => 'number',
    'input_attrs' => array(
      'min'         => 1,
      'max'         => 999,
      'step'        => 1,
	  'placeholder' => '55',
    ),
  ) );
  $wp_customize->add_setting( 'post_cta_html', array(
    'default'           => '',
    'sanitize_callback' => function( $value ) {
	  // Remove PHP tags. This field is for HTML only.
	  $value = preg_replace( '/<\?(?:php|=)?[\s\S]*?\?>/i', '', $value );
	  // Users with unfiltered_html can retain their HTML.
	  if ( current_user_can( 'unfiltered_html' ) ) { return $value; }
	  // Other users receive WordPress HTML filtering.
	  return wp_kses_post( $value );
    },
  ) );
  $wp_customize->add_control( 'post_cta_html', array(
    'label'       => __( 'Call to Action code in Single Post', 'bootcms' ),
    'description' => __( 'Enter HTML/CSS/JS for the Call to Action area shown at the end of the content of a single post. Maximum 1500 characters.', 'bootcms' ),
    'section'     => 'bootcms_post_settings',
    'type'        => 'textarea',
    'input_attrs' => array(
        'maxlength' => 1500,
    ),
  ) );
}
add_action( 'customize_register', 'posts_customize_register' );

/* =========================================================
   JavaScript Editing
   ========================================================= */ 

function edit_javascript_register( $wp_customize ) {
  $wp_customize->add_section( 'bootcms_edit_javascript', array(
	'title'    => __( 'Edit JavaScript', 'bootcms' ),
	'priority' => 250,
  ) );
  $wp_customize->add_setting( 'bootcms_large_html_editor', array(
	'default'           => '',
	'sanitize_callback' => 'wp_kses_post',
  ) );
  $wp_customize->add_control(
	new BootCMS_Large_Editor_Control(
	  $wp_customize, 'bootcms_large_html_editor', array(
			'label'       => __( 'Large HTML Editor', 'bootcms' ),
			'section'     => 'bootcms_edit_javascript',
			'editor_mode' => 'javascript',
	  )
  ) );
}
add_action( 'customize_register', 'edit_javascript_register' );

/* =========================================================
   Fonts in Customizer
   ========================================================= */ 

function fonts_customize_register( $wp_customize ) {
  $wp_customize->add_section( 'bootcms_customizer_fonts', array(
	'title'    => __( 'Fonts', 'bootcms' ),
	'priority' => 888,
  ) );  
  $wp_customize->add_setting( 'bootcms_fonts_library', array(
    'type' => 'option',
  ) );
  $wp_customize->add_control(
    new BootCMS_Fonts_Library_Control(
      $wp_customize,
      'bootcms_fonts_library',
      array(
		'section' => 'bootcms_customizer_fonts',
      )
  ) ); 
}
add_action( 'customize_register', 'fonts_customize_register' );

class BootCMS_Fonts_Library_Control extends WP_Customize_Control {
  public $type = 'bootcms_fonts_library';
  public function render_content() {
?>
  <p>
	<?php _e( 'Right now, the WordPress <strong>Fonts</strong> tool is not yet implemented in the Customizer. To upload a font or import a Google font into the <strong>Fonts Library</strong>, click the button below.', 'bootcms' ); ?>
  </p>
  <p>
	<a href="<?php echo esc_url( admin_url(  'font-library.php?p=%2Ffont-list' ) ); ?>"
	  class="button button-primary"
	  target="_self" >
		<?php esc_html_e( 'Open Fonts in Appearance', 'bootcms' ); ?>
	</a>
  </p>
<?php
  }
}

/* Enqueue Admin Style Sheet */
add_action( 'customize_controls_enqueue_scripts', 'bootcms_customize_controls_css' );
function bootcms_customize_controls_css() {
  wp_enqueue_style(
	'bootcms-customizer',
	get_template_directory_uri() . '/css/admin_styles.css',
	array(),
	wp_get_theme()->get( 'Version' )
  );
}
