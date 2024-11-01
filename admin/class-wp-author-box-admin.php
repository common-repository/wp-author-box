<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://ptheme.com/
 * @since      1.0.0
 *
 * @package    Wp_Author_Box
 * @subpackage Wp_Author_Box/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Author_Box
 * @subpackage Wp_Author_Box/admin
 * @author     Leo <newbiesup@gmail.com>
 */
class Wp_Author_Box_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * change user contact methods
	 *
	 * @since    1.0.0
	 */
	public function WPAB_change_user_contact_information( $fields ){
	    // unset($fields['aim']);
	    // unset($fields['yim']);
	    // unset($fields['jabber']);

	    $fields['twitter'] = __('Twitter Username', $this->plugin_name);
	    $fields['facebook'] = __('Facebook URL', $this->plugin_name);
	    $fields['googleplus'] = __('Google+ URL', $this->plugin_name);

	    return $fields;
	}

	/**
	 * Register customizer options for our plugin.
	 *
	 * @since    1.0.0
	 */
	public function WPAB_customize_register( $wp_customize ) {

		// Add WP Author Box customizer section.
		$wp_customize->add_section( 'Wp_Author_Box', array(
			'title'           => __( 'WP Author Box', $this->plugin_name ),
			'description'     => __( 'From here you can configure the settings of our WP Author Box.', $this->plugin_name ),
			'priority'        => 130,
		) );

		// Add WP Sticky Menu settings and controls.
		$wp_customize->add_setting( 'wpab_background', array(
			'default'           => '#E9E9E9',
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' 		=> 'postMessage',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wpab_background', array(
			'label'       => __( 'Background Color', $this->plugin_name ),
			'description' => __( 'Pick the background color of the Tabs heading. Default: #E9E9E9', $this->plugin_name ),
			'section'     => 'Wp_Author_Box',
		) ) );

		$wp_customize->add_setting( 'wpab_background_hover', array(
			'default'           => '#41A62A',
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' 		=> 'postMessage',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wpab_background_hover', array(
			'label'       => __( 'Hover Background Color', $this->plugin_name ),
			'description' => __( 'Pick the hover background color of the Tabs heading. Default: #41A62A', $this->plugin_name ),
			'section'     => 'Wp_Author_Box',
		) ) );

		$wp_customize->add_setting( 'wpab_font_color', array(
			'default'           => '#333333',
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' 		=> 'postMessage',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wpab_font_color', array(
			'label'       => __( 'Font Color', $this->plugin_name ),
			'description' => __( 'Pick the font color of the Tabs heading. Default: #333333', $this->plugin_name ),
			'section'     => 'Wp_Author_Box',
		) ) );

		$wp_customize->add_setting( 'wpab_font_color_hover', array(
			'default'           => '#ffffff',
			'type' 				=> 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' 		=> 'postMessage',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wpab_font_color_hover', array(
			'label'       => __( 'Font Hover Color', $this->plugin_name ),
			'description' => __( 'Pick the font  hover color of the Tabs heading. Default: #ffffff', $this->plugin_name ),
			'section'     => 'Wp_Author_Box',
		) ) );

	}

	/**
	 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
	 *
	 * @since    1.0.0
	 */
	public function WPAB_customize_preview_js() {

		wp_enqueue_script( $this->plugin_name . '-customize-preview', plugin_dir_url( __FILE__ ) . 'js/customize-preview.js', array( 'customize-preview' ), $this->version, false );

	}

}
