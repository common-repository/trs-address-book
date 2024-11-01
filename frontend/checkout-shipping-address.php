<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
add_action( 'woocommerce_before_checkout_shipping_form', 'checkout_shipping_address' );
function checkout_shipping_address(){
	$user_id = get_current_user_id();
  
   if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
   
    
   trs_woo_address_fields_data(); 
	}
}
add_filter( 'woocommerce_checkout_fields' , 'custom_remove_woo_checkout_fields' );
 
function custom_remove_woo_checkout_fields( $fields ) {
   
    // remove shipping fields 
    unset($fields['shipping']['shipping_first_name']);    
    unset($fields['shipping']['shipping_last_name']);  
    unset($fields['shipping']['shipping_company']);
    unset($fields['shipping']['shipping_address_1']);
    unset($fields['shipping']['shipping_address_2']);
    unset($fields['shipping']['shipping_city']);
    unset($fields['shipping']['shipping_postcode']);
    unset($fields['shipping']['shipping_country']);
    unset($fields['shipping']['shipping_state']);
      
    return $fields;
}
