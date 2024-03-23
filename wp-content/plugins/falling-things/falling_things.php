<?php

/*

Plugin Name: Falling things
Plugin URI: 
Version: 1.07
Description: Falling leafs, snowflakes, flowers or wathever you want :)
Author: Manu225
Author URI: 
Network: false
Text Domain: falling-things
Domain Path:
*/



register_activation_hook( __FILE__, 'falling_things_install' );
register_uninstall_hook(__FILE__, 'falling_things_desinstall');

function falling_things_install() {

	//ajoute les options de config
	add_option( 'falling_items_quantity', 50 );
	add_option( 'falling_items_speed', 2 );
	add_option( 'falling_items_move_lr', true );
	add_option( 'falling_items_display_on', '' );

	global $wpdb;

	$failling_images_table = $wpdb->prefix . "failling_images";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

	$sql = "
        CREATE TABLE `".$failling_images_table."` (
          id int(11) NOT NULL AUTO_INCREMENT,
          image varchar(500) NOT NULL,
          active int(1) NOT NULL,
          PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
    ";

    dbDelta($sql);

    $query = "TRUNCATE TABLE ".$failling_images_table;
    $wpdb->query($query );

    //insère les images de bases
    $query = "INSERT INTO ".$failling_images_table." (`image`, `active`)
    VALUES (%s, %d), (%s, %d), (%s, %d)";
    $query = $wpdb->prepare($query , plugins_url( 'images/leaf.png', __FILE__ ), 1, 
    plugins_url( 'images/snowflake.png', __FILE__ ), 0, plugins_url( 'images/flower.png', __FILE__ ), 0);
    $wpdb->query($query );

}

function falling_things_desinstall() {

	//suppression des options
	delete_option( 'falling_items_quantity' );
	delete_option( 'falling_items_speed' );
	delete_option( 'falling_items_move_lr' );
	delete_option( 'falling_items_display_on' );

	global $wpdb;

	$failling_images_table = $wpdb->prefix . "failling_images";

	//vidage de la table
	$sql = "TRUNCATE TABLE ".$failling_images_table.";";
	$wpdb->query($sql);

	//suppression de la table
	$sql = "DROP TABLE ".$failling_images_table.";";
	$wpdb->query($sql);

}

add_action( 'admin_menu', 'register_falling_things_menu' );
function register_falling_things_menu() {
	add_submenu_page( 'options-general.php', 'Falling things settings', 'Falling things settings', 'edit_pages', 'falling_things_settings', 'falling_things_settings');
}

add_action('admin_print_styles', 'admin_falling_things_css' );
function admin_falling_things_css() {
    wp_enqueue_style( 'LEAFSCSS', plugins_url('css/admin.css', __FILE__) );
}

add_action( 'admin_enqueue_scripts', 'admin_falling_things_script' );
function admin_falling_things_script() {
    //wp_enqueue_script( 'wp-media');
     wp_enqueue_media();
}

function falling_things_settings() {
	//formulaire soumis ?
	if(sizeof($_POST))
	{
		check_admin_referer( 'leafs_settings' );
		$quantity = (int)$_POST['quantity'];
		$speed = (int)$_POST['speed'];
		$move_lr = ($_POST['move_lr'] == 1 ? true : false);
		$display_on = (int)$_POST['display_on'];
		if($quantity < 1)
			$quantity = 1;
		else if($quantity > 100)
			$quantity = 100;
		if($speed < 1)
			$speed = 1;
		else if($speed > 5)
			$speed = 5;
		update_option('falling_items_quantity', $quantity);
		update_option('falling_items_speed', $speed);
		update_option('falling_items_move_lr', $move_lr);
		update_option('falling_items_display_on', $display_on);

		//image activé
		global $wpdb;
		$failling_images_table = $wpdb->prefix . "failling_images";
		$q = "UPDATE ".$failling_images_table." SET active = 0 WHERE id NOT IN (".implode(',', $_POST['images']).")";
		$images = $wpdb->get_results($q);
		$q = "UPDATE ".$failling_images_table." SET active = 1 WHERE id IN (".implode(',', $_POST['images']).")";
		$images = $wpdb->get_results($q);
	}
	else
	{
		$quantity = get_option('falling_items_quantity');
		$speed = get_option('falling_items_speed');
		$move_lr = get_option('falling_items_move_lr');
		$display_on = get_option('falling_items_display_on');
	}

	global $wpdb;
	$failling_images_table = $wpdb->prefix . "failling_images";
	$q = "SELECT * FROM ".$failling_images_table;
	$images = $wpdb->get_results($q);

	include(plugin_dir_path( __FILE__ ) . 'views/settings.php');
}

add_action( 'wp_head', 'head_falling_things' );
function head_falling_things()
{
	$display_on = get_option('falling_items_display_on');

	//echo $display_on;

	$current_page = get_queried_object();

	if($display_on == 0 || $display_on == $current_page->ID)
	{
		wp_enqueue_style( 'FALLINGTHINGSFRONTCSS', plugins_url('css/front.css', __FILE__) );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-effects-core');

		// Register the script
		wp_register_script( 'FALLINGTHINGSFRONTJS', plugins_url( 'js/front.js', __FILE__ ) );

		//récupère les images active
		global $wpdb;
		$failling_images_table = $wpdb->prefix . "failling_images";
		$q = "SELECT * FROM ".$failling_images_table." WHERE active=1";
		$images = $wpdb->get_results($q);

		// Localize the script with new data
		$settings = array(
			'leaf_image' => plugins_url('images/leaf.png', __FILE__),
			'quantity' => (int)get_option('falling_items_quantity'),
			'speed' => (int)get_option('falling_items_speed'),
			'move_lr' => get_option('falling_items_move_lr'),
			'images' => $images
		);
		wp_localize_script( 'FALLINGTHINGSFRONTJS', 'settings_ft', $settings );
		wp_enqueue_script( 'FALLINGTHINGSFRONTJS');
	}
}

//Ajax : suppression d'un flipping card
add_action( 'wp_ajax_falling_image_add', 'falling_image_add' );
function falling_image_add()
{
	check_ajax_referer( 'falling_image_add' );

	if (current_user_can('edit_pages') && isset($_POST['image'])) {

		global $wpdb;
		$failling_images_table = $wpdb->prefix . "failling_images";
		$q = "INSERT INTO ".$failling_images_table." (`image`, `active`) VALUES (%s, %d)";
		$q = $wpdb->prepare($q, $_POST['image'], 0);
		$wpdb->query($q);
		echo $wpdb->insert_id;

	}

	wp_die();
}