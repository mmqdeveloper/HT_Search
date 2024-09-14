jQuery(document).ready(function ($) {


    function sessionGet(key) {
        var value = null;
        var localValue = window.localStorage.getItem(key);
        var sessionValue = window.sessionStorage.getItem(key);
        if (localValue !== null || sessionValue !== null) {
            if (sessionValue) {
                value = JSON.parse(sessionValue);
            } else {
                value = JSON.parse(localValue);
            }
            var expirationDate = new Date(value.expirationDate);
            if (expirationDate > new Date()) {
                return value.value
            } else {
                window.localStorage.removeItem(key);
                window.sessionStorage.removeItem(key);
            }
        }
        return null
    }

    function sessionSet(key, value, expirationInHour) {
        var expirationDate = new Date(new Date().getTime() + (60000 * 60 * expirationInHour));
        var newValue = {
            value: value,
            expirationDate: expirationDate.toISOString()
        };

        window.localStorage.setItem(key, JSON.stringify(newValue));
        window.sessionStorage.setItem(key, JSON.stringify(newValue));
    }

    //Get URL Parameters using jQuery
    function GetURLParameter(sParam) {
        var sPageURL = window.location.search.substring(1);
        var sURLVariables = sPageURL.split('&');
        for (var i = 0; i < sURLVariables.length; i++) {
            var sParameterName = sURLVariables[i].split('=');
            if (sParameterName[0] == sParam)
            {
                return sParameterName[1];
            }
        }
    }
    function autoAddCommasPrice(nStr)
    {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
    }

    var supportsStorage = true,
        keyIsland = 'check-island';

    try {
        supportsStorage = ('sessionStorage' in window && window.sessionStorage !== null);
        window.sessionStorage.setItem('rdn', 'test');
        window.sessionStorage.removeItem('rdn');
        window.localStorage.setItem('rdn', 'test');
        window.localStorage.removeItem('rdn');
    } catch (err) {
        supportsStorage = false;
    }
    jQuery(".main_menu ul ul li a").click(function () {
        var id_menu = jQuery(this).closest('ul').closest('li').attr('id');
        if(id_menu=='menu-item-888'){
            if (supportsStorage) {
                sessionSet('check_oahu', 'true', 1000);
            }
        }
    });
    jQuery(".av-layout-tab .avia-mm-grid-row a").click(function () {
        var id_tab = jQuery(this).closest('.av-layout-tab').data('tab-section-id');
        if(id_tab=='from-oahu'){
            if (supportsStorage) {
                sessionSet('check_oahu', 'true', 1000);
            }
        }
    });
    jQuery("select.all-island-select").change(function(){
        var selectedvalue = jQuery(this).children("option:selected").val();
        if(selectedvalue=='oahu'){           
            sessionSet('check_oahu', 'true', 1000);
        }
        else sessionSet('check_oahu', '', 1000);
    });
    jQuery(".products .product-type-booking").click(function () {
        var hrefUrl = jQuery(location).attr('href').replace(/(^\w+:|^)\/\//, '');
        var pathUrl = hrefUrl.indexOf('/');
        var pathName = hrefUrl.substring(pathUrl + 1);
        var pathArray = '';
        if (pathName.indexOf('#') !== -1) {
            var tabIndex = hrefUrl.substring(pathUrl + 1).substring(1);
            switch (tabIndex) {
                case 'tab-id-2':
                    pathArray = "oahu";
                    break;
                case 'tab-id-3':
                    pathArray = "maui";
                    break;
                case 'tab-id-4':
                    pathArray = "big-island";
                    break;
                case 'tab-id-5':
                    pathArray = "kauai";
                    break;
                /*default:
                    pathArray = "vacation-packages";
                    break;*/
            }
        } else {
            var number = pathName.indexOf('/');
            pathArray = pathName.substring(0, number);
            localStorage.setItem("Homename", hrefUrl);
        }
        if(pathArray==''){
            console.log(sessionGet('check_oahu'));
            if(supportsStorage && sessionGet('check_oahu')=='true'){
                pathArray = 'oahu';
                sessionSet('check_oahu', '', 1000);
            }
            else pathArray = 'vacation-packages';
        }
        pathArray = pathArray.replace("/", "");
        pathArray = pathArray.replace("/", "");
        pathArray = pathArray.replace("-", " ");
        localStorage.setItem("Pathname", pathArray);

        if (supportsStorage) {
            sessionSet(keyIsland, pathArray, 1000);
        }
    });

    if(jQuery('.single-product').length){
        if (supportsStorage) {
            if (sessionGet(keyIsland)) {
                var island = sessionGet(keyIsland).replace(" ", "-");
                if(island){
                    jQuery('.mmt-check-island').attr('value', island);
                }
            }
        }
    }
    /*auto select one tour*/
    if(jQuery('#wc_bookings_field_resource').length){
        var count_resource = $('#wc_bookings_field_resource > option').length;
        //console.log(count_resource);
        //if(count_resource==2){
            var tour_name = jQuery("select#wc_bookings_field_resource option:nth-child(2)").text();
            jQuery("select#wc_bookings_field_resource option:nth-child(2)").attr("selected", "selected");
            jQuery('.tour-island').text(tour_name);
            /*if (jQuery('.single-product.postid-34517').length){
                var tour_name = jQuery("select#wc_bookings_field_resource option:nth-child(2)").text();
                jQuery("select#wc_bookings_field_resource option:nth-child(2)").attr("selected", "selected");
                jQuery('.tour-island').text(tour_name);
            }*/
            jQuery('.tour-island').css("display", "block");
            //jQuery('.fa-angle-down').css("display", "none");
            jQuery('.field_resource  .icon-check').css("display", "block");
            jQuery('p.wc_bookings_field_resource').css("display", "block");
            var custom_price = jQuery('ul.list-costs-island li:nth-child(1)').data('customprice');
            var costResource = jQuery('ul.list-costs-island li:nth-child(1)').attr('data-cost');
            jQuery(".form-field.form_field_person").each(function() {
                var person_id = jQuery(this).data('id');
                if(custom_price && custom_price[ person_id ]){
                    var costsPerson = parseFloat(custom_price[ person_id ]);
                    var result = costsPerson.toFixed(2).toString().split('.');
                    if (result[1]) {
                        var sup_price = result[1];
                    } else {
                        var sup_price = '00';
                    }
                    jQuery(this).find('.price-person').find('.custom-prc').html(addCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                
                }else if(costResource > 0){
                    var costPerson = jQuery(this).find('.price-person').attr('data-cost-person');
                    var costsPerson = parseFloat(costPerson) + parseFloat(costResource);

                    var result = costsPerson.toFixed(2).toString().split('.');
                    if (result[1]) {
                        var sup_price = result[1];
                    } else {
                        var sup_price = '00';
                    }
                    jQuery(this).find('.price-person').find('.custom-prc').html(addCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                }
            });
        //}
        if(jQuery('.tour_resource_hide_field').length){
            jQuery(".tour_resource_hide_field input.tour_starting_form").each(function() {
                jQuery(this).val(tour_name);
                jQuery(this).change();
            });
        }
        if(jQuery('input.get_resource_id').length){
            jQuery("input.get_resource_id").each(function() {
                jQuery(this).val(jQuery("select#wc_bookings_field_resource option:nth-child(2)").val());
                jQuery(this).change();
            });
            
            
        }
    }
    var cpc = GetURLParameter('cpc');
    /*if (typeof cpc !== 'undefined') {
        var islandName = jQuery('.list-costs-island li[data-fields="3468"] .island-name').text();
        var islandName_rp = islandName.replace(" ", "");
        jQuery('#wc_bookings_field_resource option').each(function () {
            var optionname = jQuery(this).text();
            var optioval = jQuery(this).val();
            if (optionname.toLowerCase().replace(" ", "-").search(cpc.toLowerCase()) !== -1) {
                jQuery(this).prop("selected", true);
                $('.list-costs-island li[data-fields="' + optioval + '"').addClass('selected');
                var costResource = $('.list-costs-island li[data-fields="' + optioval + '"').attr('data-cost');
                if ($('.form-field.form_person_0').length) {
                    var costPersonFirst = $('.form_person_0 .price-person').attr('data-cost-person');
                    var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                    var result = costsPerson.toFixed(2).toString().split('.');
                    if (result[1]) {
                        var sup_price = result[1];
                    } else {
                        var sup_price = '00';
                    }
                    $('.form_person_0 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                    $('.wc-bookings-booking-cost .booking-costs-new').html("<span class='woocommerce-Price-amount amount'><span class='woocommerce-Price-currencySymbol'>$</span><span class='custom-prc'>" + autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup></span></span>");
                }
                if ($('.form-field.form_person_1').length) {
                    var costPersonFirst = $('.form_person_1 .price-person').attr('data-cost-person');
                    var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                    var result = costsPerson.toFixed(2).toString().split('.');
                    if (result[1]) {
                        var sup_price = result[1];
                    } else {
                        var sup_price = '00';
                    }
                    $('.form_person_1 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                }
                if ($('.form-field.form_person_2').length) {
                    var costPersonFirst = $('.form_person_2 .price-person').attr('data-cost-person');
                    var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                    var result = costsPerson.toFixed(2).toString().split('.');
                    if (result[1]) {
                        var sup_price = result[1];
                    } else {
                        var sup_price = '00';
                    }
                    $('.form_person_2 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                }
                if ($('.form-field.form_person_3').length) {
                    var costPersonFirst = $('.form_person_3 .price-person').attr('data-cost-person');
                    var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                    var result = costsPerson.toFixed(2).toString().split('.');
                    if (result[1]) {
                        var sup_price = result[1];
                    } else {
                        var sup_price = '00';
                    }
                    $('.form_person_3 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                }
                jQuery('.tour-island').text(optionname);
                jQuery('.tour-island').css("display", "block");
                jQuery('.fa-angle-down').css("display", "none");
                jQuery('.field_resource  .icon-check').css("display", "block");
                //jQuery('.mmt-select-wrap .fa').addClass('fa-check');
            } else if (islandName_rp !== 'Maui') {
                var islandName = jQuery('.list-costs-island li:first-child .island-name').text();
                jQuery('.list-costs-island li:first-child').addClass('selected');
                jQuery("#wc_bookings_field_resource option:first").prop("selected", "selected");
                jQuery('.tour-island').text(islandName);
                var costResource = $('.list-costs-island li:first-child').attr('data-cost');
                if ($('.form-field.form_person_0').length) {
                    var costPersonFirst = $('.form_person_0 .price-person').attr('data-cost-person');
                    var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                    var result = costsPerson.toFixed(2).toString().split('.');
                    if (result[1]) {
                        var sup_price = result[1];
                    } else {
                        var sup_price = '00';
                    }
                    $('.form_person_0 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                    $('.wc-bookings-booking-cost .booking-costs-new').html("<span class='woocommerce-Price-amount amount'><span class='woocommerce-Price-currencySymbol'>$</span><span class='custom-prc'>" + autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup></span></span>");
                }
                if ($('.form-field.form_person_1').length) {
                    var costPersonFirst = $('.form_person_1 .price-person').attr('data-cost-person');
                    var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                    var result = costsPerson.toFixed(2).toString().split('.');
                    if (result[1]) {
                        var sup_price = result[1];
                    } else {
                        var sup_price = '00';
                    }
                    $('.form_person_1 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                }
                if ($('.form-field.form_person_2').length) {
                    var costPersonFirst = $('.form_person_2 .price-person').attr('data-cost-person');
                    var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                    var result = costsPerson.toFixed(2).toString().split('.');
                    if (result[1]) {
                        var sup_price = result[1];
                    } else {
                        var sup_price = '00';
                    }
                    $('.form_person_2 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                }
                if ($('.form-field.form_person_3').length) {
                    var costPersonFirst = $('.form_person_3 .price-person').attr('data-cost-person');
                    var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                    var result = costsPerson.toFixed(2).toString().split('.');
                    if (result[1]) {
                        var sup_price = result[1];
                    } else {
                        var sup_price = '00';
                    }
                    $('.form_person_3 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                }
                jQuery('.tour-island').css("display", "block");
                jQuery('.fa-angle-down').css("display", "none");
                jQuery('.field_resource  .icon-check').css("display", "block");
            }
        });

    } else if (typeof (Storage) !== "undefined") {
        if (localStorage.Pathname !== '') {
            if (localStorage.Pathname === 'tickets') {
                var islandName = jQuery('.list-costs-island li[data-fields="3468"] .island-name').text();
                if (islandName.length !== 0) {
                    jQuery("#wc_bookings_field_resource option[value='3468']").prop("selected", "selected");
                    jQuery('.list-costs-island li[data-fields="3468"]').addClass('selected');
                    jQuery('.tour-island').text(islandName);
                    var costResource = $('.list-costs-island li[data-fields="3468"]').attr('data-cost');
                    if ($('.form-field.form_person_0').length) {
                        var costPersonFirst = $('.form_person_0 .price-person').attr('data-cost-person');
                        var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                        var result = costsPerson.toFixed(2).toString().split('.');
                        if (result[1]) {
                            var sup_price = result[1];
                        } else {
                            var sup_price = '00';
                        }
                        $('.form_person_0 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                        $('.wc-bookings-booking-cost .booking-costs-new').html("<span class='woocommerce-Price-amount amount'><span class='woocommerce-Price-currencySymbol'>$</span><span class='custom-prc'>" + autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup></span></span>");
                    }
                    if ($('.form-field.form_person_1').length) {
                        var costPersonFirst = $('.form_person_1 .price-person').attr('data-cost-person');
                        var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                        var result = costsPerson.toFixed(2).toString().split('.');
                        if (result[1]) {
                            var sup_price = result[1];
                        } else {
                            var sup_price = '00';
                        }
                        $('.form_person_1 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                    }
                    if ($('.form-field.form_person_2').length) {
                        var costPersonFirst = $('.form_person_2 .price-person').attr('data-cost-person');
                        var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                        var result = costsPerson.toFixed(2).toString().split('.');
                        if (result[1]) {
                            var sup_price = result[1];
                        } else {
                            var sup_price = '00';
                        }
                        $('.form_person_2 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                    }
                    if ($('.form-field.form_person_3').length) {
                        var costPersonFirst = $('.form_person_3 .price-person').attr('data-cost-person');
                        var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                        var result = costsPerson.toFixed(2).toString().split('.');
                        if (result[1]) {
                            var sup_price = result[1];
                        } else {
                            var sup_price = '00';
                        }
                        $('.form_person_3 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                    }
                    jQuery('.tour-island').css("display", "block");
                    jQuery('.fa-angle-down').css("display", "none");
                    jQuery('.field_resource  .icon-check').css("display", "block");
                } else {
                    var islandName = jQuery('.list-costs-island li:first-child .island-name').text();
                    jQuery('.list-costs-island li:first-child').addClass('selected');
                    jQuery("#wc_bookings_field_resource option:first").prop("selected", "selected");
                    jQuery('.tour-island').text(islandName);
                    var costResource = $('.list-costs-island li:first-child').attr('data-cost');
                    if ($('.form-field.form_person_0').length) {
                        var costPersonFirst = $('.form_person_0 .price-person').attr('data-cost-person');
                        var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                        var result = costsPerson.toFixed(2).toString().split('.');
                        if (result[1]) {
                            var sup_price = result[1];
                        } else {
                            var sup_price = '00';
                        }
                        $('.form_person_0 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                        $('.wc-bookings-booking-cost .booking-costs-new').html("<span class='woocommerce-Price-amount amount'><span class='woocommerce-Price-currencySymbol'>$</span><span class='custom-prc'>" + autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup></span></span>");
                    }
                    if ($('.form-field.form_person_1').length) {
                        var costPersonFirst = $('.form_person_1 .price-person').attr('data-cost-person');
                        var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                        var result = costsPerson.toFixed(2).toString().split('.');
                        if (result[1]) {
                            var sup_price = result[1];
                        } else {
                            var sup_price = '00';
                        }
                        $('.form_person_1 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                    }
                    if ($('.form-field.form_person_2').length) {
                        var costPersonFirst = $('.form_person_2 .price-person').attr('data-cost-person');
                        var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                        var result = costsPerson.toFixed(2).toString().split('.');
                        if (result[1]) {
                            var sup_price = result[1];
                        } else {
                            var sup_price = '00';
                        }
                        $('.form_person_2 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                    }
                    if ($('.form-field.form_person_3').length) {
                        var costPersonFirst = $('.form_person_3 .price-person').attr('data-cost-person');
                        var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                        var result = costsPerson.toFixed(2).toString().split('.');
                        if (result[1]) {
                            var sup_price = result[1];
                        } else {
                            var sup_price = '00';
                        }
                        $('.form_person_3 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                    }
                    jQuery('.tour-island').css("display", "block");
                    jQuery('.fa-angle-down').css("display", "none");
                    jQuery('.field_resource  .icon-check').css("display", "block");
                }

            } else if (localStorage.Pathname) {
                jQuery('#wc_bookings_field_resource option').each(function () {

                    var optionname = jQuery(this).text();
                    var optioval = jQuery(this).val();
                    if (optionname.toLowerCase().search(localStorage.Pathname) !== -1) {
                        jQuery(this).prop("selected", true);
                        jQuery('.list-costs-island li[data-fields="' + optioval + '"]').addClass('selected');
                        var costResource = $('.list-costs-island li[data-fields="' + optioval + '"]').attr('data-cost');
                        if ($('.form-field.form_person_0').length) {
                            var costPersonFirst = $('.form_person_0 .price-person').attr('data-cost-person');
                            var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                            var result = costsPerson.toFixed(2).toString().split('.');
                            if (result[1]) {
                                var sup_price = result[1];
                            } else {
                                var sup_price = '00';
                            }
                            $('.form_person_0 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                            $('.wc-bookings-booking-cost .booking-costs-new').html("<span class='woocommerce-Price-amount amount'><span class='woocommerce-Price-currencySymbol'>$</span><span class='custom-prc'>" + autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup></span></span>");
                        }
                        if ($('.form-field.form_person_1').length) {
                            var costPersonFirst = $('.form_person_1 .price-person').attr('data-cost-person');
                            var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                            var result = costsPerson.toFixed(2).toString().split('.');
                            if (result[1]) {
                                var sup_price = result[1];
                            } else {
                                var sup_price = '00';
                            }
                            $('.form_person_1 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                        }
                        if ($('.form-field.form_person_2').length) {
                            var costPersonFirst = $('.form_person_2 .price-person').attr('data-cost-person');
                            var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                            var result = costsPerson.toFixed(2).toString().split('.');
                            if (result[1]) {
                                var sup_price = result[1];
                            } else {
                                var sup_price = '00';
                            }
                            $('.form_person_2 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                        }
                        if ($('.form-field.form_person_3').length) {
                            var costPersonFirst = $('.form_person_3 .price-person').attr('data-cost-person');
                            var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                            var result = costsPerson.toFixed(2).toString().split('.');
                            if (result[1]) {
                                var sup_price = result[1];
                            } else {
                                var sup_price = '00';
                            }
                            $('.form_person_3 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                        }
                        jQuery('.tour-island').text(optionname);
                        jQuery('.tour-island').css("display", "block");
                        jQuery('.fa-angle-down').css("display", "none");
                        jQuery('.field_resource  .icon-check').css("display", "block");
                    } else {
                        var islandName = jQuery('.list-costs-island li:first-child .island-name').text();
                        jQuery('.list-costs-island li:first-child').addClass('selected');
                        jQuery("#wc_bookings_field_resource option:first").prop("selected", "selected");
                        var costResource = $('.list-costs-island li:first-child').attr('data-cost');
                        if ($('.form-field.form_person_0').length) {
                            var costPersonFirst = $('.form_person_0 .price-person').attr('data-cost-person');
                            var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                            var result = costsPerson.toFixed(2).toString().split('.');
                            if (result[1]) {
                                var sup_price = result[1];
                            } else {
                                var sup_price = '00';
                            }
                            $('.form_person_0 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                            $('.wc-bookings-booking-cost .booking-costs-new').html("<span class='woocommerce-Price-amount amount'><span class='woocommerce-Price-currencySymbol'>$</span><span class='custom-prc'>" + autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup></span></span>");
                        }
                        if ($('.form-field.form_person_1').length) {
                            var costPersonFirst = $('.form_person_1 .price-person').attr('data-cost-person');
                            var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                            var result = costsPerson.toFixed(2).toString().split('.');
                            if (result[1]) {
                                var sup_price = result[1];
                            } else {
                                var sup_price = '00';
                            }
                            $('.form_person_1 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                        }
                        if ($('.form-field.form_person_2').length) {
                            var costPersonFirst = $('.form_person_2 .price-person').attr('data-cost-person');
                            var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                            var result = costsPerson.toFixed(2).toString().split('.');
                            if (result[1]) {
                                var sup_price = result[1];
                            } else {
                                var sup_price = '00';
                            }
                            $('.form_person_2 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                        }
                        if ($('.form-field.form_person_3').length) {
                            var costPersonFirst = $('.form_person_3 .price-person').attr('data-cost-person');
                            var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                            var result = costsPerson.toFixed(2).toString().split('.');
                            if (result[1]) {
                                var sup_price = result[1];
                            } else {
                                var sup_price = '00';
                            }
                            $('.form_person_3 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                        }
                        jQuery('.tour-island').text(islandName);
                        jQuery('.tour-island').css("display", "block");
                        jQuery('.fa-angle-down').css("display", "none");
                        jQuery('.field_resource  .icon-check').css("display", "block");
                    }
                });
            } else {
                var islandName = jQuery('.list-costs-island li[data-fields="3468"] .island-name').text();
                if (islandName.length !== 0) {
                    jQuery('.list-costs-island li[data-fields="3468"]').addClass('selected');
                    jQuery("#wc_bookings_field_resource option[value='3468']").prop("selected", "selected");
                    var costResource = $('.list-costs-island li[data-fields="3468"]').attr('data-cost');
                    if ($('.form-field.form_person_0').length) {
                        var costPersonFirst = $('.form_person_0 .price-person').attr('data-cost-person');
                        var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                        var result = costsPerson.toFixed(2).toString().split('.');
                        if (result[1]) {
                            var sup_price = result[1];
                        } else {
                            var sup_price = '00';
                        }
                        $('.form_person_0 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                        $('.wc-bookings-booking-cost .booking-costs-new').html("<span class='woocommerce-Price-amount amount'><span class='woocommerce-Price-currencySymbol'>$</span><span class='custom-prc'>" + autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup></span></span>");
                    }
                    if ($('.form-field.form_person_1').length) {
                        var costPersonFirst = $('.form_person_1 .price-person').attr('data-cost-person');
                        var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                        var result = costsPerson.toFixed(2).toString().split('.');
                        if (result[1]) {
                            var sup_price = result[1];
                        } else {
                            var sup_price = '00';
                        }
                        $('.form_person_1 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                    }
                    if ($('.form-field.form_person_2').length) {
                        var costPersonFirst = $('.form_person_2 .price-person').attr('data-cost-person');
                        var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                        var result = costsPerson.toFixed(2).toString().split('.');
                        if (result[1]) {
                            var sup_price = result[1];
                        } else {
                            var sup_price = '00';
                        }
                        $('.form_person_2 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                    }
                    if ($('.form-field.form_person_3').length) {
                        var costPersonFirst = $('.form_person_3 .price-person').attr('data-cost-person');
                        var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                        var result = costsPerson.toFixed(2).toString().split('.');
                        if (result[1]) {
                            var sup_price = result[1];
                        } else {
                            var sup_price = '00';
                        }
                        $('.form_person_3 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                    }
                    jQuery('.tour-island').text(islandName);
                    jQuery('.tour-island').css("display", "block");
                    jQuery('.fa-angle-down').css("display", "none");
                    jQuery('.field_resource  .icon-check').css("display", "block");
                } else {
                    var islandName = jQuery('.list-costs-island li:first-child .island-name').text();
                    jQuery('.list-costs-island li:first-child').addClass('selected');
                    jQuery("#wc_bookings_field_resource option:first").prop("selected", "selected");
                    var costResource = $('.list-costs-island li:first-child').attr('data-cost');
                    if ($('.form-field.form_person_0').length) {
                        var costPersonFirst = $('.form_person_0 .price-person').attr('data-cost-person');
                        var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                        var result = costsPerson.toFixed(2).toString().split('.');
                        if (result[1]) {
                            var sup_price = result[1];
                        } else {
                            var sup_price = '00';
                        }
                        $('.form_person_0 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                        $('.wc-bookings-booking-cost .booking-costs-new').html("<span class='woocommerce-Price-amount amount'><span class='woocommerce-Price-currencySymbol'>$</span><span class='custom-prc'>" + autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup></span></span>");
                    }
                    if ($('.form-field.form_person_1').length) {
                        var costPersonFirst = $('.form_person_1 .price-person').attr('data-cost-person');
                        var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                        var result = costsPerson.toFixed(2).toString().split('.');
                        if (result[1]) {
                            var sup_price = result[1];
                        } else {
                            var sup_price = '00';
                        }
                        $('.form_person_1 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                    }
                    if ($('.form-field.form_person_2').length) {
                        var costPersonFirst = $('.form_person_2 .price-person').attr('data-cost-person');
                        var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                        var result = costsPerson.toFixed(2).toString().split('.');
                        if (result[1]) {
                            var sup_price = result[1];
                        } else {
                            var sup_price = '00';
                        }
                        $('.form_person_2 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                    }
                    if ($('.form-field.form_person_3').length) {
                        var costPersonFirst = $('.form_person_3 .price-person').attr('data-cost-person');
                        var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                        var result = costsPerson.toFixed(2).toString().split('.');
                        if (result[1]) {
                            var sup_price = result[1];
                        } else {
                            var sup_price = '00';
                        }
                        $('.form_person_3 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                    }
                    jQuery('.tour-island').text(islandName);
                    jQuery('.tour-island').css("display", "block");
                    jQuery('.fa-angle-down').css("display", "none");
                    jQuery('.field_resource  .icon-check').css("display", "block");
                }
            }
        } else {
            var islandName = jQuery('.list-costs-island li[data-fields="3468"] .island-name').text();
            if (islandName.length !== 0 && localStorage.Homename === '') {
                var islandPrice = jQuery('.list-costs-island li[data-fields="3468"] .plus-price').html();
                jQuery('.list-costs-island li[data-fields="3468"]').addClass('selected');
                jQuery("#wc_bookings_field_resource option[value='3468']").prop("selected", "selected");
                var costResource = $('.list-costs-island li[data-fields="3468"]').attr('data-cost');
                if ($('.form-field.form_person_0').length) {
                    var costPersonFirst = $('.form_person_0 .price-person').attr('data-cost-person');
                    var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                    var result = costsPerson.toFixed(2).toString().split('.');
                    if (result[1]) {
                        var sup_price = result[1];
                    } else {
                        var sup_price = '00';
                    }
                    $('.form_person_0 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                    $('.wc-bookings-booking-cost .booking-costs-new').html("<span class='woocommerce-Price-amount amount'><span class='woocommerce-Price-currencySymbol'>$</span><span class='custom-prc'>" + autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup></span></span>");
                }
                if ($('.form-field.form_person_1').length) {
                    var costPersonFirst = $('.form_person_1 .price-person').attr('data-cost-person');
                    var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                    var result = costsPerson.toFixed(2).toString().split('.');
                    if (result[1]) {
                        var sup_price = result[1];
                    } else {
                        var sup_price = '00';
                    }
                    $('.form_person_1 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                }
                if ($('.form-field.form_person_2').length) {
                    var costPersonFirst = $('.form_person_2 .price-person').attr('data-cost-person');
                    var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                    var result = costsPerson.toFixed(2).toString().split('.');
                    if (result[1]) {
                        var sup_price = result[1];
                    } else {
                        var sup_price = '00';
                    }
                    $('.form_person_2 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                }
                if ($('.form-field.form_person_3').length) {
                    var costPersonFirst = $('.form_person_3 .price-person').attr('data-cost-person');
                    var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                    var result = costsPerson.toFixed(2).toString().split('.');
                    if (result[1]) {
                        var sup_price = result[1];
                    } else {
                        var sup_price = '00';
                    }
                    $('.form_person_3 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                }
                jQuery('.tour-island').text(islandName);
                jQuery('.tour-island').css("display", "block");
                jQuery('.fa-angle-down').css("display", "none");
                jQuery('.field_resource  .icon-check').css("display", "block");
            } else {
                var islandName = jQuery('.list-costs-island li:first-child .island-name').text();
                jQuery('.list-costs-island li:first-child').addClass('selected');
                jQuery("#wc_bookings_field_resource option:first").prop("selected", "selected");
                var costResource = $('.list-costs-island li:first-child').attr('data-cost');
                if ($('.form-field.form_person_0').length) {
                    var costPersonFirst = $('.form_person_0 .price-person').attr('data-cost-person');
                    var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                    var result = costsPerson.toFixed(2).toString().split('.');
                    if (result[1]) {
                        var sup_price = result[1];
                    } else {
                        var sup_price = '00';
                    }
                    $('.form_person_0 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                    $('.wc-bookings-booking-cost .booking-costs-new').html("<span class='woocommerce-Price-amount amount'><span class='woocommerce-Price-currencySymbol'>$</span><span class='custom-prc'>" + autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup></span></span>");
                }
                if ($('.form-field.form_person_1').length) {
                    var costPersonFirst = $('.form_person_1 .price-person').attr('data-cost-person');
                    var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                    var result = costsPerson.toFixed(2).toString().split('.');
                    if (result[1]) {
                        var sup_price = result[1];
                    } else {
                        var sup_price = '00';
                    }
                    $('.form_person_1 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                }
                if ($('.form-field.form_person_2').length) {
                    var costPersonFirst = $('.form_person_2 .price-person').attr('data-cost-person');
                    var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                    var result = costsPerson.toFixed(2).toString().split('.');
                    if (result[1]) {
                        var sup_price = result[1];
                    } else {
                        var sup_price = '00';
                    }
                    $('.form_person_2 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                }
                if ($('.form-field.form_person_3').length) {
                    var costPersonFirst = $('.form_person_3 .price-person').attr('data-cost-person');
                    var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
                    var result = costsPerson.toFixed(2).toString().split('.');
                    if (result[1]) {
                        var sup_price = result[1];
                    } else {
                        var sup_price = '00';
                    }
                    $('.form_person_3 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                }
                jQuery('.tour-island').text(islandName);
                jQuery('.tour-island').css("display", "block");
                jQuery('.fa-angle-down').css("display", "none");
                jQuery('.field_resource  .icon-check').css("display", "block");
            }
        }
    }*/
    localStorage.clear();
    if (jQuery('.single-product.postid-23497').length) {
        var islandName = jQuery('.list-costs-island li:first-child .island-name').text();
        jQuery('.list-costs-island li:first-child').addClass('selected');
        jQuery("#wc_bookings_field_resource option:nth-child(2)").prop("selected", "selected");
        var costResource = $('.list-costs-island li:first-child').attr('data-cost');
        if ($('.form-field.form_person_0').length) {
            var costPersonFirst = $('.form_person_0 .price-person').attr('data-cost-person');
            var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);
            var result = costsPerson.toFixed(2).toString().split('.');
            if (result[1]) {
                var sup_price = result[1];
            } else {
                var sup_price = '00';
            }
            $('.form_person_0 .price-person .custom-prc').html(autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
            $('.wc-bookings-booking-cost .booking-costs-new').html("<span class='woocommerce-Price-amount amount'><span class='woocommerce-Price-currencySymbol'>$</span><span class='custom-prc'>" + autoAddCommasPrice(result[0]) + "<sup>." + sup_price + "</sup></span></span>");
        }
        jQuery('.tour-island').text(islandName);
        jQuery('.tour-island').css("display", "block");
        //jQuery('.fa-angle-down').css("display", "none");
        jQuery('.field_resource  .icon-check').css("display", "block");
        jQuery('.booking_date_day').val('03');
        jQuery('.booking_date_month').val('06');
        jQuery('.booking_date_year').val('2020');
        jQuery('.wc_bookings_field_start_date .ht-choose-date legend, .wc_bookings_field_start_date .bookings-date-1 legend').css('display', 'none');
        jQuery('.wc-bookings-date-picker-date-fields').css('display', 'block');
        jQuery('.wc_bookings_field_start_date .wc-icon-calendar').css('display', 'none');
        jQuery('.wc_bookings_field_start_date .icon-check').css('display', 'block');
        jQuery('.mm-calendar-absolute').text('');
        jQuery('.bookings-date-1, .wc-bookings-date-picker-date-fields, .bookings-date-1 *, .wc-bookings-date-picker-date-fields *').click(false);
        jQuery(".booking_date_day, .booking_date_month, .booking_date_year").attr('readonly', 'readonly');
        jQuery('.bookings-date-1, .wc-bookings-date-picker-date-fields, .booking_date_day, .booking_date_month, .booking_date_year, .bookings-date-1 img').css('cursor','no-drop');
        jQuery('.single_add_to_cart_button').removeClass('disabled');
        jQuery('.single_add_to_cart_button').attr("disabled", false);
    }
    if (jQuery('.single-product.postid-194724').length || jQuery('.single-product.postid-204526').length || jQuery('.single-product.postid-204554').length || jQuery('.single-product.postid-204635').length || jQuery('.single-product.postid-204872').length) {
        var booking_date_day = '09';
        if(jQuery('.single-product.postid-194724').length || jQuery('.single-product.postid-204872').length){
            var booking_date_day = '09';
        }
        if(jQuery('.single-product.postid-204526').length){
            var booking_date_day = '06';
        }
        if(jQuery('.single-product.postid-204554').length || jQuery('.single-product.postid-204635').length){
            var booking_date_day = '14';
        }
        jQuery('.booking_date_day').val(booking_date_day);
        jQuery('.booking_date_month').val('10');
        jQuery('.booking_date_year').val('2022');
        jQuery('.wc_bookings_field_start_date .ht-choose-date legend, .wc_bookings_field_start_date .bookings-date-1 legend').css('display', 'none');
        jQuery('.wc-bookings-date-picker-date-fields').css('display', 'block');
        jQuery('.mm-calendar-absolute').text('');
        jQuery('.wc_bookings_field_start_date .wc-icon-calendar').css('display', 'none');
        jQuery('.wc_bookings_field_start_date .icon-check').css('display', 'block');
        jQuery('.bookings-date-1, .wc-bookings-date-picker-date-fields, .bookings-date-1 *, .wc-bookings-date-picker-date-fields *').click(false);
        jQuery(".booking_date_day, .booking_date_month, .booking_date_year").attr('readonly', 'readonly');
        jQuery('.bookings-date-1, .wc-bookings-date-picker-date-fields, .booking_date_day, .booking_date_month, .booking_date_year, .bookings-date-1 img').css('cursor','no-drop');
        jQuery('.single_add_to_cart_button').removeClass('disabled');
        jQuery('.single_add_to_cart_button').attr("disabled", false);
        jQuery('.customer-info-field').css('display','block');
        jQuery('.tc-extra-product-options').css('display','block');
        setTimeout(function(){
            jQuery('.single_add_to_cart_button').removeClass('disabled');
            jQuery('.single_add_to_cart_button').attr("disabled", false);
            var costResource = jQuery('.list-costs-island li:nth-child(1) .plus-price').html();
            jQuery('.wc-bookings-booking-cost .booking-costs-new').html(costResource);
            
        }, 500);
    }
    if (jQuery('.single-product.postid-702635').length) {
        var booking_date_day = '07';
        
        jQuery('.booking_date_day').val(booking_date_day);
        jQuery('.booking_date_month').val('11');
        jQuery('.booking_date_year').val('2024');
        jQuery('.wc_bookings_field_start_date .ht-choose-date legend, .wc_bookings_field_start_date .bookings-date-1 legend').css('display', 'none');
        jQuery('.wc-bookings-date-picker-date-fields').css('display', 'block');
        jQuery('.mm-calendar-absolute').text('');
        jQuery('.wc_bookings_field_start_date .wc-icon-calendar').css('display', 'none');
        jQuery('.wc_bookings_field_start_date .icon-check').css('display', 'block');
        jQuery('.bookings-date-1, .wc-bookings-date-picker-date-fields, .bookings-date-1 *, .wc-bookings-date-picker-date-fields *').click(false);
        jQuery(".booking_date_day, .booking_date_month, .booking_date_year").attr('readonly', 'readonly');
        jQuery('.bookings-date-1, .wc-bookings-date-picker-date-fields, .booking_date_day, .booking_date_month, .booking_date_year, .bookings-date-1 img').css('cursor','no-drop');
        jQuery('.single_add_to_cart_button').removeClass('disabled');
        jQuery('.single_add_to_cart_button').attr("disabled", false);
        jQuery('.customer-info-field').css('display','block');
        jQuery('.tc-extra-product-options').css('display','block');
        setTimeout(function(){
            jQuery('.single_add_to_cart_button').removeClass('disabled');
            jQuery('.single_add_to_cart_button').attr("disabled", false);
            var costResource = jQuery('.list-costs-island li:nth-child(1) .plus-price').html();
            jQuery('.wc-bookings-booking-cost .booking-costs-new').html(costResource);
            
        }, 500);
    }
    
    function addCommasPrice(nStr)
    {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
    }
});

