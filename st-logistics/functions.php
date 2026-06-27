<?php

/*
** Sets up theme defaults and registers support for various WordPress features
*/

require_once get_template_directory() . '/inc/customizer.php';

define('IS_ST_FREEMIUM', 'st-logistics');

function st_logistics_demo_importer_setup() {
		
	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title for us
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages
	add_theme_support( 'post-thumbnails' );

	// Custom Logo
	add_theme_support( 'custom-logo', [
		'height'      => 100,
		'width'       => 350,
		'flex-height' => true,
		'flex-width'  => true,
	] );

	// Custom Header
	add_theme_support( 'custom-header', array(
		'default-image'          => '',
		'default-text-color'     => '#161921',
		'width'                  => 1920,
		'height'                 => 1080,
		'flex-width'             => true,
		'flex-height'            => true,
		'wp-head-callback'       => 'st_logistics_header_style', // Callback for styling
	) );

	// Add theme support for Custom Background.
	add_theme_support( 'custom-background', ['default-color' => 'f5f7fb'] );

	// Set the default content width.
	$GLOBALS['content_width'] = 960;

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary', 'st-logistics' ),
		)
	);

	// Switch default core markup for search form, comment form, and comments to output valid HTML5
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Gutenberg Embeds
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );

	// Gutenberg Widget Images
	add_theme_support( 'align-wide' );

	// WooCommerce in general.
	add_theme_support( 'woocommerce' );

	// Zoom.
	add_theme_support( 'wc-product-gallery-zoom' );
	// Lightbox.
	add_theme_support( 'wc-product-gallery-lightbox' );
	// Swipe.
	add_theme_support( 'wc-product-gallery-slider' );

	add_editor_style( array( '/assets/css/editor-style.css' ) );

	// Widget support
	add_theme_support( 'widgets' );

	// Block-based widget editor (optional: disable to keep classic widgets UI)
	add_theme_support( 'widgets-block-editor' );
}

add_action( 'after_setup_theme', 'st_logistics_demo_importer_setup' );

/*
** Enqueue scripts and styles
*/
function st_logistics_demo_importer_scripts() {

	// Theme Stylesheet
	wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/assets/css/bootstrap.css', array(), '4.5.0' );

	// Remove prefix from Font Awesome
	wp_enqueue_style(
		'fontawesome-css', // Corrected handle
		get_template_directory_uri() . '/assets/css/fontawesome-all.css',
		array(),
		'4.5.0'
	);
	
	wp_enqueue_style( 'st-logistics-style', get_stylesheet_uri(), array(), '1.0' );

	// Comment reply link
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	wp_enqueue_script('st-logistics-custom-script', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), '1.0', true);

	wp_enqueue_script('st-logistics-navigation', get_template_directory_uri() . '/assets/js/navigation.js', false, '1.0', true );

	wp_enqueue_script( 'st-logistics-search-toggle', get_template_directory_uri() . '/assets/js/search-toggle.js', array(), '1.0', true );
	wp_localize_script( 'st-logistics-search-toggle', 'stSearchToggle', array(
		'closeLabel' => esc_js( __( 'Close search', 'st-logistics' ) ),
	) );
}
add_action( 'wp_enqueue_scripts', 'st_logistics_demo_importer_scripts' );

