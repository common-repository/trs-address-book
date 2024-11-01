<style>
#footercopyright-description {
    position: absolute;
    top: 320px;
}
</style>
<?php
/**
 * Create the section beneath the Shipping tab
 **/
add_filter( 'woocommerce_get_sections_shipping', 'trs_address_add_section' );
function trs_address_add_section( $sections ) {
	
	$sections['wooaddress_limit'] = __( 'Addresses', 'woocommerce-addresses' );
	return $sections;
}

/**
 * Add settings to the specific section we created before
 */
add_filter( 'woocommerce_get_settings_shipping', 'trs_address_all_settings', 10, 2 );
function trs_address_all_settings( $settings, $current_section ) {
	
	/**
	* Get Saved value from option table
	**/
	$saved_option_value = esc_attr( get_option( 'wcaddress_field' ) );
	
	/**
	 * Check the current section is what we want
	 **/
	if ( $current_section == 'wooaddress_limit' ) {
		$settings_slider = array();
		
	// Add Title to the Settings
		$settings_slider[] = array( 'name' => __( 'TRS Address Settings', 'woocommerce-addresses' ), 'type' => 'title', 'desc' => __( 'Maximum numbers of address that customer can save', 'woocommerce-addresses' ), 'id' => 'wcaddress' );
		
	// Add Text field option
		$settings_slider[] = array(
			'name'     => __( 'Number of Addresses', 'woocommerce-addresses' ),
			'desc_tip' => __( 'Enter Value that customer can store maximum number of address', 'woocommerce-addresses' ),
			'id'       => 'wcaddress_field',
			'type'     => 'text',
			'value'    => isset($saved_option_value) ? $saved_option_value : ' '
		);
		
		$settings_slider[] = array( 'type' => 'sectionend', 'id' => 'wooaddress_limit' );
		
		$settings_slider[] = array( 'name' => __( ' ' ), 'type' => 'title', 'desc' => __( ' © 2022 All rights reserved. Developed by <a href="https://therightsw.com/" target="_blank">The Right Software</a>', 'woocommerce-addresses' ), 'id' => 'footercopyright' );
		return $settings_slider;
	/**
	 * If not, return the standard settings
	 **/
	} else {

		return $settings;
	}
}