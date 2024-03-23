<?php
/*
	Plugin Name: WP Contact Slider
	Plugin URI:	https://wpcontactslider.com/
	Description: Simple Contact Slider to display Contact Form 7, Gravity Forms, some other shortcodes and dispaly random Text or HTML.
	Author: wpexpertsio
	Author URI: https://wpcontactslider.com/
	Tested up to: 6.3.1
	Version: 2.4.10
*/

if ( is_admin() ) {

	// To display admin notice
	require_once 'inc/wpcs_update_notice.php';

}
$data = ! isset( $_POST['_wpcs_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpcs_nonce'] ) ), '_wpcs_nonce' ) ? $_REQUEST : '';

if ( ( isset( $data['post_type'] ) && 'wpcs' === $data['post_type'] ) || ( isset( $data['post'] ) && 'wpcs' === get_post_type( $data['post'] ) ) || ( isset( $data['wpcs_lable_text_color'] ) || ( isset( $data['action'] ) && 'trash' === $data['action'] ) ) ) { // checking

	// For meta-box support
	if ( is_admin() && ! class_exists( 'RW_Meta_Box' ) ) {
		require_once 'inc/meta-box/meta-box.php';
	}

	// Declaring Meta fields
	require_once 'inc/wpcs_meta_fields.php';

}

// For admin functions support
require_once 'inc/wpcs_admin_functions.php';

// For slider related functions
require_once 'inc/wpcs_slider.php';

// To call front end functions
require_once 'inc/wpcs_frontend_functions.php';

// Get CSS
require_once 'inc/wpcs_enque_styles.php';

// Get Scripts
require_once 'inc/wpcs_enque_scripts.php';

// Add-ons bundle sub menu
require_once 'inc/wpcs_bundle_menu.php';

register_deactivation_hook( __FILE__, 'wpcs_deactivate' );
/**
 * @usage to avoid error after migration
 */
function wpcs_deactivate() {

	delete_option( 'fs_accounts' );

}

