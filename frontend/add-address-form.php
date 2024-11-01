<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
function trs_add_addres_book_form(){
	$fields  = wc()->countries->get_address_fields( wc()->countries->get_base_country(),'shipping_');
?>
	<div class="add-shipping-address-form">
<?php			
	foreach ( $fields as $key => $field ) {
		if ($key != 'shipping_email') {
			woocommerce_form_field( $key, $field );
		}
	}
?>
		<div class="btn-div">
		<input type="submit" name="trs_add_address" class="addres-btn">	
		</div>
		</div>
<?php
	 }