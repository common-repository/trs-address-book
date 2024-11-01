<?php
if (!defined("ABSPATH")) {
    exit();
} // Exit if accessed directly

function trs_woo_address_endpoint()
{
    add_rewrite_endpoint("woo-addresses", EP_ROOT | EP_PAGES);
}

add_action("init", "trs_woo_address_endpoint");

function trs_address_query_vars($vars)
{
    $vars[] = "woo-addresses";

    return $vars;
}

add_filter("query_vars", "trs_address_query_vars", 0);

function trs_address_insert_after_helper($items, $new_items, $after)
{
    // Search for the item position and +1 since is after the selected item key.
    $position = array_search($after, array_keys($items)) + 1;

    // Insert the new item.
    $array = array_slice($items, 0, $position, true);
    $array += $new_items;
    $array += array_slice($items, $position, count($items) - $position, true);

    return $array;
}

/**
 * Insert the new endpoint into the My Account menu.
 *
 * @param array $items
 * @return array
 */
function trs_address_my_account_menu_items($items)
{
    $new_items = [];
    $new_items["woo-addresses"] = __("Address Book", "woocommerce");

    // Add the new item after `orders`.
    return trs_address_insert_after_helper($items, $new_items, "orders");
}

add_filter(
    "woocommerce_account_menu_items",
    "trs_address_my_account_menu_items"
);
function trs_address_endpoint_content() {
	global  $num_of_rows;
	$user_id = get_current_user_id();
	 if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
?>
        <p>The following addresses will be available on the checkout page.</p>
<?php
	trs_woo_address_fields_data();
    

	$saved_option_value = esc_attr(get_option("wcaddress_field"));

      if ($num_of_rows < $saved_option_value) {
?>
            <div class="btn-div">
            <a href="#" class="myacc-addres-btn">Add New Address</a>
            </div>
<?php
        }
?>
<div class="account-add-address-field" style="display:none;">
<?php
  trs_add_addres_book_form();
?>
 </div>
	 <div class="edit-area-field main-row" style="display:none;">
 <?php
	trs_edit_address_form();
 ?>
  </div>	
<?php
	}

}
add_action(
    "woocommerce_account_woo-addresses_endpoint",
    "trs_address_endpoint_content"
);

function trs_address_endpoint_title($title)
{
    global $wp_query;

    $is_endpoint = isset($wp_query->query_vars["woo-addresses"]);

    if (
        $is_endpoint &&
        !is_admin() &&
        is_main_query() &&
        in_the_loop() &&
        is_account_page()
    ) {
        // New page title.
       // $title = __("My Custom Endpoint", "woocommerce");

        remove_filter("the_title", "trs_address_endpoint_title");
    }

    return $title;
}

add_filter("the_title", "trs_address_endpoint_title");
