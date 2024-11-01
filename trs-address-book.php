<?php
/**
 * Plugin Name:    TRS Address Book
 * Description:     Allow customers to save multiple addresses that are used when placing an order.
 * Author:          The Right Software
 * Author URI: 		https://therightsw.com/plugin-development/
 * Text Domain:     trs-address-book
 * Domain Path:     /languages
 * Version:         1.0.2
 * WC tested up to: 6.2.1
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
function trs_woo_address_book_enqueue_script() {   
	wp_enqueue_style( 'woo-address-style', plugin_dir_url( __FILE__ ) . 'assets/css/address-style.css' );
	
	wp_enqueue_script( 'jQuery', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.js', true	 );
	
	wp_enqueue_script( 'main-js', plugin_dir_url( __FILE__ ) . 'assets/js/main.js', true	 );
	
}
add_action('wp_enqueue_scripts', 'trs_woo_address_book_enqueue_script');


include( plugin_dir_path( __FILE__ ) . 'admin/admin_field.php');

include( plugin_dir_path( __FILE__ ) . 'frontend/show_address.php');

include( plugin_dir_path( __FILE__ ) . 'frontend/add-address-form.php');

include( plugin_dir_path( __FILE__ ) . 'frontend/display_woo_field_data.php');

include( plugin_dir_path( __FILE__ ) . 'frontend/edit-address-form.php');

include( plugin_dir_path( __FILE__ ) . 'frontend/checkout-shipping-address.php');

include( plugin_dir_path( __FILE__ ) . 'function.php');