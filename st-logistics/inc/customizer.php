<?php
/**
 * ST Logistics Theme Customizer
 */

/**
 * Register customizer settings.
 */
function st_logistics_customize_register( $wp_customize ) {

	/* =========================================================
	   Loader Section
	========================================================= */
	$wp_customize->add_section( 'st_logistics_loader_section', array(
		'title'    => esc_html__( 'Loader Settings', 'st-logistics' ),
		'priority' => 30,
	) );

	// Setting: Loader Background Color
	$wp_customize->add_setting( 'st_logistics_loader_bg_color', array(
		'default'           => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'st_logistics_loader_bg_color',
		array(
			'label'   => esc_html__( 'Loader Background Color', 'st-logistics' ),
			'section' => 'st_logistics_loader_section',
		)
	) );

	// Setting: Loader Image
	$wp_customize->add_setting( 'st_logistics_loader_image', array(
		'default'           => get_template_directory_uri() . '/assets/img/loader-logo.webp',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize,
		'st_logistics_loader_image',
		array(
			'label'   => esc_html__( 'Loader Image', 'st-logistics' ),
			'section' => 'st_logistics_loader_section',
		)
	) );
}
add_action( 'customize_register', 'st_logistics_customize_register' );


/**
 * Output dynamic loader CSS based on customizer values.
 */
function st_logistics_loader_customizer_css() {
	$bg_color = get_theme_mod( 'st_logistics_loader_bg_color', '#ffffff' );
	$bg_color = sanitize_hex_color( $bg_color );
	?>
	<style>
		#st-logistics-loader-container {
			background: <?php echo esc_attr( $bg_color ); ?>;
		}
	</style>
	<?php
}
add_action( 'wp_head', 'st_logistics_loader_customizer_css' );
