<?php

/**
 * @usage function to display Addons bundle sub menu
 */

add_action( 'admin_menu', 'wpcs_register_bundle_submenu', 999 );
/**
 * Adds a submenu page under a custom post type parent.
 */
function wpcs_register_bundle_submenu() {
	
	add_submenu_page(
		'edit.php?post_type=wpcs',
		__( 'Add-Ons Bundle', 'wpcs' ),
		__( 'Add-Ons Bundle', 'wpcs' ),
		'manage_options',
		//'wpcs-add-ons-bundle',
		'https://goo.gl/Nf7T1M'
	);
}