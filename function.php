<?php
add_filter( 'woocommerce_ship_to_different_address_checked', '__return_true' );
function trs_address_book_ajaxurl()
{
    echo '<script type="text/javascript">
           var ajaxurl = "' .
        admin_url("admin-ajax.php") .
        '";
         </script>';
}
add_action("wp_head", "trs_address_book_ajaxurl");

function trs_address_book_get_address()
{
    global $wpdb;

    $table_name = $wpdb->usermeta;

    $query = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM $wpdb->usermeta WHERE umeta_id = %d AND meta_key = %s",
            sanitize_text_field($_REQUEST["metaId"]),
            "trs_shipping_address"
        )
    );

    $address = [];
    foreach ($query as $address) {
        $address = maybe_unserialize($address->meta_value);
    }
    $address["metaID"] = sanitize_text_field( $_REQUEST["metaId"] );
    print_r(wp_send_json_success($address));
}
add_action("wp_ajax_trs_address_book_get_address", "trs_address_book_get_address");
add_action("wp_ajax_nopriv_trs_address_book_get_address", "trs_address_book_get_address");

function trs_address_book_add_shipping_address(){
		$user_id = get_current_user_id();

		$data = array(
    'trs_shipping_first_name'  => sanitize_text_field( $_REQUEST['fieldData']['trs_shipping_first_name'] ),
    'trs_shipping_last_name'   => sanitize_text_field( $_REQUEST['fieldData']['trs_shipping_last_name'] ),
    'trs_shipping_company'     => sanitize_text_field( $_REQUEST['fieldData']['trs_shipping_company'] ),
    'trs_shipping_address_1'   => sanitize_text_field( $_REQUEST['fieldData']['trs_shipping_address_1'] ),
	'trs_shipping_address_2'   => sanitize_text_field( $_REQUEST['fieldData']['trs_shipping_address_2'] ),
    'trs_shipping_city'        => sanitize_text_field( $_REQUEST['fieldData']['trs_shipping_city'] ),
    'trs_shipping_postcode'    => sanitize_text_field( $_REQUEST['fieldData']['trs_shipping_postcode'] ),
    'trs_shipping_state'       => sanitize_text_field( $_REQUEST['fieldData']['trs_shipping_state'] ),
    'trs_shipping_country'     => sanitize_text_field( $_REQUEST['fieldData']['trs_shipping_country'] ),
);
	$defaultAddress = sanitize_text_field( $_REQUEST['defaultAddress'] );

	$metaID = add_user_meta( $user_id, 'trs_shipping_address', $data , false );
	
	if($defaultAddress == 1){
		update_user_meta( $user_id, "trs_default_shipping_address",$metaID );
        global $woocommerce;

                // Get the WC_Customer instance object from user ID
                $customer = new WC_Customer($user_id);

                $customer->set_shipping_first_name(
                    esc_attr($data["trs_shipping_first_name"])
                );
                $customer->set_shipping_last_name(
                    esc_attr($data["trs_shipping_last_name"])
                );
                $customer->set_shipping_company(
                    esc_attr($data["trs_shipping_company"])
                );
                $customer->set_shipping_address_1(
                    esc_attr($data["trs_shipping_address_1"])
                );
                $customer->set_shipping_address_2(
                    esc_attr($data["trs_shipping_address_2"])
                );
                $customer->set_shipping_city(
                    esc_attr($data["trs_shipping_city"])
                );
                $customer->set_shipping_postcode(
                    esc_attr($data["trs_shipping_postcode"])
                );
                $customer->set_shipping_state(
                    esc_attr($data["trs_shipping_state"])
                );
                $customer->set_shipping_country(
                    esc_attr($data["trs_shipping_country"])
                );
                $customer->save();
	}

}
add_action("wp_ajax_trs_address_book_add_shipping_address", "trs_address_book_add_shipping_address");
add_action("wp_ajax_nopriv_trs_address_book_add_shipping_address", "trs_address_book_add_shipping_address");

function trs_address_book_update_shipping_address(){
	 global $wpdb;
        $table_name = $wpdb->usermeta;
		$user_id = get_current_user_id();
		 $data = array(
    'trs_shipping_first_name'  => sanitize_text_field( $_REQUEST['trs_shipping_first_name'] ),
    'trs_shipping_last_name'   => sanitize_text_field( $_REQUEST['trs_shipping_last_name'] ),
    'trs_shipping_company'     => sanitize_text_field( $_REQUEST['trs_shipping_company'] ),
    'trs_shipping_address_1'   => sanitize_text_field( $_REQUEST['trs_shipping_address_1'] ),
	'trs_shipping_address_2'   => sanitize_text_field( $_REQUEST['trs_shipping_address_2'] ),
    'trs_shipping_city'        => sanitize_text_field( $_REQUEST['trs_shipping_city'] ),
    'trs_shipping_postcode'    => sanitize_text_field( $_REQUEST['trs_shipping_postcode'] ),
    'trs_shipping_state'       => sanitize_text_field( $_REQUEST['trs_shipping_state'] ),
    'trs_shipping_country'     => sanitize_text_field( $_REQUEST['trs_shipping_country'] )
);
    $defaultAddress = sanitize_text_field( $_REQUEST['defaultAddress'] );
	$metaID = sanitize_text_field( $_REQUEST['metaId'] );
	$data = maybe_serialize($data);
	 $result = $wpdb->update(
            $wpdb->usermeta,
            ["meta_value" => $data],
            ["umeta_id" => $metaID],
            ["%s"],
            ["%d"]
        );

     if( $defaultAddress == 1){
             update_user_meta(
                $user_id,
                "trs_default_shipping_address",
               $metaID
            );
     }

		}
