<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
function trs_edit_address_form(){
?>
    <div class="form-fields-row">
    <label for="trs_shipping_first_name">First Name*</label>
    <input type="text" class="trs_form_fields update_first_name" name="trs_shipping_first_name" id="trs_shipping_first_name" value="" required>
    </div>

    <div class="form-fields-row">
    <label for="trs_shipping_last_name">Last Name*</label>
    <input type="text" class="trs_form_fields update_last_name" name="trs_shipping_last_name" id="trs_shipping_last_name" value="" required>
    </div>

    <div class="form-fields-row">
    <label for="trs_shipping_company">Company name (optional)</label>
    <input type="text" class="trs_form_fields update_company_name" value="" name="trs_shipping_company" id="trs_shipping_company">
    </div>

    <div class="form-fields-row">
    <label for="trs_shipping_address_1">Street address*</label>
    <input type="text" class="trs_form_fields update_address_1" name="trs_shipping_address_1" id="trs_shipping_address_1" value="" required>
    </div>
	
    <div class="form-fields-row">
    <input type="text" class="trs_form_fields update_address_2" name="trs_shipping_address_2" id="trs_shipping_address_2" placeholder="Apartment, suite, unit, etc. (optional)" value="" required>
    </div>

    <div class="form-fields-row">
    <label for="trs_shipping_city">Town / City*</label>
    <input type="text" class="trs_form_fields update_city" name="trs_shipping_city" id="trs_shipping_city" value="" required>
   </div>

    <div class="form-fields-row">
    <label for="trs_shipping_postcode">Postalcode / ZIP*</label>
    <input type="text" class="trs_form_fields update_postcode" name="trs_shipping_postcode" id="trs_shipping_postcode" value="" required>
    </div>
<?php
    $countries_object = new WC_Countries();
    $countries = $countries_object->__get("countries");
?>
    <div class="form-fields-row">
    <label for="trs_shipping_Country">Country *</label>
<?php
    woocommerce_form_field("the_country_field", [
        "type" => "select",
		"id" => "update_country",
        "class" => ["trs_shipping_field_country"],
        "placeholder" => __("Enter something"),
        "options" => $countries,
        "required" => true,
        "name" => "trs_shipping_country",
    ]);
?>
    </div>

    <div class="form-fields">
    <label for="trs_shipping_state">State *</label>
    <input type="text" class="trs_form_fields update_state" name="trs_shipping_state" id="trs_shipping_state" value="" required>
    </div>

    <div class="trs_form_fields">
        <input type="checkbox" name="trs_default_address" id="trs_default_address" class="trs_default_address">
        <label for="trs_shipping_state">Set as Defaul Address (optional)</label>
        </div>  

    <div class="btn-div">
    <button type="submit" name="updateAddress" class="address-update-btn">Update Address</a>
    </div>
    <input type="hidden" name="address_metaID" class="hiddenIDfield">
<?php
}