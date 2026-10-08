<?php
/**
 * WordPress classic theme
 * bootcms-help/help.php 
 * @link https://github/...
 * @package bootcms
 * @since bootcms 2.0
 */
defined( 'ABSPATH' ) || exit; // Exit if accessed directly 
/* ========================================================
   Help Documents for Customizer
   ========================================================= */  
/*
Getting Started
Theme & Appearance
Simple Styles
Header & Logo
Navigation & Menus
Frameworks
Widgets
Custom HTML
Additional CSS
Troubleshooting
*/
// Create the section
function help_docs_customize_register( $wp_customize ) {
  $wp_customize->add_section( 'help_documents', array(
	'title'    => __( 'Help', 'bootcms' ),
	'priority' => 999,
  ) );
// ------------- 
  $wp_customize->add_setting( 'getting_started_help', array(
	'default'           => '',
	'sanitize_callback' => 'esc_url_raw',
  ) );
  $wp_customize->add_control( 'getting_started_help', array(
    'type'        => 'hidden',
    'section'     => 'help_documents',
    'label'       => __( 'Choose a Topic', 'bootcms' ),
    'description' => '<a href="' .
        esc_url( get_template_directory_uri() . '/bootcms-help/getting-started.html' ) .
        '" class="help-links" target="_blank" >' .
        esc_html__( 'Getting Started', 'bootcms' ) .
        '</a>',
  ) );	
  $wp_customize->add_setting( 'features_scaffolding_help', array(
	'default'           => '',
	'sanitize_callback' => 'esc_url_raw',
  ) );
  $wp_customize->add_control( 'features_scaffolding_help', array(
    'type'        => 'hidden',
    'section'     => 'help_documents',
    'description' => '<a href="' .
        esc_url( get_template_directory_uri() . '/bootcms-help/features-scaffolding.html' ) .
        '" class="help-links" target="_blank">' .
        esc_html__( 'Features & Scaffolding', 'bootcms' ) .
        '</a>',
  ) );
  $wp_customize->add_setting( 'site_identity_help', array(
	'default'           => '',
	'sanitize_callback' => 'esc_url_raw',
  ) );
  $wp_customize->add_control( 'site_identity_help', array(
    'type'        => 'hidden',
    'section'     => 'help_documents',
    'description' => '<a href="' .
        esc_url( get_template_directory_uri() . '/bootcms-help/site-identity.html' ) .
        '" class="help-links" target="_blank">' .
        esc_html__( 'Site Identity', 'bootcms' ) .
        '</a>',
  ) );  
  $wp_customize->add_setting( 'global_styles_help', array(
	'default'           => '',
	'sanitize_callback' => 'esc_url_raw',
  ) );
  $wp_customize->add_control( 'global_styles_help', array(
    'type'        => 'hidden',
    'section'     => 'help_documents',
    'description' => '<a href="' .
        esc_url( get_template_directory_uri() . '/bootcms-help/global-styles.html' ) .
        '" class="help-links" target="_blank">' .
        esc_html__( 'Simple Styles Global', 'bootcms' ) .
        '</a>',
  ) );  
  $wp_customize->add_setting( 'bootcms_styles_help', array(
	'default'           => '',
	'sanitize_callback' => 'esc_url_raw',
  ) );
  $wp_customize->add_control( 'bootcms_styles_help', array(
    'type'        => 'hidden',
    'section'     => 'help_documents',
    'description' => '<a href="' .
        esc_url( get_template_directory_uri() . '/bootcms-help/bootcms-styles.html' ) .
        '" class="help-links" target="_blank">' .
        esc_html__( 'Simple Styles BootCMS', 'bootcms' ) .
        '</a>',
  ) );	
  $wp_customize->add_setting( 'advanced_settings_help', array(
	'default'           => '',
	'sanitize_callback' => 'esc_url_raw',
  ) );
  $wp_customize->add_control( 'advanced_settings_help', array(
    'type'        => 'hidden',
    'section'     => 'help_documents',
    'description' => '<a href="' .
        esc_url( get_template_directory_uri() . '/bootcms-help/advanced_settings.html' ) .
        '" class="help-links" target="_blank">' .
        esc_html__( 'Advanced Settings', 'bootcms' ) .
        '</a>',
  ) );
  $wp_customize->add_setting( 'post_settings_help', array(
	'default'           => '',
	'sanitize_callback' => 'esc_url_raw',
  ) );
  $wp_customize->add_control( 'post_settings_help', array(
    'type'        => 'hidden',
    'section'     => 'help_documents',
    'description' => '<a href="' .
        esc_url( get_template_directory_uri() . '/bootcms-help/post-settings.html' ) .
        '" class="help-links" target="_blank">' .
        esc_html__( 'Post Settings', 'bootcms' ) .
        '</a>',
  ) );
  $wp_customize->add_setting( 'the_menus_help', array(
	'default'           => '',
	'sanitize_callback' => 'esc_url_raw',
  ) );
  $wp_customize->add_control( 'the_menus_help', array(
    'type'        => 'hidden',
    'section'     => 'help_documents',
    'description' => '<a href="' .
        esc_url( get_template_directory_uri() . '/bootcms-help/menus.html' ) .
        '" class="help-links" target="_blank">' .
        esc_html__( 'Menus', 'bootcms' ) .
        '</a>',
  ) );
  $wp_customize->add_setting( 'the_widgets_help', array(
	'default'           => '',
	'sanitize_callback' => 'esc_url_raw',
  ) );
  $wp_customize->add_control( 'the_widgets_help', array(
    'type'        => 'hidden',
    'section'     => 'help_documents',
    'description' => '<a href="' .
        esc_url( get_template_directory_uri() . '/bootcms-help/widgets.html' ) .
        '" class="help-links" target="_blank">' .
        esc_html__( 'Widgets', 'bootcms' ) .
        '</a>',
  ) );
  $wp_customize->add_setting( 'homepage_settings_help', array(
	'default'           => '',
	'sanitize_callback' => 'esc_url_raw',
  ) );
  $wp_customize->add_control( 'homepage_settings_help', array(
    'type'        => 'hidden',
    'section'     => 'help_documents',
    'description' => '<a href="' .
        esc_url( get_template_directory_uri() . '/bootcms-help/homepage_settings.html' ) .
        '" class="help-links" target="_blank">' .
        esc_html__( 'Homepage Settings', 'bootcms' ) .
        '</a>',
  ) );
  $wp_customize->add_setting( 'additional_css_help', array(
	'default'           => '',
	'sanitize_callback' => 'esc_url_raw',
  ) );
  $wp_customize->add_control( 'additional_css_help', array(
    'type'        => 'hidden',
    'section'     => 'help_documents',
    'description' => '<a href="' .
        esc_url( get_template_directory_uri() . '/bootcms-help/additional-css.html' ) .
        '" class="help-links" target="_blank">' .
        esc_html__( 'Additional CSS', 'bootcms' ) .
        '</a>',
  ) ); 
  $wp_customize->add_setting( 'large_editor_help', array(
	'default'           => '',
	'sanitize_callback' => 'esc_url_raw',
  ) );
  $wp_customize->add_control( 'large_editor_help', array(
    'type'        => 'hidden',
    'section'     => 'help_documents',
    'description' => '<a href="' .
        esc_url( get_template_directory_uri() . '/bootcms-help/large-html-editor.html' ) .
        '" class="help-links" target="_blank">' .
        esc_html__( 'Large HTML Editor', 'bootcms' ) .
        '</a>',
  ) );  
}
add_action( 'customize_register', 'help_docs_customize_register' );

// send direct URL requests to the help files, to the real path
add_action( 'template_redirect', function() {
  $request = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );
  $position = strpos( $request, 'bootcms-help/' );
  if ( $position !== false ) {
	$requested_file = substr(
	  $request,
	  $position + strlen( 'bootcms-help/' )
	);
	wp_safe_redirect(
	  get_template_directory_uri()
	  . '/bootcms-help/'
	  . $requested_file,
	  302
	);
	exit;
  }
} );