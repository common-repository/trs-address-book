<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
function trs_woo_address_fields_data(){
     $user_id = esc_attr(get_current_user_id());

    global $wpdb;
    global  $num_of_rows;
    $table_name = esc_attr($wpdb->usermeta);
   
    $um_id = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM $wpdb->usermeta WHERE user_id = %d AND meta_key = %s",
            esc_attr($user_id),
            "trs_shipping_address"
        )
    );

    $num_of_rows = esc_attr($wpdb->num_rows);


    $defaultAddress = esc_attr(
                get_user_meta($user_id, "trs_default_shipping_address", true)
            );      

 if( is_checkout() == false) {
?>
    <h3>Shipping Address</h3>
<?php
 }
    if (empty($um_id)) {
?>
        <p>No Address is Stored.</p>
<?php
    } else {
?>

       <div class="main-address-section my-account-address-section">
<?php
        foreach ($um_id as $key => $shippingAddresses) {
			global $woocommerce;
            $meta_value = maybe_unserialize($shippingAddresses->meta_value);
		      	$country_name = WC()->countries->countries[ $meta_value['trs_shipping_country'] ]; 
            $state = $meta_value["trs_shipping_state"];
        
$state_name = WC()->countries->get_states($meta_value['trs_shipping_country'])[$state];
?>
        <div class="checkout-label-radio-wrapper">
<?php
			 if( is_checkout() == true ) {

			if($defaultAddress == $shippingAddresses->umeta_id){
?>
		<input id="checkout-address-<?php echo esc_attr( $shippingAddresses->umeta_id );?>" type="radio" class="checkout-default-radio-btn" name="set_default_address" value="<?php echo esc_attr($shippingAddresses->umeta_id);?>" checked>
<?php
			}else{
?>
	<input id="checkout-address-<?php echo esc_attr ( $shippingAddresses->umeta_id );?>" type="radio" class="checkout-default-radio-btn" name="set_default_address" value="<?php echo esc_attr($shippingAddresses->umeta_id);?>">
<?php
			}
			 }
			 $myaccount_address_section = "myaccount-address-section";
?>
      <label for="checkout-address-<?php echo esc_attr( $shippingAddresses->umeta_id );?>">
				<div class="<?php if(is_checkout() == false){ echo esc_attr( $myaccount_address_section );}?> address-section defaultAddressBox">
<?php
	
				  if( is_checkout() == false) {
?>
            <div class="edit-area">
            <a class="addressEdit" href="?mID='<?php echo esc_attr($shippingAddresses->umeta_id);?>" data-metaid="<?php echo esc_attr($shippingAddresses->umeta_id);?>"><span class="dashicons dashicons-edit"></span></a>
<?php
					if($defaultAddress != $shippingAddresses->umeta_id) {
?>
     <a href="#" data-metaid="<?php echo esc_attr($shippingAddresses->umeta_id);?>" class="delBTN"><span class="dashicons dashicons-trash"></span></a>
<?php
  }
?>
             </div>
<?php
				  }
?>
        <div class="userMetaDAta">
<?php
            if (isset($meta_value["trs_shipping_company"])) {
?>
              <div class="formfields">
          <b>
            <?php echo esc_attr($meta_value["trs_shipping_company"]);?>
           </b>
              </div>
<?php
            }
?>
            <div class="formfields">
<?php
            if (isset($meta_value["trs_shipping_first_name"])) {
?>
             <?php echo esc_attr($meta_value["trs_shipping_first_name"]);?>&nbsp;
<?php
            }

             if (isset($meta_value["trs_shipping_last_name"])) {
?>
              <p id="lastname" class="address-data" data-lastname="<?php echo esc_attr($meta_value["trs_shipping_last_name"]);?>">
               <?php echo esc_attr($meta_value["trs_shipping_last_name"]);?>
                </p>
<?php
            }
?>
            </div>
            <div class="formfields">
<?php
            if(isset($meta_value["trs_shipping_address_1"])){
?>
            <p id="address1" class="address-data"  data-address1="<?php echo esc_attr($meta_value["trs_shipping_address_1"]);?>">
            <?php echo esc_attr($meta_value["trs_shipping_address_1"]);?>&nbsp;
              </p>
<?php
            }
            if(isset($meta_value["trs_shipping_address_2"])){
?>
             <p data-address2="<?php echo esc_attr($meta_value["trs_shipping_address_2"]);?>">
                <?php echo esc_attr($meta_value["trs_shipping_address_2"]);?>&nbsp;</p> 
<?php
            }   
             
            if(isset($meta_value["trs_shipping_city"])){      
?>
           <p data-city="<?php echo esc_attr($meta_value["trs_shipping_city"]);?>">
            <?php echo esc_attr($meta_value["trs_shipping_city"]);?>&nbsp;
             </p>
<?php
            }
            if(isset($meta_value["trs_shipping_postcode"])){   
?>
             <p data-postcode="<?php echo esc_attr($meta_value["trs_shipping_postcode"]);?>">
             <?php echo esc_attr($meta_value["trs_shipping_postcode"]);?>
            </p>
<?php
        }
?>           
            </div>
             <div class="formfields">
<?php
            if (isset($meta_value["trs_shipping_state"])) {
?>
             
<?php 
                echo esc_attr($state_name);
?>
            &nbsp;
<?php
            }
            if (isset($meta_value["trs_shipping_country"])) {
?>
            
<?php echo esc_attr( $country_name );?>
            
<?php
                  }
?>
              </div>
            </div>
<?php
		if( is_checkout() == false) {
            if ($defaultAddress == $um_id[$key]->umeta_id) {
?>
                <p class="defaultText">Default Address</p>
<?php           } else {
?>  
             <p class="defaultShippingText">
               <a href="#" class="setDefaultAddress" data-defaultaddress="<?php echo esc_attr( $um_id[$key]->umeta_id );?>">Set as Default</a>
               </p>
<?php
            }
		}
?>
           </div>
         </label>
       </div>
<?php
        }
?>
        </div>
<?php
 return $num_of_rows;
}
}