add_action("wp_ajax_trs_address_book_update_shipping_address", "trs_address_book_update_shipping_address");
add_action("wp_ajax_nopriv_trs_address_book_update_shipping_address", "trs_address_book_update_shipping_address");

function trs_address_book_set_default_address(){
    global $wpdb;
	$user_id = get_current_user_id();
	update_user_meta(
                $user_id,
                "trs_default_shipping_address",
                sanitize_text_field( $_REQUEST["metaId"] )
            );
	  
            $get_metaData = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT * FROM $wpdb->usermeta WHERE umeta_id = %d AND meta_key = %s",
                    sanitize_text_field( $_REQUEST["metaId"] ),
                    "trs_shipping_address"
                )
            );


            foreach ($get_metaData as $data) {
                $data = maybe_unserialize($data->meta_value);
                global $woocommerce;

                // // Get the WC_Customer instance object from user ID
                $customer = new WC_Customer($user_id);

                $customer->set_shipping_first_name(
                    esc_attr($data["trs_shipping_first_name"])
                );
                $customer->set_shipping_last_name(
                    esc_attr($data["trs_shipping_last_name"])
                );
                $customer->set_shipping_company(
                    esc_attr($data["trs_shipping_company"])
                );
                $customer->set_shipping_address_1(
                    esc_attr($data["trs_shipping_address_1"])
                );
                $customer->set_shipping_address_2(
                    esc_attr($data["trs_shipping_address_2"])
                );
                $customer->set_shipping_city(
                    esc_attr($data["trs_shipping_city"])
                );
                $customer->set_shipping_postcode(
                    esc_attr($data["trs_shipping_postcode"])
                );
                $customer->set_shipping_state(
                    esc_attr($data["trs_shipping_state"])
                );
                $customer->set_shipping_country(
                    esc_attr($data["trs_shipping_country"])
                );
                $customer->save();

            }

	}

add_action("wp_ajax_trs_address_book_set_default_address", "trs_address_book_set_default_address");
add_action("wp_ajax_nopriv_trs_address_book_set_default_address", "trs_address_book_set_default_address");

function trs_address_book_delete_shipping_address(){
	 global $wpdb;
		$user_id = get_current_user_id();
	$metaID = sanitize_text_field( $_REQUEST['metaId'] );
    echo esc_attr( $metaID);
	 $del_query = $wpdb->get_results(
            $wpdb->prepare(
                "DELETE FROM $wpdb->usermeta WHERE umeta_id = %d AND meta_key = %s",
                $metaID,
                "trs_shipping_address"
            )
        );
}
add_action("wp_ajax_trs_address_book_delete_shipping_address", "trs_address_book_delete_shipping_address");
add_action("wp_ajax_nopriv_trs_address_book_delete_shipping_address", "trs_address_book_delete_shipping_address");

add_filter( 'woocommerce_my_account_get_addresses', 'trs_address_book_filter_wc_account_addresses', 10, 2 ); 
function trs_address_book_filter_wc_account_addresses( $adresses, $customer_id ) { 
    if( isset($adresses['shipping']) ) {
        unset($adresses['shipping']);
    }
    return $adresses; 
}

add_action('woocommerce_after_edit_account_address_form','trs_address_book_shipping_address_my_account');
function trs_address_book_shipping_address_my_account(){
    global $wpdb;
    $user_id = esc_attr(get_current_user_id());
    $defaultAddress_id = esc_attr(
                get_user_meta($user_id, "trs_default_shipping_address", true)
            );         
     $query = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM $wpdb->usermeta WHERE umeta_id = %d AND meta_key = %s",
            esc_attr( $defaultAddress_id ),
            "trs_shipping_address"
        )
    );
     foreach($query as $address ){
        $default_shipping_address = maybe_unserialize( $address->meta_value );
?>
            <div class="woocommmerce-adress-book-account-page">
        <header class="woocommerce-address-title">
          <h3>Shipping Address</h3>
        </header>
        <address>
<?php  
 $country_name = WC()->countries->countries[ $default_shipping_address['trs_shipping_country'] ]; 
echo esc_attr( $default_shipping_address['trs_shipping_first_name'] ) . ' '.esc_attr($default_shipping_address['trs_shipping_last_name']).'<br>'.
    esc_attr( $default_shipping_address['trs_shipping_company'] ).'<br>'.
   esc_attr( $default_shipping_address['trs_shipping_address_1'] ).'<br>'.
   esc_attr( $default_shipping_address['trs_shipping_address_2'] ).'<br>'.
   esc_attr( $default_shipping_address['trs_shipping_city'] ).'<br>'.
   esc_attr( $default_shipping_address['trs_shipping_state'] ).'<br>'.
   esc_attr( $default_shipping_address['trs_shipping_postcode'] ).'<br>'.
   esc_attr( $country_name );
?>
     </address>
        </div>
<?php
     }
}	