/*
** Register widget areas including 4 footer widget columns
*/
function st_logistics_widgets_init() {

	// Main Sidebar
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'st-logistics' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here to appear in the main sidebar.', 'st-logistics' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title title">',
			'after_title'   => '</h4>',
		)
	);

	// Page Sidebar
	register_sidebar(
		array(
			'name'          => esc_html__( 'Page Sidebar', 'st-logistics' ),
			'id'            => 'sidebar-2',
			'description'   => esc_html__( 'Add widgets here to appear in the page sidebar.', 'st-logistics' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title title">',
			'after_title'   => '</h4>',
		)
	);

	// Sidebar Three
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar three', 'st-logistics' ),
			'id'            => 'sidebar-3',
			'description'   => esc_html__( 'Add widgets here to appear in the third sidebar area.', 'st-logistics' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title title">',
			'after_title'   => '</h4>',
		)
	);

	// Footer Widget Area 1
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Widget Area 1', 'st-logistics' ),
			'id'            => 'footer1-sidebar',
			'description'   => esc_html__( 'Add widgets here to appear in footer column 1.', 'st-logistics' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title title">',
			'after_title'   => '</h4>',
		)
	);

	// Footer Widget Area 2
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Widget Area 2', 'st-logistics' ),
			'id'            => 'footer2-sidebar',
			'description'   => esc_html__( 'Add widgets here to appear in footer column 2.', 'st-logistics' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title title">',
			'after_title'   => '</h4>',
		)
	);

	// Footer Widget Area 3
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Widget Area 3', 'st-logistics' ),
			'id'            => 'footer3-sidebar',
			'description'   => esc_html__( 'Add widgets here to appear in footer column 3.', 'st-logistics' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title title">',
			'after_title'   => '</h4>',
		)
	);

	// Footer Widget Area 4
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Widget Area 4', 'st-logistics' ),
			'id'            => 'footer4-sidebar',
			'description'   => esc_html__( 'Add widgets here to appear in footer column 4.', 'st-logistics' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title title">',
			'after_title'   => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'st_logistics_widgets_init' );

function st_logistics_enqueue_admin_script() {
    // Enqueue the custom admin script
    wp_enqueue_script('st-logistics-custom-admin-script', get_template_directory_uri() . '/assets/js/custom-admin-script.js', array('jquery'), '1.0', true);
}
add_action('admin_enqueue_scripts', 'st_logistics_enqueue_admin_script');

/*
** Notices
*/
require_once get_parent_theme_file_path( '/inc/activation/class-welcome-notice.php' );
require_once get_parent_theme_file_path( '/inc/activation/class-rating-notice.php' );

add_action( 'after_switch_theme', 'st_logistics_activation_time');
add_action('after_setup_theme', 'st_logistics_activation_time');
    
function st_logistics_activation_time() {
	if ( false === get_option( 'st_logistics_activation_time' ) ) {
		add_option( 'st_logistics_activation_time', strtotime('now') );
	}
}

function st_logistics_custom_loader(){
	$loader_image = get_theme_mod( 'st_logistics_loader_image', get_template_directory_uri() . '/assets/img/loader-logo.webp' );
?>
    <div id="st-logistics-loader-container">
        <?php if ( $loader_image ) : ?>
            <img src="<?php echo esc_url( $loader_image ); ?>" alt="<?php esc_attr_e( 'Loading', 'st-logistics' ); ?>" id="st-logistics-loader-img" />
        <?php else : ?>
            <div id="st-logistics-custom-loader"></div>
        <?php endif; ?>
    </div>
<?php
}
add_action('wp_head', 'st_logistics_custom_loader');

/*
** Additions for Header Text Color and Header Image
*/

/**
 * Custom styles for Header Text Color.
 */
function st_logistics_header_style() {
    $st_logistics_header_text_color = get_header_textcolor();

    // Get the default header text color defined in the theme support array.
    $st_logistics_default_header_text_color = get_theme_support( 'custom-header', 'default-text-color' );

    // Exit if default header text color is being used.
    if ( $st_logistics_header_text_color === $st_logistics_default_header_text_color ) {
        return;
    }

    // Custom CSS for header text color.
    ?>
    <style type="text/css">
        <?php if ( ! display_header_text() ) : ?>
            .site-title,
            .site-description {
                display: none;
            }
        <?php else : ?>
            .site-title a,
            .site-description {
                color: #<?php echo esc_attr( $st_logistics_header_text_color ); ?>;
            }
        <?php endif; ?>
    </style>
    <?php
}




/* =============================================================================
   ST Logistics – header Topbar Customizer Options
   ============================================================================= */
