(function ($) {
    "use strict";

    function update(cart, container) {
        $.ajax({
            type: 'post',
            url: mmt_ajax_obj['ajaxurl'],
            dataType: 'json',
            data: cart,
            cache: false,
            beforeSend: function () {
                container.addClass('processing').block({
                    message: null,
                    overlayCSS: {
                        background: '#fff',
                        opacity: 0.6
                    }
                });
            },
            success: function (data) {
                $('body').trigger('update_checkout');
                container.removeClass('processing').unblock();
            },
            error: function (xhr, textStatus, errorThrown) {
                container.removeClass('processing').unblock();
            }
        });
    }

    jQuery(document).on('ready', function () {
        var upgrade = $('.mmt-upgrade-wrap');
        if (upgrade.length) {

            var xhr = '';
            $(document.body).on('change', '.mmt-repeater-wrap .mmt-repeater-item .mmt-upgrade-label', function () {
                $(this).parents('.mmt-repeater-wrap').find('.upgrade-reset').show();
                var form = $('form.woocommerce-checkout');
                var container = $('.woocommerce-checkout-review-order');
                var isPrivate = $(this).parents('.mmt-repeater-wrap').hasClass('is_private');
                if (isPrivate) {
                    $('body').trigger('update_checkout');
                } else {
                    if (xhr) {
                        xhr.abort();
                    }
                    xhr = $.ajax({
                        type: 'post',
                        url: mmt_ajax_obj['checkout_url'],
                        dataType: 'text',
                        data: form.serialize(),
                        cache: false,
                        beforeSend: function () {
                            container.addClass('processing').block({
                                message: null,
                                overlayCSS: {
                                    background: '#fff',
                                    opacity: 0.6
                                }
                            });
                        },
                        success: function (data) {
                            $('body').trigger('update_checkout');
                            container.removeClass('processing').unblock();
                        },
                        error: function (xhr, textStatus, errorThrown) {
                            container.removeClass('processing').unblock();
                        }
                    });
                }
                return false;
            });

            $(document.body).on('click', '.mmt-repeater-wrap .upgrade-reset', function () {
                $(this).parent().parent().find('input[type="radio"]').prop('checked', false);
                $(this).parent().parent().find('input[type="checkbox"]').prop('checked', false);
                $(this).parent().parent().find('select').val(1).change();
                $(this).parent().parent().find('.mmt-quantity-count input[type=number]').val(0).change();
                $(this).hide();
                var form = $('form.woocommerce-checkout');
                var container = $('.woocommerce-checkout-review-order');
                var isPrivate = $(this).parent().parent().hasClass('is_private');
                if (isPrivate) {
                    $('body').trigger('update_checkout');
                } else {
                    $.ajax({
                        type: 'post',
                        url: mmt_ajax_obj['checkout_url'],
                        dataType: 'text',
                        data: form.serialize(),
                        cache: false,
                        beforeSend: function () {
                            container.addClass('processing').block({
                                message: null,
                                overlayCSS: {
                                    background: '#fff',
                                    opacity: 0.6
                                }
                            });
                        },
                        success: function (data) {
                            $('body').trigger('update_checkout');
                            container.removeClass('processing').unblock();
                        },
                        error: function (xhr, textStatus, errorThrown) {
                            container.removeClass('processing').unblock();
                        }
                    });
                }
                return false;
            });

            $(document.body).on('click', '[class*=upgrade-tour-]', function () {
                upgrade.find('.mmt-upgrade-tour input').prop("checked", false);
                $('body').trigger('update_checkout');
            });

            $(document.body).on('change', '.mmt-upgrade-wrap .mmt-upgrade-tour .mmt-upgrade-label', function () {
                $(this).parents('.mmt-upgrade-list').find('.upgrade-reset').show();
                $('body').trigger('update_checkout');
                return false;
            });


            $(document.body).on('click', '.mmt-upgrade-tour .upgrade-reset', function () {
                $(this).parent().parent().find('input[type="radio"]').prop('checked', false);
                $(this).parent().parent().find('input[type="checkbox"]').prop('checked', false);
                $(this).hide();
                $('body').trigger('update_checkout');
                return false;
            });

            $(document.body).on('click', '.mmt-upgrade-private .upgrade-reset', function () {
                $(this).parent().parent().find('input[type="radio"]').prop('checked', false);
                $(this).parent().parent().find('input[type="checkbox"]').prop('checked', false);
                $(this).hide();
                var form = $('form.mmt_form_upgrade');
                form.find('input[name="upgrade_private"]').attr('value', '');
                form.find('input[name="upgrade_private_reset"]').attr('value', 'true');
                var cart = form.serialize();
                var container = $('.woocommerce-checkout-review-order');
                $.ajax({
                    type: 'post',
                    url: mmt_ajax_obj['ajaxurl'],
                    dataType: 'json',
                    data: cart,
                    cache: false,
                    beforeSend: function () {
                        container.addClass('processing').block({
                            message: null,
                            overlayCSS: {
                                background: '#fff',
                                opacity: 0.6
                            }
                        });
                    },
                    success: function (data) {
                        if (data && data['success'] === true) {
                            var res = $(data['data']);
                            var upgradeWrap = $('.mmt-upgrade-wrap');
                            var upgradeWrapAjax = $('.mmt-upgrade-ajax');
                            upgradeWrap.remove();
                            upgradeWrapAjax.append(res);
                            $('body').trigger('update_checkout');
                        }
                        container.removeClass('processing').unblock();
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        container.removeClass('processing').unblock();
                    }
                });
                return false;
            });

            $(document.body).on('change', '.mmt-upgrade-wrap .mmt-upgrade-private .mmt-upgrade-label', function () {
                $(this).parents('.mmt-upgrade-list').find('.upgrade-reset').show();
                var cart = $('form.mmt_form_upgrade').serialize();
                var container = $('.woocommerce-checkout-review-order');
                $.ajax({
                    type: 'post',
                    url: mmt_ajax_obj['ajaxurl'],
                    dataType: 'json',
                    data: cart,
                    cache: false,
                    beforeSend: function () {
                        container.addClass('processing').block({
                            message: null,
                            overlayCSS: {
                                background: '#fff',
                                opacity: 0.6
                            }
                        });
                    },
                    success: function (data) {
                        if (data && data['success'] === true) {
                            var res = $(data['data']);
                            var upgradeWrap = $('.mmt-upgrade-wrap');
                            var upgradeWrapAjax = $('.mmt-upgrade-ajax');
                            upgradeWrap.remove();
                            upgradeWrapAjax.append(res);
                            $('body').trigger('update_checkout');
                        }
                        container.removeClass('processing').unblock();
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        container.removeClass('processing').unblock();
                    }
                });
                return false;
            });
        }

        var checkout = $('.woocommerce-checkout');
        if (checkout.length) {

            var condition = $('.mmt-condition');
            if (condition.length) {
                switch (condition.val()) {
                    case '11773-time-1200':
                        $('.mmt-product-id-11773 .mmt-item-1').remove();
                        break;
                }
            }

            $(document.body).on('click', '.mmt-repeater-wrap .mmt-quantity-count .mmt-button-qty', function () {
                var $button = $(this);
                var oldValue = $button.parent().find("input").val();
                var newVal = 0;
                if ($button.data('quantity') === "plus") {
                    newVal = parseFloat(oldValue) + 1;
                } else {
                    if (oldValue > 0) {
                        newVal = parseFloat(oldValue) - 1;
                    } else {
                        newVal = 0;
                    }
                }
                if (parseFloat(newVal) === 0) {
                    $button.parent().parent().parent().find('.mmt-input-repeat').prop('checked', false).change();
                } else {
                    $button.parent().parent().parent().find('.mmt-input-repeat').prop('checked', true).change();
                }

                $button.parent().find("input").val(newVal);
            });

            $(document.body).on('change', '.mmt-upgrade-wrap .mmt-quantity-count input[type=number]', function () {
                var value = $(this).val();
                if (value === '0') {
                    $(this).parent().parent().parent().find('.mmt-input-repeat').prop('checked', false).change();
                }
                $('body').trigger('update_checkout');
                return false;
            });

            var hotelNameWrap = $('#mmt_hotel_name_field'),
                hotelName = $('#mmt_hotel_name'),
                otherHotelNameWrap = $('#mmt_other_hotel_name_field'),
                otherHotelName = $('#mmt_other_hotel_name'),
                hotelCruiseShipWrap = $('#mmt_hotel_cruise_ship_field'),
                hotelCruiseShip = $('#mmt_hotel_cruise_ship'),
                hotelAirBndWrap = $('#mmt_hotel_air_bnd_field'),
                hotelAirBnd = $('#mmt_hotel_air_bnd'),
                hotelPrivateAddressWrap = $('#mmt_hotel_private_address_field'),
                hotelPrivateAddress = $('#mmt_hotel_private_address'),
                hotelHonoluluAirportAirlineWrap = $('#mmt_hotel_honolulu_airport_airline_field'),
                hotelHonoluluAirportAirline = $('#mmt_hotel_honolulu_airport_airline'),
                hotelHonoluluAirportFlightWrap = $('#mmt_hotel_honolulu_airport_flight_field'),
                hotelHonoluluAirportFlight = $('#mmt_hotel_honolulu_airport_flight');

            $(document.body).on('change', '#mmt_hotel_name', function () {
                var hotel = $(this).val();
                if (hotel === 'other') {
                    otherHotelNameWrap.show();
                    otherHotelName.val('').change();
                } else {
                    otherHotelNameWrap.hide();
                    otherHotelName.val('cruise-ship').change();
                    hotelCruiseShipWrap.hide();
                    hotelCruiseShip.val('default').change();
                    hotelAirBndWrap.hide();
                    hotelAirBnd.val('default').change();
                    hotelPrivateAddressWrap.hide();
                    hotelPrivateAddress.val('default').change();
                    hotelHonoluluAirportAirlineWrap.hide();
                    hotelHonoluluAirportAirline.val('default').change();
                    hotelHonoluluAirportFlightWrap.hide();
                    hotelHonoluluAirportFlight.val('default').change();
                }
            });

            $(document.body).on('change', '#mmt_other_hotel_name', function () {
                var other = $(this).val();
                if (other === 'cruise-ship') {
                    hotelCruiseShipWrap.show();
                    hotelCruiseShip.val('').change();

                    hotelAirBndWrap.hide();
                    hotelAirBnd.val('default').change();
                    hotelPrivateAddressWrap.hide();
                    hotelPrivateAddress.val('default').change();
                    hotelHonoluluAirportAirlineWrap.hide();
                    hotelHonoluluAirportAirline.val('default').change();
                    hotelHonoluluAirportFlightWrap.hide();
                    hotelHonoluluAirportFlight.val('default').change();
                } else if (other === 'air-bnd') {
                    hotelAirBndWrap.show();
                    hotelAirBnd.val('').change();

                    hotelCruiseShipWrap.hide();
                    hotelCruiseShip.val('default').change();
                    hotelPrivateAddressWrap.hide();
                    hotelPrivateAddress.val('default').change();
                    hotelHonoluluAirportAirlineWrap.hide();
                    hotelHonoluluAirportAirline.val('default').change();
                    hotelHonoluluAirportFlightWrap.hide();
                    hotelHonoluluAirportFlight.val('default').change();
                } else if (other === 'private-address') {
                    hotelPrivateAddressWrap.show();
                    hotelPrivateAddress.val('').change();

                    hotelCruiseShipWrap.hide();
                    hotelCruiseShip.val('default').change();
                    hotelAirBndWrap.hide();
                    hotelAirBnd.val('default').change();
                    hotelHonoluluAirportAirlineWrap.hide();
                    hotelHonoluluAirportAirline.val('default').change();
                    hotelHonoluluAirportFlightWrap.hide();
                    hotelHonoluluAirportFlight.val('default').change();
                } else if (other === 'honolulu-airport') {
                    hotelHonoluluAirportAirlineWrap.show();
                    hotelHonoluluAirportAirline.val('').change();
                    hotelHonoluluAirportFlightWrap.show();
                    hotelHonoluluAirportFlight.val('').change();

                    hotelCruiseShipWrap.hide();
                    hotelCruiseShip.val('default').change();
                    hotelAirBndWrap.hide();
                    hotelAirBnd.val('default').change();
                    hotelPrivateAddressWrap.hide();
                    hotelPrivateAddress.val('default').change();
                } else {
                    hotelCruiseShipWrap.hide();
                    hotelCruiseShip.val('default').change();
                    hotelAirBndWrap.hide();
                    hotelAirBnd.val('default').change();
                    hotelPrivateAddressWrap.hide();
                    hotelPrivateAddress.val('default').change();
                    hotelHonoluluAirportAirlineWrap.hide();
                    hotelHonoluluAirportAirline.val('default').change();
                    hotelHonoluluAirportFlightWrap.hide();
                    hotelHonoluluAirportFlight.val('default').change();
                }
            });
        }
        if(jQuery( ".birthday_guest_checkout input" ).length){
            jQuery( ".birthday_guest_checkout input" ).attr('readonly', true);
            jQuery( ".birthday_guest_checkout input" ).datepicker({
                dateFormat : 'mm/dd/yy',
                changeMonth : true,
                yearRange: '-100y:c+nn',
                changeYear : true,
                maxDate: -1 
            });
            jQuery.datepicker.setDefaults($.datepicker.regional['en']);
        }
        
    });

})(jQuery);