if ( ! function_exists( 'shapeSpace_allowed_html' ) ) :
	function wpcs_allowed_html() {

		$allowed_atts                = array(
			'align'      => array(),
			'class'      => array(),
			'type'       => array(),
			'id'         => array(),
			'dir'        => array(),
			'lang'       => array(),
			'style'      => array(),
			'xml:lang'   => array(),
			'src'        => array(),
			'alt'        => array(),
			'href'       => array(),
			'rel'        => array(),
			'rev'        => array(),
			'target'     => array(),
			'novalidate' => array(),
			'type'       => array(),
			'value'      => array(),
			'required'   => array(),
			'name'       => array(),
			'tabindex'   => array(),
			'action'     => array(),
			'method'     => array(),
			'for'        => array(),
			'width'      => array(),
			'height'     => array(),
			'data-editor' => array(),
			'data'     	 => array(),
			'title'      => array(),
			'value'      => array(),
			'selected'   => array(),
			'enctype'    => array(),
			'disable'    => array(),
			'disabled'   => array(),
			'noscript'   => array(),
			'checked'	 => array(),
			'autocomplete' => array(),
			'aria-label' => array(),
			'media'		 => array(),
			'data-wp-editor-id' => array(),
			'rows'		 => array(),
			'cols'		 => array(),
			'aria-hidden' => array(),
			'role'		 => array(),
			'hidefocus'	 => array(),
			'tabindex'	 => array(),
			'aria-pressed' => array(),
			'aria-disabled' => array(),
			'frameborder' => array(),
			'allowtransparency' => array(),
			'size'		 => array(),
			'data-options' => array(),
			'aria-haspopup' => array(),
			'aria-expanded' => array(),
			'aria-labelledby' => array(),
			'aria-describedby' => array(),
			'data-selected' => array(),
			'placeholder' => array(),
			'data-autosave' => array(),
			'data-object-type' => array(),
			'data-object-id' => array()
		);
		$allowed_atts = apply_filters('wpcs_allowed_atts', $allowed_atts);

		$allowedposttags['font']     = $allowed_atts;
		$allowedposttags['form']     = $allowed_atts;
		$allowedposttags['link']     = $allowed_atts;
		$allowedposttags['required'] = $allowed_atts;
		$allowedposttags['noscript'] = $allowed_atts;
		$allowedposttags['label']    = $allowed_atts;
		$allowedposttags['select']   = $allowed_atts;
		$allowedposttags['option']   = $allowed_atts;
		$allowedposttags['input']    = $allowed_atts;
		$allowedposttags['button']    = $allowed_atts;
		$allowedposttags['textarea'] = $allowed_atts;
		$allowedposttags['iframe']   = $allowed_atts;
		$allowedposttags['style']    = $allowed_atts;
		$allowedposttags['strong']   = $allowed_atts;
		$allowedposttags['small']    = $allowed_atts;
		$allowedposttags['table']    = $allowed_atts;
		$allowedposttags['span']     = $allowed_atts;
		$allowedposttags['abbr']     = $allowed_atts;
		$allowedposttags['code']     = $allowed_atts;
		$allowedposttags['pre']      = $allowed_atts;
		$allowedposttags['div']      = $allowed_atts;
		$allowedposttags['img']      = $allowed_atts;
		$allowedposttags['h1']       = $allowed_atts;
		$allowedposttags['h2']       = $allowed_atts;
		$allowedposttags['h3']       = $allowed_atts;
		$allowedposttags['h4']       = $allowed_atts;
		$allowedposttags['h5']       = $allowed_atts;
		$allowedposttags['h6']       = $allowed_atts;
		$allowedposttags['ol']       = $allowed_atts;
		$allowedposttags['ul']       = $allowed_atts;
		$allowedposttags['li']       = $allowed_atts;
		$allowedposttags['em']       = $allowed_atts;
		$allowedposttags['hr']       = $allowed_atts;
		$allowedposttags['br']       = $allowed_atts;
		$allowedposttags['tr']       = $allowed_atts;
		$allowedposttags['td']       = $allowed_atts;
		$allowedposttags['p']        = $allowed_atts;
		$allowedposttags['a']        = $allowed_atts;
		$allowedposttags['b']        = $allowed_atts;
		$allowedposttags['i']        = $allowed_atts;
		
		$allowedposttags = apply_filters('wpcs_allowed_html', $allowedposttags, $allowed_atts );		
		return $allowedposttags;
	}
endif;

/* Register activation hook. */
register_activation_hook( __FILE__, 'wpcs_admin_notice_activation_hook' );

/**
 * Runs only when the plugin is activated.
 *
 * @since 2.2
 */
function wpcs_admin_notice_activation_hook() {

	if ( get_option( 'wpcs_display_notice_2_2' ) === 'no' ) { // Here we can leave it as it is even if future - as this delay is required for only new users
		return '';
	}

	/* Create transient data */
	set_transient( 'wpcs-admin-notice-2-2-hold', true, 24 * HOUR_IN_SECONDS );

}

// Create a helper function for easy SDK access.
function wpcs_fs() {
	global $wpcs_fs;

	if ( ! isset( $wpcs_fs ) ) {
		// Include Freemius SDK.
		require_once dirname( __FILE__ ) . '/freemius/start.php';

		$wpcs_fs = fs_dynamic_init(
			array(
				'id'             => '1355',
				'slug'           => 'wp-contact-slider',
				'type'           => 'plugin',
				'public_key'     => 'pk_8c7f1aab720c6d8cbfa2c2cb0f7a0',
				'is_premium'     => false,
				'has_addons'     => true,
				'has_paid_plans' => false,
				'menu'           => array(
					'slug'    => 'edit.php?post_type=wpcs',
					'contact' => false,
				),
			)
		);
	}

	return $wpcs_fs;
}

// Init Freemius.
wpcs_fs();
// Signal that SDK was initiated.
do_action( 'wpcs_fs_loaded' );
