jQuery(document).ready(function () {
    jQuery(".addressEdit").click(function (a) {
        a.preventDefault();
        var e = jQuery(this).attr("data-metaid");
        jQuery(".edit-area-field").css("display", "block"),
            jQuery.ajax({
                url: ajaxurl,
                data: { action: "trs_address_book_get_address", metaId: e },
                success: function (a) {
                    jQuery(".hiddenIDfield").val(a.data.metaID),
                        jQuery(".update_first_name").val(a.data.trs_shipping_first_name),
                        jQuery(".update_last_name").val(a.data.trs_shipping_last_name),
                        jQuery(".update_company_name").val(a.data.trs_shipping_company),
                        jQuery(".update_address_1").val(a.data.trs_shipping_address_1),
                        jQuery(".update_address_2").val(a.data.trs_shipping_address_2),
                        jQuery(".update_city").val(a.data.trs_shipping_city),
                        jQuery(".update_postcode").val(a.data.trs_shipping_postcode),
                        jQuery(".update_country").val(a.data.trs_shipping_country),
                        jQuery(".update_state").val(a.data.trs_shipping_state);
                },
            });
    }),
        jQuery(".address-update-btn").click(function (a) {
            var e;
            a.preventDefault();
            var t = jQuery(".hiddenIDfield").val(),
                s = jQuery(".update_first_name").val(),
                r = jQuery(".update_last_name").val(),
                d = jQuery(".update_company_name").val(),
                i = jQuery(".update_address_1").val(),
                u = jQuery(".update_address_2").val(),
                _ = jQuery(".update_city").val(),
                n = jQuery(".update_postcode").val(),
                p = jQuery("#update_country").val(),
                l = jQuery(".update_state").val();
            (e = jQuery(".trs_default_address").prop("checked") ? 1 : 0),
                jQuery.ajax({
                    url: ajaxurl,
                    data: {
                        action: "trs_address_book_update_shipping_address",
                        metaId: t,
                        trs_shipping_first_name: s,
                        trs_shipping_last_name: r,
                        trs_shipping_company: d,
                        trs_shipping_address_1: i,
                        trs_shipping_address_2: u,
                        trs_shipping_city: _,
                        trs_shipping_postcode: n,
                        trs_shipping_country: p,
                        trs_shipping_state: l,
                        defaultAddress: e,
                    },
                    success: function (a) {
                        location.reload(!0);
                    },
                });
        }),
        jQuery(".myacc-addres-btn").click(function (a) {
            a.preventDefault(), jQuery(".myacc-addres-btn").css("display", "none"), jQuery(".account-add-address-field").css("display", "block"), jQuery(".account-edit-area-field").css("display", "none");
        }),
        jQuery(".addres-btn").click(function (a) {
            a.preventDefault();
            var e,
                t = {};
            (t.trs_shipping_first_name = jQuery("#shipping_first_name").val()),
                (t.trs_shipping_last_name = jQuery("#shipping_last_name").val()),
                (t.trs_shipping_company = jQuery("#shipping_company").val()),
                (t.trs_shipping_address_1 = jQuery("#shipping_address_1").val()),
                (t.trs_shipping_address_2 = jQuery("#shipping_address_2").val()),
                (t.trs_shipping_city = jQuery("#shipping_city").val()),
                (t.trs_shipping_postcode = jQuery("#shipping_postcode").val()),
                (t.trs_shipping_country = jQuery("#shipping_country").val()),
                (t.trs_shipping_state = jQuery("#shipping_state").val()),
                (e = jQuery(".trs_default_address").prop("checked") ? 1 : 0),
                console.log(t),
                jQuery.ajax({
                    url: ajaxurl,
                    data: { action: "trs_address_book_add_shipping_address", fieldData: t, defaultAddress: e },
                    success: function (a) {
                        location.reload(!0);
                    },
                });
        }),
        jQuery(".setDefaultAddress").click(function (a) {
            a.preventDefault();
            var e = jQuery(this).attr("data-defaultaddress");
            jQuery.ajax({
                url: ajaxurl,
                data: { action: "trs_address_book_set_default_address", metaId: e },
                success: function (a) {
                    location.reload(!0);
                },
            });
        }),
        jQuery(".delBTN").click(function (a) {
            a.preventDefault();
            var e = jQuery(".delBTN").attr("data-metaid");
            jQuery.ajax({
                url: ajaxurl,
                data: { action: "trs_address_book_delete_shipping_address", metaId: e },
                success: function (a) {
                    location.reload(!0);
                },
            });
        }),
        jQuery("input[name=set_default_address]").change(function () {
            var a = jQuery("input[name=set_default_address]:checked").val();
            jQuery.ajax({
                url: ajaxurl,
                data: { action: "trs_address_book_set_default_address", metaId: a },
                success: function (a) {
                    location.reload(!0);
                },
            });
        });
});
