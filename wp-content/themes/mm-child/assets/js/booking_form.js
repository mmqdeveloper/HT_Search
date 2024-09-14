jQuery(document).ready(function ($) {
    // This button will increment the value
    //$('label[for="wc_bookings_field_persons_1121"] .person-name').text('Van');
    //$('label[for="wc_bookings_field_persons_34525"] .person-name').text('Van');
    
    $('.form_person_0 select.mm-bookings-field-select#wc_bookings_field_persons_360025').attr('max', '10');
    if ($('.postid-11261').length ||  $('.postid-5946').length || $('.postid-6231').length || $('.postid-164539').length ) {
        $('.form_person_1, .form_person_2').css('display','none');
        if($('.postid-6231').length){
            $('.form_person_0 select.mm-bookings-field-select').val('1');
        }
    }
    if ($('.postid-213251').length){
        $('.form_person_2').css('display','none');
    }
    
    if ($('.postid-11261').length){
        $('.form_person_0').css('display','none');
        $('.form_person_0 select.mm-bookings-field-select').val('0');
    }
    if ($('.postid-5480').length) {
        $('.form_person_0 select.mm-bookings-field-select option[value="0"]').css('display','none');
        $('.form_person_0 select.mm-bookings-field-select option[value="1"]').css('display','none');
        $('.form_person_1').css('display','none');
        $('.form_person_1 select.mm-bookings-field-select').val('0');
    }
    if ($('.postid-19254').length) {
        $('.wc_bookings_field_persons_585239, .wc_bookings_field_persons_585241').css('display','none');
        $('.wc_bookings_field_persons_585239 select.mm-bookings-field-select, .wc_bookings_field_persons_585241 select.mm-bookings-field-select').val('0');
    }
    if ($('.postid-194886').length) {
        $('.wc_bookings_field_persons_589100, .wc_bookings_field_persons_589111, .wc_bookings_field_persons_589101, .wc_bookings_field_persons_589112').css('display','none');
        $('.wc_bookings_field_persons_589100 select.mm-bookings-field-select, .wc_bookings_field_persons_589111 select.mm-bookings-field-select, .wc_bookings_field_persons_589101 select.mm-bookings-field-select, .wc_bookings_field_persons_589112 select.mm-bookings-field-select').val('0');
    }
    if ($('.postid-184305').length){
        $('.form_person_0 select.mm-bookings-field-select option[value="0"]').css('display','none');
        $('.form_person_0 select.mm-bookings-field-select option[value="1"]').css('display','none');
    }
    if ($('.postid-512979').length) {
        jQuery('.form_person_1 .mm-bookings-field-select').find('option[value="1"]').css('display','none');
        jQuery('.form_person_2 .mm-bookings-field-select').find('option[value="1"]').css('display','none');
        jQuery('.form_person_2 .mm-bookings-field-select').find('option[value="2"]').css('display','none');
        jQuery('.form_person_3 .mm-bookings-field-select').find('option[value="1"]').css('display','none');
        jQuery('.form_person_3 .mm-bookings-field-select').find('option[value="2"]').css('display','none');
        jQuery('.form_person_3 .mm-bookings-field-select').find('option[value="3"]').css('display','none');
    }
    if ($('.postid-28279').length){
        $('.form_person_1').css('display','none');
        $('.form_person_1 select.mm-bookings-field-select').val('0');
    }
    if ($('.postid-105724').length){
        $('.wc_bookings_field_persons_174582 select.mm-bookings-field-select option[value="1"]').css('display','none');
        $('.wc_bookings_field_persons_174579 select.mm-bookings-field-select option[value="1"]').css('display','none');
        $('.wc_bookings_field_persons_174580 select.mm-bookings-field-select option[value="1"]').css('display','none');
        $('.wc_bookings_field_persons_174580 select.mm-bookings-field-select option[value="2"]').css('display','none');
        $('.wc_bookings_field_persons_174581 select.mm-bookings-field-select option[value="1"]').css('display','none');
    }
    if ($('.postid-232721').length){
        $('.wc_bookings_field_persons_299542 select.mm-bookings-field-select option[value="1"]').css('display','none');
        $('.wc_bookings_field_persons_232728 select.mm-bookings-field-select option[value="1"]').css('display','none');
        $('.wc_bookings_field_persons_232728 select.mm-bookings-field-select option[value="2"]').css('display','none');
        $('.wc_bookings_field_persons_232729 select.mm-bookings-field-select option[value="1"]').css('display','none');
        $('.wc_bookings_field_persons_232729 select.mm-bookings-field-select option[value="2"]').css('display','none');
        $('.wc_bookings_field_persons_232729 select.mm-bookings-field-select option[value="3"]').css('display','none');
        
    }
    if ($('.postid-237220').length){
        $('.wc_bookings_field_persons_299537 select.mm-bookings-field-select option[value="1"]').css('display','none');
        $('.wc_bookings_field_persons_299538 select.mm-bookings-field-select option[value="1"]').css('display','none');
        $('.wc_bookings_field_persons_299538 select.mm-bookings-field-select option[value="2"]').css('display','none');
        $('.wc_bookings_field_persons_299540 select.mm-bookings-field-select option[value="1"]').css('display','none');
        $('.wc_bookings_field_persons_299540 select.mm-bookings-field-select option[value="2"]').css('display','none');
        $('.wc_bookings_field_persons_299540 select.mm-bookings-field-select option[value="3"]').css('display','none');
        
    }
    if ($('.postid-577863').length){
        $('.form_person_0 select.mm-bookings-field-select option[value="3"]').remove();
        $('.form_person_0 select.mm-bookings-field-select option[value="4"]').remove();
    }
    if ($('.postid-5590').length){
        $('.form_person_3').css('display','none');
        $('.form_person_4').css('display','none');
    }
    if ($('.postid-151954').length){
        $('.form_person_1').css('display','none');
        $('.wc_bookings_field_persons_635642 select.mm-bookings-field-select option[value="0"]').css('display','none');
        $('.wc_bookings_field_persons_635642 select.mm-bookings-field-select option[value="1"]').css('display','none');
        $('.wc_bookings_field_persons_635642  select.mm-bookings-field-select').val('2');
    }
    if ($('.postid-80080').length){
        $('.form_person_2').css('display','none');
        $('.form_person_3').css('display','none');
        $('.form_person_0 select.mm-bookings-field-select option[value="0"]').css('display','none');
        $('.form_person_2  select.mm-bookings-field-select').val('0');
        $('.form_person_3  select.mm-bookings-field-select').val('0');
    }
    if ($('.postid-86230').length){
        $('.form_person_1').css('display','none');
        $('.form_person_2').css('display','none');
        $('.form_person_3').css('display','none');
        $('.form_person_0 select.mm-bookings-field-select option[value="0"]').css('display','none');
        $('.form_person_1  select.mm-bookings-field-select').val('0');
        $('.form_person_2  select.mm-bookings-field-select').val('0');
        $('.form_person_3  select.mm-bookings-field-select').val('0');
    }
    if ($('.postid-27480').length){
        $('.form_person_2').css('display','none');
        $('.form_person_4').css('display','none');
    }
    if ($('.postid-6576').length){
        $('.form_person_3').css('display','none');
        $('.form_person_3 select.mm-bookings-field-select').val('0');
    }
    if($('.postid-3920').length){
        $('.customer-info-field  .customer-info-item').css('display','none');
    }
    if ($('.postid-218407').length){
        $('.form_person_1').css('display','none');
        $('.form_person_2').css('display','none');
        $('.form_person_3').css('display','none');
        $('.form_person_0 select.mm-bookings-field-select option[value="1"]').css('display','none');
        $('.form_person_1 select.mm-bookings-field-select option[value="1"]').css('display','none');
        $('.form_person_2 select.mm-bookings-field-select option[value="1"]').css('display','none');
        $('.form_person_2 select.mm-bookings-field-select option[value="2"]').css('display','none');
        $('.form_person_3 select.mm-bookings-field-select option[value="1"]').css('display','none');
        $('.form_person_3 select.mm-bookings-field-select option[value="2"]').css('display','none');
        $('.form_person_3 select.mm-bookings-field-select option[value="3"]').css('display','none');
        $('.form_person_1  select.mm-bookings-field-select').val('0');
        $('.form_person_2  select.mm-bookings-field-select').val('0');
        $('.form_person_3  select.mm-bookings-field-select').val('0');
    }
    if ($('.postid-215905').length){
        $('.form_person_1').css('display','none');
        $('.form_person_1 select.mm-bookings-field-select').val('0');
    }
    if ($('.postid-360130').length){
        $('.form_person_1').css('display','none');
        $('.form_person_1 select.mm-bookings-field-select').val('0');
    }
    if ($('.postid-359863').length){
        $('.mm-content-person .person-description-tooltip').css('display','none');
    }
    $(document).on('click', '.form_field_person [data-quantity="plus"]', function (e) {
        // Stop acting like a button
        e.preventDefault();
        //check choose date
        if ($('.required_for_calculation.booking_date_month').val() === '') {
            $('.wc-bookings-booking-cost').html('<span class="booking-error">Choose a date above to see available times</span>');
        }
        // Get the field name
        var fieldName = $(this).attr('data-field');
        var tour_id = $('.wc-booking-product-id').val();
        // Get its current value
        var currentVal = parseInt($('select[name=' + fieldName + ']').val());
        var quantity_min = $('select[name=' + fieldName + ']').attr('min');
        var quantity_max = $('select[name=' + fieldName + ']').attr('max');
        if (typeof quantity_max !== typeof undefined && quantity_max !== false) {
            var check_max_quantity = true;
            if(quantity_max<=currentVal){
                $('button[data-field=' + fieldName + '][data-quantity="plus"]').attr("disabled", true);
                return;
            }
        }
        if (typeof quantity_min !== typeof undefined && quantity_min !== false) {
            if(quantity_min<=currentVal){
                $('button[data-field=' + fieldName + '][data-quantity="minus"]').attr("disabled", false);
            }
        } 
        // If is not undefined
        if (!isNaN(currentVal)) {
            // Increment
            $('select[name=' + fieldName + ']').val(currentVal + 1);
            $('select[name=' + fieldName + ']').attr("data-value", currentVal + 1);
            /*if (tour_id == 165337 || tour_id == 239676 || tour_id == 234090 || tour_id == 164794) {
                $('select[name=' + fieldName + ']').val(quantity_max);
                $('select[name=' + fieldName + ']').attr("data-value", quantity_max);
                $('button[data-field=' + fieldName + '][data-quantity="plus"]').attr("disabled", true);
                $('button[data-field=' + fieldName + '][data-quantity="minus"]').attr("disabled", false);
            }*/
            /*if (tour_id == 1120) {
                var qty_people = currentVal + 1;
                var tour_island_text = '';
                var tour_price = '';
                var resource_id = $('#wc_bookings_field_resource').val();
                if (qty_people <7 && resource_id != 63854) {
                    $("#wc_bookings_field_resource > option[value=63853]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="63853"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="63853"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    $('.person-name').text(tour_island_text);
                }else if (qty_people > 4 && qty_people <= 6) {
                    $("#wc_bookings_field_resource > option[value=63854]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="63854"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="63854"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    $('.person-name').text(tour_island_text);
                }if (qty_people <7 ) {
                    $("#wc_bookings_field_resource > option[value=63853]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="63853"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="63853"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    $('.person-name').text(tour_island_text);
                }else if (qty_people >= 7 && qty_people <= 13) {
                    $("#wc_bookings_field_resource > option[value=63858]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="63858"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="63858"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    $('.person-name').text(tour_island_text);
                } else if (qty_people > 13) {
                    $("#wc_bookings_field_resource > option[value=3504]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="3504"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="3504"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    $('.person-name').text(tour_island_text);
                }
            } */
            if (tour_id == 101441) {
                var qty_people = currentVal + 1;
                var tour_island_text = '';
                var tour_price = '';
                var resource_id = $('#wc_bookings_field_resource').val();
                if (qty_people >6 && resource_id == 194437) {
                    $("#wc_bookings_field_resource > option[value=194441]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="194441"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="194441"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    $('.person-name').text(tour_island_text);
                }else if (qty_people >14 && resource_id == 194441) {
                    $("#wc_bookings_field_resource > option[value=275932]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="275932"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="275932"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    $('.person-name').text(tour_island_text);
                }else if (qty_people > 6 && resource_id == 194434) {
                    $("#wc_bookings_field_resource > option[value=194439]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="194439"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="194439"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    $('.person-name').text(tour_island_text);
                } 
            } 
            if (tour_id == 34517) {
                var qty_people = currentVal + 1;
                var tour_island_text = '';
                var tour_price = '';
                var resource_id = $('#wc_bookings_field_resource').val();
                if (qty_people >5) {
                    $("#wc_bookings_field_resource > option[value=3503]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="3503"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="3503"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    $('.person-name').text("Mercedes Sprinter");
                }
            } 
            if (tour_id == 164794) {
                var qty_people = currentVal + 1;
                var tour_island_text = '';
                var tour_price = '';
                var resource_id = $('#wc_bookings_field_resource').val();
                if (qty_people >3) {
                    $("#wc_bookings_field_resource > option[value=331676]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="331676"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="331676"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    $('.person-name').text(tour_island_text);
                }
            } 
            if (tour_id == 165337) {
                var qty_people = currentVal + 1;
                var tour_island_text = '';
                var tour_price = '';
                var resource_id = $('#wc_bookings_field_resource').val();
                if (qty_people >7) {
                    $("#wc_bookings_field_resource > option[value=331260]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="331260"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="331260"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    $('.person-name').text(tour_island_text);
                }else if (qty_people >5 && (resource_id == 3501 || resource_id == 3502)) {
                    $("#wc_bookings_field_resource > option[value=331702]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="331702"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="331702"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    $('.person-name').text(tour_island_text);
                }else if (qty_people >3 && resource_id == 3501) {
                    $("#wc_bookings_field_resource > option[value=3502]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="3502"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="3502"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    $('.person-name').text(tour_island_text);
                } 
            } 
            if (tour_id == 234090) {
                var qty_people = currentVal + 1;
                var tour_island_text = '';
                var tour_price = '';
                var resource_id = $('#wc_bookings_field_resource').val();
                if (qty_people >6) {
                    $("#wc_bookings_field_resource > option[value=272994]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="272994"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="272994"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    $('.person-name').text(tour_island_text);
                }else if (qty_people >5 && (resource_id == 272989 || resource_id == 272993)) {
                    $("#wc_bookings_field_resource > option[value=272992]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="272992"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="272992"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    $('.person-name').text(tour_island_text);
                }else if (qty_people >3 && resource_id == 272989) {
                    $("#wc_bookings_field_resource > option[value=272993]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="272993"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="272993"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    $('.person-name').text(tour_island_text);
                } 
            } 
            if (tour_id == 239676) {
                var qty_people = currentVal + 1;
                var tour_island_text = '';
                var tour_price = '';
                var resource_id = $('#wc_bookings_field_resource').val();
                if (qty_people >6) {
                    $("#wc_bookings_field_resource > option[value=273008]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="273008"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="273008"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    $('.person-name').text(tour_island_text);
                }else if (qty_people >5 && (resource_id == 273007 || resource_id == 273009)) {
                    $("#wc_bookings_field_resource > option[value=273010]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="273010"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="273010"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    $('.person-name').text(tour_island_text);
                }else if (qty_people >3 && resource_id == 273007) {
                    $("#wc_bookings_field_resource > option[value=273009]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="273009"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="273009"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    $('.person-name').text(tour_island_text);
                } 
            } 
            if ((tour_id == 32265 || tour_id == 32899 || tour_id == 32913 || tour_id == 32927) && fieldName=='wc_bookings_field_duration') {
                var duration = currentVal + 1;
                if(duration<=8){
                    $("#wc_bookings_field_resource > option[value=32358]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    $('.tour-island').text($( "#wc_bookings_field_resource > option[value=32358]" ).text());
                    if($('.vacation_islands-div').length){
                        mm_package_auto_select_island('32358');
                    }
                }
                else if(duration<=11){
                    $("#wc_bookings_field_resource > option[value=32359]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    $('.tour-island').text($( "#wc_bookings_field_resource > option[value=32359]" ).text());
                    if($('.vacation_islands-div').length){
                        mm_package_auto_select_island('32359');
                    }
                }
                else if(duration>11){
                    $("#wc_bookings_field_resource > option[value=32360]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    $('.tour-island').text($( "#wc_bookings_field_resource > option[value=32360]" ).text());
                    if($('.vacation_islands-div').length){
                        mm_package_auto_select_island('32360');
                    }
                }
                
            }
            if (tour_id == 360050) {
                var qty_people = currentVal + 1;
                var tour_island_text = '';
                var tour_price = '';
                var resource_id = $('#wc_bookings_field_resource').val();
                if (qty_people >7) {
                    $("#wc_bookings_field_resource > option[value=372840]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="372840"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="372840"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    $('.person-name').text('Mercedes Sprinter (up to 11 guests)');
                }else if (qty_people >5 && (resource_id == 372838)) {
                    $("#wc_bookings_field_resource > option[value=372839]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="372839"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="372839"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    $('.person-name').text('SUV (up to 7 guests)');
                }
            } 
            if(tour_id ==  32960 && fieldName=='wc_bookings_field_duration'){
                var duration = currentVal + 1;
                if(duration==4){
                    $("#wc_bookings_field_resource > option[value=333777]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    $('.tour-island').text($( "#wc_bookings_field_resource > option[value=333777]" ).text());
                }
                if(duration==5){
                    $("#wc_bookings_field_resource > option[value=333779]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    $('.tour-island').text($( "#wc_bookings_field_resource > option[value=333779]" ).text());
                }
                if(duration>=6){
                    $("#wc_bookings_field_resource > option[value=333780]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    $('.tour-island').text($( "#wc_bookings_field_resource > option[value=333780]" ).text());
                }
            }
            if (tour_id == 194724) {
                var qty_people = currentVal + 1;
                var resource_title = '';
                if(qty_people == 1){
                    $("#wc_bookings_field_resource > option[value=196826]").prop("selected", true);
                    resource_title = $('.list-costs-island li[data-fields="196826"] .island-name').text();
                }else if(qty_people == 2){
                    $("#wc_bookings_field_resource > option[value=196827]").prop("selected", true);
                    resource_title = $('.list-costs-island li[data-fields="196827"] .island-name').text();
                }else if(qty_people == 3){
                    $("#wc_bookings_field_resource > option[value=196828]").prop("selected", true);
                    resource_title = $('.list-costs-island li[data-fields="196828"] .island-name').text();
                }else if(qty_people == 4){
                    $("#wc_bookings_field_resource > option[value=196830]").prop("selected", true);
                    resource_title = $('.list-costs-island li[data-fields="196830"] .island-name').text();
                }
                if(resource_title!=''){
                    $('.tour-island').text(resource_title);
                }
                
            } 
            if (tour_id == 204535) {
                var qty_people = currentVal + 1;
                var resource_title = '';
                if(qty_people == 1){
                    $("#wc_bookings_field_resource > option[value=23499]").prop("selected", true);
                    resource_title = $('.list-costs-island li[data-fields="23499"] .island-name').text();
                }else if(qty_people == 2){
                    $("#wc_bookings_field_resource > option[value=23501]").prop("selected", true);
                    resource_title = $('.list-costs-island li[data-fields="23501"] .island-name').text();
                }else if(qty_people == 3){
                    $("#wc_bookings_field_resource > option[value=23502]").prop("selected", true);
                    resource_title = $('.list-costs-island li[data-fields="23502"] .island-name').text();
                }else if(qty_people == 4){
                    $("#wc_bookings_field_resource > option[value=23503]").prop("selected", true);
                    resource_title = $('.list-costs-island li[data-fields="23503"] .island-name').text();
                }
                if(resource_title!=''){
                    $('.tour-island').text(resource_title);
                }
            } 
            if (tour_id == 204526) {
                var qty_people = currentVal + 1;
                var resource_title = '';
                if(qty_people == 1){
                    $("#wc_bookings_field_resource > option[value=205983]").prop("selected", true);
                    resource_title = $('.list-costs-island li[data-fields="205983"] .island-name').text();
                }/*else if(qty_people == 2){
                    $("#wc_bookings_field_resource > option[value=205982]").prop("selected", true);
                    resource_title = $('.list-costs-island li[data-fields="205982"] .island-name').text();
                }*/
                if(resource_title!=''){
                    $('.tour-island').text(resource_title);
                }
            } 
            if (tour_id == 5590) {
                var resource_id = $('#wc_bookings_field_resource').val();
                if(resource_id == 117719){
                    var adult_count = $('.form_person_0  select.mm-bookings-field-select').val();
                    var child_count = $('.form_person_1  select.mm-bookings-field-select').val();
                    $('.form_person_1  select.mm-bookings-field-select').attr('max',adult_count);
                    $('.form_person_1 button[data-quantity="plus"]').attr("disabled", false);
                    if(child_count>adult_count){
                        $('.form_person_1  select.mm-bookings-field-select').val(adult_count);
                    }
                }else{
                    $('.form_person_1  select.mm-bookings-field-select').attr('max','6');
                }
            }
            if (tour_id == 11261 || tour_id == 5946) {
                var resource_id = $('#wc_bookings_field_resource').val();
                var hiker = $('.form_person_0  select.mm-bookings-field-select').val();
                if(hiker > 9 && (resource_id != 374689 && resource_id != 374680)){
                    $('.form_person_0  select.mm-bookings-field-select').val('0');
                    $('.form_person_1  select.mm-bookings-field-select').val('10');
                    $('.form_person_1 select.mm-bookings-field-select').attr('min', '1');
                    $('.form_person_2 button[data-quantity="plus"]').attr("disabled", false);
                    $("select#wc_bookings_field_resource option:last-child").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    var tour_resource = $('.list-costs-island li:last-child .island-name').text();
                    var tour_price = $('.list-costs-island li:last-child .custom-prc').html();
                    $('.tour-island').text(tour_resource);
                    $('.form_person_1 .price-person .custom-prc').html(tour_price);
                    $('.form_person_2 .price-person .custom-prc').html('159<sup>.00</sup>');
                    $('.form_person_1, .form_person_2').css('display','');
                    $('.form_person_0').css('display','none');
                    if($('input.get_resource_id').length){
                        $("input.get_resource_id").each(function() {
                            var resource_change = $('.list-costs-island li:last-child').attr('data-fields');
                            $(this).val(resource_change);
                            $(this).change();
                        });
                    }
                    $('.ht-choose-date').trigger('click');
                }
            }
            if (tour_id == 164539) {
                var resource_id = $('#wc_bookings_field_resource').val();
                if(resource_id == 164384){
                    var adult_count = $('.form_person_0  select.mm-bookings-field-select').val();
                    if(adult_count>=2){
                        $('.form_person_1, .form_person_2').css('display','');
                    }else{
                        $('.form_person_1, .form_person_2').css('display','none');
                        $('.form_person_1  select.mm-bookings-field-select, .form_person_2  select.mm-bookings-field-select').val('0');
                    }
                }
            }
            if (tour_id == 476436 && fieldName == 'wc_bookings_field_persons_476632') {
                var qty_people = currentVal + 1;
                var tour_island_text = '';
                var tour_price = '';
                var resource_id = $('#wc_bookings_field_resource').val();
                if(qty_people >13){
                    $("#wc_bookings_field_resource > option[value=476629]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="476629"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="476629"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.form_person_0 .price-person .custom-prc').html(tour_price);
                    $('.mmt-button-waitlist').css('display','none');
                    $('.single_add_to_cart_button').css('display','');
                    if(qty_people >=20 && qty_people <=24){
                        $('.form_person_0 .price-person .custom-prc').html('400<sup>.00</sup>');
                    }else if(qty_people >=25 && qty_people <=29){
                        $('.form_person_0 .price-person .custom-prc').html('550<sup>.00</sup>');
                    }else if(qty_people >=30 && qty_people <=34){
                        $('.form_person_0 .price-person .custom-prc').html('600<sup>.00</sup>');
                    }else if(qty_people >=35 && qty_people <=39){
                        $('.form_person_0 .price-person .custom-prc').html('750<sup>.00</sup>');
                    }else if(qty_people >= 40){
                        $('.single_add_to_cart_button').css('display','none');
                        $('.mmt-button-waitlist').css('display','');
                    }
                }else if (qty_people >=6 && resource_id != 476576) {
                    $("#wc_bookings_field_resource > option[value=476576]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="476576"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="476576"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.form_person_0 .price-person .custom-prc').html(tour_price);
                    $('.mmt-button-waitlist').css('display','none');
                    $('.single_add_to_cart_button').css('display','');
                }else{
                    $('.mmt-button-waitlist').css('display','none');
                    $('.single_add_to_cart_button').css('display','');
                }
            } 
            if($(this).hasClass('mm_bookings_field_persons_Persons')){
                mm_package_auto_choose_room_field();
            }
            if(tour_id == 34517){
               if ($('select[name=' + fieldName + ']').val() == 12) {
                    $('button[data-field=' + fieldName + '][data-quantity="plus"]').attr("disabled", true);
                } 
            }
            else if (tour_id == 1120) {
                if ($('select[name=' + fieldName + ']').val() == 24) {
                    $('button[data-field=' + fieldName + '][data-quantity="plus"]').attr("disabled", true);
                }
            } else {
                if (check_max_quantity) {
                    if ($('select[name=' + fieldName + ']').val() == quantity_max) {
                        $('button[data-field=' + fieldName + '][data-quantity="plus"]').attr("disabled", true);
                    }
                }
                else if ($('select[name=' + fieldName + ']').val() == 20) {
                    $('button[data-field=' + fieldName + '][data-quantity="plus"]').attr("disabled", true);
                }
            }

        } else {
            // Otherwise put a 0 there
            $('select[name=' + fieldName + ']').val(0);
        }
        customer_info_field_bookingbox();
        auto_change_tm_quantity_bookingbox();
        if($('.get_person_id').length){
            mm_get_list_person_id_bookingbox();
        }
        if($('.mm_plan_total_guest').length){
            mm_change_plan_total_guest();
        }
        var xhr = [];
        var name = $(this).attr('name');
        var $fieldset = $(this).closest('fieldset');
        var $picker = $fieldset.find('.picker:eq(0)');
        if ($picker.data('is_range_picker_enabled')) {
            if ('wc_bookings_field_duration' !== name) {
                return;
            }
        }

        var index = $('.wc-bookings-booking-form').index(this);
        $form = $(this).closest('form');
        var isEmptyCalendarSelection = !$form.find("[name='wc_bookings_field_start_date_day']").val() &&
            !$form.find('#wc_bookings_field_start_date').val();

        // Do not update if triggered by Product Addons and no date is selected.
        if (jQuery(e.target).hasClass('addon') && isEmptyCalendarSelection) {
            return;
        }

        var required_fields = $form.find('input.required_for_calculation');
        var filled = true;
        $.each(required_fields, function (index, field) {
            var value = $(field).val();
            if (!value) {
                filled = false;
            }
        });
        if (!filled) {
            $form.find('.wc-bookings-booking-cost').hide();
            return;
        }

        $form.find('.wc-bookings-booking-cost').block({message: null, overlayCSS: {background: '#fff', backgroundSize: '16px 16px', opacity: 0.6}}).show();
        xhr[index] = $.ajax({
            type: 'POST',
            url: booking_form_params.ajax_url,
            data: {
                action: 'wc_bookings_calculate_costs',
                form: $form.serialize()
            },
            success: function (code) {
                if (code.charAt(0) !== '{') {
                    //console.log(code);
                    code = '{' + code.split(/\{(.+)?/)[1];
                }

                result = $.parseJSON(code);
                jQuery('.customer-info-field').css('display','none');
                jQuery('.tc-extra-product-options').css('display','none');
                if (result.result == 'ERROR') {
                    $form.find('.wc-bookings-booking-cost').html(result.html);
                    $form.find('.wc-bookings-booking-cost').unblock();
                    $form.find('.single_add_to_cart_button').addClass('disabled');
                    $form.find('.single_add_to_cart_button').attr("disabled", true);
                    if(result.html.indexOf("The maximum persons fareharbor")>=0){
                        $form.find('.wc-bookings-booking-cost').html('');
                        jQuery('.mmt-button-waitlist').css('display','');
                        jQuery('.single_add_to_cart_button').css('display','none');
                    }
                    else if(result.html.indexOf("Sorry, the selected block is not available")>=0){
                        jQuery('.mmt-button-waitlist').css('display','');
                        jQuery('.single_add_to_cart_button').css('display','none');
                    }
                } else if (result.result == 'SUCCESS') {
                    $form.find('.wc-bookings-booking-cost').html(result.html);
                    $form.find('.wc-bookings-booking-cost').unblock();
                    $form.find('.single_add_to_cart_button').removeClass('disabled');
                    $form.find('.single_add_to_cart_button').attr("disabled", false);
                    jQuery('.customer-info-field').css('display','block');
                    jQuery('.tc-extra-product-options').css('display','block');
                    jQuery('.mmt-button-waitlist').css('display','none');
                    jQuery('.single_add_to_cart_button').css('display','');
                } else {
                    $form.find('.wc-bookings-booking-cost').hide();
                    $form.find('.single_add_to_cart_button').addClass('disabled');
                    $form.find('.single_add_to_cart_button').attr("disabled", true);
                    //console.log(code);
                }

                $(document.body).trigger('wc_booking_form_changed');
            },
            error: function () {
                $form.find('.wc-bookings-booking-cost').hide();
                $form.find('.single_add_to_cart_button').addClass('disabled');
                $form.find('.single_add_to_cart_button').attr("disabled", true);
            },
            dataType: "html"
        });

    });
    // This button will decrement the value till 0
    $(document).on('click', '.form_field_person [data-quantity="minus"]', function (e) {
        // Stop acting like a button
        e.preventDefault();
        //check choose date
        if ($('.required_for_calculation.booking_date_month').val() === '') {
            $('.wc-bookings-booking-cost').html('<span class="booking-error">Choose a date above to see available times</span>');
        }
        // Get the field name
        var fieldName = $(this).attr('data-field');
        var tour_id = $('.wc-booking-product-id').val();
        // Get its current value
        var currentVal = parseInt($('select[name=' + fieldName + ']').val());
        var quantity_min = $('select[name=' + fieldName + ']').attr('min');
        var quantity_max = $('select[name=' + fieldName + ']').attr('max');
        if (typeof quantity_min !== typeof undefined && quantity_min !== false) {
            var check_min_quantity = true;
            if(quantity_min>=currentVal){
                $('button[data-field=' + fieldName + '][data-quantity="minus"]').attr("disabled", true);
                return;
            }
        }
        if (typeof quantity_max !== typeof undefined && quantity_max !== false) {
            if(quantity_max>currentVal){
                $('button[data-field=' + fieldName + '][data-quantity="plus"]').attr("disabled", false);
            }
        }
        // If it isn't undefined or its greater than 0
        if (!isNaN(currentVal) && currentVal > 0) {
            // Decrement one
            $('select[name=' + fieldName + ']').val(currentVal - 1);
            $('select[name=' + fieldName + ']').attr("data-value", currentVal - 1);
            /*if (tour_id == 165337 || tour_id == 239676 || tour_id == 234090 || tour_id == 164794) {
                $('select[name=' + fieldName + ']').val(quantity_min);
                $('select[name=' + fieldName + ']').attr("data-value", quantity_min);
                $('button[data-field=' + fieldName + '][data-quantity="minus"]').attr("disabled", true);
                $('button[data-field=' + fieldName + '][data-quantity="plus"]').attr("disabled", false);
            }*/
            if (tour_id == 1120) {
                var qty_people = currentVal - 1;
                var tour_island_text = '';
                var tour_price = '';
                var resource_id = $('#wc_bookings_field_resource').val();
                if (qty_people >6 && (resource_id == 63853 || resource_id == 63854)) {
                    $("#wc_bookings_field_resource > option[value=544525]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="544525"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="544525"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    
                }else if(qty_people >7 && resource_id == 544525){
                    $("#wc_bookings_field_resource > option[value=63858]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="63858"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="63858"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                }else if(qty_people >13){
                    $("#wc_bookings_field_resource > option[value=3504]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="3504"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="3504"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                }
                
            }
            if (tour_id == 101441) {
                var qty_people = currentVal - 1;
                var tour_island_text = '';
                var tour_price = '';
                var resource_id = $('#wc_bookings_field_resource').val();
                if (qty_people >6 && resource_id == 194437) {
                    $("#wc_bookings_field_resource > option[value=194441]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="194441"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="194441"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    //$('.person-name').text(tour_island_text);
                }else if (qty_people >14 && resource_id == 194441) {
                    $("#wc_bookings_field_resource > option[value=275932]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="275932"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="275932"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    //$('.person-name').text(tour_island_text);
                }else if (qty_people >6 && resource_id == 194434) {
                    $("#wc_bookings_field_resource > option[value=194439]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="194439"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="194439"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    //$('.person-name').text(tour_island_text);
                } 
            }
            if (tour_id == 34517) {
                var qty_people = currentVal - 1;
                var tour_island_text = '';
                var tour_price = '';
                var resource_id = $('#wc_bookings_field_resource').val();
                if (qty_people >5) {
                    $("#wc_bookings_field_resource > option[value=3503]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="3503"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="3503"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    //$('.person-name').text("Mercedes Sprinter");
                }
            }
            if (tour_id == 164794) {
                var qty_people = currentVal - 1;
                var tour_island_text = '';
                var tour_price = '';
                var resource_id = $('#wc_bookings_field_resource').val();
                if (qty_people >3) {
                    $("#wc_bookings_field_resource > option[value=331676]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="331676"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="331676"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    $('.person-name').text(tour_island_text);
                }
            } 
            if (tour_id == 165337) {
                var qty_people = currentVal - 1;
                var tour_island_text = '';
                var tour_price = '';
                var resource_id = $('#wc_bookings_field_resource').val();
                if (qty_people >7) {
                    $("#wc_bookings_field_resource > option[value=331260]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="331260"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="331260"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    //$('.person-name').text(tour_island_text);
                }else if (qty_people >5 && (resource_id == 3501 || resource_id == 3502)) {
                    $("#wc_bookings_field_resource > option[value=331702]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="331702"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="331702"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    //$('.person-name').text(tour_island_text);
                }else if (qty_people >3 && resource_id == 3501) {
                    $("#wc_bookings_field_resource > option[value=3502]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="3502"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="3502"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    //$('.person-name').text(tour_island_text);
                } 
            } 
            if (tour_id == 234090) {
                var qty_people = currentVal - 1;
                var tour_island_text = '';
                var tour_price = '';
                var resource_id = $('#wc_bookings_field_resource').val();
                if (qty_people >6) {
                    $("#wc_bookings_field_resource > option[value=272994]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="272994"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="272994"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    //$('.person-name').text(tour_island_text);
                }else if (qty_people >5 && (resource_id == 272989 || resource_id == 272993)) {
                    $("#wc_bookings_field_resource > option[value=272992]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="272992"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="272992"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    //$('.person-name').text(tour_island_text);
                }else if (qty_people >3 && resource_id == 272989) {
                    $("#wc_bookings_field_resource > option[value=272993]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="272993"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="272993"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    //$('.person-name').text(tour_island_text);
                } 
            } 
            if (tour_id == 239676) {
                var qty_people = currentVal - 1;
                var tour_island_text = '';
                var tour_price = '';
                var resource_id = $('#wc_bookings_field_resource').val();
                if (qty_people >6) {
                    $("#wc_bookings_field_resource > option[value=273008]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="273008"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="273008"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    //$('.person-name').text(tour_island_text);
                }else if (qty_people >5 && (resource_id == 273007 || resource_id == 273009)) {
                    $("#wc_bookings_field_resource > option[value=273010]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="273010"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="273010"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    //$('.person-name').text(tour_island_text);
                }else if (qty_people >3 && resource_id == 273007) {
                    $("#wc_bookings_field_resource > option[value=273009]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="273009"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="273009"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    //$('.person-name').text(tour_island_text);
                } 
            } 
            if ((tour_id == 32265 || tour_id == 32899 || tour_id == 32913 || tour_id == 32927) && fieldName=='wc_bookings_field_duration') {
                var duration = currentVal - 1;
                if(duration<=8){
                    $("#wc_bookings_field_resource > option[value=32358]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    $('.tour-island').text($( "#wc_bookings_field_resource > option[value=32358]" ).text());
                    if($('.vacation_islands-div').length){
                        mm_package_auto_select_island('32358');
                    }
                }
                else if(duration<=11){
                    $("#wc_bookings_field_resource > option[value=32359]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    $('.tour-island').text($( "#wc_bookings_field_resource > option[value=32359]" ).text());
                    if($('.vacation_islands-div').length){
                        mm_package_auto_select_island('32359');
                    }
                }
                else if(duration>11){
                    $("#wc_bookings_field_resource > option[value=32360]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    $('.tour-island').text($( "#wc_bookings_field_resource > option[value=32360]" ).text());
                    if($('.vacation_islands-div').length){
                        mm_package_auto_select_island('32360');
                    }
                }
                
            }
            if (tour_id == 360050) {
                var qty_people = currentVal - 1;
                var tour_island_text = '';
                var tour_price = '';
                var resource_id = $('#wc_bookings_field_resource').val();
                if (qty_people >7) {
                    $("#wc_bookings_field_resource > option[value=372840]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="372840"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="372840"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    //$('.person-name').text('Mercedes Sprinter (up to 11 guests)');
                }else if (qty_people >5 && (resource_id == 372838)) {
                    $("#wc_bookings_field_resource > option[value=372839]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="372839"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="372839"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.price-person .custom-prc').html(tour_price);
                    //$('.person-name').text('SUV (up to 7 guests)');
                }
            } 
            if(tour_id ==  32960 && fieldName=='wc_bookings_field_duration'){
                var duration = currentVal - 1;
                if(duration==4){
                    $("#wc_bookings_field_resource > option[value=333777]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    $('.tour-island').text($( "#wc_bookings_field_resource > option[value=333777]" ).text());
                }
                if(duration==5){
                    $("#wc_bookings_field_resource > option[value=333779]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    $('.tour-island').text($( "#wc_bookings_field_resource > option[value=333779]" ).text());
                }
                if(duration>=6){
                    $("#wc_bookings_field_resource > option[value=333780]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    $('.tour-island').text($( "#wc_bookings_field_resource > option[value=333780]" ).text());
                }
            }
            if (tour_id == 194724) {
                var qty_people = currentVal - 1;
                var resource_title = '';
                if(qty_people == 1){
                    $("#wc_bookings_field_resource > option[value=196826]").prop("selected", true);
                    resource_title = $('.list-costs-island li[data-fields="196826"] .island-name').text();
                }else if(qty_people == 2){
                    $("#wc_bookings_field_resource > option[value=196827]").prop("selected", true);
                    resource_title = $('.list-costs-island li[data-fields="196827"] .island-name').text();
                }else if(qty_people == 3){
                    $("#wc_bookings_field_resource > option[value=196828]").prop("selected", true);
                    resource_title = $('.list-costs-island li[data-fields="196828"] .island-name').text();
                }else if(qty_people == 4){
                    $("#wc_bookings_field_resource > option[value=196830]").prop("selected", true);
                    resource_title = $('.list-costs-island li[data-fields="196830"] .island-name').text();
                }
                if(resource_title!=''){
                    $('.tour-island').text(resource_title);
                }
            } 
            if (tour_id == 204535) {
                var qty_people = currentVal - 1;
                var resource_title = '';
                if(qty_people == 1){
                    $("#wc_bookings_field_resource > option[value=23499]").prop("selected", true);
                    resource_title = $('.list-costs-island li[data-fields="23499"] .island-name').text();
                }else if(qty_people == 2){
                    $("#wc_bookings_field_resource > option[value=23501]").prop("selected", true);
                    resource_title = $('.list-costs-island li[data-fields="23501"] .island-name').text();
                }else if(qty_people == 3){
                    $("#wc_bookings_field_resource > option[value=23502]").prop("selected", true);
                    resource_title = $('.list-costs-island li[data-fields="23502"] .island-name').text();
                }else if(qty_people == 4){
                    $("#wc_bookings_field_resource > option[value=23503]").prop("selected", true);
                    resource_title = $('.list-costs-island li[data-fields="23503"] .island-name').text();
                }
                if(resource_title!=''){
                    $('.tour-island').text(resource_title);
                }
            } 
            if (tour_id == 204526) {
                var qty_people = currentVal - 1;
                var resource_title = '';
                if(qty_people == 1){
                    $("#wc_bookings_field_resource > option[value=205983]").prop("selected", true);
                    resource_title = $('.list-costs-island li[data-fields="205983"] .island-name').text();
                }/*else if(qty_people == 2){
                    $("#wc_bookings_field_resource > option[value=205982]").prop("selected", true);
                    resource_title = $('.list-costs-island li[data-fields="205982"] .island-name').text();
                }*/
                if(resource_title!=''){
                    $('.tour-island').text(resource_title);
                }
            } 
            if (tour_id == 5590) {
                var resource_id = $('#wc_bookings_field_resource').val();
                if(resource_id == 117719){
                    var adult_count = $('.form_person_0  select.mm-bookings-field-select').val();
                    var child_count = $('.form_person_1  select.mm-bookings-field-select').val();
                    $('.form_person_1  select.mm-bookings-field-select').attr('max',adult_count);
                    if(child_count>adult_count){
                        $('.form_person_1  select.mm-bookings-field-select').val(adult_count);
                    }
                }else{
                    $('.form_person_1  select.mm-bookings-field-select').attr('max','6');
                }
            }
            if (tour_id == 11261 || tour_id == 5946) {
                var resource_id = $('#wc_bookings_field_resource').val();
                var hiker = $('.form_person_0  select.mm-bookings-field-select').val();
                if(hiker > 9 && (resource_id != 374689 && resource_id != 374680)){
                    $('.form_person_0  select.mm-bookings-field-select').val('0');
                    $('.form_person_1  select.mm-bookings-field-select').val('10');
                    $('.form_person_1 select.mm-bookings-field-select').attr('min', '1');
                    $('.form_person_2 button[data-quantity="plus"]').attr("disabled", false);
                    $("select#wc_bookings_field_resource option:last-child").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    var tour_resource = $('.list-costs-island li:last-child .island-name').text();
                    var tour_price = $('.list-costs-island li:last-child .custom-prc').html();
                    $('.tour-island').text(tour_resource);
                    $('.form_person_1 .price-person .custom-prc').html(tour_price);
                    $('.form_person_2 .price-person .custom-prc').html('159<sup>.00</sup>');
                    $('.form_person_1, .form_person_2').css('display','');
                    $('.form_person_0').css('display','none');
                    if($('input.get_resource_id').length){
                        $("input.get_resource_id").each(function() {
                            var resource_change = $('.list-costs-island li:last-child').attr('data-fields');
                            $(this).val(resource_change);
                            $(this).change();
                        });
                    }
                    $('.ht-choose-date').trigger('click');
                }
            }
            if (tour_id == 164539) {
                var resource_id = $('#wc_bookings_field_resource').val();
                if(resource_id == 164384){
                    var adult_count = $('.form_person_0  select.mm-bookings-field-select').val();
                    if(adult_count>=2){
                        $('.form_person_1, .form_person_2').css('display','');
                    }else{
                        $('.form_person_1, .form_person_2').css('display','none');
                        $('.form_person_1  select.mm-bookings-field-select, .form_person_2  select.mm-bookings-field-select').val('0');
                    }
                }
            }
            if (tour_id == 476436 && fieldName == 'wc_bookings_field_persons_476632') {
                var qty_people = currentVal - 1;
                var tour_island_text = '';
                var tour_price = '';
                var resource_id = $('#wc_bookings_field_resource').val();
                if(qty_people >13){
                    $("#wc_bookings_field_resource > option[value=476629]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="476629"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="476629"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.form_person_0 .price-person .custom-prc').html(tour_price);
                    $('.mmt-button-waitlist').css('display','none');
                    $('.single_add_to_cart_button').css('display','');
                    if(qty_people >=20 && qty_people <=24){
                        $('.form_person_0 .price-person .custom-prc').html('400<sup>.00</sup>');
                    }else if(qty_people >=25 && qty_people <=29){
                        $('.form_person_0 .price-person .custom-prc').html('550<sup>.00</sup>');
                    }else if(qty_people >=30 && qty_people <=34){
                        $('.form_person_0 .price-person .custom-prc').html('600<sup>.00</sup>');
                    }else if(qty_people >=35 && qty_people <=39){
                        $('.form_person_0 .price-person .custom-prc').html('750<sup>.00</sup>');
                    }else if(qty_people >= 40){
                        $('.single_add_to_cart_button').css('display','none');
                        $('.mmt-button-waitlist').css('display','');
                    }
                }else if (qty_people >=6 && resource_id != 476576) {
                    $("#wc_bookings_field_resource > option[value=476576]").prop("selected", true);
                    $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                    $('.tour-island').css('display', 'block');
                    tour_island_text = $('.list-costs-island li[data-fields="476576"] .island-name').text();
                    tour_price = $('.list-costs-island li[data-fields="476576"] .custom-prc').html();
                    $('.tour-island').text(tour_island_text);
                    $('.form_person_0 .price-person .custom-prc').html(tour_price);
                    $('.mmt-button-waitlist').css('display','none');
                    $('.single_add_to_cart_button').css('display','');
                }else{
                    $('.mmt-button-waitlist').css('display','none');
                    $('.single_add_to_cart_button').css('display','');
                }
            } 
            if($(this).hasClass('mm_bookings_field_persons_Persons')){
                mm_package_auto_choose_room_field();
            }
            if (tour_id == 1120 || tour_id == 34517) {
                if ($('select[name=' + fieldName + ']').val() < 24) {
                    $('button[data-field=' + fieldName + '][data-quantity="plus"]').attr("disabled", false);
                }
            } else {
                if(check_min_quantity){
                    if ($('select[name=' + fieldName + ']').val() == quantity_min) {
                        $('button[data-field=' + fieldName + '][data-quantity="minus"]').attr("disabled", true);
                    }
                }
                if ($('select[name=' + fieldName + ']').val() < 20) {
                    $('button[data-field=' + fieldName + '][data-quantity="plus"]').attr("disabled", false);
                }
            }

        } else {
            // Otherwise put a 0 there
            $('select[name=' + fieldName + ']').val(0);
        }
        
        customer_info_field_bookingbox();
        auto_change_tm_quantity_bookingbox();
        if($('.get_person_id').length){
            mm_get_list_person_id_bookingbox();
        }
        if($('.mm_plan_total_guest').length){
            mm_change_plan_total_guest();
        }
        var xhr = [];
        var name = $(this).attr('name');

        var $fieldset = $(this).closest('fieldset');
        var $picker = $fieldset.find('.picker:eq(0)');
        if ($picker.data('is_range_picker_enabled')) {
            if ('wc_bookings_field_duration' !== name) {
                return;
            }
        }

        var index = $('.wc-bookings-booking-form').index(this);
        $form = $(this).closest('form');
        var isEmptyCalendarSelection = !$form.find("[name='wc_bookings_field_start_date_day']").val() &&
            !$form.find('#wc_bookings_field_start_date').val();

        // Do not update if triggered by Product Addons and no date is selected.
        if (jQuery(e.target).hasClass('addon') && isEmptyCalendarSelection) {
            return;
        }

        var required_fields = $form.find('input.required_for_calculation');
        var filled = true;
        $.each(required_fields, function (index, field) {
            var value = $(field).val();
            if (!value) {
                filled = false;
            }
        });
        if (!filled) {
            $form.find('.wc-bookings-booking-cost').hide();
            return;
        }

        $form.find('.wc-bookings-booking-cost').block({message: null, overlayCSS: {background: '#fff', backgroundSize: '16px 16px', opacity: 0.6}}).show();
        xhr[index] = $.ajax({
            type: 'POST',
            url: booking_form_params.ajax_url,
            data: {
                action: 'wc_bookings_calculate_costs',
                form: $form.serialize()
            },
            success: function (code) {
                if (code.charAt(0) !== '{') {
                    //console.log(code);
                    code = '{' + code.split(/\{(.+)?/)[1];
                }

                result = $.parseJSON(code);
                jQuery('.customer-info-field').css('display','none');
                jQuery('.tc-extra-product-options').css('display','none');
                if (result.result == 'ERROR') {
                    $form.find('.wc-bookings-booking-cost').html(result.html);
                    $form.find('.wc-bookings-booking-cost').unblock();
                    $form.find('.single_add_to_cart_button').addClass('disabled');
                    $form.find('.single_add_to_cart_button').attr("disabled", true);
                    if(result.html.indexOf("The maximum persons fareharbor")>=0){
                        $form.find('.wc-bookings-booking-cost').html('');
                        jQuery('.mmt-button-waitlist').css('display','');
                        jQuery('.single_add_to_cart_button').css('display','none');
                    }
                    else if(result.html.indexOf("Sorry, the selected block is not available")>=0){
                        jQuery('.mmt-button-waitlist').css('display','');
                        jQuery('.single_add_to_cart_button').css('display','none');
                    }
                } else if (result.result == 'SUCCESS') {
                    $form.find('.wc-bookings-booking-cost').html(result.html);
                    $form.find('.wc-bookings-booking-cost').unblock();
                    $form.find('.single_add_to_cart_button').removeClass('disabled');
                    $form.find('.single_add_to_cart_button').attr("disabled", false);
                    jQuery('.customer-info-field').css('display','block');
                    jQuery('.tc-extra-product-options').css('display','block');
                    jQuery('.mmt-button-waitlist').css('display','none');
                    jQuery('.single_add_to_cart_button').css('display','');
                } else {
                    $form.find('.wc-bookings-booking-cost').hide();
                    $form.find('.single_add_to_cart_button').addClass('disabled');
                    $form.find('.single_add_to_cart_button').attr("disabled", true);
                    //console.log(code);
                }

                $(document.body).trigger('wc_booking_form_changed');
            },
            error: function () {
                $form.find('.wc-bookings-booking-cost').hide();
                $form.find('.single_add_to_cart_button').addClass('disabled');
                $form.find('.single_add_to_cart_button').attr("disabled", true);
            },
            dataType: "html"
        });
    });

    $('.ht-choose-date, .bookings-date-1').on('click', function () {
        if ($("#mm-time-picker").hasClass("block-picker-visible")) {
            $('#mm-time-picker').removeClass('block-picker-visible');
            $('.form_field-time').removeClass('show-list-time');
        }
        $(".mm-calendar-absolute").toggleClass("active");
        //$(".picker").toggleClass("active");
        //$(".mm-calendar-visible").toggleClass("active");
        //$('.wc-icon-calendar').css('display', 'none');
        //$('.wc-bookings-date-picker-date-fields').css('display', 'none');
        //if ($(".picker").hasClass("active")) {
            //var heightDate = $('.hasDatepicker').height();
            //var heightDateWrap = $('.wc-bookings-date-picker').height();
            //$('.wc-bookings-date-picker').css('height', heightDate + heightDateWrap + 3);
            //$('.back-choose-date').css('display', 'block');
        //} else {
            //$('.back-choose-date').css('display', 'none');
        //}

    });
    $('.back-choose-date').on('click', function () {
        //$(".picker").removeClass("active");
        $(".mm-calendar-absolute").removeClass("active");
        //$(".mm-calendar-visible").removeClass("active");
        //$(this).css('display', 'none');
        //$('.picker').css('display', 'none');
    });
    /*$('.mm-discounted, .mm-available').on('click', function () {
        if ($("#mm-time-picker").hasClass("block-picker-visible")) {
            $('#mm-time-picker').removeClass('block-picker-visible');
            $('.form_field-time').removeClass('show-list-time');
        }
        //$(".picker").toggleClass("active");
        //$('.wc-icon-calendar').css('display', 'none');
        $('.wc-bookings-date-picker-date-fields').css('display', 'none');
        if ($(".picker").hasClass("active")) {
            var heightDate = $('.hasDatepicker').height();
            var heightDateWrap = $('.wc-bookings-date-picker').height();
            $('.wc-bookings-date-picker').css('height', heightDate + heightDateWrap + 3);
            $(".picker").css("display", "block");
        } else {
            $('.wc-bookings-date-picker').css('height', 'auto');
            $(".picker").css("display", "none");
        }

    });*/

    $(document).on('change', '.booking_date_day', function (e) {
        $(".mm-calendar-absolute").removeClass("active");
        //$(".hasDatepicker").slideToggle(100);
        $('.wc-bookings-date-picker').css('height', 'auto');
        //$('.hasDatepicker').removeClass('active');
        $(".mm-calendar-visible").removeClass("active");
        $('.wc_bookings_field_start_date .ht-choose-date legend, .wc_bookings_field_start_date .bookings-date-1 legend').css('display', 'none');
        $('.wc-bookings-date-picker-date-fields').css('display', 'block');
        //$('.back-choose-date').css('display', 'none');
        $('.wc_bookings_field_start_date .wc-icon-calendar').css('display', 'none');
        $('.wc_bookings_field_start_date .icon-check').css('display', 'block');
        /* Luau 2020 price*/
        var booking_date_year = $('.booking_date_year').val();
        var product_id = $('.wc-booking-product-id').val();
        var resource_id = $('#wc_bookings_field_resource').val();
        /*if(product_id=='3129'){
            if(resource_id =='6608'){
                if ($('.form-field.form_person_1').length) {
                    $('.form_person_1 .price-person .custom-prc').html("89<sup>.00</sup>");
                }
                if ($('.form-field.form_person_2').length) {
                    $('.form_person_2 .price-person .custom-prc').html("79<sup>.00</sup>");
                }
            }
            if(resource_id =='6606'){
                if ($('.form-field.form_person_0').length) {
                    $('.form_person_0 .price-person .custom-prc').html("139<sup>.99</sup>");
                }
                if ($('.form-field.form_person_1').length) {
                    $('.form_person_1 .price-person .custom-prc').html("124<sup>.99</sup>");
                }
                if ($('.form-field.form_person_2').length) {
                    $('.form_person_2 .price-person .custom-prc').html("99<sup>.99</sup>");
                }
            }
            if(resource_id =='6607'){
                if ($('.form-field.form_person_0').length) {
                    $('.form_person_0 .price-person .custom-prc').html("179<sup>.99</sup>");
                }
                if ($('.form-field.form_person_1').length) {
                    $('.form_person_1 .price-person .custom-prc').html("154<sup>.99</sup>");
                }
                if ($('.form-field.form_person_2').length) {
                    $('.form_person_2 .price-person .custom-prc').html("144<sup>.99</sup>");
                }
            }
            $('.list-costs-island li[data-fields="6608"] .custom-prc').html("98<sup>.99</sup>");
            $('.list-costs-island li[data-fields="6606"] .custom-prc').html("139<sup>.99</sup>");
            $('.list-costs-island li[data-fields="6607"] .custom-prc').html("179<sup>.99</sup>");
        }*/
        /*if(product_id=='3113'){
            if(booking_date_year>2019){
                if(resource_id =='6962'){
                    if ($('.form-field.form_person_0').length) {
                        $('.form_person_0 .price-person .custom-prc').html("114<sup>.00</sup>");
                    }
                    if ($('.form-field.form_person_1').length) {
                        $('.form_person_1 .price-person .custom-prc').html("104<sup>.00</sup>");
                    }
                    if ($('.form-field.form_person_2').length) {
                        $('.form_person_2 .price-person .custom-prc').html("94<sup>.00</sup>");
                    }
                }
                if(resource_id =='6960'){
                    if ($('.form-field.form_person_0').length) {
                        $('.form_person_0 .price-person .custom-prc').html("147<sup>.00</sup>");
                    }
                    if ($('.form-field.form_person_1').length) {
                        $('.form_person_1 .price-person .custom-prc').html("131<sup>.00</sup>");
                    }
                    if ($('.form-field.form_person_2').length) {
                        $('.form_person_2 .price-person .custom-prc').html("121<sup>.00</sup>");
                    }
                }
                if(resource_id =='6959'){
                    if ($('.form-field.form_person_0').length) {
                        $('.form_person_0 .price-person .custom-prc').html("184<sup>.00</sup>");
                    }
                    if ($('.form-field.form_person_1').length) {
                        $('.form_person_1 .price-person .custom-prc').html("168<sup>.00</sup>");
                    }
                    if ($('.form-field.form_person_2').length) {
                        $('.form_person_2 .price-person .custom-prc').html("153<sup>.00</sup>");
                    }
                }
                $('.list-costs-island li[data-fields="6962"] .custom-prc').html("114<sup>.00</sup>");
                $('.list-costs-island li[data-fields="6960"] .custom-prc').html("147<sup>.00</sup>");
                $('.list-costs-island li[data-fields="6959"] .custom-prc').html("184<sup>.00</sup>");
            }
            
        }*/
        if(product_id=='5043'){
            /*var booking_date_month = $('.booking_date_month').val();
            var booking_date_day = $('.booking_date_day').val();
            var weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
            var get_booking_date = new Date(booking_date_month+'/'+booking_date_day+'/'+ booking_date_year);
            var form_person_0_default= $('.form_person_0 .price-person .custom-prc').text();
            var form_person_1_default= $('.form_person_1 .price-person .custom-prc').text();
            
            var person_0_arr = form_person_0_default.split(".");
            var person_1_arr = form_person_1_default.split(".");
                       
            if(weekday[get_booking_date.getDay()]=='Friday'){
                if(!$('.mmt-flex-box').hasClass('.mm_fri_day')){
                    $('.mmt-flex-box').addClass('.mm_fri_day');
                    
                    var new_price_0 = parseInt(person_0_arr[0]) + 15;
                    var new_price_1 = parseInt(person_1_arr[0]) + 15;
                    $('.form_person_0 .price-person .custom-prc').html(new_price_0+"<sup>."+person_0_arr[1]+"</sup>");
                    $('.form_person_1 .price-person .custom-prc').html(new_price_1+"<sup>."+person_1_arr[1]+"</sup>");
                }
            }
            else{
                if($('.mmt-flex-box').hasClass('.mm_fri_day')){
                    $('.mmt-flex-box').removeClass('.mm_fri_day');
                    var old_price_0 = parseInt(person_0_arr[0]) - 15;
                    var old_price_1 = parseInt(person_1_arr[0]) - 15;
                    $('.form_person_0 .price-person .custom-prc').html(old_price_0+"<sup>."+person_0_arr[1]+"</sup>");
                    $('.form_person_1 .price-person .custom-prc').html(old_price_1+"<sup>."+person_1_arr[1]+"</sup>");
                }
            }*/
        }
        if(product_id=='3554'){
            var booking_date_month = $('.booking_date_month').val();
            var booking_date_day = $('.booking_date_day').val();
            var weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
            var get_booking_date = new Date(booking_date_month+'/'+booking_date_day+'/'+ booking_date_year);
            if(weekday[get_booking_date.getDay()]=='Sunday'){
                $('.form_person_0 select.mm-bookings-field-select').val('0');
                $('.form_person_0').css('display','none');
                $('.form_person_0 select.mm-bookings-field-select').change();
            }else{
                $('.form_person_0').css('display','');
            }
        }
        if(product_id=='1120'){
            var booking_date_month = $('.booking_date_month').val();
            var booking_date_day = $('.booking_date_day').val();
            var weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
            var get_booking_date = new Date(booking_date_month+'/'+booking_date_day+'/'+ booking_date_year);
            $(".maui_private_addons li.tmcp-field-wrap").each(function() {
                var option_title = $(this).find('.tm-label').text();
                if(option_title.indexOf("Polynesian Cultural Center Admission") >= 0){
                    if(weekday[get_booking_date.getDay()]=='Sunday' || weekday[get_booking_date.getDay()]=='Wednesday'){
                        $(this).find('input[type="checkbox"]').prop('checked', false);
                        $(this).removeClass('tc-active');
                        $(this).addClass('tc-mm-disable');
                    }else{
                        $(this).removeClass('tc-mm-disable');
                    }
                }
                if(option_title.indexOf("Waimea Valley Waterfall") >= 0){
                    if(weekday[get_booking_date.getDay()]=='Monday'){
                        $(this).find('input[type="checkbox"]').prop('checked', false);
                        $(this).removeClass('tc-active');
                        $(this).addClass('tc-mm-disable');
                    }else{
                        $(this).removeClass('tc-mm-disable');
                    }
                }
            });
            
        }
        if(product_id=='718981'){
            var booking_date_month = $('.booking_date_month').val();
            if(booking_date_month == '07' || booking_date_month == '7'){
                $(".one-way-route-ul li:nth-child(1) label").trigger('click');
            }else{
                $(".one-way-route-ul li:nth-child(2) label").trigger('click');
            }
            $('.depart-date-ul select.tmcp-date-month option').each(function() {
                var option_value = $(this).attr('value');
                if(option_value != '8' && option_value !=''){
                    $(this).css('display','none');
                }
            });
            $('.depart-date-ul select.tmcp-date-day option').each(function() {
                var option_value_day = $(this).attr('value');
                if(option_value_day != '3' && option_value_day !='4' && option_value_day !='5'){
                    $(this).css('display','none');
                }
            });
            
        }
        if($('.seasonal_option').length){
            var seasonal_option = $('.seasonal_option').data('seasonal');
            var date = $('.booking_date_day').val();
            var month = $('.booking_date_month').val();
            var year = $('.booking_date_year').val();
            var booking_date = year+'-'+month+'-'+date;
            var starting_form =0;
            var starting_resource = Array();
            var person_old = Array();
            var resource_old = Array();
            var seasonal_exist = false;

            $.each(seasonal_option, function(idx, obj) {
                var from_seasonal = obj.from;
                var to_seasonal = obj.to;
                var mm_resource_id = obj.mm_resource_id;
                var mm_person_id = obj.mm_person_id;
                var seasonal_cost = obj.cost;
                var seasonal_type = obj.type;
                var add_seasonal = false;
                if(seasonal_type =='months'){
                    if(parseInt(to_seasonal)>=parseInt(from_seasonal)){
                        if(parseInt(month)>=parseInt(from_seasonal) && parseInt(month)<=parseInt(to_seasonal)){
                            add_seasonal = true;
                        }
                    }else{
                        if(parseInt(month)<=parseInt(from_seasonal) && parseInt(month)<=parseInt(to_seasonal)){
                            add_seasonal = true;
                        }
                    }
                }
                if(seasonal_type =='days'){
                    var d_booking = new Date(booking_date);
                    var booking_day = d_booking.getDay();
                    if(parseInt(to_seasonal)>=parseInt(from_seasonal)){
                        if(parseInt(booking_day)>=parseInt(from_seasonal) && parseInt(booking_day)<=parseInt(to_seasonal)){
                            add_seasonal = true;
                        }
                    }else{
                        if(parseInt(booking_day)<=parseInt(from_seasonal) && parseInt(booking_day)<=parseInt(to_seasonal)){
                            add_seasonal = true;
                        }
                    }

                }
                if(seasonal_type =='custom'){
                    if(new Date(from_seasonal) <= new Date(booking_date) && new Date(booking_date) <= new Date(to_seasonal) && mm_person_id!=''){
                        add_seasonal = true;
                    }
                }
                if(add_seasonal){
                    seasonal_cost = parseFloat(seasonal_cost);
                    var seasonal_price = seasonal_cost.toFixed(2).toString().split('.');
                    if (seasonal_price[1]) {
                        var sup_price = seasonal_price[1];
                    } else {
                        var sup_price = '00';
                    }
                    if(mm_resource_id == resource_id){
                        var person_price_old = $('.wc_bookings_field_persons_'+mm_person_id+' .price-person .custom-prc').html();
                        person_old.push({
                            person_id : mm_person_id, 
                            person_cost : person_price_old,
                        });
                        
                        
                        $('.wc_bookings_field_persons_'+mm_person_id+' .price-person .custom-prc').html(seasonal_price[0] + "<sup>." + sup_price + "</sup>");
                        seasonal_exist = true;
                    }
                    if(starting_resource[mm_resource_id] < parseInt(seasonal_cost)|| typeof starting_resource[mm_resource_id] == 'undefined'){
                        var resource_price_old = $('.list-costs-island li[data-fields="'+mm_resource_id+'"] .custom-prc').html();
                        resource_old.push({
                            resource_id : mm_resource_id, 
                            resource_cost : resource_price_old,
                        });
                        starting_resource[mm_resource_id] = seasonal_cost;
                        $('.list-costs-island li[data-fields="'+mm_resource_id+'"] .custom-prc').html(seasonal_price[0] + "<sup>." + sup_price + "</sup>");
                    }
                }
                                
            });
            if(seasonal_exist==true){
                if(localStorage.getItem("price_default")=== null){
                    localStorage.setItem("price_default", JSON.stringify(person_old));
                    
                }
                if(localStorage.getItem("resource_default")=== null){
                    localStorage.setItem("resource_default", JSON.stringify(resource_old));
                }
                
            }else{
                if(localStorage.getItem("price_default")!== null){
                    var set_price = JSON.parse(localStorage.getItem("price_default"));
                    $.each(set_price, function(i, value) {
                        $('.wc_bookings_field_persons_'+set_price[i].person_id+' .price-person .custom-prc').html(set_price[i].person_cost);
                    });
                    localStorage.removeItem('price_default');
                }
                if(localStorage.getItem("resource_default")!= null){
                    var set_price_rs = JSON.parse(localStorage.getItem("resource_default"));
                    $.each(set_price_rs, function(i, value) {
                        $('.list-costs-island li[data-fields="'+set_price_rs[i].resource_id+'"] .custom-prc').html(set_price_rs[i].resource_cost);
                    });
                }
            }
        }
        
        mm_auto_change_person_number_with_date_of_birth();
        if($('.mm_sumo_payment_plans').length){
            var date = $('.booking_date_day').val();
            var month = $('.booking_date_month').val();
            var year = $('.booking_date_year').val();
            if(date !=''){
                var current_date = new Date();
                var booking_date = new Date(year+'-'+month+'-'+date);
                var millisBetween = booking_date.getTime() - current_date.getTime();
                var days = millisBetween / (1000 * 3600 * 24);
                if(days>60){
                    $('.mm_sumo_payment_plans').css('display','block');
                }else{
                    $('.mm_sumo_payment_plans').css('display','none');
                    $('input[name="_sumo_pp_payment_type"][value="pay_in_full"]').prop('checked', true);
                }
            }
        }
        //$('.list-costs-island').addClass('mmt-fix-island');
        return false;
        // $('.form_field-time').trigger('click');
    });

    $(document).on('click', '.form_field-time', function (e) {
        var pickup_time = $("#mm-time-picker").find("li").length;
        $(".mm-calendar-absolute").removeClass("active");
        if ($('body').hasClass('postid-4760') || $('body').hasClass('postid-3824') || $('body').hasClass('postid-3676')) {
            //$('.picker.hasDatepicker').css('display', 'none');
            if ($(".hasDatepicker").hasClass("active")) {
                $('.wc-bookings-date-picker').css('height', 'auto');
                $('.hasDatepicker').removeClass('active');
            }
        } else if (pickup_time > 1) {
            $("#wc-bookings-booking-form div.form_field-time i").css("color", "#404040");
            $('#wc-bookings-booking-form div.form_field-time i').css('display', 'block');
            //$('.picker.hasDatepicker').css('display', 'none');
            //$('.pickup-time').css('display', 'none');
            if ($(".hasDatepicker").hasClass("active")) {
                $('.wc-bookings-date-picker').css('height', 'auto');
                $('.hasDatepicker').removeClass('active');
            }
            $('#mm-time-picker').toggleClass('block-picker-visible');
            $(this).toggleClass('show-list-time');
        }
        if(pickup_time > 4) {
            if (!$('#mm-time-picker').hasClass('time-picker-scroll')) {
                $('#mm-time-picker').addClass('time-picker-scroll');
            }
        }
    });
    $(document).on('click', '.field_resource', function (e) {
        $(".list-costs-island").toggle();
        $(this).toggleClass("active");
        //$("#wc-bookings-booking-form div.field_resource i").css("color", "#404040");
        //$('#wc-bookings-booking-form div.field_resource i').css('display', 'block');
        //$('.picker.hasDatepicker').css('display', 'none');
        //$('.tour-island').css('display', 'none');
        $(".mm-calendar-absolute").removeClass("active");
        /*if ($(".hasDatepicker").hasClass("active")) {
            $('.wc-bookings-date-picker').css('height', 'auto');
            $('.hasDatepicker').removeClass('active');
        }*/
        
        $(".list-costs-island").removeClass('mmt-fix-island');
    });
    $(document).on('click', '.list-costs-island li', function (e) {
        $('div.field_resource').removeClass("active");
        var fieldNameData = $(this).attr('data-fields');
        var product_id = $('.wc-booking-product-id').val();
        var nameIsland = $(this).attr('data-island');
        /*if (!$('.list-costs-island').hasClass('resource-combine')) {*/
            $(".list-costs-island").toggle();
        /*}*/
        $("#wc_bookings_field_resource > option[value=" + fieldNameData + "]").prop("selected", true);
        //$('#wc-bookings-booking-form div.field_resource i').css('display', 'none');
        $('.tour-island').css('display', 'block');
        $('p.wc_bookings_field_resource').css('display', 'block');
        $('.tour-island').text(nameIsland);
        $('.field_resource  .icon-check').css("display", "block");
        //$('.field_resource  .fa-angle-down').css("display", "none");
        //$('label[for="wc_bookings_field_persons_1121"] .person-name').text(nameIsland);
        //$('label[for="wc_bookings_field_persons_34525"] .person-name').text(nameIsland);
        $('.mmt-flex-box').removeClass('.mm_fri_day');
        $(this).siblings().removeClass('selected');
        $(this).addClass('selected');
        var costResource = $(this).attr('data-cost');
        if($('.bookings-date-1').length){
            $('.bookings-date-1').trigger('click');
        }
        else $('.ht-choose-date').trigger('click');
        var d = new Date();
        var currentDay = d.getDate();
        var currentMonth = d.getMonth();
        var currentDayMonth = currentDay + '/' + currentMonth;
        localStorage.removeItem('price_default');
        if($('.vacation_islands-div').length){
            mm_package_auto_select_island(fieldNameData);
        }
        if($('.vp_widget_booking').length){
            if(fieldNameData== 32358){
                $("select#wc_bookings_field_duration").val('7');
            }
            if(fieldNameData== 32359){
                $("select#wc_bookings_field_duration").val('9');
            }
            if(fieldNameData== 32360){
                $("select#wc_bookings_field_duration").val('12');
            }
            if(fieldNameData == 32984 || fieldNameData == 333770 || fieldNameData == 333777 || fieldNameData == 333763){
                $("select#wc_bookings_field_duration").val('4');
            }
            if(fieldNameData == 32985 || fieldNameData == 333771 || fieldNameData == 333779 || fieldNameData == 333765){
                $("select#wc_bookings_field_duration").val('5');
            }
            if(fieldNameData == 32986 || fieldNameData == 333772 || fieldNameData == 333780 || fieldNameData == 333766){
                $("select#wc_bookings_field_duration").val('6');
            }
            if(fieldNameData == 142892){
                $("select#wc_bookings_field_duration").val('7');
            }
            if(fieldNameData == 142891){
                $("select#wc_bookings_field_duration").val('12');
            }
            if(fieldNameData == 142887){
                $("select#wc_bookings_field_duration").val('7');
            }
            if(fieldNameData == 142888){
                $("select#wc_bookings_field_duration").val('9');
            }
            if(fieldNameData == 142889){
                $("select#wc_bookings_field_duration").val('7');
            }
            if(fieldNameData == 142890){
                $("select#wc_bookings_field_duration").val('9');
            }
            if($("select#wc_bookings_field_duration").length){
                vp_widget_booking_change_resource();
            }
            
        }
        if($('.postid-194724').length){
            if(fieldNameData== 196826 || fieldNameData== 201022){
                $(".form_person_0  input[type='number']").val('1');
            }
            if(fieldNameData== 196827){
                $(".form_person_0  input[type='number']").val('2');
            }
            if(fieldNameData== 196828){
                $(".form_person_0  input[type='number']").val('3');
            }
            if(fieldNameData== 196830){
                $(".form_person_0  input[type='number']").val('4');
            }
            customer_info_field_bookingbox();
            auto_change_tm_quantity_bookingbox();
            if($('.get_person_id').length){
                mm_get_list_person_id_bookingbox();
            }
            if($('.mm_plan_total_guest').length){
                mm_change_plan_total_guest();
            }
        }
        if($('.postid-204535').length){
            if(fieldNameData== 23499 || fieldNameData== 201022){
                $(".form_person_0  input[type='number']").val('1');
            }
            if(fieldNameData== 23501){
                $(".form_person_0  input[type='number']").val('2');
            }
            if(fieldNameData== 23502){
                $(".form_person_0  input[type='number']").val('3');
            }
            if(fieldNameData== 23503){
                $(".form_person_0  input[type='number']").val('4');
            }
            customer_info_field_bookingbox();
            auto_change_tm_quantity_bookingbox();
            if($('.get_person_id').length){
                mm_get_list_person_id_bookingbox();
            }
            if($('.mm_plan_total_guest').length){
                mm_change_plan_total_guest();
            }
        }
        if($('.postid-204526').length){
            if(fieldNameData== 205983 || fieldNameData== 205986){
                $(".form_person_0  input[type='number']").val('1');
            }
            if(fieldNameData== 205982){
                $(".form_person_0  input[type='number']").val('2');
            }
            customer_info_field_bookingbox();
            auto_change_tm_quantity_bookingbox();
            if($('.get_person_id').length){
                mm_get_list_person_id_bookingbox();
            }
            if($('.mm_plan_total_guest').length){
                mm_change_plan_total_guest();
            }
        }
        if($('.postid-34517').length){
            /*if(fieldNameData== 333791){
                $('.person-name').text("Van");
            }else if(fieldNameData== 331684){
                $('.person-name').text("Luxury SUV");
            }else{
                $('.person-name').text("Mercedes Sprinter");
            }*/
            
        }
        if($('.tour_resource_hide_field').length){
            $(".tour_resource_hide_field input.tour_starting_form").each(function() {
                $(this).val(nameIsland);
                $(this).change();
            });
        }
        if(product_id==3685){
            if(fieldNameData == 3992){
                $('.customer-info-field  .customer-info-item').css('display','none');
            }
            else{
                $('.customer-info-field  .customer-info-item').css('display','');
            }
        }
        if(product_id==5946){
            if(fieldNameData== 117611){
                $('.customer-info-field  .customer-info-item').css('display','none');
                jQuery('.customer-info-div textarea').val('');
            }
            else{
                $('.customer-info-field  .customer-info-item').css('display','');
            }
        }
        if(product_id==3920){
            if(fieldNameData== 117742){
                $('.customer-info-field  .customer-info-item').css('display','none');
                jQuery('.customer-info-div textarea').val('');
            }
            else{
                $('.customer-info-field  .customer-info-item').css('display','');
            }
        }
        if(product_id==522148){
            if(fieldNameData== 522209){
                $('.customer-info-field  .customer-info-item').css('display','none');
                jQuery('.customer-info-div textarea').val('');
            }
            else{
                $('.customer-info-field  .customer-info-item').css('display','');
            }
        }
        if(product_id==24053){
            if(fieldNameData == 304871){
                $('.form_person_0').css('display','none');
                $('.form_person_0 select.mm-bookings-field-select').val('0');
            }
            else{
                $('.form_person_0').css('display','');
            }
        }
        if(product_id==116873){
            if(fieldNameData == 122691){
                $('.form_person_2').css('display','none');
                $('.form_person_2 select.mm-bookings-field-select').val('0');
            }
            else{
                $('.form_person_2').css('display','');
            }
        }
        if(product_id==190141){
            if(fieldNameData ==194152 || fieldNameData ==194150 || fieldNameData ==194151 || fieldNameData ==194149 || fieldNameData ==190417){
                //$('.customer-info-field  .customer-info-item').css('display','none');
                //jQuery('.customer-info-div textarea').val('');
                $(".customer-info-field  .customer-info-item").each(function() {
                    $(this).css('display','none');
                });
            }
            else{
                $(".customer-info-field  .customer-info-item").each(function() {
                    $(this).css('display','');
                });
                //$('.customer-info-field  .customer-info-item').css('display','');
            }
        }
        if(product_id==216760){
            if(fieldNameData ==222479){
                //$('.customer-info-field  .customer-info-item').css('display','none');
                //jQuery('.customer-info-div textarea').val('');
                
                $(".customer-info-field  .customer-info-item").each(function() {
                    $(this).css('display','none');
                });
            }
            else{
                //$('.customer-info-field  .customer-info-item').css('display','');
                $(".customer-info-field  .customer-info-item").each(function() {
                    $(this).css('display','');
                });
            }
        }
        if(product_id==231414){
            if(fieldNameData== 231729){
                $('.form_person_0, .form_person_1').css('display','');
                $('.form_person_0 select.mm-bookings-field-select').val('1');
                $('.form_person_2, .form_person_3, .form_person_4, .form_person_5').css('display','none');
                $('.form_person_2 select.mm-bookings-field-select, .form_person_3 select.mm-bookings-field-select, .form_person_4 select.mm-bookings-field-select, .form_person_5 select.mm-bookings-field-select').val('0');
            }
            else{
                $('.form_person_0, .form_person_1').css('display','none');
                $('.form_person_0 select.mm-bookings-field-select, .form_person_1 select.mm-bookings-field-select').val('0');
                $('.form_person_2, .form_person_3, .form_person_4, .form_person_5').css('display','');
                $('.form_person_2 select.mm-bookings-field-select').val('1');
            }
        }
        if (product_id == 11261 || product_id == 5946) {
            if(fieldNameData == 374689 || fieldNameData == 374680){
                $('.form_person_1, .form_person_2').css('display','');
                $('.form_person_0 select.mm-bookings-field-select').val('0');
                $('.form_person_0').css('display','none');
                $('.form_person_1 select.mm-bookings-field-select').attr('min', '1');
                $('.form_person_1 select.mm-bookings-field-select').val('1');
                $('.form_person_2 button[data-quantity="plus"]').attr("disabled", false);
                    
            }
            else{
                $('.form_person_1, .form_person_2').css('display','none');
                $('.form_person_1 select.mm-bookings-field-select, .form_person_2 select.mm-bookings-field-select').val('0');
                $('.form_person_0').css('display','');
                $('.form_person_1 select.mm-bookings-field-select').attr('min', '0');
                if(parseInt($('.form_person_0 select.mm-bookings-field-select').val()) > 9){
                    $('.form_person_0 select.mm-bookings-field-select').val('9');
                }
            }
            
        }
        if (product_id == 11261){
            if(fieldNameData == 374267){
                $('.wc_bookings_field_persons_465420').css('display','');
                $('.form_person_0').css('display','none');
                $('.form_person_0 select.mm-bookings-field-select').val('0');
            }else{
                $('.wc_bookings_field_persons_465420').css('display','none');
                $('.wc_bookings_field_persons_465420 select.mm-bookings-field-select').val('0');
            }
        }
        if (product_id == 6231) {
            if(fieldNameData == 118484){
                $('.form_person_1, .form_person_2').css('display','none');
                $('.form_person_1 select.mm-bookings-field-select, .form_person_2 select.mm-bookings-field-select').val('0');
                $('.form_person_0 select.mm-bookings-field-select').attr('min', '1');
                $('.form_person_0, .form_person_3').css('display','');
                if(parseInt($('.form_person_0 select.mm-bookings-field-select').val()) == 0){
                    $('.form_person_0 select.mm-bookings-field-select').val('1');
                }
            }else if(fieldNameData == 405919){
                $('.form_person_0, .form_person_2').css('display','none');
                $('.form_person_0 select.mm-bookings-field-select, .form_person_2 select.mm-bookings-field-select').val('0');
                $('.form_person_1 select.mm-bookings-field-select').attr('min', '1');
                $('.form_person_1, .form_person_3').css('display','');
                if(parseInt($('.form_person_1 select.mm-bookings-field-select').val()) == 0){
                    $('.form_person_1 select.mm-bookings-field-select').val('1');
                }
            }else{
                $('.form_person_0, .form_person_1').css('display','none');
                $('.form_person_0 select.mm-bookings-field-select, .form_person_1 select.mm-bookings-field-select').val('0');
                $('.form_person_2 select.mm-bookings-field-select').attr('min', '1');
                $('.form_person_2, .form_person_3').css('display','');
                if(parseInt($('.form_person_2 select.mm-bookings-field-select').val()) == 0){
                    $('.form_person_2 select.mm-bookings-field-select').val('1');
                }
            }
        }
        if(product_id==164539){
            if(fieldNameData == 164384 && parseInt($('.form_person_0 select.mm-bookings-field-select').val()) < 2){
                $('.form_person_1, .form_person_2').css('display','none');
                $('.form_person_1 select.mm-bookings-field-select, .form_person_2 select.mm-bookings-field-select').val('0');
            }
            else{
                $('.form_person_1, .form_person_2').css('display','');
            }
        }
        if (product_id == 476436){
            if(fieldNameData == 476575 && parseInt($('.form_person_1 select.mm-bookings-field-select').val()) >5){
                $('.form_person_1 select.mm-bookings-field-select').val('5');
            }
        }
        if (product_id == 431240){
            if((fieldNameData == 615146 || fieldNameData == 63854) && parseInt($('.form_person_1 select.mm-bookings-field-select').val()) >6){
                $('.form_person_1 select.mm-bookings-field-select').val('6');
            }
            if((fieldNameData == 63858) && parseInt($('.form_person_1 select.mm-bookings-field-select').val()) >13){
                $('.form_person_1 select.mm-bookings-field-select').val('13');
            }
        }
        if(product_id==213251){
            if(fieldNameData== 281438 || fieldNameData== 281439){
                $('.form_person_1').css('display','none');
                $('.form_person_1 select.mm-bookings-field-select').val('0');
            }
            else{
                $('.form_person_1').css('display','');
            }
        }
        if(product_id==213251){
            if(fieldNameData == 213259 || fieldNameData == 213292){
                $('.form_person_2').css('display','none');
                $('.form_person_2 select.mm-bookings-field-select').val('0');
                $('.form_person_0, .form_person_1').css('display','');
                if(parseInt($('.form_person_0 select.mm-bookings-field-select').val()) ==0){
                    $('.form_person_0 select.mm-bookings-field-select').val('1');
                }
            }
            else{
                $('.form_person_2').css('display','');
                $('.form_person_2 select.mm-bookings-field-select').val('1');
                $('.form_person_0 select.mm-bookings-field-select, .form_person_1 select.mm-bookings-field-select').val('0');
                $('.form_person_0, .form_person_1').css('display','none');
            }
        }
        /*if(product_id==86822){
            if(fieldNameData == 124072){
                $('.form_person_2').css('display','none');
                $('.form_person_2 select.mm-bookings-field-select').val('0');
            }
            else{
                $('.form_person_2').css('display','');
            }
        }*/
        if(product_id==5590){
            if(fieldNameData == 117716){
                $('.form_person_3').css('display','none');
                $('.form_person_4').css('display','none');
                $('.form_person_3 select.mm-bookings-field-select').val('0');
                $('.form_person_4 select.mm-bookings-field-select').val('0');
                $('.form_person_1, .form_person_2').css('display','');
                
            }
            else{
                $('.form_person_3').css('display','');
                $('.form_person_4').css('display','');
                $('.form_person_1 select.mm-bookings-field-select').val('0');
                $('.form_person_2 select.mm-bookings-field-select').val('0');
                $('.form_person_1, .form_person_2').css('display','none');
            }
        }
        if(product_id==151954){
            $('#wc-bookings-booking-form select.mm-bookings-field-select option[value="0"]').css('display','none');
            $('#wc-bookings-booking-form select.mm-bookings-field-select option[value="1"]').css('display','none');
            if(fieldNameData == 635628 || fieldNameData == 635629){
                $('.form_person_0').css('display','');
                $('.form_person_1').css('display','none');
                $('.form_person_1 select.mm-bookings-field-select option[value="0"]').css('display','');
                $('.form_person_1 select.mm-bookings-field-select').val('0');
                var guest_number = $('.form_person_0 select.mm-bookings-field-select').val();
                if(parseInt(guest_number) ==0 || guest_number == ''){
                    $('.wc_bookings_field_persons_635642  select.mm-bookings-field-select').val('2');
                }
            }
            else{
                $('.form_person_0').css('display','none');
                $('.form_person_1').css('display','');
                $('.form_person_0 select.mm-bookings-field-select option[value="0"]').css('display','');
                $('.form_person_0 select.mm-bookings-field-select').val('0');
                var guest_number = $('.form_person_1 select.mm-bookings-field-select').val();
                if(parseInt(guest_number) ==0 || guest_number == ''){
                    $('.form_person_1  select.mm-bookings-field-select').val('2');
                }
            }
        }
        if (product_id==80080){
            $('.form_person_0 select.mm-bookings-field-select option[value="0"]').css('display','none');
            $('.form_person_2 select.mm-bookings-field-select option[value="0"]').css('display','none');
            if(fieldNameData == 545191){
                $('.form_person_0').css('display','');
                $('.form_person_1').css('display','');
                $('.form_person_2').css('display','none');
                $('.form_person_3').css('display','none');
                $('.form_person_2 select.mm-bookings-field-select option[value="0"]').css('display','');
                $('.form_person_2 select.mm-bookings-field-select').val('0');
                $('.form_person_3 select.mm-bookings-field-select').val('0');
                var adult = $('.form_person_0 select.mm-bookings-field-select').val();
                var default_adult = $('.form_person_0 select.mm-bookings-field-select').data('default');
                if(parseInt(adult) ==0 || adult == ''){
                    $('.form_person_0  select.mm-bookings-field-select').val(default_adult).change();
                }
            }
            else{
                $('.form_person_0').css('display','none');
                $('.form_person_1').css('display','none');
                $('.form_person_2').css('display','');
                $('.form_person_3').css('display','');
                $('.form_person_0 select.mm-bookings-field-select option[value="0"]').css('display','');
                $('.form_person_0 select.mm-bookings-field-select').val('0');
                $('.form_person_1 select.mm-bookings-field-select').val('0');
                var adult = $('.form_person_2 select.mm-bookings-field-select').val();
                var default_adult = $('.form_person_2 select.mm-bookings-field-select').data('default');
                if(parseInt(adult) ==0 || adult == ''){
                    $('.form_person_2  select.mm-bookings-field-select').val(default_adult).change();
                }
            }
            
        }
        if (product_id==86230){
            $('.form_person_0 select.mm-bookings-field-select option[value="0"]').css('display','none');
            if(fieldNameData == 126477 || fieldNameData == 116549){
                $('.form_person_0').css('display','');
                $('.form_person_1').css('display','none');
                $('.form_person_2').css('display','none');
                $('.form_person_3').css('display','none');
                $('.form_person_1 select.mm-bookings-field-select').val('0');
                $('.form_person_2 select.mm-bookings-field-select').val('0');
                $('.form_person_3 select.mm-bookings-field-select').val('0');
                var adult = $('.form_person_0 select.mm-bookings-field-select').val();
                var default_adult = $('.form_person_0 select.mm-bookings-field-select').data('default');
                if(parseInt(adult) ==0 || adult == ''){
                    $('.form_person_0  select.mm-bookings-field-select').val(default_adult);
                }
            }
            else{
                $('.form_person_0').css('display','none');
                $('.form_person_1').css('display','');
                $('.form_person_2').css('display','');
                $('.form_person_3').css('display','');
                $('.form_person_0 select.mm-bookings-field-select option[value="0"]').css('display','');
                $('.form_person_0 select.mm-bookings-field-select').val('0');
                var biker = $('.form_person_1 select.mm-bookings-field-select').val();
                var default_biker = $('.form_person_1 select.mm-bookings-field-select').data('default');
                if(parseInt(biker) ==0 || biker == ''){
                    $('.form_person_1  select.mm-bookings-field-select').val(default_biker);
                }
            }
            
        }
        if (product_id==24053){
            if(fieldNameData == 653123){
                var adult = $('.form_person_0 select.mm-bookings-field-select').val();
                var child = $('.form_person_1 select.mm-bookings-field-select').val();
                $('.form_person_0 .person-description-tooltip').css('display','none');
                if(parseInt(adult)>4){
                    $('.form_person_0 select.mm-bookings-field-select').val(4);
                }
                if(parseInt(child)>4){
                    $('.form_person_1 select.mm-bookings-field-select').val(4);
                }
                $(".form_person_0 select.mm-bookings-field-select option").each(function() {
                    if(this.value>4){
                        $(this).css('display','none');
                    }
                });
                $(".form_person_1 select.mm-bookings-field-select option").each(function() {
                    if(this.value>4){
                        $(this).css('display','none');
                    }
                });
            }else{
                $('.form_person_0 .person-description-tooltip').css('display','');
                $(".form_person_0 select.mm-bookings-field-select option").each(function() {
                    $(this).css('display','');
                });
                $(".form_person_1 select.mm-bookings-field-select option").each(function() {
                    $(this).css('display','');
                });
            }
        }
        if (product_id==6576){
            if(fieldNameData == 116488 || fieldNameData == 116487 || fieldNameData == 116489){
                $('.form_person_0').css('display','');
                $('.form_person_1').css('display','');
                $('.form_person_2').css('display','');
                $('.form_person_3').css('display','none');
                $('.form_person_3 select.mm-bookings-field-select').val('0');
            }else{
                $('.form_person_0').css('display','none');
                $('.form_person_1').css('display','none');
                $('.form_person_2').css('display','none');
                $('.form_person_0 select.mm-bookings-field-select').val('0');
                $('.form_person_1 select.mm-bookings-field-select').val('0');
                $('.form_person_2 select.mm-bookings-field-select').val('0');
                $('.form_person_3').css('display','');
                if(parseInt($('.form_person_3 select.mm-bookings-field-select').val()) == 0){
                    $('.form_person_3 select.mm-bookings-field-select').val(1);
                }
            }
        }
        if (product_id==218407){
            $('.form_person_0 select.mm-bookings-field-select option[value="0"]').css('display','none');
            if(fieldNameData == 221429){
                $('.form_person_0').css('display','');
                $('.form_person_1').css('display','none');
                $('.form_person_2').css('display','none');
                $('.form_person_3').css('display','none');
                $('.form_person_1 select.mm-bookings-field-select').val('0');
                $('.form_person_2 select.mm-bookings-field-select').val('0');
                $('.form_person_3 select.mm-bookings-field-select').val('0');
                var adult = $('.form_person_0 select.mm-bookings-field-select').val();
                var default_adult = $('.form_person_0 select.mm-bookings-field-select').data('default');
                if(parseInt(adult) ==0 || adult == ''){
                    $('.form_person_0  select.mm-bookings-field-select').val(default_adult).change();
                }
            }
            else{
                $('.form_person_0').css('display','none');
                $('.form_person_1').css('display','');
                $('.form_person_2').css('display','');
                $('.form_person_3').css('display','');
                $('.form_person_0 select.mm-bookings-field-select option[value="0"]').css('display','');
                $('.form_person_0 select.mm-bookings-field-select').val('0').change();
                /*var biker = $('.form_person_1 select.mm-bookings-field-select').val();
                var default_biker = $('.form_person_1 select.mm-bookings-field-select').data('default');
                if(parseInt(biker) ==0 || biker == ''){
                    $('.form_person_1  select.mm-bookings-field-select').val(default_biker);
                }*/
            }
            
        }
        if (product_id==215905){
            if(fieldNameData == 215918){
                $('.form_person_1').css('display','none');
                $('.form_person_0').css('display','');
                $('.form_person_1 select.mm-bookings-field-select').val('0');
                if(parseInt($('.form_person_0 select.mm-bookings-field-select').val()) == 0){
                    $('.form_person_0 select.mm-bookings-field-select').val(1);
                }
            }else{
                $('.form_person_0').css('display','none');
                $('.form_person_1').css('display','');
                $('.form_person_0 select.mm-bookings-field-select').val('0');
                if(parseInt($('.form_person_1 select.mm-bookings-field-select').val()) == 0){
                    $('.form_person_1 select.mm-bookings-field-select').val(1);
                }
            }
        }
        if (product_id==360130){
            if(fieldNameData != 743604){
                $('.form_person_1').css('display','none');
                $('.form_person_0').css('display','');
                $('.form_person_1 select.mm-bookings-field-select').val('0');
                if(parseInt($('.form_person_0 select.mm-bookings-field-select').val()) == 0){
                    $('.form_person_0 select.mm-bookings-field-select').val(1);
                }
            }else{
                $('.form_person_0').css('display','none');
                $('.form_person_1').css('display','');
                $('.form_person_0 select.mm-bookings-field-select').val('0');
                if(parseInt($('.form_person_1 select.mm-bookings-field-select').val()) == 0){
                    $('.form_person_1 select.mm-bookings-field-select').val(1);
                }
            }
        }
        if (product_id==724558){
            if(fieldNameData == 724703 || fieldNameData == 724705){
                if(parseInt($('.form_person_0 select.mm-bookings-field-select').val()) >5){
                    $('.form_person_0 select.mm-bookings-field-select').val('5').change();
                }
                $('.form_person_0 select.mm-bookings-field-select option[value="6"]').css('display','none');
                $('.form_person_0 select.mm-bookings-field-select option[value="7"]').css('display','none');
                $('.form_person_0 select.mm-bookings-field-select option[value="8"]').css('display','none');
                $('.form_person_0 select.mm-bookings-field-select option[value="9"]').css('display','none');
                $('.form_person_0 select.mm-bookings-field-select option[value="10"]').css('display','none');
                $('.form_person_0 select.mm-bookings-field-select option[value="11"]').css('display','none');
                $('.form_person_0 select.mm-bookings-field-select option[value="12"]').css('display','none');
            }else{
                $('.form_person_0 select.mm-bookings-field-select option[value="6"]').css('display','');
                $('.form_person_0 select.mm-bookings-field-select option[value="7"]').css('display','');
                $('.form_person_0 select.mm-bookings-field-select option[value="8"]').css('display','');
                $('.form_person_0 select.mm-bookings-field-select option[value="9"]').css('display','');
                $('.form_person_0 select.mm-bookings-field-select option[value="10"]').css('display','');
                $('.form_person_0 select.mm-bookings-field-select option[value="11"]').css('display','');
                $('.form_person_0 select.mm-bookings-field-select option[value="12"]').css('display','');
            }
        }
        if (product_id==476562){
            if(fieldNameData == 476656 || fieldNameData == 476659){
                if(parseInt($('.form_person_0 select.mm-bookings-field-select').val()) >4){
                    $('.form_person_0 select.mm-bookings-field-select').val('4').change();
                }
            }
        }
        var count_person = 0;
        jQuery(".form_field_person select.mm-bookings-field-select:not(#wc_bookings_field_duration, .mm_bookings_field_persons_Room)").each(function() {
            var person_val = parseInt(jQuery(this).val());
            count_person = count_person + person_val;
        });
        if(product_id==34517){
            if(fieldNameData == 333791 && count_person>5){
                $('.form_person_0 select.mm-bookings-field-select').val('5');
            }else if(fieldNameData == 708570 && count_person > 5){
                $('.form_person_0 select.mm-bookings-field-select').val('5');
            }else if(fieldNameData == 3503 && count_person > 11){
                $('.form_person_0 select.mm-bookings-field-select').val('11');
            }
        }
        if(product_id==164794){
            if(fieldNameData == 272798 && count_person>3){
                $('.form_person_0 select.mm-bookings-field-select').val('3');
            }
        }
        if(product_id==165337){
            if(fieldNameData == 3501 && count_person>3){
                $('.form_person_0 select.mm-bookings-field-select').val('3');
            }
            if(fieldNameData == 3502 && count_person>5){
                $('.form_person_0 select.mm-bookings-field-select').val('5');
            }
            if(fieldNameData == 331702 && count_person>7){
                $('.form_person_0 select.mm-bookings-field-select').val('7');
            }
        }
        if(product_id==234090){
            if(fieldNameData == 272989 && count_person>3){
                $('.form_person_0 select.mm-bookings-field-select').val('3');
            }
            if(fieldNameData == 272993 && count_person>5){
                $('.form_person_0 select.mm-bookings-field-select').val('5');
            }
            if(fieldNameData == 272992 && count_person>6){
                $('.form_person_0 select.mm-bookings-field-select').val('6');
            }
        }
        if(product_id==239676){
            if(fieldNameData == 273007 && count_person>3){
                $('.form_person_0 select.mm-bookings-field-select').val('3');
            }
            if(fieldNameData == 273009 && count_person>5){
                $('.form_person_0 select.mm-bookings-field-select').val('5');
            }
            if(fieldNameData == 273010 && count_person>6){
                $('.form_person_0 select.mm-bookings-field-select').val('6');
            }
        }
        if(product_id==360050){
            if(fieldNameData == 372838 && count_person>5){
                $('.form_person_0 select.mm-bookings-field-select').val('5');
                
            }
            if(fieldNameData == 372839 && count_person>7){
                $('.form_person_0 select.mm-bookings-field-select').val('7');
                
            }
            /*if(fieldNameData == 372838){
                $('.person-name').text('Van (up to 5 guests)');
            }
            if(fieldNameData == 372839){
                $('.person-name').text('SUV (up to 7 guests)');
            }
            if(fieldNameData == 372840){
                $('.person-name').text('Mercedes Sprinter (up to 11 guests)');
            }*/
        }
        if(product_id==558036){
            if(fieldNameData == 558159 && count_person>5){
                $('.form_person_0 select.mm-bookings-field-select').val('5');
                
            }
        }
        if(product_id==1120){
            if((fieldNameData == 63853 || fieldNameData == 63854) && count_person>6){
                $('.form_person_0 select.mm-bookings-field-select').val('6');
            }else if(fieldNameData == 63858 && count_person > 13){
                $('.form_person_0 select.mm-bookings-field-select').val('13');
            }else if(fieldNameData == 544525 && count_person > 7){
                $('.form_person_0 select.mm-bookings-field-select').val('7');
            }
        }
        /*if(product_id==218407){
            if(fieldNameData == 221428){
                $('.form_person_0 select.mm-bookings-field-select').val('1');
                $('.form_person_0 select.mm-bookings-field-select').attr('min', '1');
                $('.form_person_0 select.mm-bookings-field-select').attr('max', '1');
            }else{
                if(count_person <= 1){
                    $('.form_person_0 select.mm-bookings-field-select').val('2');
                }
                $('.form_field_person button[data-quantity="minus"]').attr("disabled", false);
                $('.form_field_person button[data-quantity="plus"]').attr("disabled", false);
                $('.form_person_0 select.mm-bookings-field-select').attr('min', '2');
                $('.form_person_0 select.mm-bookings-field-select').attr('max', '6');
            }
        }*/
        if(product_id==101441){
            if((fieldNameData == 194437 || fieldNameData == 194434) && count_person>6){
                $('.form_person_0 select.mm-bookings-field-select').val('6');
            }
            if((fieldNameData == 194441 || fieldNameData == 194439) && count_person>14){
                $('.form_person_0 select.mm-bookings-field-select').val('14');
            }
            if((fieldNameData == 617467) && count_person>5){
                $('.form_person_0 select.mm-bookings-field-select').val('5');
            }
        }
        if(product_id==360669){
            if((fieldNameData == 360734) && count_person>6){
                $('.form_person_0 select.mm-bookings-field-select').val('6');
            }
        }
        if(product_id==359863){
            if((fieldNameData == 372920 || fieldNameData == 372922)){
                $('.form_person_0 select.mm-bookings-field-select').attr('max', '10');
                if(count_person>10){
                    $('.form_person_0 select.mm-bookings-field-select').val('10');
                }
            }else {
                $('.form_person_0 select.mm-bookings-field-select').attr('max', '12');
            }
            if((fieldNameData == 372921 || fieldNameData == 372923)){
                $('.mm-content-person .person-description-tooltip').css('display','');
            }else{
                $('.mm-content-person .person-description-tooltip').css('display','none');
            }
        }
        if(product_id==218407){
            if((fieldNameData == 281953 || fieldNameData == 221429)){
                $('.form_person_0 label.label-content-person .person-description').text('Ages 7 and up');
            }else{
                $('.form_person_0 label.label-content-person .person-description').text('Per Person (12+ years)');
            }
        }
        if(product_id==422773){
            if(fieldNameData == 422912 || fieldNameData == 422915){
                $('.form_person_1').css('display','none');
                $('.form_person_1 select.mm-bookings-field-select').val('0');
            }
            else{
                $('.form_person_1').css('display','');
            }
        }
        if(product_id==5480){
            if(fieldNameData != 427228){
                $('.form_person_1').css('display','none');
                $('.form_person_1 select.mm-bookings-field-select').val('0');
                $('.form_person_0').css('display','');
                if(parseInt($('.form_person_0 select.mm-bookings-field-select').val()) < 2){
                    $('.form_person_0 select.mm-bookings-field-select').val('2').change();
                }
            }
            else{
                $('.form_person_0').css('display','none');
                $('.form_person_0 select.mm-bookings-field-select').val('0').change();
                $('.form_person_1').css('display','');
                if(parseInt($('.form_person_1 select.mm-bookings-field-select').val()) < 1){
                    $('.form_person_1 select.mm-bookings-field-select').val('1').change();
                }
            }
        }
        /*if(product_id==218407){
            if((fieldNameData == 281953 || fieldNameData == 221429)){
                $('.form_person_0 select.mm-bookings-field-select').attr('min', '2');
                $('.form_person_0 select.mm-bookings-field-select').val('2');
            }else {
                $('.form_person_0 select.mm-bookings-field-select').attr('min', '1');
                $('.form_person_0 button[data-quantity="minus"]').attr("disabled", false);
            }
        }*/
        if(product_id==5043){
            if(fieldNameData == 438747){
                $('.form_person_2').css('display','none');
                $('.form_person_2 select.mm-bookings-field-select').val('0');
            }
            else{
                $('.form_person_2').css('display','');
            }
        }
        if(product_id==9736){
            if(fieldNameData == 117050 || fieldNameData == 117066){
                $('.form_person_1, .form_person_2').css('display','none');
                $('.form_person_1 select.mm-bookings-field-select, .form_person_2 select.mm-bookings-field-select').val('0');
            }
            else{
                $('.form_person_1, .form_person_2').css('display','');
                
            }
        }
        if(product_id==190067){
            if((fieldNameData == 196327 || fieldNameData == 197732) && count_person>5){
                $('.form_person_0 select.mm-bookings-field-select').val('5');
            }
        }
        if(product_id==360130){
            if((fieldNameData == 541239 || fieldNameData == 541240) && count_person>6){
                $('.form_person_0 select.mm-bookings-field-select').val('6').change();
            }
            
        }
        if(product_id==184305){
            if(fieldNameData == 184336 || fieldNameData == 184337){
                $('.form_person_0 select.mm-bookings-field-select option[value="0"]').css('display','none');
                $('.form_person_0 select.mm-bookings-field-select option[value="1"]').css('display','none');
                if(parseInt($('.form_person_0 select.mm-bookings-field-select').val()) < 2){
                    $('.form_person_0 select.mm-bookings-field-select').val('2');
                }
                
            }
            else{
                $('.form_person_0 select.mm-bookings-field-select option[value="0"]').css('display','none');
                $('.form_person_0 select.mm-bookings-field-select option[value="1"]').css('display','');
                if(parseInt($('.form_person_0 select.mm-bookings-field-select').val()) < 1){
                    $('.form_person_0 select.mm-bookings-field-select').val('1');
                }
            }
        }
        if(product_id==28279){
            if(fieldNameData == 28301 || fieldNameData == 28302){
                $('.form_person_1').css('display','none');
                $('.form_person_1 select.mm-bookings-field-select').val('0');
                $('.form_person_0').css('display','');
                if(parseInt($('.form_person_0 select.mm-bookings-field-select').val()) < 1){
                    $('.form_person_0 select.mm-bookings-field-select').val('1');
                }
            }
            else{
                $('.form_person_0').css('display','none');
                $('.form_person_0 select.mm-bookings-field-select').val('0');
                $('.form_person_1').css('display','');
                if(parseInt($('.form_person_1 select.mm-bookings-field-select').val()) < 1){
                    $('.form_person_1 select.mm-bookings-field-select').val('1');
                }
            }
        }
        if(product_id==577863){
            if(!$('.form_person_0 select.mm-bookings-field-select option[value="3"]').length){
                $('.form_person_0 select.mm-bookings-field-select').append('<option value="3">3</option>');
            }
            if(!$('.form_person_0 select.mm-bookings-field-select option[value="4"]').length){
                $('.form_person_0 select.mm-bookings-field-select').append('<option value="4">4</option>');
            }
            if(fieldNameData == 578015){
                if(parseInt($('.form_person_0 select.mm-bookings-field-select').val()) >2){
                    $('.form_person_0 select.mm-bookings-field-select').val('2');
                }
                $('.form_person_0 select.mm-bookings-field-select option[value="3"]').remove();
                $('.form_person_0 select.mm-bookings-field-select option[value="4"]').remove();
                
            }else if(fieldNameData == 584518){
                if(parseInt($('.form_person_0 select.mm-bookings-field-select').val()) >3){
                    $('.form_person_0 select.mm-bookings-field-select').val('3');
                }
                $('.form_person_0 select.mm-bookings-field-select option[value="4"]').remove();
                
            }
        }
        /*if(product_id==577863){
            if(fieldNameData == 578015){
                $('.form_person_0 select.mm-bookings-field-select').val('2');
                
            }else if(fieldNameData == 584518){
                $('.form_person_0 select.mm-bookings-field-select').val('3');
            }else if(fieldNameData == 584519){
                $('.form_person_0 select.mm-bookings-field-select').val('4');
            }
            customer_info_field_bookingbox();
            auto_change_tm_quantity_bookingbox();
            if($('.get_person_id').length){
                mm_get_list_person_id_bookingbox();
            }
            if($('.mm_plan_total_guest').length){
                mm_change_plan_total_guest();
            }
        }*/
        if($('input.get_resource_id').length){
            $("input.get_resource_id").each(function() {
                $(this).val(fieldNameData);
                $(this).change();
            });
            
            setTimeout(function(){
                if($('.weight_hono-div').length){
                    var text_descrition = $('.weight_hono-div:not(.tc-hidden) .weight_hono-ul li:nth-child(1) .tc-field-display i').data('tm-tooltip-html');
                    $(".customer-info-item").each(function() {
                        if($(this).find('.mm-weight-note').length == 1){
                            $(this).find('.mm-weight-note').text(text_descrition);
                        }
                    });
                    $('.customer-info-field input.first_name').change();
                }
                
            },600);
        }
        $(".form_field_person:not(.wc_bookings_field_duration)").each(function() {
            var costPersonFirst = $(this).find('.price-person').attr('data-cost-person');
            var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);

            var result = costsPerson.toFixed(2).toString().split('.');
            if (result[1]) {
                var sup_price = result[1];
            } else {
                var sup_price = '00';
            }
            $(this).find('.price-person').find('.custom-prc').html(addCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
        
        });
        /*if ($('.form-field.form_person_0').length) {
            var costPersonFirst = $('.form_person_0 .price-person').attr('data-cost-person');
            var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);

            var result = costsPerson.toFixed(2).toString().split('.');
            if (result[1]) {
                var sup_price = result[1];
            } else {
                var sup_price = '00';
            }
            $('.form_person_0 .price-person .custom-prc').html(addCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
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

            $('.form_person_1 .price-person .custom-prc').html(addCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
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
            $('.form_person_2 .price-person .custom-prc').html(addCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
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
            $('.form_person_3 .price-person .custom-prc').html(addCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
        }*/
        if(product_id==19254){
            if(fieldNameData == 477235){
                $('.wc_bookings_field_persons_19255, .wc_bookings_field_persons_19256, .wc_bookings_field_persons_477265').css('display','none');
                $('.wc_bookings_field_persons_19255 select.mm-bookings-field-select').val('0');
                $('.wc_bookings_field_persons_19256 select.mm-bookings-field-select').val('0');
                $('.wc_bookings_field_persons_477265 select.mm-bookings-field-select').val('0');
                $('.wc_bookings_field_persons_585239, .wc_bookings_field_persons_585241').css('display','');
                if(parseInt($('.wc_bookings_field_persons_585239 select.mm-bookings-field-select').val()) < 1){
                    $('.wc_bookings_field_persons_585239 select.mm-bookings-field-select').val('1');
                    $('.wc_bookings_field_persons_585239 select.mm-bookings-field-select option[value="0"]').css('display','none');
                
                }
            }
            else{
                $('.wc_bookings_field_persons_19255, .wc_bookings_field_persons_19256, .wc_bookings_field_persons_477265').css('display','');
                $('.wc_bookings_field_persons_585239 select.mm-bookings-field-select').val('0');
                $('.wc_bookings_field_persons_585241 select.mm-bookings-field-select').val('0');
                $('.wc_bookings_field_persons_585239, .wc_bookings_field_persons_585241').css('display','none');
                if(parseInt($('.wc_bookings_field_persons_19255 select.mm-bookings-field-select').val()) < 1){
                    $('.wc_bookings_field_persons_19255 select.mm-bookings-field-select').val('1');
                    $('.wc_bookings_field_persons_19255 select.mm-bookings-field-select option[value="0"]').css('display','none');
                
                }
            }
        }
        if(product_id==194886){
            if(fieldNameData == 194924){
                $('.wc_bookings_field_persons_589100, .wc_bookings_field_persons_589111, .wc_bookings_field_persons_589101, .wc_bookings_field_persons_589112').css('display','none');
                $('.wc_bookings_field_persons_589100 select.mm-bookings-field-select, .wc_bookings_field_persons_589111 select.mm-bookings-field-select, .wc_bookings_field_persons_589101 select.mm-bookings-field-select, .wc_bookings_field_persons_589112 select.mm-bookings-field-select').val('0');
    
                $('.wc_bookings_field_persons_194887, .wc_bookings_field_persons_194921, .wc_bookings_field_persons_194922').css('display','');
                if(parseInt($('.wc_bookings_field_persons_194887 select.mm-bookings-field-select').val()) < 1){
                    $('.wc_bookings_field_persons_194887 select.mm-bookings-field-select').val('1');
                    //$('.wc_bookings_field_persons_585239 select.mm-bookings-field-select option[value="0"]').css('display','none');
                
                }
            }
            else{
                $('.wc_bookings_field_persons_589100, .wc_bookings_field_persons_589111, .wc_bookings_field_persons_589101, .wc_bookings_field_persons_589112').css('display','');
                $('.wc_bookings_field_persons_194887 select.mm-bookings-field-select, .wc_bookings_field_persons_194921 select.mm-bookings-field-select, .wc_bookings_field_persons_194922 select.mm-bookings-field-select').val('0');
                $('.wc_bookings_field_persons_194887, .wc_bookings_field_persons_194921, .wc_bookings_field_persons_194922').css('display','none');
                if(parseInt($('.wc_bookings_field_persons_589100 select.mm-bookings-field-select').val()) < 1){
                    $('.wc_bookings_field_persons_589100 select.mm-bookings-field-select').val('1');
                    //$('.wc_bookings_field_persons_19255 select.mm-bookings-field-select option[value="0"]').css('display','none');
                
                }
            }
        }
        
        var custom_price = $(this).data('customprice');
        $(".form-field.form_field_person").each(function() {
            var person_id = parseInt($(this).data('id'));
            if(typeof custom_price[person_id] !== 'undefined'){
                var costsPerson = parseFloat(custom_price[ person_id ]);
                var result = costsPerson.toFixed(2).toString().split('.');
                if (result[1]) {
                    var sup_price = result[1];
                } else {
                    var sup_price = '00';
                }
                $(this).find('.price-person').find('.custom-prc').html(addCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
            
            }
        });  
        if (!$('.block-picker li').length) {
            $('.wc-bookings-booking-cost').html('<span class="booking-error">Date is required - please choose one above</span>');
        }

        var xhr = [];
        var name = $(this).attr('name');

        var $fieldset = $(this).closest('fieldset');
        var $picker = $fieldset.find('.picker:eq(0)');
        if ($picker.data('is_range_picker_enabled')) {
            if ('wc_bookings_field_duration' !== name) {
                return;
            }
        }

        var index = $('.wc-bookings-booking-form').index(this);
        $form = $(this).closest('form');
        var isEmptyCalendarSelection = !$form.find("[name='wc_bookings_field_start_date_day']").val() &&
            !$form.find('#wc_bookings_field_start_date').val();

        // Do not update if triggered by Product Addons and no date is selected.
        if (jQuery(e.target).hasClass('addon') && isEmptyCalendarSelection) {
            return;
        }

        var required_fields = $form.find('input.required_for_calculation');
        var filled = true;
        $.each(required_fields, function (index, field) {
            var value = $(field).val();
            if (!value) {
                filled = false;
            }
        });
        if (!filled) {
            $form.find('.wc-bookings-booking-cost').hide();
            return;
        }
        if (!jQuery('.single-product.postid-23497').length && !jQuery('.single-product.postid-194724').length && !jQuery('.single-product.postid-204526').length && !jQuery('.single-product.postid-204554').length && !jQuery('.single-product.postid-204635').length  && !jQuery('.single-product.postid-702635').length) {
            $('.wc-bookings-date-picker-date-fields input').val('');
            $('.wc_bookings_field_start_date .ht-choose-date legend, .wc_bookings_field_start_date .bookings-date-1 legend').css('display', 'block');
            $('.wc-bookings-date-picker-date-fields').css('display', 'none');
        }
        //$('.wc-bookings-date-picker-date-fields input').val('');

        var dataPrice = $('.data-name-island-private').attr('data-price-island-name');
        $form.find('.wc-bookings-booking-cost').block({message: null, overlayCSS: {background: '#fff', backgroundSize: '16px 16px', opacity: 0.6}}).show();
        xhr[index] = $.ajax({
            type: 'POST',
            url: booking_form_params.ajax_url,
            data: {
                action: 'wc_bookings_calculate_costs',
                form: $form.serialize() + '&data_price=' + dataPrice
            },
            success: function (code) {
                if (code.charAt(0) !== '{') {
                    //console.log(code);
                    code = '{' + code.split(/\{(.+)?/)[1];
                }

                result = $.parseJSON(code);
                jQuery('.customer-info-field').css('display','none');
                jQuery('.tc-extra-product-options').css('display','none');
                if (result.result == 'ERROR') {
                    $form.find('.wc-bookings-booking-cost').html(result.html);
                    $form.find('.wc-bookings-booking-cost').unblock();
                    $form.find('.single_add_to_cart_button').addClass('disabled');
                    $form.find('.single_add_to_cart_button').attr("disabled", true);
                    if(result.html.indexOf("The maximum persons fareharbor")>=0){
                        $form.find('.wc-bookings-booking-cost').html('');
                        jQuery('.mmt-button-waitlist').css('display','');
                        jQuery('.single_add_to_cart_button').css('display','none');
                    }
                    else if(result.html.indexOf("Sorry, the selected block is not available")>=0){
                        jQuery('.mmt-button-waitlist').css('display','');
                        jQuery('.single_add_to_cart_button').css('display','none');
                    }
                } else if (result.result == 'SUCCESS') {
                    $form.find('.wc-bookings-booking-cost').html(result.html);
                    $form.find('.wc-bookings-booking-cost').unblock();
                    $form.find('.single_add_to_cart_button').removeClass('disabled');
                    $form.find('.single_add_to_cart_button').attr("disabled", false);
                    jQuery('.customer-info-field').css('display','block');
                    jQuery('.tc-extra-product-options').css('display','block');
                    jQuery('.mmt-button-waitlist').css('display','none');
                    jQuery('.single_add_to_cart_button').css('display','');
                } else {
                    $form.find('.wc-bookings-booking-cost').hide();
                    $form.find('.single_add_to_cart_button').addClass('disabled');
                    $form.find('.single_add_to_cart_button').attr("disabled", true);
                    //console.log(code);
                }

                $(document.body).trigger('wc_booking_form_changed');
            },
            error: function () {
                $form.find('.wc-bookings-booking-cost').hide();
                $form.find('.single_add_to_cart_button').addClass('disabled');
                $form.find('.single_add_to_cart_button').attr("disabled", true);
            },
            dataType: "html"
        });
    });
    $(document).on('click', '#mm-time-picker li a', function (e) {
        e.preventDefault();
        if (!$('.block-picker li').length) {
            $('.wc-bookings-booking-cost').html('<span class="booking-error">Date is required - please choose one above</span>');
            $('#wc-bookings-booking-form .form_field-time i').css('display', 'none');
            $('.pickup-time').css('display', 'block');
            
            var text_pickup_time = $(this).text();
            $('.pickup-time').text(text_pickup_time);
            $('#mm-time-picker').toggleClass('block-picker-visible');
            //$(".list-costs-island").toggle(100);
        } else {
            var value = $(this).data('value');
            $(".block-picker a[data-value='" + value + "']").trigger('click');
            var text_pickup_time = $(this).text();
            $('#wc-bookings-booking-form .form_field-time i').css('display', 'none');
            $('.pickup-time').css('display', 'block');
            $('.pickup-time').text(text_pickup_time);
            $('#mm-time-picker').toggleClass('block-picker-visible');
            //$(".list-costs-island").toggle(100);
        }
        $('.form_field-time').removeClass('show-list-time');
        $('#wc-bookings-booking-form .form_field-time .wc_bookings_field_start_date').css('display', 'none');
        $('#wc-bookings-booking-form .form_field-time .icon-hour').css('display', 'none');
        $('#wc-bookings-booking-form .form_field-time .icon-check').css('display', 'block');
        if($('.get_time_start').length){
            $('input.get_time_start').val(text_pickup_time);
            $('input.get_time_start').change();
        }
    });
    //auto seclect time first
    $('#wc-bookings-booking-form .form_field-time i').css('display', 'none');
    var total = $('.form_person_0 .woocommerce-Price-amount.amount').html();
    /*if($('.cart .wc-booking-product-id').length){                  
        var ct_product_id = $('.cart .wc-booking-product-id').val();
        if(ct_product_id=='9499'||ct_product_id=='9489'||ct_product_id=='8664'||ct_product_id=='8648'||ct_product_id=='8634'||ct_product_id=='17057'){
            var costResource = $('.list-costs-island li:first-child').attr('data-cost');
            var costPersonFirst = $('.form_person_0 .price-person').attr('data-cost-person');
            var costsPerson = parseFloat(costPersonFirst*2) + parseFloat(costResource);
            var result = costsPerson.toFixed(2).toString().split('.');
            if (result[1]) {
                var sup_price = result[1];
            } else {
                var sup_price = '00';
            }
            total = "<span class='woocommerce-Price-currencySymbol'>$</span><span class='custom-prc'>" + result[0] + "<sup>." + sup_price + "</sup></span>";
        }
    }*/
    $('.wc-bookings-booking-cost .woocommerce-Price-amount.amount').html(total);
    var get_person_name = $('.form_person_0 .person-name').text();
    var count_person = $('.form_person_0 .content-person select.mm-bookings-field-select').val();
    var per_person_text = $('ul.list-costs-island li:first-child small').text().trim();
    if(per_person_text.indexOf("per boat")<0 && per_person_text.indexOf("per vehicle")<0 && per_person_text.indexOf("per group")<0 && per_person_text.indexOf("per charter")<0 && per_person_text.indexOf("per kayak")<0 && count_person > 1){
    
        var price_person = $('.form_person_0 .price-person').attr('data-cost-person');
        var online_booking = price_person * count_person;
        $('.wc-bookings-booking-cost .woocommerce-Price-amount.amount .custom-prc').html(online_booking);
    }
    if($('.vp_widget_booking').length){
        var online_booking = 0;
        var resource_id = $('#wc_bookings_field_resource').val();
        var resource_price =  parseFloat($('ul.list-costs-island li[data-fields="'+resource_id+'"] .ht-price-option .custom-prc').text().replace(/,/g, ''));
        jQuery(".form_field_person select.mm-bookings-field-select:not(#wc_bookings_field_duration, .mm_bookings_field_persons_Room)").each(function() {
            var person_val = parseInt(jQuery(this).val());

            online_booking = online_booking + (resource_price);
            if ($('.postid-577863').length){
                online_booking = online_booking*person_val;
            }
        });
        if(online_booking != 0){
            var result = online_booking.toFixed(2).toString().split('.');
            if (result[1]) {
                var sup_price = result[1];
            } else {
                var sup_price = '00';
            }
            $('.wc-bookings-booking-cost .woocommerce-Price-amount.amount .custom-prc').html(addCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
        }
    }
    

    $('#booking-box').on('change', '.form_field_person  select.mm-bookings-field-select', function( e ) {
        var tour_id = $('.wc-booking-product-id').val();
        var currentVal = parseInt($(this).val());
        /*if (tour_id == 165337 || tour_id == 239676 || tour_id == 234090 || tour_id == 164794) {
            if(currentVal!=0){
                var quantity_max = $(this).attr('max');
                $(this).val(quantity_max);
                $(this).attr("data-value", quantity_max);
            }
        }*/
        if(tour_id == 86822 || tour_id == 6133 || tour_id == 5720 || tour_id == 3879){
            var person_val = parseInt($(this).val());
            var person_name = $(this).closest('.form_field_person').find('.person-name').text().toLowerCase();
            if(person_val>0){
                var tmp = false;
                if(person_name.indexOf("with")>=0){
                    tmp = true;
                }
                $(".form_field_person select.mm-bookings-field-select:not(#wc_bookings_field_duration, .mm_bookings_field_persons_Room)").each(function() {
                    var tmp_person_name = $(this).closest('.form_field_person').find('.person-name').text().toLowerCase();
                    if(tmp){
                        if(tmp_person_name.indexOf("with")<0){
                            $(this).val('0');
                        }
                    }else{
                        if(tmp_person_name.indexOf("with")>=0){
                            $(this).val('0');
                        }
                    }
                });
            }
        }
        customer_info_field_bookingbox();
        if($('.set_price_per_person-div:not(.tc-hidden)').length || $('.set_price_per_night-div:not(.tc-hidden)').length || $('.get_person_number-div:not(.tc-hidden)').length || $('.get_person_id_number-div:not(.tc-hidden)').length){
            auto_change_tm_quantity_bookingbox();
        }
        if($('.mm_set_qty_for_person-div:not(.tc-hidden)').length ){
            auto_change_tm_quantity_bookingbox_for_person();
        }
        if($('.get_person_id').length){
            mm_get_list_person_id_bookingbox();
        }
        if($('.mm_plan_total_guest').length){
            mm_change_plan_total_guest();
        }
        var data_cost = '';
        if (tour_id == 1120) {
            var qty_people = currentVal;
            var tour_island_text = '';
            var tour_price = '';
            var resource_id = $('#wc_bookings_field_resource').val();
            if(qty_people >13){
                $("#wc_bookings_field_resource > option[value=3504]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="3504"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="3504"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.price-person .custom-prc').html(tour_price);

                data_cost = $('.list-costs-island li[data-fields="3504"]').attr('data-cost');
            }else if(qty_people >7 && (resource_id != 63858 && resource_id != 3504)){
                $("#wc_bookings_field_resource > option[value=63858]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="63858"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="63858"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.price-person .custom-prc').html(tour_price);
                
                data_cost = $('.list-costs-island li[data-fields="63858"]').attr('data-cost');
            }else if (qty_people >6 && (resource_id == 63853 || resource_id == 63854)) {
                $("#wc_bookings_field_resource > option[value=544525]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="544525"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="544525"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.price-person .custom-prc').html(tour_price);
                
                data_cost = $('.list-costs-island li[data-fields="544525"]').attr('data-cost');
            }
            
        } 
        if (tour_id == 101441) {
            var qty_people = currentVal;
            var tour_island_text = '';
            var tour_price = '';
            var resource_id = $('#wc_bookings_field_resource').val();
            if (qty_people ==6 && resource_id == 617467) {
                $("#wc_bookings_field_resource > option[value=194437]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="194437"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="194437"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.price-person .custom-prc').html(tour_price);
                //$('.person-name').text(tour_island_text);
                data_cost = $('.list-costs-island li[data-fields="194437"]').attr('data-cost');
            }else if (qty_people >6 && qty_people <=14 && (resource_id == 194437 || resource_id == 617467)) {
                $("#wc_bookings_field_resource > option[value=194441]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="194441"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="194441"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.price-person .custom-prc').html(tour_price);
                //$('.person-name').text(tour_island_text);
                data_cost = $('.list-costs-island li[data-fields="194441"]').attr('data-cost');
            }else if (qty_people >14 && (resource_id == 194441 || resource_id == 194437 || resource_id == 617467)) {
                $("#wc_bookings_field_resource > option[value=275932]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="275932"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="275932"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.price-person .custom-prc').html(tour_price);
                //$('.person-name').text(tour_island_text);
                data_cost = $('.list-costs-island li[data-fields="275932"]').attr('data-cost');
            }else if (qty_people > 6 && qty_people <14 && resource_id == 194434) {
                $("#wc_bookings_field_resource > option[value=194439]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="194439"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="194439"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.price-person .custom-prc').html(tour_price);
                //$('.person-name').text(tour_island_text);
                data_cost = $('.list-costs-island li[data-fields="194439"]').attr('data-cost');
            }else if (qty_people > 14 && (resource_id == 194439 || resource_id == 194434)) {
                $("#wc_bookings_field_resource > option[value=275932]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="275932"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="275932"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.price-person .custom-prc').html(tour_price);
                //$('.person-name').text(tour_island_text);
                data_cost = $('.list-costs-island li[data-fields="275932"]').attr('data-cost');
            } 
        } 
        if (tour_id == 34517) {
            var qty_people = currentVal;
            var tour_island_text = '';
            var tour_price = '';
            var resource_id = $('#wc_bookings_field_resource').val();
            if (qty_people >5) {
                $("#wc_bookings_field_resource > option[value=3503]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="3503"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="3503"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.price-person .custom-prc').html(tour_price);
                //$('.person-name').text("Mercedes Sprinter");
                data_cost = $('.list-costs-island li[data-fields="3503"]').attr('data-cost');
            }
        } 
        if (tour_id == 164794) {
            var qty_people = currentVal;
            var tour_island_text = '';
            var tour_price = '';
            var resource_id = $('#wc_bookings_field_resource').val();
            if (qty_people >3) {
                $("#wc_bookings_field_resource > option[value=331676]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="331676"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="331676"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.price-person .custom-prc').html(tour_price);
                //$('.person-name').text(tour_island_text);
                data_cost = $('.list-costs-island li[data-fields="331676"]').attr('data-cost');
            }
        } 
        if (tour_id == 165337) {
            var qty_people = currentVal;
            var tour_island_text = '';
            var tour_price = '';
            var resource_id = $('#wc_bookings_field_resource').val();
            if (qty_people >7) {
                $("#wc_bookings_field_resource > option[value=331260]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="331260"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="331260"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.price-person .custom-prc').html(tour_price);
                //$('.person-name').text(tour_island_text);
                data_cost = $('.list-costs-island li[data-fields="331260"]').attr('data-cost');
            }else if (qty_people >5 && (resource_id == 3501 || resource_id == 3502)) {
                $("#wc_bookings_field_resource > option[value=331702]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="331702"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="331702"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.price-person .custom-prc').html(tour_price);
                //$('.person-name').text(tour_island_text);
                data_cost = $('.list-costs-island li[data-fields="331702"]').attr('data-cost');
            }else if (qty_people >3 && resource_id == 3501) {
                $("#wc_bookings_field_resource > option[value=3502]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="3502"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="3502"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.price-person .custom-prc').html(tour_price);
                //$('.person-name').text(tour_island_text);
                data_cost = $('.list-costs-island li[data-fields="3502"]').attr('data-cost');
            } 
        } 
        if (tour_id == 234090) {
            var qty_people = currentVal;
            var tour_island_text = '';
            var tour_price = '';
            var resource_id = $('#wc_bookings_field_resource').val();
            if (qty_people >6) {
                $("#wc_bookings_field_resource > option[value=272994]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="272994"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="272994"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.price-person .custom-prc').html(tour_price);
                //$('.person-name').text(tour_island_text);
                data_cost = $('.list-costs-island li[data-fields="272994"]').attr('data-cost');
            }else if (qty_people >5 && (resource_id == 272989 || resource_id == 272993)) {
                $("#wc_bookings_field_resource > option[value=272992]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="272992"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="272992"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.price-person .custom-prc').html(tour_price);
                //$('.person-name').text(tour_island_text);
                data_cost = $('.list-costs-island li[data-fields="272992"]').attr('data-cost');
            }else if (qty_people >3 && resource_id == 272989) {
                $("#wc_bookings_field_resource > option[value=272993]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="272993"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="272993"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.price-person .custom-prc').html(tour_price);
               // $('.person-name').text(tour_island_text);
               data_cost = $('.list-costs-island li[data-fields="272993"]').attr('data-cost');
            } 
        } 
        if (tour_id == 239676) {
            var qty_people = currentVal;
            var tour_island_text = '';
            var tour_price = '';
            var resource_id = $('#wc_bookings_field_resource').val();
            if (qty_people >6) {
                $("#wc_bookings_field_resource > option[value=273008]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="273008"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="273008"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.price-person .custom-prc').html(tour_price);
                //$('.person-name').text(tour_island_text);
                data_cost = $('.list-costs-island li[data-fields="273008"]').attr('data-cost');
            }else if (qty_people >5 && (resource_id == 273007 || resource_id == 273009)) {
                $("#wc_bookings_field_resource > option[value=273010]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="273010"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="273010"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.price-person .custom-prc').html(tour_price);
                //$('.person-name').text(tour_island_text);
                data_cost = $('.list-costs-island li[data-fields="273010"]').attr('data-cost');
            }else if (qty_people >3 && resource_id == 273007) {
                $("#wc_bookings_field_resource > option[value=273009]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="273009"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="273009"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.price-person .custom-prc').html(tour_price);
                //$('.person-name').text(tour_island_text);
                data_cost = $('.list-costs-island li[data-fields="273009"]').attr('data-cost');
            } 
        } 
        if (tour_id == 360050) {
            var qty_people = currentVal;
            var tour_island_text = '';
            var tour_price = '';
            var resource_id = $('#wc_bookings_field_resource').val();
            if (qty_people >5 && (resource_id == 372838)) {
                $("#wc_bookings_field_resource > option[value=372840]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="372840"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="372840"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.price-person .custom-prc').html(tour_price);
                data_cost = $('.list-costs-island li[data-fields="372840"]').attr('data-cost');
            }
        } 
        if (tour_id == 558036) {
            var qty_people = currentVal;
            var tour_island_text = '';
            var tour_price = '';
            var resource_id = $('#wc_bookings_field_resource').val();
            if (qty_people >5 && (resource_id == 558159)) {
                $("#wc_bookings_field_resource > option[value=558172]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="558172"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="558172"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.price-person .custom-prc').html(tour_price);
                data_cost = $('.list-costs-island li[data-fields="558172"]').attr('data-cost');
            }
        } 
        if ((tour_id == 32265 || tour_id == 32899 || tour_id == 32913 || tour_id == 32927) && $(this).attr('name')=='wc_bookings_field_duration') {
            var duration = currentVal;
            if(duration<=8){
                $("#wc_bookings_field_resource > option[value=32358]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                $('.tour-island').text($( "#wc_bookings_field_resource > option[value=32358]" ).text());
                if($('.vacation_islands-div').length){
                    mm_package_auto_select_island('32358');
                }
                data_cost = $('.list-costs-island li[data-fields="32358"]').attr('data-cost');
            }
            else if(duration<=11){
                $("#wc_bookings_field_resource > option[value=32359]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                $('.tour-island').text($( "#wc_bookings_field_resource > option[value=32359]" ).text());
                if($('.vacation_islands-div').length){
                    mm_package_auto_select_island('32359');
                }
                data_cost = $('.list-costs-island li[data-fields="32359"]').attr('data-cost');
            }
            else if(duration>11){
                $("#wc_bookings_field_resource > option[value=32360]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                $('.tour-island').text($( "#wc_bookings_field_resource > option[value=32360]" ).text());
                if($('.vacation_islands-div').length){
                    mm_package_auto_select_island('32360');
                }
                data_cost = $('.list-costs-island li[data-fields="32360"]').attr('data-cost');
            }

        }
        if(tour_id ==  32960 && $(this).attr('name')=='wc_bookings_field_duration'){
            var duration = currentVal;
            if(duration==4){
                $("#wc_bookings_field_resource > option[value=333777]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                $('.tour-island').text($( "#wc_bookings_field_resource > option[value=333777]" ).text());
                data_cost = $('.list-costs-island li[data-fields="32360"]').attr('data-cost');
            }
            if(duration==5){
                $("#wc_bookings_field_resource > option[value=333779]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                $('.tour-island').text($( "#wc_bookings_field_resource > option[value=333779]" ).text());
                data_cost = $('.list-costs-island li[data-fields="32360"]').attr('data-cost');
            }
            if(duration>=6){
                $("#wc_bookings_field_resource > option[value=333780]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                $('.tour-island').text($( "#wc_bookings_field_resource > option[value=333780]" ).text());
                data_cost = $('.list-costs-island li[data-fields="32360"]').attr('data-cost');
            }
        }
        if (tour_id == 194724) {
            var qty_people = currentVal;
            var resource_title = '';
            if(qty_people == 1){
                $("#wc_bookings_field_resource > option[value=196826]").prop("selected", true);
                resource_title = $('.list-costs-island li[data-fields="196826"] .island-name').text();
            }else if(qty_people == 2){
                $("#wc_bookings_field_resource > option[value=196827]").prop("selected", true);
                resource_title = $('.list-costs-island li[data-fields="196827"] .island-name').text();
            }else if(qty_people == 3){
                $("#wc_bookings_field_resource > option[value=196828]").prop("selected", true);
                resource_title = $('.list-costs-island li[data-fields="196828"] .island-name').text();
            }else if(qty_people == 4){
                $("#wc_bookings_field_resource > option[value=196830]").prop("selected", true);
                resource_title = $('.list-costs-island li[data-fields="196830"] .island-name').text();
            }
            if(resource_title!=''){
                $('.tour-island').text(resource_title);
            }

        } 
        if (tour_id == 204535) {
            var qty_people = currentVal;
            var resource_title = '';
            if(qty_people == 1){
                $("#wc_bookings_field_resource > option[value=23499]").prop("selected", true);
                resource_title = $('.list-costs-island li[data-fields="23499"] .island-name').text();
            }else if(qty_people == 2){
                $("#wc_bookings_field_resource > option[value=23501]").prop("selected", true);
                resource_title = $('.list-costs-island li[data-fields="23501"] .island-name').text();
            }else if(qty_people == 3){
                $("#wc_bookings_field_resource > option[value=23502]").prop("selected", true);
                resource_title = $('.list-costs-island li[data-fields="23502"] .island-name').text();
            }else if(qty_people == 4){
                $("#wc_bookings_field_resource > option[value=23503]").prop("selected", true);
                resource_title = $('.list-costs-island li[data-fields="23503"] .island-name').text();
            }
            if(resource_title!=''){
                $('.tour-island').text(resource_title);
            }
        } 
        if (tour_id == 204526) {
            var qty_people = currentVal;
            var resource_title = '';
            if(qty_people == 1){
                $("#wc_bookings_field_resource > option[value=205983]").prop("selected", true);
                resource_title = $('.list-costs-island li[data-fields="205983"] .island-name').text();
            }/*else if(qty_people == 2){
                $("#wc_bookings_field_resource > option[value=205982]").prop("selected", true);
                resource_title = $('.list-costs-island li[data-fields="205982"] .island-name').text();
            }*/
            if(resource_title!=''){
                $('.tour-island').text(resource_title);
            }
        } 
        if (tour_id == 5590) {
            var resource_id = $('#wc_bookings_field_resource').val();
            if(resource_id == 117719){
                var adult_count = $('.form_person_0  select.mm-bookings-field-select').val();
                var child_count = $('.form_person_1  select.mm-bookings-field-select').val();
                $('.form_person_1  select.mm-bookings-field-select').attr('max',adult_count);
                $('.form_person_1 button[data-quantity="plus"]').attr("disabled", false);
                if(child_count>adult_count){
                    $('.form_person_1  select.mm-bookings-field-select').val(adult_count);
                }
            }else{
                $('.form_person_1  select.mm-bookings-field-select').attr('max','6');
            }
        }
        if (tour_id == 11261 || tour_id == 5946) {
            var resource_id = $('#wc_bookings_field_resource').val();
            var hiker = $('.form_person_0  select.mm-bookings-field-select').val();
            if(hiker > 9 && (resource_id != 374689 && resource_id != 374680)){
                $('.form_person_0  select.mm-bookings-field-select').val('0');
                $('.form_person_1  select.mm-bookings-field-select').val('10');
                $('.form_person_1 select.mm-bookings-field-select').attr('min', '1');
                $('.form_person_2 button[data-quantity="plus"]').attr("disabled", false);
                $("select#wc_bookings_field_resource option:last-child").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                var tour_resource = $('.list-costs-island li:last-child .island-name').text();
                var tour_price = $('.list-costs-island li:last-child .custom-prc').html();
                $('.tour-island').text(tour_resource);
                $('.form_person_1 .price-person .custom-prc').html(tour_price);
                $('.form_person_2 .price-person .custom-prc').html('159<sup>.00</sup>');
                $('.form_person_1, .form_person_2').css('display','');
                $('.form_person_0').css('display','none');
                if($('input.get_resource_id').length){
                    $("input.get_resource_id").each(function() {
                        var resource_change = $('.list-costs-island li:last-child').attr('data-fields');
                        $(this).val(resource_change);
                        $(this).change();
                    });
                }
                $('.ht-choose-date').trigger('click');
            }
        }
        if (tour_id == 164539) {
            var resource_id = $('#wc_bookings_field_resource').val();
            if(resource_id == 164384){
                var adult_count = $('.form_person_0  select.mm-bookings-field-select').val();
                if(adult_count>=2){
                    $('.form_person_1, .form_person_2').css('display','');
                }else{
                    $('.form_person_1, .form_person_2').css('display','none');
                    $('.form_person_1  select.mm-bookings-field-select, .form_person_2  select.mm-bookings-field-select').val('0');
                }
            }
        }
        if (tour_id == 476436 && $(this).attr('name') == 'wc_bookings_field_persons_476632') {
            var qty_people = currentVal;
            var tour_island_text = '';
            var tour_price = '';
            var resource_id = $('#wc_bookings_field_resource').val();
            if(qty_people >13){
                $("#wc_bookings_field_resource > option[value=476629]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="476629"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="476629"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.form_person_0 .price-person .custom-prc').html(tour_price);
                $('.mmt-button-waitlist').css('display','none');
                $('.single_add_to_cart_button').css('display','');
                if(qty_people >=20 && qty_people <=24){
                    $('.form_person_0 .price-person .custom-prc').html('400<sup>.00</sup>');
                }else if(qty_people >=25 && qty_people <=29){
                    $('.form_person_0 .price-person .custom-prc').html('550<sup>.00</sup>');
                }else if(qty_people >=30 && qty_people <=34){
                    $('.form_person_0 .price-person .custom-prc').html('600<sup>.00</sup>');
                }else if(qty_people >=35 && qty_people <=39){
                    $('.form_person_0 .price-person .custom-prc').html('750<sup>.00</sup>');
                }else if(qty_people >= 40){
                    $('.single_add_to_cart_button').css('display','none');
                    $('.mmt-button-waitlist').css('display','');
                }
                data_cost = $('.list-costs-island li[data-fields="476629"]').attr('data-cost');
            }else if (qty_people >=6 && resource_id != 476576) {
                $("#wc_bookings_field_resource > option[value=476576]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="476576"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="476576"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.form_person_0 .price-person .custom-prc').html(tour_price);
                $('.mmt-button-waitlist').css('display','none');
                $('.single_add_to_cart_button').css('display','');
                data_cost = $('.list-costs-island li[data-fields="476576"]').attr('data-cost');
            }else{
                $('.mmt-button-waitlist').css('display','none');
                $('.single_add_to_cart_button').css('display','');
            }
        } 
        if (tour_id == 431240 && $(this).attr('name') == 'wc_bookings_field_persons_754703') {
            var qty_people = currentVal;
            var tour_island_text = '';
            var tour_price = '';
            var resource_id = $('#wc_bookings_field_resource').val();
            if(qty_people >13){
                $("#wc_bookings_field_resource > option[value=3504]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="3504"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="3504"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.form_person_0 .price-person .custom-prc').html(tour_price);
                $('.mmt-button-waitlist').css('display','none');
                $('.single_add_to_cart_button').css('display','');
                /*if(qty_people >=20 && qty_people <=24){
                    $('.form_person_0 .price-person .custom-prc').html('400<sup>.00</sup>');
                }else if(qty_people >=25 && qty_people <=29){
                    $('.form_person_0 .price-person .custom-prc').html('550<sup>.00</sup>');
                }else if(qty_people >=30 && qty_people <=34){
                    $('.form_person_0 .price-person .custom-prc').html('600<sup>.00</sup>');
                }else if(qty_people >=35 && qty_people <=39){
                    $('.form_person_0 .price-person .custom-prc').html('750<sup>.00</sup>');
                }else if(qty_people >= 40){
                    $('.single_add_to_cart_button').css('display','none');
                    $('.mmt-button-waitlist').css('display','');
                }*/
                data_cost = $('.list-costs-island li[data-fields="3504"]').attr('data-cost');
            }else if (qty_people >=6 && resource_id != 63858) {
                $("#wc_bookings_field_resource > option[value=63858]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="63858"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="63858"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.form_person_0 .price-person .custom-prc').html(tour_price);
                $('.mmt-button-waitlist').css('display','none');
                $('.single_add_to_cart_button').css('display','');
                data_cost = $('.list-costs-island li[data-fields="63858"]').attr('data-cost');
            }else{
                $('.mmt-button-waitlist').css('display','none');
                $('.single_add_to_cart_button').css('display','');
            }
        } 
        if (tour_id == 190067) {
            var qty_people = currentVal;
            var tour_island_text = '';
            var tour_price = '';
            var resource_id = $('#wc_bookings_field_resource').val();
            if (qty_people >5 && resource_id == 196327) {
                $("#wc_bookings_field_resource > option[value=292002]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="292002"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="292002"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.price-person .custom-prc').html(tour_price);
                //$('.person-name').text('Mercedes Sprinter (up to 11 guests)');
                data_cost = $('.list-costs-island li[data-fields="292002"]').attr('data-cost');
            }else if (qty_people >5 && resource_id == 197732) {
                $("#wc_bookings_field_resource > option[value=292003]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="292003"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="292003"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.price-person .custom-prc').html(tour_price);
                //$('.person-name').text('SUV (up to 7 guests)');
                data_cost = $('.list-costs-island li[data-fields="292003"]').attr('data-cost');
            }
        } 
        if (tour_id == 360130) {
            var qty_people = currentVal;
            var tour_island_text = '';
            var tour_price = '';
            var resource_id = $('#wc_bookings_field_resource').val();
            if (qty_people >6 && resource_id == 541239) {
                $("#wc_bookings_field_resource > option[value=360641]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="360641"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="360641"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.price-person .custom-prc').html(tour_price);
                //$('.person-name').text('Mercedes Sprinter (up to 11 guests)');
                data_cost = $('.list-costs-island li[data-fields="360641"]').attr('data-cost');
            }else if (qty_people >6 && resource_id == 541240) {
                $("#wc_bookings_field_resource > option[value=360643]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="360643"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="360643"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.price-person .custom-prc').html(tour_price);
                //$('.person-name').text('SUV (up to 7 guests)');
                data_cost = $('.list-costs-island li[data-fields="360643"]').attr('data-cost');
            }
        } 
        if (tour_id == 553456) {
            var qty_people = currentVal;
            var tour_island_text = '';
            var tour_price = '';
            var resource_id = $('#wc_bookings_field_resource').val();
            if (qty_people >5) {
                $("#wc_bookings_field_resource > option[value=553617]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="553617"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="553617"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.price-person .custom-prc').html(tour_price);
                //$('.person-name').text('Mercedes Sprinter (up to 11 guests)');
                data_cost = $('.list-costs-island li[data-fields="553617"]').attr('data-cost');
            }
        } 
        if (tour_id == 360669) {
            var qty_people = currentVal;
            var tour_island_text = '';
            var tour_price = '';
            var resource_id = $('#wc_bookings_field_resource').val();
            if (qty_people >6) {
                $("#wc_bookings_field_resource > option[value=486872]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="486872"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="486872"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.price-person .custom-prc').html(tour_price);
                data_cost = $('.list-costs-island li[data-fields="486872"]').attr('data-cost');
            }
        }
        if (tour_id == 512979) {
            var qty_people = currentVal;
            var person_id = jQuery(this).attr('id');
            jQuery(".form_field_person select.mm-bookings-field-select:not(#"+person_id+")").each(function() {
                if(qty_people != 0){
                    //jQuery(this).val('0').change();
                    jQuery(this).closest('.form_field_person').css('display','none');
                    //jQuery(this).find('option[value="1"]').css('display','none');
                    //jQuery(this).find('option[value="2"]').css('display','none');
                    //jQuery(this).find('option[value="3"]').css('display','none');
                    //jQuery(this).find('option[value="4"]').css('display','none');
                }else{
                    jQuery(this).closest('.form_field_person').css('display','');
                    //jQuery(this).find('option[value="1"]').css('display','');
                    //jQuery(this).find('option[value="2"]').css('display','');
                    //jQuery(this).find('option[value="3"]').css('display','');
                    //jQuery(this).find('option[value="4"]').css('display','');
                }
                /*var max_person = jQuery(this).attr('max');
                if(max_person == 4){
                    jQuery(this).find('option[value="1"]').css('display','none');
                    jQuery(this).find('option[value="2"]').css('display','none');
                    jQuery(this).find('option[value="3"]').css('display','none');
                }
                if(max_person == 3){
                    jQuery(this).find('option[value="1"]').css('display','none');
                    jQuery(this).find('option[value="2"]').css('display','none');
                }
                if(max_person == 2){
                    jQuery(this).find('option[value="2"]').css('display','none');
                }*/
            });
        }
        if (tour_id == 476562) {
            var qty_people = currentVal;
            var tour_island_text = '';
            var tour_price = '';
            var resource_id = $('#wc_bookings_field_resource').val();
            if (qty_people >4 && resource_id == 476656) {
                $("#wc_bookings_field_resource > option[value=750490]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="750490"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="750490"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.price-person .custom-prc').html(tour_price);
                //$('.person-name').text('Mercedes Sprinter (up to 11 guests)');
                data_cost = $('.list-costs-island li[data-fields="750490"]').attr('data-cost');
            }else if (qty_people >4 && resource_id == 476659) {
                $("#wc_bookings_field_resource > option[value=750492]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="750492"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="750492"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.price-person .custom-prc').html(tour_price);
                //$('.person-name').text('SUV (up to 7 guests)');
                data_cost = $('.list-costs-island li[data-fields="750492"]').attr('data-cost');
            }
        }
        if(data_cost){
            var e_pricePerson = $(this).parent().next().find('.price-person');
            var price_person = 0;
            if(e_pricePerson){
                price_person = e_pricePerson.attr('data-cost-person');
            }
            var cost_price = parseFloat(data_cost) + parseFloat(price_person);
            var price_tax = cost_price * 0.095;
            var total_price =  cost_price + price_tax;
            //$('#top.mm-custom-builder #mm_bookings_total_price p .price').html('$' + Math.round(total_price) + ' USD');
        }
        /*if(tour_id==577863){
            var qty_people = currentVal;
            if(qty_people == 2){
                $("#wc_bookings_field_resource > option[value=578015]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="578015"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="578015"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.price-person .custom-prc').html(tour_price);
            }
            if(qty_people == 3){
                $("#wc_bookings_field_resource > option[value=584518]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="584518"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="584518"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.price-person .custom-prc').html(tour_price);
            }
            if(qty_people == 4){
                $("#wc_bookings_field_resource > option[value=584519]").prop("selected", true);
                $('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
                $('.tour-island').css('display', 'block');
                tour_island_text = $('.list-costs-island li[data-fields="584519"] .island-name').text();
                tour_price = $('.list-costs-island li[data-fields="584519"] .custom-prc').html();
                $('.tour-island').text(tour_island_text);
                $('.price-person .custom-prc').html(tour_price);
            }
            
        }*/
        if($('.vp_widget_booking').length && $(this).attr('name')=='wc_bookings_field_duration'){
            vp_widget_booking_change_resource();
        }
        if (tour_id == 218397) {
            var total_guest = 0;
            jQuery(".form_field_person select.mm-bookings-field-select:not(#wc_bookings_field_persons_503651)").each(function() {
                var person_val = parseInt(jQuery(this).val());
                total_guest = total_guest + person_val;
            });
            var empty_seat = jQuery(".form_person_2 select").val();
            if (total_guest % 2 == 0){
                if(empty_seat != 0){
                    jQuery(".form_person_2 select").val('0').change();
                }
                jQuery('.form_person_2 select option[value="1"]').css('display','none');
                jQuery('.form_person_2 select option[value="0"]').css('display','');
                
            }else{
                if(empty_seat != 1){
                    jQuery(".form_person_2 select").val('1').change();
                }
                jQuery('.form_person_2 select option[value="0"]').css('display','none');
                jQuery('.form_person_2 select option[value="1"]').css('display','');
            }
        }   
        if (tour_id == 27480) {
            var seaters_including_2 = parseInt(jQuery('.form_person_1  select.mm-bookings-field-select').val());
            var seaters_including_4 = parseInt(jQuery('.form_person_3  select.mm-bookings-field-select').val());
            if(seaters_including_2 == 0){
                jQuery('.form_person_2').css('display','none');
                jQuery('.form_person_2 select.mm-bookings-field-select').val('0');
            }else{
                jQuery('.form_person_2').css('display','');
                if(seaters_including_2 == 1){
                    if(parseInt(jQuery('.form_person_2 select').val())>1){
                        jQuery('.form_person_2 select.mm-bookings-field-select').val('1');
                    }
                    jQuery('.form_person_2 select option[value="2"]').css('display','none');
                    
                }else{
                    jQuery('.form_person_2 select option[value="2"]').css('display','');
                }
            }
            if(seaters_including_4 == 0){
                jQuery('.form_person_4').css('display','none');
                jQuery('.form_person_4 select.mm-bookings-field-select').val('0');
            }else{
                jQuery('.form_person_4').css('display','');
                var form_person_4 = parseInt(jQuery('.form_person_4 select.mm-bookings-field-select').val());
                if(seaters_including_4 ==1){
                    if(form_person_4>3){
                        jQuery('.form_person_4 select.mm-bookings-field-select').val('3');
                    }
                    jQuery('.form_person_4 select option[value="4"]').css('display','none');
                    jQuery('.form_person_4 select option[value="5"]').css('display','none');
                    jQuery('.form_person_4 select option[value="6"]').css('display','none');
                }else{
                    jQuery('.form_person_4 select option[value="4"]').css('display','');
                    jQuery('.form_person_4 select option[value="5"]').css('display','');
                    jQuery('.form_person_4 select option[value="6"]').css('display','');
                }
            }
        }
        if ($(this).closest('form').find("[name='wc_bookings_field_start_date_day']").val() == '') {
            var online_booking = 0;
            jQuery(".form_field_person select.mm-bookings-field-select:not(#wc_bookings_field_duration, .mm_bookings_field_persons_Room)").each(function() {
                var person_val = parseInt(jQuery(this).val());
                var resource_id = $('#wc_bookings_field_resource').val();
                var per_person_text = $('ul.list-costs-island li[data-fields="'+resource_id+'"] small').text().trim();
                if(person_val>0){
                    var price_person = parseFloat($(this).closest('.form_field_person').find('.price-person').find('.custom-prc').text().replace(/,/g, ''));
                    if(per_person_text.indexOf("per boat")<0 && per_person_text.indexOf("per vehicle")<0 && per_person_text.indexOf("per group")<0 && per_person_text.indexOf("per charter")<0 && per_person_text.indexOf("per kayak")<0){
                        online_booking = online_booking +  (price_person * person_val);
                    }else{
                        online_booking = online_booking + price_person;
                    }
                }

            });
            if(online_booking != 0){
                $('.wc-bookings-booking-cost .woocommerce-Price-amount.amount .custom-prc').html(online_booking);
            }
        }
        if($('.mm_input_weight').length && !$('.ari-kauai-weight').length){
            var person_val = parseInt($(this).val());
            var person_name = $(this).closest('.form_field_person').find('.person-name').text().toLowerCase();
            if(person_name.indexOf("mandatory comfort seat")>=0 || person_name.indexOf("extra comfort seat")>=0){        
                var weight_240 = 0;
                var weight_250 = 0;
                var weight_270 = 0;
                var weight_290 = 0;
                var total_2_guest_weight = 0;
                var count_2_guest_weight_420 = 0;
                var i = 0;
                $('.cpf-section:not(.tc-hidden) .tc-container:not(.tc-hidden) input.mm_input_weight').each(function() {
                    var get_weight = $(this).val();
                    if($(this).hasClass('mm_comfort_seat_290') && get_weight>290){
                        weight_290 ++;
                    }
                    if($(this).hasClass('mm_comfort_seat_240') && get_weight>240){
                        weight_240 ++;
                    }
                    if($(this).hasClass('mm_comfort_seat_250') && get_weight>250){
                        weight_250 ++;
                    }
                    if($(this).hasClass('mm_comfort_seat_270') && get_weight>270){
                        weight_270 ++;
                    }
                    if($('.mm_comfort_seat_250').length && $('.total_weight_420-div').length){
                        if(get_weight<=250){
                            i++;
                            total_2_guest_weight = total_2_guest_weight + parseInt(get_weight);
                            if(i==2){
                                if(total_2_guest_weight >=420){
                                    count_2_guest_weight_420 ++;
                                }
                                total_2_guest_weight = 0;
                                i = 0;
                            }
                        }
                    }
                });
                var total_comfort_seat =  weight_290 + weight_240 + weight_250 + weight_270 + count_2_guest_weight_420;
                $(this).val(total_comfort_seat);
                /*if(total_comfort_seat>person_val){
                    $(this).val(total_comfort_seat);
                }*/
            }
        }
           
        var xhr = [];
        var index = $('.wc-bookings-booking-form').index(this);
        $form = $(this).closest('form');
        var isEmptyCalendarSelection = !$form.find("[name='wc_bookings_field_start_date_day']").val() &&
            !$form.find('#wc_bookings_field_start_date').val();

        // Do not update if triggered by Product Addons and no date is selected.
        if (jQuery(e.target).hasClass('addon') && isEmptyCalendarSelection) {
            return;
        }

        var required_fields = $form.find('input.required_for_calculation');
        var filled = true;
        $.each(required_fields, function (index, field) {
            var value = $(field).val();
            if (!value) {
                filled = false;
            }
        });
        if (!filled) {
            $form.find('.wc-bookings-booking-cost').hide();
            return;
        }
        setTimeout(function(){
            $form.find('.wc-bookings-booking-cost').block({message: null, overlayCSS: {background: '#fff', backgroundSize: '16px 16px', opacity: 0.6}}).show();
            xhr[index] = $.ajax({
                type: 'POST',
                url: booking_form_params.ajax_url,
                data: {
                    action: 'wc_bookings_calculate_costs',
                    form: $form.serialize()
                },
                success: function (code) {
                    if (code.charAt(0) !== '{') {
                        //console.log(code);
                        code = '{' + code.split(/\{(.+)?/)[1];
                    }

                    result = $.parseJSON(code);
                    jQuery('.customer-info-field').css('display','none');
                    jQuery('.tc-extra-product-options').css('display','none');
                    if (result.result == 'ERROR') {
                        $form.find('.wc-bookings-booking-cost').html(result.html);
                        $form.find('.wc-bookings-booking-cost').unblock();
                        $form.find('.single_add_to_cart_button').addClass('disabled');
                        $form.find('.single_add_to_cart_button').attr("disabled", true);
                        if(result.html.indexOf("The maximum persons fareharbor")>=0){
                            $form.find('.wc-bookings-booking-cost').html('');
                            jQuery('.mmt-button-waitlist').css('display','');
                            jQuery('.single_add_to_cart_button').css('display','none');
                        }
                        else if(result.html.indexOf("Sorry, the selected block is not available")>=0){
                            jQuery('.mmt-button-waitlist').css('display','');
                            jQuery('.single_add_to_cart_button').css('display','none');
                        }
                    } else if (result.result == 'SUCCESS') {
                        $form.find('.wc-bookings-booking-cost').html(result.html);
                        $form.find('.wc-bookings-booking-cost').unblock();
                        $form.find('.single_add_to_cart_button').removeClass('disabled');
                        $form.find('.single_add_to_cart_button').attr("disabled", false);
                        jQuery('.customer-info-field').css('display','block');
                        jQuery('.tc-extra-product-options').css('display','block');
                        jQuery('.mmt-button-waitlist').css('display','none');
                        jQuery('.single_add_to_cart_button').css('display','');
                    } else {
                        $form.find('.wc-bookings-booking-cost').hide();
                        $form.find('.single_add_to_cart_button').addClass('disabled');
                        $form.find('.single_add_to_cart_button').attr("disabled", true);
                        //console.log(code);
                    }

                    $(document.body).trigger('wc_booking_form_changed');
                },
                error: function () {
                    $form.find('.wc-bookings-booking-cost').hide();
                    $form.find('.single_add_to_cart_button').addClass('disabled');
                    $form.find('.single_add_to_cart_button').attr("disabled", true);
                },
                dataType: "html"
            });
        }, 500);
    });

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
    function customer_info_field_bookingbox(){
        var count_person = 0;
        var current_row = jQuery('.customer-info-item').length;
        if(!current_row) return;
        var tour_id = $('.wc-booking-product-id').val();
        var customer_field_html = jQuery('.customer-info-item[data-item="1"]').html();
        jQuery(".form_field_person select.mm-bookings-field-select:not(#wc_bookings_field_duration, .mm_bookings_field_persons_Room)").each(function() {
            var person_val = parseInt(jQuery(this).val());
            var person_name = jQuery(this).closest('.form_field_person').find('.person-name').text().trim();
            if(person_name !='Extra Comfort Seat'){
                count_person = count_person + person_val;
            }
            
        });
        
        var resource_id = $('#wc_bookings_field_resource').val();
        var style_customer_item = '';
        if (tour_id==3685 && resource_id == 3992){
            style_customer_item ='style="display:none"';
        }
        if (tour_id==216760 && resource_id == 222479){
            style_customer_item ='style="display:none"';
        }
        if (tour_id==3920 && resource_id == 117742){
            style_customer_item ='style="display:none"';
        }
        if (tour_id==194724 && resource_id == 201022){
            count_person = 2;
            jQuery('.customer-info-field .customer-info-item[data-item="2"] .has-error').each(function () {
                jQuery(this).removeClass('has-error');
                jQuery(this).closest('.form-row').find('.error').addClass('hidden');
            });
        }
        if (tour_id==167016 && resource_id == 167048 && count_person > 6){
            jQuery("#wc_bookings_field_resource > option[value=167047]").prop("selected", true);
            jQuery('#wc-bookings-booking-form div.mm_resource i').css('display', 'none');
            jQuery('.tour-island').css('display', 'block');
            var tour_island_text = jQuery('.list-costs-island li[data-fields="167047"] .island-name').text();
            //var tour_price = jQuery('.list-costs-island li[data-fields="167047"] .custom-prc').html();
            jQuery('.tour-island').text(tour_island_text);
            var costResource = jQuery('ul.list-costs-island li[data-fields=167047]').attr('data-cost');
            jQuery(".form_field_person").each(function() {
                var costPersonFirst = jQuery(this).find('.price-person').attr('data-cost-person');
                var costsPerson = parseFloat(costPersonFirst) + parseFloat(costResource);

                var result = costsPerson.toFixed(2).toString().split('.');
                if (result[1]) {
                    var sup_price = result[1];
                } else {
                    var sup_price = '00';
                }
                jQuery(this).find('.price-person').find('.custom-prc').html(addCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
            });
            
        }
        if(tour_id == 190141 && (resource_id ==194152 || resource_id ==194150 || resource_id ==194151 || resource_id ==194149 || resource_id ==190417)){
            jQuery('.customer-info-field').css('display','none');
        }
        if(tour_id==522148){
            if(resource_id== 522209){
                $('.customer-info-field  .customer-info-item').css('display','none');
                jQuery('.customer-info-div textarea').val('');
            }
            else{
                $('.customer-info-field  .customer-info-item').css('display','');
            }
        }
        if(tour_id==216760){
            if(resource_id== 222479){
                $('.customer-info-field  .customer-info-item').css('display','none');
                jQuery('.customer-info-div textarea').val('');
            }
            else{
                $('.customer-info-field  .customer-info-item').css('display','');
            }
        }
        if(count_person>0){
            /*if(!jQuery( '.single_add_to_cart_button').hasClass('disabled')){
                
            }*/
            //jQuery('.customer-info-field').css('display','block');
            var collapse_open = 'mm-collapse-open';
            if(jQuery('.vacation_packages_tour').length){
                collapse_open = '';
            }
            if(current_row<count_person){
                for (var i = current_row + 1; i <= count_person; i++) {
                
                    jQuery('.customer-info-field').append('<div class="customer-info-item '+collapse_open+'" data-item="'+i+'" '+style_customer_item+'>'+customer_field_html+'</div>');
                    jQuery('<span class="item">'+i+'</span>').replaceAll('.customer-info-field .customer-info-item:nth-child('+i+') .item');
                    jQuery('.customer-info-field .customer-info-item:nth-child('+i+') .birthday_guest_checkout input').attr("id","");
                    jQuery('.customer-info-field .customer-info-item:nth-child('+i+') .birthday_guest_checkout input').removeClass('hasDatepicker');
                    if(i==2){
                        jQuery('.customer-info-field .customer-info-item:nth-child('+i+') .item-th').text("nd");
                    }
                    if(i==3){
                        jQuery('.customer-info-field .customer-info-item:nth-child('+i+') .item-th').text("rd");
                    }
                    if(i>3){
                        jQuery('.customer-info-field .customer-info-item:nth-child('+i+') .item-th').text("th");
                    }
                }
            }
            else if(current_row>count_person){
                for (var j = count_person + 1; j <= current_row; j++) {
                    jQuery('.customer-info-field .customer-info-item[data-item="'+j+'"]').remove();
                }
            }
            
        }else{
            jQuery('.customer-info-field').css('display','none');
        }
        if(tour_id==190141){
            if(resource_id ==194152 || resource_id ==194150 || resource_id ==194151 || resource_id ==194149 || resource_id ==190417 || resource_id ==''){
                jQuery(".customer-info-field  .customer-info-item").each(function() {
                    jQuery(this).css('display','none');
                });
            }
            else{
                jQuery(".customer-info-field  .customer-info-item").each(function() {
                    jQuery(this).css('display','');
                });
            }
        }
        if(tour_id==522148){
            if(resource_id== 522209){
                jQuery(".customer-info-field  .customer-info-item").each(function() {
                    jQuery(this).css('display','none');
                });
            }
            else{
                jQuery(".customer-info-field  .customer-info-item").each(function() {
                    jQuery(this).css('display','');
                });
            }
        }
        if(jQuery('.postid-24053').length){
            var driver_utv = jQuery('.wc_bookings_field_persons_278118 select.mm-bookings-field-select').val();
            var tmp = 0;
            jQuery(".customer-info-field .customer-info-item").each(function() {
                tmp++;
                if(tmp<=driver_utv){
                    jQuery(this).find(".birthday_guest_checkout input:not(.hasDatepicker)").datepicker({
                        dateFormat : 'mm/dd/yy',
                        changeMonth : true,
                        yearRange: '-100y:c+nn',
                        changeYear : true,
                        maxDate: '-21Y' ,
                        defaultDate: '01/01/1980'
                    });
                    jQuery(this).find(".birthday_guest_checkout .mm-weight-note").text('Minimum age: 21yrs');
                }else{
                    jQuery(this).find(".birthday_guest_checkout input:not(.hasDatepicker)").datepicker({
                        dateFormat : 'mm/dd/yy',
                        changeMonth : true,
                        yearRange: '-100y:c+nn',
                        changeYear : true,
                        maxDate: -1 ,
                        defaultDate: '01/01/1980'
                    });
                    jQuery(this).find(".birthday_guest_checkout .mm-weight-note").text('');
                }
            });
            
        }else{
            jQuery(".birthday_guest_checkout input:not(.hasDatepicker)").datepicker({
                dateFormat : 'mm/dd/yy',
                changeMonth : true,
                yearRange: '-100y:c+nn',
                changeYear : true,
                maxDate: -1 ,
                defaultDate: '01/01/1980'
            });
        }
    }
    function auto_change_tm_quantity_bookingbox(){
        var count_person = 0;
        jQuery(".form_field_person select.mm-bookings-field-select:not(#wc_bookings_field_duration,.mm_bookings_field_persons_Room, #wc_bookings_field_persons_22041)").each(function() {
            var person_val = parseInt(jQuery(this).val());
            var person_name = jQuery(this).closest('.form_field_person').find('.person-name').text().toLowerCase();;
            if(person_name.indexOf("mandatory comfort seats")<0){
                count_person = count_person + person_val;
            }
        });
        jQuery(".set_price_per_person-div .tm-quantity input[type='number']").each(function() {
            jQuery(this).val(count_person);  
            if(jQuery('.postid-34517').length){
                if(jQuery(this).attr("name") == 'tmcp_checkbox_1_4_quantity' || jQuery(this).attr("name") == 'tmcp_checkbox_1_8_quantity' || jQuery(this).attr("name") == 'tmcp_checkbox_1_9_quantity' || jQuery(this).attr("name") == 'tmcp_checkbox_1_10_quantity' || jQuery(this).attr("name") == 'tmcp_checkbox_1_11_quantity'){
                    //jQuery(this).val(1);  
                }
            }
            if(jQuery('.postid-1120').length){
                if(jQuery(this).attr("name") == 'tmcp_checkbox_2_7_quantity'){
                    //jQuery(this).val(1);  
                }
            }
            if(jQuery('.postid-142872').length){
                var person_golf = parseInt(jQuery(".form_field_person .persons_golfers").val());
                var person_non_golf = parseInt(jQuery(".form_field_person #wc_bookings_field_persons_142886").val());
                var label_parent = jQuery(this).closest('.set_price_per_person-div').find('label.tm-epo-element-label').text();
                if(label_parent.indexOf("Golf")>=0){
                    jQuery(this).val(person_golf);
                }
                if(label_parent.indexOf("Non-Golfers")>=0){
                    jQuery(this).val(person_non_golf);
                }
            }
            if(jQuery('.set_price_per_group ').length){
                var label_parent = jQuery(this).closest('li.tmcp-field-wrap').find('span.tm-label').text();
                if(label_parent.indexOf("per group")>=0){
                    jQuery(this).val(1);
                }
            }
            if(jQuery('.postid-360130').length){
                var label_parent = jQuery(this).closest('li.tmcp-field-wrap').find('span.tm-label').text().toLowerCase();
                if(label_parent.indexOf("atv")>=0){
                    //var atv = Math.ceil(count_person/2);
                    //jQuery(this).val(atv);
                }
            }
            //3864, 3844, 3864, 3839
            if(jQuery('div.pht_oahu_pickup').length){
                jQuery("div.pht_oahu_pickup ul li:nth-child(2) .tm-quantity input[type='number']").val(1); 
            }
        });
        if(jQuery('input.get_person_number').length){
            jQuery('input.get_person_number').val(count_person);
            jQuery('input.get_person_number').change();
        }
        if(jQuery('input.get_person_id_number').length){
            jQuery(".get_person_id_number-div").each(function() {
                var person_id = jQuery(this).attr('id');
                var person_id_val = jQuery('select#wc_bookings_field_persons_'+person_id).val();
                jQuery(this).find('input.get_person_id_number').val(person_id_val);
                jQuery(this).find('input.get_person_id_number').change();
            });
            
        }
        
        if(jQuery('.set_price_per_night-div').length){
            count_person = parseInt(jQuery('#wc_bookings_field_duration').val());
            jQuery(".set_price_per_night-div .tm-quantity input[type='number']").each(function() {
                jQuery(this).val(count_person);    
            });
        }
    }
    function auto_change_tm_quantity_bookingbox_for_person(){
        var count_person = 0;
        jQuery(".form_field_person select.mm-bookings-field-select:not(#wc_bookings_field_duration,.mm_bookings_field_persons_Room, #wc_bookings_field_persons_22041)").each(function() {
            var person_val = parseInt(jQuery(this).val());
            var person_name = jQuery(this).closest('.form_field_person').find('.person-name').text().toLowerCase().trim();
            if(jQuery(this).closest('.form_field_person').css('display') != 'none'){
                jQuery(".mm_set_qty_for_person-div .tm-quantity input[type='number']").each(function() {
                    var get_label = jQuery(this).closest(".tmcp-field-wrap").find('.tm-epo-field-label').text().toLowerCase();
                    if(get_label.indexOf(person_name)>=0){
                        jQuery(this).val(person_val);
                    }
                });
            }
        });
        
    }
    function mm_get_list_person_id_bookingbox(){
        var list_person = [];
        jQuery(".form_field_person select.mm-bookings-field-select:not(#wc_bookings_field_duration,.mm_bookings_field_persons_Room)").each(function() {
            var person_val = parseInt(jQuery(this).val());
            if(person_val>0){
                var person_id = jQuery(this).closest('.form-field').data('id');
                list_person.push(person_id); 
            }
        });
        var get_person_id = list_person.toString();
        jQuery('input.get_person_id').val(get_person_id);
        jQuery('input.get_person_id').change();
    }
    $('.customer-info-field').on('change', 'input, select, textarea', function( e ) {
        var output = '';
        var count_ibs_265 = 0;
        var count_ibs_300 = 0;
        var count_ibs_230 = 0;
        var count_ibs_240 = 0;
        var count_ibs_260 = 0;
        var count_ibs_270 = 0;
        var count_ibs_280 = 0;
        var count_ibs_285 = 0;
        var count_ibs_290 = 0;
        var count_ibs_300 = 0;
        var count_2_guest_weight_400 = 0;
        var count_2_guest_weight_420 = 0;
        var count_2_guest_weight_470 = 0;
        var total_2_guest_weight = 0;
        var i = 0;
        jQuery(".customer-info-item .form-row").each(function() {
            var label_element = jQuery(this).find('label:not(.error)').text();
            label_element = label_element.replace('Enter the date of birth as it appears on your ID.', '');
            if(jQuery(this).find('input').length){
                var value_element = jQuery(this).find('input').val();
            }else if(jQuery(this).find('textarea').length){
                var value_element = jQuery(this).find('textarea').val();
            }else {
                value_element = jQuery(this).find('select').val();
                /*if(jQuery(this).find('select').val()!=''){
                    var check_field_empty = true;
                    jQuery(this).find("input").each(function() {
                        if(jQuery(this).val()==''){
                            check_field_empty = false;
                        }
                    });
                    if(check_field_empty){
                        
                    }
                }*/
            }
            if(jQuery(this).hasClass('birthday_guest_checkout') && jQuery('select.birthday_month').length){
                value_element ='';
                if(jQuery(this).find('select.birthday_month').val()!=''){
                    value_element = jQuery(this).find('select.birthday_month').val() + '/';
                }
                if(jQuery(this).find('select.birthday_day').val()!=''){
                    value_element += jQuery(this).find('select.birthday_day').val()+ '/';
                }
                if(jQuery(this).find('select.birthday_year').val()!=''){
                    value_element += jQuery(this).find('select.birthday_year').val();
                }
            }
            if(value_element!=''){
                output+= label_element+': ' + value_element+'\n';
            }
            var check_weight_2_guest = true;
            var get_weight = jQuery(this).find('.mmt_weight').val();
            if(jQuery('.weight_option_hilo-div').length && jQuery(this).find('.mmt_weight').length){
                if(parseInt(get_weight)>=265 && parseInt(get_weight)<=300){
                    count_ibs_265 ++;
                    check_weight_2_guest = false;
                }
                if(parseInt(get_weight)>300){
                    count_ibs_300 ++;
                    check_weight_2_guest = false;
                }
            }
            if(jQuery('.weight_hono-div').length && jQuery(this).find('.mmt_weight').length){
                if(jQuery('.postid-192152').length && parseInt(get_weight)>=230){
                    count_ibs_240 ++;
                    check_weight_2_guest = false;
                }else if(parseInt(get_weight)>=240){
                    count_ibs_240 ++;
                    check_weight_2_guest = false;
                }
                
            }
            if(jQuery('.weight_option_260_280-div').length && jQuery(this).find('.mmt_weight').length){
                if(parseInt(get_weight)>=260 && parseInt(get_weight)<=279){
                    count_ibs_260 ++;
                    check_weight_2_guest = false;
                }
                if(parseInt(get_weight)>=280){
                    count_ibs_280 ++;
                    check_weight_2_guest = false;
                }
            }
            if(jQuery('.weight_option_240_290-div').length && jQuery(this).find('.mmt_weight').length){
                if(parseInt(get_weight)>=240 && parseInt(get_weight)<=289){
                    count_ibs_240 ++;
                    check_weight_2_guest = false;
                }
                if(parseInt(get_weight)>=290){
                    count_ibs_290 ++;
                    check_weight_2_guest = false;
                }
            }
            if(jQuery('.weight_option_230-div').length && jQuery(this).find('.mmt_weight').length){
                if(parseInt(get_weight)>=230){
                    count_ibs_230 ++;
                    check_weight_2_guest = false;
                }
            }
            if(jQuery('.weight_option_270-div').length && jQuery(this).find('.mmt_weight').length){
                if(parseInt(get_weight)>=270){
                    count_ibs_270 ++;
                    check_weight_2_guest = false;
                }
            }
            if(jQuery('.weight_option_285-div').length && jQuery(this).find('.mmt_weight').length){
                if(parseInt(get_weight)>=285){
                    count_ibs_285 ++;
                    check_weight_2_guest = false;
                }
            }
            if(jQuery('.weight_option_290-div').length && jQuery(this).find('.mmt_weight').length){
                if(parseInt(get_weight)>=290){
                    count_ibs_290 ++;
                    check_weight_2_guest = false;
                }
            }
            if(jQuery('.weight_option_300-div').length && jQuery(this).find('.mmt_weight').length){
                if(parseInt(get_weight)>=300){
                    count_ibs_300 ++;
                    check_weight_2_guest = false;
                }
            }
            if(jQuery('.weight_option_260-div').length && jQuery(this).find('.mmt_weight').length){
                if(parseInt(get_weight)>=260){
                    count_ibs_260 ++;
                    check_weight_2_guest = false;
                }
            }
            if(jQuery('.total_weight_400-div').length && jQuery(this).find('.mmt_weight').length){
                if(check_weight_2_guest){
                    i++;
                    total_2_guest_weight = total_2_guest_weight + parseInt(get_weight);
                    if(i==2){
                        if(total_2_guest_weight >=400){
                            count_2_guest_weight_400 ++;
                        }
                        total_2_guest_weight = 0;
                        i = 0;
                    }
                }
            }
            if(jQuery('.total_weight_420-div').length && jQuery(this).find('.mmt_weight').length){
                if(check_weight_2_guest){
                    i++;
                    total_2_guest_weight = total_2_guest_weight + parseInt(get_weight);
                    if(i==2){
                        if(total_2_guest_weight >=420){
                            count_2_guest_weight_420 ++;
                        }
                        total_2_guest_weight = 0;
                        i = 0;
                    }
                }
            }
            if(jQuery('.total_weight_470-div').length && jQuery(this).find('.mmt_weight').length){
                if(check_weight_2_guest){
                    i++;
                    total_2_guest_weight = total_2_guest_weight + parseInt(get_weight);
                    if(i==2){
                        if(total_2_guest_weight >=470){
                            count_2_guest_weight_470 ++;
                        }
                        total_2_guest_weight = 0;
                        i = 0;
                    }
                }
            }
        }); 
        jQuery('.customer-info-div textarea').val(output);
        /*if(jQuery('.weight_option_hilo-div').length){
            if(count_ibs_265>0){
                jQuery('.weight_option_hilo-ul li:nth-child(1) .weight_option_hilo').prop('checked', true);
                jQuery('.weight_option_hilo-ul li:nth-child(1) input.tm-qty').val(count_ibs_265);
            }
            else{
                jQuery('.weight_option_hilo-ul li:nth-child(1) .weight_option_hilo').prop('checked', false);
            }
            if(count_ibs_300>0){
                jQuery('.weight_option_hilo-ul li:nth-child(2) .weight_option_hilo').prop('checked', true);
                jQuery('.weight_option_hilo-ul li:nth-child(2) input.tm-qty').val(count_ibs_300);
            }
            else{
                jQuery('.weight_option_hilo-ul li:nth-child(2) .weight_option_hilo').prop('checked', false);
            }
        }
        */
        if(jQuery('.weight_hono-div').length){
            if(count_ibs_240>0){
                jQuery('.weight_hono-ul li:nth-child(1)').each(function() {
                    if(jQuery(this).find('.weight_hono').prop("checked") == false){
                        jQuery(this).find('.tm-epo-field-label').trigger('click');
                    }
                    jQuery(this).find('input.tm-qty').val(count_ibs_240);
                });
                
                //jQuery('.weight_hono-ul li:nth-child(1) .weight_hono').prop('checked', true);
                //jQuery('.weight_hono-ul li:nth-child(1) .tc-label').change();
                
            }
            else{
                jQuery('.weight_hono-ul li:nth-child(1)').each(function() {
                    jQuery(this).find('.weight_hono').prop('checked', false);
                });
            }
            
        }
        if(jQuery('.weight_option_260_280-div').length){
            jQuery('.weight_option_260_280-ul li:nth-child(1), .weight_option_260_280-ul li:nth-child(2)').each(function() {
                jQuery(this).find('.weight_option_260_280').prop('checked', false);
            });
            if(count_ibs_260>0){
                jQuery('.weight_option_260_280-ul li:nth-child(1)').each(function() {
                    if(jQuery(this).find('.weight_option_260_280').prop("checked") == false){
                        jQuery(this).find('.tm-epo-field-label').trigger('click');
                    }
                    jQuery(this).find('input.tm-qty').val(count_ibs_260);
                });
            }
            if(count_ibs_280>0){
                jQuery('.weight_option_260_280-ul li:nth-child(2)').each(function() {
                    if(jQuery(this).find('.weight_option_260_280').prop("checked") == false){
                        jQuery(this).find('.tm-epo-field-label').trigger('click');
                    }
                    jQuery(this).find('input.tm-qty').val(count_ibs_280);
                });
            }
            
        }
        if(jQuery('.weight_option_240_290-div').length){
            jQuery('.weight_option_240_290-ul li:nth-child(1), .weight_option_240_290-ul li:nth-child(2)').each(function() {
                jQuery(this).find('.weight_option_240_290').prop('checked', false);
            });
            if(count_ibs_240>0){
                jQuery('.weight_option_240_290-ul li:nth-child(1)').each(function() {
                    if(jQuery(this).find('.weight_option_240_290').prop("checked") == false){
                        jQuery(this).find('.tm-epo-field-label').trigger('click');
                    }
                    jQuery(this).find('input.tm-qty').val(count_ibs_260);
                });
            }
            if(count_ibs_290>0){
                jQuery('.weight_option_240_290-ul li:nth-child(2)').each(function() {
                    if(jQuery(this).find('.weight_option_240_290').prop("checked") == false){
                        jQuery(this).find('.tm-epo-field-label').trigger('click');
                    }
                    jQuery(this).find('input.tm-qty').val(count_ibs_280);
                });
            }
        }
        if(jQuery('.weight_option_230-div').length){
            if(count_ibs_230>0){
                jQuery('.weight_option_230-ul li:nth-child(1)').each(function() {
                    if(jQuery(this).find('.weight_option_230').prop("checked") == false){
                        jQuery(this).find('.tm-epo-field-label').trigger('click');
                    }
                    jQuery(this).find('input.tm-qty').val(count_ibs_230);
                });
            }
            else{
                jQuery('.weight_option_230-ul li:nth-child(1)').each(function() {
                    jQuery(this).find('.weight_option_230').prop('checked', false);
                });
            }
        }
        if(jQuery('.weight_option_260-div').length){
            if(count_ibs_260>0){
                jQuery('.weight_option_260-ul li:nth-child(1)').each(function() {
                    if(jQuery(this).find('.weight_option_260').prop("checked") == false){
                        jQuery(this).find('.tm-epo-field-label').trigger('click');
                    }
                    jQuery(this).find('input.tm-qty').val(count_ibs_260);
                });
            }
            else{
                jQuery('.weight_option_260-ul li:nth-child(1)').each(function() {
                    jQuery(this).find('.weight_option_260').prop('checked', false);
                });
            }
        }
        if(jQuery('.weight_option_270-div').length){
            if(count_ibs_270>0){
                jQuery('.weight_option_270-ul li:nth-child(1)').each(function() {
                    if(jQuery(this).find('.weight_option_270').prop("checked") == false){
                        jQuery(this).find('.tm-epo-field-label').trigger('click');
                    }
                    jQuery(this).find('input.tm-qty').val(count_ibs_270);
                });
            }
            else{
                jQuery('.weight_option_270-ul li:nth-child(1)').each(function() {
                    jQuery(this).find('.weight_option_270').prop('checked', false);
                });
            }
        }
        if(jQuery('.weight_option_285-div').length){
            if(count_ibs_285>0){
                jQuery('.weight_option_285-ul li:nth-child(1)').each(function() {
                    if(jQuery(this).find('.weight_option_285').prop("checked") == false){
                        jQuery(this).find('.tm-epo-field-label').trigger('click');
                    }
                    jQuery(this).find('input.tm-qty').val(count_ibs_285);
                });
            }
            else{
                jQuery('.weight_option_285-ul li:nth-child(1)').each(function() {
                    jQuery(this).find('.weight_option_285').prop('checked', false);
                });
            }
        }
        if(jQuery('.weight_option_290-div').length){
            if(count_ibs_290>0){
                jQuery('.weight_option_290-ul li:nth-child(1)').each(function() {
                    if(jQuery(this).find('.weight_option_290').prop("checked") == false){
                        jQuery(this).find('.tm-epo-field-label').trigger('click');
                    }
                    jQuery(this).find('input.tm-qty').val(count_ibs_285);
                });
            }
            else{
                jQuery('.weight_option_290-ul li:nth-child(1)').each(function() {
                    jQuery(this).find('.weight_option_290').prop('checked', false);
                });
            }
        }
        if(jQuery('.weight_option_300-div').length){
            if(count_ibs_300>0){
                jQuery('.weight_option_300-ul li:nth-child(1)').each(function() {
                    if(jQuery(this).find('.weight_option_300').prop("checked") == false){
                        jQuery(this).find('.tm-epo-field-label').trigger('click');
                    }
                    jQuery(this).find('input.tm-qty').val(count_ibs_300);
                });
            }
            else{
                jQuery('.weight_option_300-ul li:nth-child(1)').each(function() {
                    jQuery(this).find('.weight_option_300').prop('checked', false);
                });
            }
        }
        if(jQuery('.total_weight_400-div').length){
            if(count_2_guest_weight_400>0){
                jQuery('.total_weight_400-ul li:nth-child(1)').each(function() {
                    if(jQuery(this).find('.total_weight_400').prop("checked") == false){
                        jQuery(this).find('.tm-epo-field-label').trigger('click');
                    }
                    jQuery(this).find('input.tm-qty').val(count_2_guest_weight_400);
                });
            }
            else{
                jQuery('.total_weight_400-ul li:nth-child(1)').each(function() {
                    jQuery(this).find('.total_weight_400').prop('checked', false);
                });
            }
        }
        if(jQuery('.total_weight_420-div').length){
            if(count_2_guest_weight_420>0){
                jQuery('.total_weight_420-ul li:nth-child(1)').each(function() {
                    if(jQuery(this).find('.total_weight_420').prop("checked") == false){
                        jQuery(this).find('.tm-epo-field-label').trigger('click');
                    }
                    jQuery(this).find('input.tm-qty').val(count_2_guest_weight_420);
                });
            }
            else{
                jQuery('.total_weight_420-ul li:nth-child(1)').each(function() {
                    jQuery(this).find('.total_weight_420').prop('checked', false);
                });
            }
        }
        if(jQuery('.total_weight_470-div').length){
            if(count_2_guest_weight_470>0){
                jQuery('.total_weight_470-ul li:nth-child(1)').each(function() {
                    if(jQuery(this).find('.total_weight_470').prop("checked") == false){
                        jQuery(this).find('.tm-epo-field-label').trigger('click');
                    }
                    jQuery(this).find('input.tm-qty').val(count_2_guest_weight_470);
                });
            }
            else{
                jQuery('.total_weight_470-ul li:nth-child(1)').each(function() {
                    jQuery(this).find('.total_weight_470').prop('checked', false);
                });
            }
        }
    });
    $('.customer-info-field').on('change', '.birthday_guest_checkout select', function( e ) {
        var m = $(this).closest('.birthday_guest_checkout').find('select.birthday_month').val();
        var d = $(this).closest('.birthday_guest_checkout').find('select.birthday_day').val();
        var y = $(this).closest('.birthday_guest_checkout').find('select.birthday_year').val();
        if(m!=''){
            $(this).closest('.birthday_guest_checkout').find('select.birthday_day').find("option").removeAttr("disabled");
            if(m=='02' || m=='04' || m=='06' || m=='09' || m=='11'){
                $(this).closest('.birthday_guest_checkout').find('select.birthday_day').find("option[value=\"31\"]").attr("disabled", "disabled");
                if(d=='31'){
                    $(this).closest('.birthday_guest_checkout').find('select.birthday_day').val('');
                }
            }
            if(m=='02'){
                $(this).closest('.birthday_guest_checkout').find('select.birthday_day').find("option[value=\"30\"]").attr("disabled", "disabled");
                if(d=='30'){
                    $(this).closest('.birthday_guest_checkout').find('select.birthday_day').val('');
                }
            }
        }
        if(m!='02'){
            $(this).closest('.birthday_guest_checkout').find('select.birthday_day').find("option[value=\"29\"]").removeAttr("disabled");
        }
        if(m=='02' && d=='29'){
            $(this).closest('.birthday_guest_checkout').find('select.birthday_year').find("option").each(function (index, value) {
                if (index > 0) {
                    var option = $(value);
                    var year = parseInt(option.attr("value"));
                    if (year % 4 != 0) {
                        option.attr("disabled", "disabled");
                    }
                }
            });
        }else if(m=='02' && y!=''){
            $(this).closest('.birthday_guest_checkout').find('select.birthday_year').find("option").removeAttr("disabled");
            $(this).closest('.birthday_guest_checkout').find('select.birthday_day').find("option[value=\"29\"]").removeAttr("disabled");
            if (y % 4 != 0) {
                $(this).closest('.birthday_guest_checkout').find('select.birthday_day').find("option[value=\"29\"]").attr("disabled", "disabled");
            }
        }else{
            $(this).closest('.birthday_guest_checkout').find('select.birthday_year').find("option").removeAttr("disabled");
        }
        mm_auto_change_person_number_with_date_of_birth();
    });
    /*$('.customer-info-field').on('change', 'input.birthday', function( e ) {
        //mm_auto_change_person_number_with_date_of_birth();
    });*/
    /*$('.tc-extra-product-options').on('change', 'input.mm_date_of_birth', function( e ) {
        if(mm_auto_change_person_number_with_date_of_birth() =='change_person'){
            $(this).val('');
        }
    });*/
    function mm_auto_change_person_number_with_date_of_birth(){
        var change_person = false;
        var empty_birth = false;
        if($(".customer-info-item input.birthday").length || $(".tc-extra-product-options input.mm_date_of_birth").length || $(".customer-info-item .birthday_guest_checkout select").length){
            if($(".tc-extra-product-options input.mm_date_of_birth").length){
                $(".cpf-section:not(.tc-hidden) .tc-container:not(.tc-hidden) input.mm_date_of_birth").each(function() {
                    var get_date_birth = $(this).val();
                    if(get_date_birth == ''){
                        empty_birth = true;
                    }
                });
            }else if($(".customer-info-item .birthday_guest_checkout select").length){
                $(".customer-info-item .birthday_guest_checkout").each(function() {
                    var m = $(this).closest('.birthday_guest_checkout').find('select.birthday_month').val();
                    var d = $(this).closest('.birthday_guest_checkout').find('select.birthday_day').val();
                    var y = $(this).closest('.birthday_guest_checkout').find('select.birthday_year').val();
                    var get_date_birth = m+'/'+d+'/'+y;
                    if(m == '' || d == '' || y == ''){
                        empty_birth = true;
                    }
                });
            }else{
                $(".customer-info-item input.birthday").each(function() {
                    var get_date_birth = $(this).val();
                    if(get_date_birth == ''){
                        empty_birth = true;
                    }
                });
            }
            if(empty_birth){
                return;
            }
            var booking_date_month = $('.booking_date_month').val();
            var booking_date_day = $('.booking_date_day').val();
            var booking_date_year = $('.booking_date_year').val();
            var booking_date = booking_date_year+'-'+booking_date_month+'-'+booking_date_day;
            var get_booking_date = new Date(booking_date);
            $("#wc-bookings-booking-form .form_field_person").each(function() {
                var field_person_val = parseInt($(this).find('.mm-bookings-field-select').val());
                var min_age =  $(this).find('.mm-bookings-field-select').data('min_age');
                var max_age =  $(this).find('.mm-bookings-field-select').data('max_age');
                if($(this).find('.mm-bookings-field-select').data('min_age').length != 0 && $(this).find('.mm-bookings-field-select').data('max_age').length != 0){
                    var tmp_person = 0;
                    if($(".tc-extra-product-options input.mm_date_of_birth").length){
                        $(".cpf-section:not(.tc-hidden) .tc-container:not(.tc-hidden) input.mm_date_of_birth").each(function() {
                            var get_date_birth = $(this).val();
                            get_date_birth = new Date(get_date_birth);
                            var millisBetween = get_booking_date.getTime() - get_date_birth.getTime();
                            var days = millisBetween / (1000 * 60 * 60 * 24 * 365.25);
                            var daysdifference = Math.floor(Math.abs(days));
                            //var daysdifference = days.toFixed();
                            if(daysdifference>=parseInt(min_age) && daysdifference<=parseInt(max_age)){
                                tmp_person++;
                            }
                        });
                    }else if($(".customer-info-item .birthday_guest_checkout select").length){
                        $(".customer-info-item .birthday_guest_checkout").each(function() {
                            var m = $(this).closest('.birthday_guest_checkout').find('select.birthday_month').val();
                            var d = $(this).closest('.birthday_guest_checkout').find('select.birthday_day').val();
                            var y = $(this).closest('.birthday_guest_checkout').find('select.birthday_year').val();
                            var get_date_birth = m+'/'+d+'/'+y;
                            get_date_birth = new Date(get_date_birth);
                            var millisBetween = get_booking_date.getTime() - get_date_birth.getTime();
                            var days = millisBetween / (1000 * 60 * 60 * 24 * 365.25);
                            var daysdifference = Math.floor(Math.abs(days));
                            //var daysdifference = days.toFixed();
                            if(daysdifference>=parseInt(min_age) && daysdifference<=parseInt(max_age)){
                                tmp_person++;
                            }
                        });
                    }else{
                        $(".customer-info-item input.birthday").each(function() {
                            var get_date_birth = $(this).val();
                            get_date_birth = new Date(get_date_birth);
                            var millisBetween = get_booking_date.getTime() - get_date_birth.getTime();
                            var days = millisBetween / (1000 * 60 * 60 * 24 * 365.25);
                            var daysdifference = Math.floor(Math.abs(days));
                            //var daysdifference = days.toFixed();
                            if(daysdifference>=parseInt(min_age) && daysdifference<=parseInt(max_age)){
                                tmp_person++;
                            }
                        });
                    }
                    if($(this).find('.mm-bookings-field-select').find('option[value="'+tmp_person+'"]').length && tmp_person != field_person_val){
                        $(this).find('.mm-bookings-field-select').val(tmp_person);
                        change_person = true;
                    }
                }
            });
            if(change_person){
                $('.form_person_0 .mm-bookings-field-select').change();
                return 'change_person';
            }
        }
    }
    $(document).off('keydown', '.customer-info-field input.birthday, .tc-extra-product-options input.mm_date_of_birth');
    $(document).on('keydown', '.customer-info-field input.birthday, .tc-extra-product-options input.mm_date_of_birth', function(e){

        $(this).attr('maxlength', '10');

        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }

        var value=$(this).val();

        if(value.length==2||value.length==5){
            $(this).val($(this).val()+'/');
        }
    });
    $(document).on('change', '.customer-info-field input.birthday', function( e ) {
        var get_date_dob = $(this).val();
        if(mm_dob_validateDate(get_date_dob) == false){
            var text_error = "The date is invalid. Please enter a date in the format: MM/DD/YYYY";
            if($(this).closest('.birthday_guest_checkout').find('.mm-dob-error').length <=0){
                $(this).closest('.birthday_guest_checkout').append( "<span class='mm-dob-error'>"+text_error+"</span>" );
            }else{
                $(this).closest('.birthday_guest_checkout').find('.mm-dob-error').text(text_error);
            }
            $(this).closest('.birthday_guest_checkout').find('.mm-dob-error').css('display','');
            $(this).val('');
        }else{
            $(this).closest('.birthday_guest_checkout').find('.mm-dob-error').css('display','none');
        }
        mm_auto_change_person_number_with_date_of_birth();
    });
    $(document).on('change', '.tc-extra-product-options input.mm_date_of_birth', function( e ) {
        var get_date_dob = $(this).val();
        if(mm_dob_validateDate(get_date_dob) == false){
            var text_error = "The date is invalid. Please enter a date in the format: MM/DD/YYYY";
            if($(this).closest('.tmcp-field-wrap').find('.mm-dob-error').length <=0){
                $(this).closest('.tmcp-field-wrap').append( "<span class='mm-dob-error'>"+text_error+"</span>" );
            }else{
                $(this).closest('.tmcp-field-wrap').find('.mm-dob-error').text(text_error);
            }
            $(this).closest('.tmcp-field-wrap').find('.mm-dob-error').css('display','');
            $(this).val('');
        }else{
            $(this).closest('.tmcp-field-wrap').find('.mm-dob-error').css('display','none');
        }
        if(mm_auto_change_person_number_with_date_of_birth() =='change_person'){
            $(this).val('');
        }
    });
    $('#tm-extra-product-options').on('change', 'input.mm_input_weight', function( e ) {
        var weight_240 = 0;
        var weight_250 = 0;
        var weight_270 = 0;
        var weight_290 = 0;
        var count_2_guest_weight_470 = 0;
        var count_2_guest_weight_420 = 0;
        var total_2_guest_weight = 0;
        var i = 0;
        if($('.ari-kauai-weight').length){
            var total_comfort_seat = 0;
            var first_class_count = $(".form_person_1 select.mm-bookings-field-select").val();
            var general = $(".form_person_0 select.mm-bookings-field-select").val();
            var tmp_first_class_name = '';
            var tmp_first_class_weight = '';
            if(first_class_count == 1){
                $('.cpf-section:not(.tc-hidden) .tc-container:not(.tc-hidden) input.mm_input_weight.pax_first_class').each(function() {
                    var get_weight = $(this).val();
                    if(get_weight>240){
                        total_comfort_seat++;
                    }
                });
            }
            if(first_class_count == 2){
                $('.cpf-section:not(.tc-hidden) .tc-container:not(.tc-hidden) input.mm_input_weight.pax_first_class').each(function() {
                    var get_weight = $(this).val();
                    total_2_guest_weight = total_2_guest_weight + parseInt(get_weight);
                    if(tmp_first_class_weight == '' && get_weight>=240){
                        tmp_first_class_weight = $(this).val();
                        tmp_first_class_name = $(this).closest('.tm-collapse-wrap').find('.cpf-type-textfield:not(.mm_input_weight)').find('input.tmcp-field').val();
                    }
                });
                if(total_2_guest_weight>=380){
                    $(".form_person_0 select.mm-bookings-field-select").val(parseInt(general)+1).change();
                    $(".form_person_1 select.mm-bookings-field-select").val(1).change();
                    $('.first_class_info_1 .cpf-type-textfield:not(.mm_input_weight) input.tmcp-field').val(tmp_first_class_name);
                    $('.first_class_info_1 .mm_input_weight input.tmcp-field').val(tmp_first_class_weight);
                }
            }
            if(general >=1){
                var average_general = 0;
                var total_weight_general = 0;
                var total_weight_2_general = 0;
                var not_empty_val = 0;
                var count_2_guest_weight_400 = 0
                var i = 0;
                $('.cpf-section:not(.tc-hidden) .tc-container:not(.tc-hidden) input.mm_input_weight:not(.pax_first_class)').each(function() {
                    var get_weight = $(this).val();
                    if(get_weight>240){
                        total_comfort_seat++;
                        return;
                    }
                    total_weight_general = total_weight_general + parseInt(get_weight);
                    if(get_weight!=''){
                        not_empty_val ++;
                        
                        i++;
                        total_weight_2_general = total_weight_2_general + parseInt(get_weight);
                        if(i==2){
                            if(total_weight_2_general >=400){
                                total_comfort_seat ++;
                            }
                            total_weight_2_general = 0;
                            i = 0;
                        }
                    }
                });
                
                if(not_empty_val >= 3 && total_weight_general>0 && (total_weight_general / not_empty_val)>190){
                    total_comfort_seat ++;
                }
                
            }
            $('.form_person_2 select.mm-bookings-field-select').val(total_comfort_seat).change();
        }else{
            $('.cpf-section:not(.tc-hidden) .tc-container:not(.tc-hidden) input.mm_input_weight').each(function() {
                var check_weight_2_guest = true;
                var get_weight = $(this).val();
                if($(this).hasClass('mm_comfort_seat_290') && get_weight>290){
                    weight_290 ++;
                }
                if($(this).hasClass('mm_comfort_seat_240') && get_weight>240){
                    weight_240 ++;
                }
                if($(this).hasClass('mm_comfort_seat_250') && get_weight>250){
                    weight_250 ++;
                }
                if($(this).hasClass('mm_comfort_seat_270') && get_weight>270){
                    weight_270 ++;
                }
                if($('.weight_less_than_240').length && get_weight > 240 ){
                    return;
                }
                if($('.total_weight_470-div').length){
                    if(check_weight_2_guest){
                        i++;
                        total_2_guest_weight = total_2_guest_weight + parseInt(get_weight);
                        if(i==2){
                            if(total_2_guest_weight >=470){
                                count_2_guest_weight_470 ++;
                            }
                            total_2_guest_weight = 0;
                            i = 0;
                        }
                    }
                }
                if($('.mm_comfort_seat_250').length && $('.total_weight_420-div').length){
                    if(get_weight<=250){
                        i++;
                        total_2_guest_weight = total_2_guest_weight + parseInt(get_weight);
                        if(i==2){
                            if(total_2_guest_weight >=420){
                                count_2_guest_weight_420 ++;
                            }
                            total_2_guest_weight = 0;
                            i = 0;
                        }
                    }
                }

            });
            var total_comfort_seat =  weight_290 + weight_240 + weight_250 + weight_270 + count_2_guest_weight_420;
            if(total_comfort_seat>=0){
                jQuery(".form_field_person select.mm-bookings-field-select:not(#wc_bookings_field_duration,.mm_bookings_field_persons_Room, #wc_bookings_field_persons_22041)").each(function() {
                    var person_val = parseInt(jQuery(this).val());
                    var person_name = jQuery(this).closest('.form_field_person').find('.person-name').text().toLowerCase();
                    if(person_name.indexOf("mandatory comfort seat")>=0 || person_name.indexOf("extra comfort seat")>=0){
                        jQuery(this).val(total_comfort_seat).change();
                        /*if(total_comfort_seat>person_val){
                            jQuery(this).val(total_comfort_seat).change();
                        }*/
                    }
                });
            }
            if($('.total_weight_470-div').length){
                if(count_2_guest_weight_470>0){
                    $('.total_weight_470-ul li:nth-child(1)').each(function() {
                        if($(this).find('.total_weight_470').prop("checked") == false){
                            $(this).find('.tm-epo-field-label').trigger('click');
                        }
                        $(this).find('input.tm-qty').val(count_2_guest_weight_470);
                    });
                }
                else{
                    $('.total_weight_470-ul li:nth-child(1)').each(function() {
                        $(this).find('.total_weight_470').prop('checked', false);
                    });
                }
            }
        }
        
    });
    $('#tm-extra-product-options').on('change', 'input.input_weight', function( e ) {
        var i = 0;
        var ibs_230 = 0;
        var ibs_240 = 0;
        var total_2_guest_weight = 0;
        var count_2_guest_weight_420 = 0;
        var count_2_guest_weight_470 = 0;
        $('.input_weight-div:not(.tc-hidden) input.input_weight').each(function() {
            var get_weight = $(this).val();
            if(parseInt(get_weight)<240){
                i++;
                total_2_guest_weight = total_2_guest_weight + parseInt(get_weight);
                if(i==2){
                    if(total_2_guest_weight >=420){
                        count_2_guest_weight_420 ++;
                    }
                    if(total_2_guest_weight >=470){
                        count_2_guest_weight_470 ++;
                    }
                    total_2_guest_weight = 0;
                    i = 0;
                }
            }
            if(parseInt(get_weight)>=230){
                ibs_230 ++;
            }
            if(parseInt(get_weight)>=240){
                ibs_240 ++;
            }
        });
        if($('.couple_weight').length){
            if(count_2_guest_weight_420>0){
                $('ul.couple_weight li:nth-child(1) .couple_weight ').prop('checked', true);
            }else{
                $('ul.couple_weight li:nth-child(1) .couple_weight ').prop('checked', false);
            }
            $('.couple_weight .tm-quantity input[type="number"]').val(count_2_guest_weight_420);
        }
        if($('.couple_weight_470').length){
            if(count_2_guest_weight_470>0){
                $('.couple_weight_470-ul li:nth-child(1) .couple_weight_470 ').prop('checked', true);
            }else{
                $('.couple_weight_470-ul li:nth-child(1) .couple_weight_470 ').prop('checked', false);
            }
            $('.couple_weight_470-ul li:nth-child(1) .tm-quantity input[type="number"]').val(count_2_guest_weight_470);
        }
        if($('.weight_option_230').length){
            if(ibs_230>0){
                $('.weight_option_230-ul li:nth-child(1) .weight_option_230 ').prop('checked', true);
            }else{
                $('.weight_option_230-ul li:nth-child(1) .weight_option_230 ').prop('checked', false);
            }
            $('.weight_option_230-ul li:nth-child(1) .tm-quantity input[type="number"]').val(ibs_230).change();
        }
        if($('.weight_option_240').length){
            if(ibs_230>0){
                $('.weight_option_240-ul li:nth-child(1) .weight_option_240 ').prop('checked', true);
            }else{
                $('.weight_option_240-ul li:nth-child(1) .weight_option_240 ').prop('checked', false);
            }
            $('.weight_option_240-ul li:nth-child(1) .tm-quantity input[type="number"]').val(ibs_240).change();
        }
    });
    $('#tm-extra-product-options').on('change', 'input.bigisland-private-guest-weight', function( e ) {
        var total_guest = 0;
        $(this).closest('.tm-collapse').find('input.bigisland-private-guest-weight').each(function() {
            var this_weight = parseInt($(this).val());
            if(this_weight!=''){
                total_guest = total_guest + this_weight;
            }
        });
        $(this).closest('.tm-collapse').find('input.bigisland-private-total-weight').val(total_guest).change();
    });
    $('.vp_widget_booking').on('change', '.mm-bookings-field-select.mm_bookings_field_persons_Persons', function( e ) {
        mm_package_auto_choose_room_field();
    });
    
    if($('.single-product').length){
        $('.wc-bookings-booking-form .booking_date_month').attr('readonly', 'readonly');
        $('.wc-bookings-booking-form .booking_date_day').attr('readonly', 'readonly');
        $('.wc-bookings-booking-form .booking_date_year').attr('readonly', 'readonly');
        if($('.mm-tour_id').length){
            
            var product_id = $('.tc-add-to-cart').val();
            $('.mm-tour_id-div .mm-tour_id').val(product_id);
        }
        if($( ".vp_widget_booking" ).length){
            $( ".wc-bookings-booking-form .form_person_0 .mm-bookings-field-select.mm_bookings_field_persons_Persons" ).val(2);
            
        }
        if(!$('.customer-info-div').length){
            $('.customer-info-field').html('');
            //$('.tm-extra-product-options-field .cpf-section:first-child .tm-toggle').trigger( "click" );
        }else{
            customer_info_field_bookingbox();
            var tour_id = $('.wc-booking-product-id').val();
            if($( ".vp_widget_booking" ).length){
                $( ".customer-info-field" ).insertAfter( ".tc-extra-product-options" );
            }
        }
        var product_id = $('.wc-booking-product-id').val();
        var resource_id = $('#wc_bookings_field_resource').val();
        if(product_id==190141){
            if(resource_id ==194152 || resource_id ==194150 || resource_id ==194151 || resource_id ==194149 || resource_id ==190417 || resource_id ==''){
                //$('.customer-info-field  .customer-info-item').css('display','none');
                //jQuery('.customer-info-div textarea').val('');
                
                $(".customer-info-field  .customer-info-item").each(function() {
                    $(this).css('display','none');
                });
            }
            else{
                //$('.customer-info-field  .customer-info-item').css('display','');
                $(".customer-info-field  .customer-info-item").each(function() {
                    $(this).css('display','');
                });
            }
        }
        if(product_id==216760){
            if(resource_id ==222479){
                //$('.customer-info-field  .customer-info-item').css('display','none');
                //jQuery('.customer-info-div textarea').val('');
                
                $(".customer-info-field  .customer-info-item").each(function() {
                    $(this).css('display','none');
                });
            }
            else{
                //$('.customer-info-field  .customer-info-item').css('display','');
                $(".customer-info-field  .customer-info-item").each(function() {
                    $(this).css('display','');
                });
            }
        }
        
        if($('.set_price_per_person-div:not(.tc-hidden)').length || $('.set_price_per_night-div:not(.tc-hidden)').length || $('.get_person_number-div:not(.tc-hidden)').length || $('.get_person_id_number-div:not(.tc-hidden)').length){
            auto_change_tm_quantity_bookingbox();
        }
        if($('.mm_set_qty_for_person-div:not(.tc-hidden)').length ){
            auto_change_tm_quantity_bookingbox_for_person();
        }
        if($('.get_person_id').length){
            mm_get_list_person_id_bookingbox();
        }
        if($('.mm_plan_total_guest').length){
            mm_change_plan_total_guest();
        }
        if($('#ui-datepicker-div').length && $('.birthday_guest_checkout input').length){
            var field_date_w = $('#wc-bookings-booking-form').width();
            $('#ui-datepicker-div').css('min-width', field_date_w - 30);
        }
        if($('.postid-34517').length || $('.postid-1120').length){
            /*$('ul.maui_private_addons  li.tmcp-field-wrap').each(function() {
                var check_island_label = $(this).find('.tc-label-wrap .tm-label').text();
                if(check_island_label == 'Oahu' || check_island_label == 'Kauai' || check_island_label == 'Big Island'){
                    $(this).css('display', 'none');
                }
            });*/
            $("ul.maui_private_addons  li.tmcp-field-wrap:nth-child(2), ul.maui_private_addons  li.tmcp-field-wrap:nth-child(3), ul.maui_private_addons  li.tmcp-field-wrap:nth-child(4)").css('display','none');
            $("ul.maui_private_addons  li.tmcp-field-wrap:nth-child(2), ul.maui_private_addons  li.tmcp-field-wrap:nth-child(3), ul.maui_private_addons  li.tmcp-field-wrap:nth-child(4)").css('padding-left','20px');
            $("ul.maui_private_addons  li.tmcp-field-wrap:nth-child(1)").on("click", function() {
                if($(this).hasClass('tc-active')){
                    $("ul.maui_private_addons  li.tmcp-field-wrap:nth-child(2), ul.maui_private_addons  li.tmcp-field-wrap:nth-child(3), ul.maui_private_addons  li.tmcp-field-wrap:nth-child(4)").css('display','none');
                    
                }else{
                    $("ul.maui_private_addons  li.tmcp-field-wrap:nth-child(2), ul.maui_private_addons  li.tmcp-field-wrap:nth-child(3), ul.maui_private_addons  li.tmcp-field-wrap:nth-child(4)").css('display','');
                }
            });
        }
        $("ul.max_one_checkbox_checked  li.tmcp-field-wrap").on("click", function() {
            var this_lable = $(this).find('label.tm-epo-field-label');
            if($(this).find('input[type="checkbox"]').prop("checked") == false){
                $("ul.max_one_checkbox_checked  li.tmcp-field-wrap").each(function() {
                    var each_all_label = $(this).find('label.tm-epo-field-label');
                    if(this_lable != each_all_label && $(this).find('input[type="checkbox"]').prop("checked") == true){
                        $(this).find('label.tm-epo-field-label').trigger('click');
                    }
                });
            }
        });
        $('#tm-extra-product-options').on('change', 'input.mm_pickup_time', function( e ) {
            if($(this).closest('.tmcp-field-wrap').find('.mm_pickup_time').hasClass('mm_checkin_time')){
                var count_before_6am = 0;
                $('#tm-extra-product-options input.mm_pickup_time.mm_checkin_time.tcenabled').each(function() {
                    var get_checkin_time = $(this).val();
                    if(get_checkin_time!=''){
                        var dt = new Date();
                        var end_time = "06:00";
                        //convert both time into timestamp
                        var stt = new Date((dt.getMonth() + 1) + "/" + dt.getDate() + "/" + dt.getFullYear() + " " + get_checkin_time);

                        stt = stt.getTime();
                        var endt = new Date((dt.getMonth() + 1) + "/" + dt.getDate() + "/" + dt.getFullYear() + " " + end_time);
                        endt = endt.getTime();
                        if (stt < endt) {
                            count_before_6am++;
                        }
                    }
                });
                if (count_before_6am >0) {
                    $('ul.mm_checkin_before_6am-ul li:nth-child(1) .mm_checkin_before_6am.tcenabled').prop('checked', true);
                    //$('ul.mm_checkin_before_6am-ul li:nth-child(1) .tm-quantity input.tm-qty').val(count_before_6am).change();
                    $('ul.mm_checkin_before_6am-ul li:nth-child(1) .mm_checkin_before_6am.tcenabled').closest('ul.mm_checkin_before_6am-ul').find('.tm-quantity input.tm-qty').val(count_before_6am).change();
                }else{
                    $('ul.mm_checkin_before_6am-ul li:nth-child(1) .mm_checkin_before_6am.tcenabled').prop('checked', false);
                }
            }
        });
        $('#tm-extra-product-options').on('change', 'input, select', function( e ) {
            if($(this).closest('.tm-extra-product-options-container').find('.tm-error').length){
                if($(this).hasClass('tmcp-radio') || $(this).hasClass('tmcp-checkbox')){
                    $(this).closest('.tm-extra-product-options-container').find('.tm-error').text('');
                }else{
                    if($(this).closest('.tmcp-field-wrap').find('.tm-error').length){
                        var this_val = $(this).val();
                        if($(this).hasClass('tmcp-date-select')){
                            this_val = $(this).closest('.tmcp-field-wrap').find('input.tmcp-date').val();
                        }
                        if(this_val !=''){
                            $(this).removeClass('tm-error');
                            $(this).closest('.tmcp-field-wrap').find('.tm-error').text('');
                        }
                    }
                }
            }
        });
        $('#tm-extra-product-options input').keyup(function() {
            if($(this).closest('.tmcp-field-wrap').find('.tm-error').length){
                var this_val = $(this).val();
                if($(this).hasClass('tmcp-date-select')){
                    this_val = $(this).closest('.tmcp-field-wrap').find('input.tmcp-date').val();
                }
                if(this_val !=''){
                    $(this).removeClass('tm-error');
                    $(this).closest('.tmcp-field-wrap').find('.tm-error').text('');
                }
            }
        });
        /*Fix Deposit Payment */
        
        if($('.ht_deposit_percentage').length){
            
            $(document).on('click', '#_sumo_pp_payment_type_fields .ht_deposit_payment_type', function (e) {
                if($("#_sumo_pp_payment_type_fields select[name='_sumo_pp_payment_type']:checked").val() == 'pay-in-deposit'){
                    if($('.wc-bookings-booking-cost .custom-prc').length){
                        var get_price_cost = $('.wc-bookings-booking-cost .custom-prc').text().replace(/,/g, '');
                        var get_percentage = parseFloat($('.ht_deposit_percentage').val());
                        if(get_price_cost!=''){
                            get_price_cost = parseFloat(get_price_cost);
                            var deposit_price = (get_price_cost * get_percentage) / 100;
                            $('#_sumo_pp_amount_to_choose select[name="_sumo_pp_deposited_amount"').val(deposit_price);
                            var result = deposit_price.toFixed(2).toString().split('.');
                            if (result[1]) {
                                var sup_price = result[1];
                            } else {
                                var sup_price = '00';
                            }
                            $("#_sumo_pp_amount_to_choose .custom-prc").html(addCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                        }
                    }
                }
            });
        }
        if($('#wc-bookings-booking-form #_sumo_pp_payment_type_fields').length){
            $('#wc-bookings-booking-form #_sumo_pp_payment_type_fields').prependTo( ".book-now-widget" );
        }
        if($('.mm_sumo_payment_plans').length){
            $('form.cart .mm_sumo_payment_plans').css('display','block');
            $( document ).on( 'wc_booking_form_changed' , mm_sumo_wc_booking_form_changed ) ;
            /*if($('.single-product.postid-69485').length || $('.single-product.postid-69711').length || $('.single-product.postid-69706').length){
                setTimeout(function(){
                    mm_sumo_wc_booking_form_changed();
                },500);
                $("#_sumo_pp_payment_type_fields .mm_payment_plans_type:nth-child(1)").insertAfter("#_sumo_pp_payment_type_fields .mm_payment_plans_type:nth-child(2)");
                $('#_sumo_pp_payment_type_fields .mm_payment_plans_type:nth-child(1)').trigger('click');
            }*/
        }
        $(document).on('click', '#_sumo_pp_payment_type_fields .mm_payment_plans_type', function (e) {
            mm_sumo_wc_booking_form_changed();
        });
        function mm_sumo_wc_booking_form_changed(){
            if($("#_sumo_pp_payment_type_fields select[name='_sumo_pp_payment_type']:checked").val() == 'payment-plans'){
                if($('.wc-bookings-booking-cost .custom-prc').length){
                    var get_price_cost = $('.wc-bookings-booking-cost .custom-prc').text().replace(/,/g, '');
                    $('.mm_plan_price_type').each(function() {
                        var pricetype = $(this).data('pricetype');
                        var plan_id = $(this).data('id');
                        var pricetype_value = parseFloat($(this).val());
                        if(pricetype == 'percentage'){
                            if(pricetype_value!=''){
                                var plan_price = (get_price_cost * pricetype_value) / 100;
                                var result = plan_price.toFixed(2).toString().split('.');
                                if (result[1]) {
                                    var sup_price = result[1];
                                } else {
                                    var sup_price = '00';
                                }
                                $(this).closest('.mm_plan_'+plan_id).find('._sumo_pp_initial_payable').find('.custom-prc').html(addCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                            }
                        }else{
                            var mm_plan_per_person = $(this).closest('.mm_plan_'+plan_id).find('.mm_plan_per_person').val();
                            if(mm_plan_per_person !='' && pricetype_value!=''){
                                var total_guest = $('.mm_plan_total_guest').val();
                                var plan_price = pricetype_value * total_guest;
                                var result = plan_price.toFixed(2).toString().split('.');
                                if (result[1]) {
                                    var sup_price = result[1];
                                } else {
                                    var sup_price = '00';
                                }
                                $(this).closest('.mm_plan_'+plan_id).find('._sumo_pp_initial_payable').find('.custom-prc').html(addCommasPrice(result[0]) + "<sup>." + sup_price + "</sup>");
                            }
                        }
                    });

                }
            }
        }
        if($('input.mm_date_of_birth').length){
            jQuery("input.mm_date_of_birth:not(.hasDatepicker)").datepicker({
                dateFormat : 'mm/dd/yy',
                changeMonth : true,
                yearRange: '-100y:c+nn',
                changeYear : true,
                maxDate: -1 ,
                defaultDate: '01/01/1980'
            });
            jQuery("input.mm_date_of_birth").attr('autocomplete', 'off');
        }
    }
    if($('.postid-231414').length){
        $('.form_person_0, .form_person_1').css('display','');
        $('.form_person_0 select.mm-bookings-field-select').val('1');
        $('.form_person_2, .form_person_3, .form_person_4, .form_person_5').css('display','none');
        $('.form_person_2 select.mm-bookings-field-select, .form_person_3 select.mm-bookings-field-select, .form_person_4 select.mm-bookings-field-select, .form_person_5 select.mm-bookings-field-select').val('0');    
    }
    $( window ).resize(function() {
        if($('#ui-datepicker-div').length && $('.birthday_guest_checkout input').length){
            var field_date_w = $('#wc-bookings-booking-form').width();
            $('#ui-datepicker-div').css('min-width', field_date_w - 30);
        }
    });
    $(window).on('load', function () {
        if($('.single-product').length){
            if($('.customer-info-div').length){
                customer_info_field_bookingbox();
            }
            if ($('#wc-bookings-booking-form').find("[name='wc_bookings_field_start_date_day']").val() != '') {
                auto_change_tm_quantity_bookingbox();
            }
            if($('.get_person_id').length){
                mm_get_list_person_id_bookingbox();
            }
        }
        if($('.vp_widget_booking').length){
            if($("select#wc_bookings_field_duration").length){
                vp_widget_booking_change_resource();
            }
            if($('#itinerary-highlights .av-section-tab-title').length){
                var url_acive_tab = $(location).attr('hash');
                vp_auto_change_resource_and_tour_detail(url_acive_tab);
                var acive_tab = url_acive_tab.replace("#", "");
                if(acive_tab!=''){
                    $('#itinerary-highlights .av-tab-section-inner-container').addClass('mm-vp-tab-content');
                    $('#itinerary-highlights .av-tab-section-inner-container .av-layout-tab.active-ss-tab').removeClass('active-ss-tab');
                    $('#itinerary-highlights .av-tab-section-inner-container .av-layout-tab[data-tab-section-id="'+acive_tab+'"]').addClass('active-ss-tab');
                }
            }
        }
            
    });
    function mm_package_auto_select_island(fieldNameData){
        $(".vacation_islands-ul li").each(function() {
            if($(this).find('input[type="checkbox"]').prop("checked") == true){
                $(this).find('label.tm-epo-field-label').trigger('click');
            }
            $(this).find('input[type="checkbox"]').prop('checked', false);
            $(this).removeClass('tc-active');
        });
        if(fieldNameData=='32358'){
            $('input.vacation_islands[value="Maui_0"]').closest('label.tm-epo-field-label').trigger('click');
            $('input.vacation_islands[value="Oahu_2"]').closest('label.tm-epo-field-label').trigger('click');
        }
        else if(fieldNameData=='32359'){
            $('input.vacation_islands[value="Maui_0"]').closest('label.tm-epo-field-label').trigger('click');
            $('input.vacation_islands[value="Oahu_2"]').closest('label.tm-epo-field-label').trigger('click');
            $('input.vacation_islands[value="Big Island_3"]').closest('label.tm-epo-field-label').trigger('click');
            if($('.postid-32913').length || $('.postid-32899').length){
                if($(".tm-element-ul-checkbox.element_4 li.tmcp-field-wrap:nth-child(7)").hasClass("tc-active")){
                    $(".tm-element-ul-checkbox.element_4 li.tmcp-field-wrap:nth-child(7) .tm-epo-field-label").trigger('click');
                }
            }
        }
        else if(fieldNameData=='32360'){
            $('input.vacation_islands[value="Maui_0"]').closest('label.tm-epo-field-label').trigger('click');
            $('input.vacation_islands[value="Oahu_2"]').closest('label.tm-epo-field-label').trigger('click');
            $('input.vacation_islands[value="Kauai_1"]').closest('label.tm-epo-field-label').trigger('click');
            $('input.vacation_islands[value="Big Island_3"]').closest('label.tm-epo-field-label').trigger('click');
            if($('.postid-32913').length || $('.postid-32899').length){
                if($(".tm-element-ul-checkbox.element_4 li.tmcp-field-wrap:nth-child(7)").hasClass("tc-active")){
                    $(".tm-element-ul-checkbox.element_4 li.tmcp-field-wrap:nth-child(7) .tm-epo-field-label").trigger('click');
                }
            }
        }
        if($('.postid-32960').length){
            $('input.vacation_islands[value="Kauai_0"]').closest('label.tm-epo-field-label').trigger('click');
            if(fieldNameData=='333780'){
                if(!$(".tm-element-ul-checkbox.element_4 li.tmcp-field-wrap:nth-child(5)").hasClass("tc-active")){
                    $(".tm-element-ul-checkbox.element_4 li.tmcp-field-wrap:nth-child(5) .tm-epo-field-label").trigger('click');
                }
            }else{
                if($(".tm-element-ul-checkbox.element_4 li.tmcp-field-wrap:nth-child(5)").hasClass("tc-active")){
                    $(".tm-element-ul-checkbox.element_4 li.tmcp-field-wrap:nth-child(5) .tm-epo-field-label").trigger('click');
                }
            }
        }
        if($('.postid-32994').length){
            $('input.vacation_islands[value="Maui_0"]').closest('label.tm-epo-field-label').trigger('click');
            if(fieldNameData=='333772'){
                if(!$(".island_maui_checkbox .tm-element-ul-checkbox li.tmcp-field-wrap:nth-child(4)").hasClass("tc-active")){
                    $(".island_maui_checkbox .tm-element-ul-checkbox li.tmcp-field-wrap:nth-child(4) .tm-epo-field-label").trigger('click');
                }
            }else{
                if($(".island_maui_checkbox .tm-element-ul-checkbox li.tmcp-field-wrap:nth-child(4)").hasClass("tc-active")){
                    $(".island_maui_checkbox .tm-element-ul-checkbox li.tmcp-field-wrap:nth-child(4) .tm-epo-field-label").trigger('click');
                }
            }
        }
        if($('.postid-33008').length){
            $('input.vacation_islands[value="Oahu_0"]').closest('label.tm-epo-field-label').trigger('click');
            if(fieldNameData=='333766'){
                if(!$(".island_oahu_checkbox .tm-element-ul-checkbox li.tmcp-field-wrap:nth-child(4)").hasClass("tc-active")){
                    $(".island_oahu_checkbox .tm-element-ul-checkbox li.tmcp-field-wrap:nth-child(4) .tm-epo-field-label").trigger('click');
                }
            }else{
                if($(".island_oahu_checkbox .tm-element-ul-checkbox li.tmcp-field-wrap:nth-child(4)").hasClass("tc-active")){
                    $(".island_oahu_checkbox .tm-element-ul-checkbox li.tmcp-field-wrap:nth-child(4) .tm-epo-field-label").trigger('click');
                }
            }
        }
        if($('.postid-33032').length){
            $('input.vacation_islands[value="Big Island_0"]').closest('label.tm-epo-field-label').trigger('click');
            if(fieldNameData=='32985'){
                if(!$(".island_bigisland_checkbox .tm-element-ul-checkbox li.tmcp-field-wrap:nth-child(4)").hasClass("tc-active")){
                    $(".island_bigisland_checkbox .tm-element-ul-checkbox li.tmcp-field-wrap:nth-child(4) .tm-epo-field-label").trigger('click');
                }
                if($(".island_bigisland_checkbox .tm-element-ul-checkbox li.tmcp-field-wrap:nth-child(9)").hasClass("tc-active")){
                    $(".island_bigisland_checkbox .tm-element-ul-checkbox li.tmcp-field-wrap:nth-child(9) .tm-epo-field-label").trigger('click');
                }
            }else if(fieldNameData=='32986'){
                if(!$(".island_bigisland_checkbox .tm-element-ul-checkbox li.tmcp-field-wrap:nth-child(4)").hasClass("tc-active")){
                    $(".island_bigisland_checkbox .tm-element-ul-checkbox li.tmcp-field-wrap:nth-child(4) .tm-epo-field-label").trigger('click');
                }
                if(!$(".island_bigisland_checkbox .tm-element-ul-checkbox li.tmcp-field-wrap:nth-child(9)").hasClass("tc-active")){
                    $(".island_bigisland_checkbox .tm-element-ul-checkbox li.tmcp-field-wrap:nth-child(9) .tm-epo-field-label").trigger('click');
                }
            }else{
                if($(".island_bigisland_checkbox .tm-element-ul-checkbox li.tmcp-field-wrap:nth-child(4)").hasClass("tc-active")){
                    $(".island_bigisland_checkbox .tm-element-ul-checkbox li.tmcp-field-wrap:nth-child(4) .tm-epo-field-label").trigger('click');
                }
                if($(".island_bigisland_checkbox .tm-element-ul-checkbox li.tmcp-field-wrap:nth-child(9)").hasClass("tc-active")){
                    $(".island_bigisland_checkbox .tm-element-ul-checkbox li.tmcp-field-wrap:nth-child(9) .tm-epo-field-label").trigger('click');
                }
            }
        }
        if($('.postid-142872').length){
            if(fieldNameData=='142892'){
                $('input.vacation_islands[value="Maui_0"]').closest('label.tm-epo-field-label').trigger('click');
                $('input.vacation_islands[value="Oahu_2"]').closest('label.tm-epo-field-label').trigger('click');
                $(".maui-golf ul li, .maui-activities ul li, .oahu-golf ul li, .oahu-activities ul li").each(function() {
                    if($(this).find('input[type="checkbox"]').prop("checked") == true){
                        $(this).find('label.tm-epo-field-label').trigger('click');
                    }
                    $(this).find('input[type="checkbox"]').prop('checked', false);
                    $(this).removeClass('tc-active');
                    var label = $(this).find('.tm-label').text();
                    if(label.indexOf("Kapalua Plantation")>=0 || label.indexOf("Luxury Road To Hana Tour")>=0 || label.indexOf("Royal Lahaina")>=0){
                        $(this).find('.tm-epo-field-label').trigger('click');
                    }
                    if(label.indexOf("Kapolei Golf Club")>=0 || label.indexOf("Arizona Memorial")>=0){
                        $(this).find('.tm-epo-field-label').trigger('click');
                    }
                });
            }else if(fieldNameData=='142891'){
                $('input.vacation_islands[value="Maui_0"]').closest('label.tm-epo-field-label').trigger('click');
                $('input.vacation_islands[value="Oahu_2"]').closest('label.tm-epo-field-label').trigger('click');
                $('input.vacation_islands[value="Big Island_1"]').closest('label.tm-epo-field-label').trigger('click');
                $('input.vacation_islands[value="Kauai_3"]').closest('label.tm-epo-field-label').trigger('click');
                $(".maui-golf ul li, .maui-activities ul li").each(function() {
                    if($(this).find('input[type="checkbox"]').prop("checked") == true){
                        $(this).find('label.tm-epo-field-label').trigger('click');
                    }
                    $(this).find('input[type="checkbox"]').prop('checked', false);
                    $(this).removeClass('tc-active');
                    var label = $(this).find('.tm-label').text();
                    if(label.indexOf("Kapalua Plantation")>=0 || label.indexOf("Luxury Road To Hana Tour")>=0){
                        $(this).find('.tm-epo-field-label').trigger('click');
                    }
                });
                $(".oahu-golf ul li, .oahu-activities ul li").each(function() {
                    if($(this).find('input[type="checkbox"]').prop("checked") == true){
                        $(this).find('label.tm-epo-field-label').trigger('click');
                    }
                    $(this).find('input[type="checkbox"]').prop('checked', false);
                    $(this).removeClass('tc-active');
                    var label = $(this).find('.tm-label').text();
                    if(label.indexOf("Kapolei Golf Club")>=0 || label.indexOf("Arizona Memorial")>=0){
                        $(this).find('.tm-epo-field-label').trigger('click');
                    }
                });
                $(".big-island-golf ul li, .big-island-activities ul li").each(function() {
                    if($(this).find('input[type="checkbox"]').prop("checked") == true){
                        $(this).find('label.tm-epo-field-label').trigger('click');
                    }
                    $(this).find('input[type="checkbox"]').prop('checked', false);
                    $(this).removeClass('tc-active');
                    var label = $(this).find('.tm-label').text();
                    if(label.indexOf("Waikoloa Village")>=0 || label.indexOf("Grand Circle Island")>=0 || label.indexOf("Hawaiian Luau")>=0){
                        $(this).find('.tm-epo-field-label').trigger('click');
                    }
                });
                $(".kauai-activities ul li").each(function() {
                    if($(this).find('input[type="checkbox"]').prop("checked") == true){
                        $(this).find('label.tm-epo-field-label').trigger('click');
                    }
                    $(this).find('input[type="checkbox"]').prop('checked', false);
                    $(this).removeClass('tc-active');
                    var label = $(this).find('.tm-label').text();
                    if(label.indexOf("Na Pali Snorkel Tour")>=0 || label.indexOf("Princeville Course")>=0){
                        $(this).find('.tm-epo-field-label').trigger('click');
                    }
                });
            }else if(fieldNameData=='142887'){
                $('input.vacation_islands[value="Maui_0"]').closest('label.tm-epo-field-label').trigger('click');
                $('input.vacation_islands[value="Oahu_2"]').closest('label.tm-epo-field-label').trigger('click');
                $(".maui-golf ul li, .maui-activities ul li, .oahu-golf ul li, .oahu-activities ul li").each(function() {
                    if($(this).find('input[type="checkbox"]').prop("checked") == true){
                        $(this).find('label.tm-epo-field-label').trigger('click');
                    }
                    $(this).find('input[type="checkbox"]').prop('checked', false);
                    $(this).removeClass('tc-active');
                    var label = $(this).find('.tm-label').text();
                    if(label.indexOf("Kapalua Plantation")>=0 || label.indexOf("Luxury Road To Hana Tour")>=0 || label.indexOf("Royal Lahaina")>=0){
                        $(this).find('.tm-epo-field-label').trigger('click');
                    }
                    if(label.indexOf("Pearl Country Club")>=0 || label.indexOf("Arizona Memorial")>=0){
                        $(this).find('.tm-epo-field-label').trigger('click');
                    }
                });
            }else if(fieldNameData=='142888'){
                $('input.vacation_islands[value="Maui_0"]').closest('label.tm-epo-field-label').trigger('click');
                $('input.vacation_islands[value="Oahu_2"]').closest('label.tm-epo-field-label').trigger('click');
                $(".maui-golf ul li, .maui-activities ul li, .oahu-golf ul li, .oahu-activities ul li").each(function() {
                    if($(this).find('input[type="checkbox"]').prop("checked") == true){
                        $(this).find('label.tm-epo-field-label').trigger('click');
                    }
                    $(this).find('input[type="checkbox"]').prop('checked', false);
                    $(this).removeClass('tc-active');
                    var label = $(this).find('.tm-label').text();
                    if(label.indexOf("Wailea Blue Course")>=0 || label.indexOf("Wailea Emerald")>=0 || label.indexOf("Luxury Road To Hana")>=0){
                        $(this).find('.tm-epo-field-label').trigger('click');
                    }
                    if(label.indexOf("Ko Olina Golf")>=0 || label.indexOf("Sunset Dinner Cruise")>=0 || label.indexOf("Hawaiian Luau")>=0){
                        $(this).find('.tm-epo-field-label').trigger('click');
                    }
                });
            }else if(fieldNameData=='142889'){
                $('input.vacation_islands[value="Maui_0"]').closest('label.tm-epo-field-label').trigger('click');
                $('input.vacation_islands[value="Big Island_1"]').closest('label.tm-epo-field-label').trigger('click');
                $(".maui-golf ul li, .maui-activities ul li, .big-island-golf ul li, .big-island-activities ul li").each(function() {
                    if($(this).find('input[type="checkbox"]').prop("checked") == true){
                        $(this).find('label.tm-epo-field-label').trigger('click');
                    }
                    $(this).find('input[type="checkbox"]').prop('checked', false);
                    $(this).removeClass('tc-active');
                    var label = $(this).find('.tm-label').text();
                    if(label.indexOf("Wailea Gold Course")>=0 || label.indexOf("Royal Lahaina Luau")>=0 || label.indexOf("Luxury Road To Hana")>=0){
                        $(this).find('.tm-epo-field-label').trigger('click');
                    }
                    if(label.indexOf("Hualalai Course")>=0){
                        $(this).find('.tm-epo-field-label').trigger('click');
                    }
                });
            }else if(fieldNameData=='142890'){
                $('input.vacation_islands[value="Maui_0"]').closest('label.tm-epo-field-label').trigger('click');
                $('input.vacation_islands[value="Kauai_3"]').closest('label.tm-epo-field-label').trigger('click');
                $('input.vacation_islands[value="Big Island_1"]').closest('label.tm-epo-field-label').trigger('click');
                $(".kauai-activities ul li,.kauai-golf ul li, .big-island-golf ul li, .big-island-activities ul li").each(function() {
                    if($(this).find('input[type="checkbox"]').prop("checked") == true){
                        $(this).find('label.tm-epo-field-label').trigger('click');
                    }
                    $(this).find('input[type="checkbox"]').prop('checked', false);
                    $(this).removeClass('tc-active');
                    var label = $(this).find('.tm-label').text();
                    if(label.indexOf("Na Pali Snorkel Tour")>=0 || label.indexOf("Kauai Lagoons Resort")>=0 || label.indexOf("Ocean Course at Hokuala")>=0){
                        $(this).find('.tm-epo-field-label').trigger('click');
                    }
                    if(label.indexOf("Hualalai Course")>=0 || label.indexOf("Evening Volcano Explorer")>=0 || label.indexOf("Hawaiian Luau")>=0){
                        $(this).find('.tm-epo-field-label').trigger('click');
                    }
                });
            }
        }
    }
    function mm_change_plan_total_guest(){
        var count_person = 0;
        jQuery(".form_field_person select.mm-bookings-field-select:not(#wc_bookings_field_duration,.mm_bookings_field_persons_Room)").each(function() {
            var person_val = parseInt(jQuery(this).val());
            count_person = count_person + person_val;
        });
        jQuery('.mm_plan_total_guest').val(count_person);
    }
    function mm_package_auto_choose_room_field(){
        var get_value = 0;
        jQuery('select.mm-bookings-field-select.mm_bookings_field_persons_Persons').each(function() {
            var person_val = parseInt(jQuery(this).val());
            get_value = get_value + person_val;
        });
        //var get_value = $('select.mm-bookings-field-select.mm_bookings_field_persons_Persons').val();
        var room = Math.ceil(get_value/4);
        var get_resource = $('select#wc_bookings_field_resource').val();
        if($('.postid-204526').length){
            if(get_resource == '205982'){
                room = Math.ceil(get_value/2);
            }else if(get_resource == '205983'){
                room = get_value;
            }
        }
        if($('.postid-204535').length){
            if(get_resource == '23501' || get_resource == '201022'){
                room = Math.ceil(get_value/2);
            }else if(get_resource == '23499'){
                room = get_value;
            }else if(get_resource == '23502'){
                room = Math.ceil(get_value/3);
            }else if(get_resource == '23503'){
                room = Math.ceil(get_value/4);
            }
        }
        $('.mm-bookings-field-select.mm_bookings_field_persons_Room').val(room);
    }
    function vp_widget_booking_change_resource(){
        var resource = $("select#wc_bookings_field_resource option:selected" ).text();
        if(resource == ''){
            resource = $("select#wc_bookings_field_resource option:nth-child(2)").text();
        }
        resource = resource.toLowerCase();
        resource = resource.replace(" ", "-");
        $("select#wc_bookings_field_resource option").each(function() {
            var island_name = $(this).text().toLowerCase();
            if(island_name.indexOf('1-island')>=0){
                island_name = '1-island';
            }
            if(island_name.indexOf('2-island')>=0){
                island_name = '2-island';
            }
            if(island_name.indexOf('3-island')>=0){
                island_name = '3-island';
            }
            if(island_name.indexOf('4-island')>=0){
                island_name = '4-island';
            }
            if(island_name!='' && island_name != resource && resource.indexOf(island_name)<0){
                $(".av-woo-product-tabs ."+island_name+"-itinerary_tab").css('display','none');
                $(".av-woo-product-tabs #tab-"+island_name+"-itinerary").addClass('vp-hide-tab');
            }else{
                $(".av-woo-product-tabs ."+island_name+"-itinerary_tab").css('display','');
                $(".av-woo-product-tabs #tab-"+island_name+"-itinerary").removeClass('vp-hide-tab');
            }
        });
        
        if($('#itinerary-highlights .av-section-tab-title').length){
            var acive_tab = $('#itinerary-highlights .av-active-tab-title').attr('href');
            if(acive_tab != '#'+resource){
               $('#itinerary-highlights .av-section-tab-title[href="#'+resource+'"]').trigger('click');
            }
        }
        if($('.holiday-bookingbox').length){
            var get_night = $('.wc_bookings_field_duration .mm-bookings-field-select').val();
            $(".av-woo-product-tabs .wc-tabs li").each(function() {
                var get_class_tab = $(this).attr('class');
                var get_id_tab = $(this).attr('id');
                get_id_tab = get_id_tab.replace("-title-", "");
                if(get_class_tab.indexOf('itinerary_tab')>=0){
                    $(this).css('display','none');
                    $(".av-woo-product-tabs ").find('#'+get_id_tab).addClass('vp-hide-tab');
                    if(get_class_tab.indexOf(get_night)>=0){
                        $(".av-woo-product-tabs ."+get_night+"-night-itinerary_tab").css('display','');
                        $(".av-woo-product-tabs #tab-"+get_night+"-night-itinerary").removeClass('vp-hide-tab');
                    }
                }
            });
            if($('#itinerary-highlights .av-section-tab-title').length){
                var acive_tab = $('#itinerary-highlights .av-active-tab-title').attr('href');
                if(acive_tab != '#'+get_night+"-nights"){
                   $('#itinerary-highlights .av-section-tab-title[href="#'+get_night+'-nights"]').trigger('click');
                }
            }
        }
    }
    if($('.vp_widget_booking').length){
        function vp_auto_change_resource_and_tour_detail(url_acive_tab){
            if(url_acive_tab !=''){
                var acive_tab = url_acive_tab.replace("#", "");
                if($('.holiday-bookingbox').length){
                    if(acive_tab.indexOf('night')>=0){
                        var get_night = acive_tab.replace("-nights", "");
                        $("select#wc_bookings_field_duration").val(get_night);
                        $(".av-woo-product-tabs .wc-tabs li").each(function() {
                            var get_class_tab = $(this).attr('class');
                            var get_id_tab = $(this).attr('id');
                            get_id_tab = get_id_tab.replace("-title-", "");
                            if(get_class_tab.indexOf('itinerary_tab')>=0){
                                $(this).css('display','none');
                                $(".av-woo-product-tabs ").find('#'+get_id_tab).addClass('vp-hide-tab');
                                if(get_class_tab.indexOf(get_night)>=0){
                                    $(".av-woo-product-tabs ."+get_night+"-night-itinerary_tab").css('display','');
                                    $(".av-woo-product-tabs #tab-"+get_night+"-night-itinerary").removeClass('vp-hide-tab');
                                }
                            }
                        });
                    }
                    
                }else{
                    var resource = $("select#wc_bookings_field_resource option:selected" ).val();
                    $("select#wc_bookings_field_resource option").each(function() {
                        var island_name = $(this).text().toLowerCase();
                        island_name = island_name.replace(" ", "-");
                        if(island_name.indexOf('1-island')>=0){
                            island_name = '1-island';
                        }
                        if(island_name.indexOf('2-island')>=0){
                            island_name = '2-island';
                        }
                        if(island_name.indexOf('3-island')>=0){
                            island_name = '3-island';
                        }
                        if(island_name.indexOf('4-island')>=0){
                            island_name = '4-island';
                        }
                        if(island_name!='' ){
                            if(island_name != acive_tab && acive_tab.indexOf(island_name)<0){
                                $(".av-woo-product-tabs ."+island_name+"-itinerary_tab").css('display','none');
                                $(".av-woo-product-tabs #tab-"+island_name+"-itinerary").addClass('vp-hide-tab');
                            }else{
                                $(".av-woo-product-tabs ."+island_name+"-itinerary_tab").css('display','');
                                $(".av-woo-product-tabs #tab-"+island_name+"-itinerary").removeClass('vp-hide-tab');
                                //$('.list-costs-island li[data-fields="'+$(this).val()+'"]').click();
                                var fieldNameData = $(this).val();
                                if(resource != fieldNameData){
                                    $(this).prop("selected", true);
                                    var tour_resource = $(this).text();
                                    $('.tour-island').text(tour_resource);

                                    if(fieldNameData== 32358){
                                        $("select#wc_bookings_field_duration").val('7');
                                    }
                                    if(fieldNameData== 32359){
                                        $("select#wc_bookings_field_duration").val('9');
                                    }
                                    if(fieldNameData== 32360){
                                        $("select#wc_bookings_field_duration").val('12');
                                    }
                                    if(fieldNameData == 32984 || fieldNameData == 333770 || fieldNameData == 333777 || fieldNameData == 333763){
                                        $("select#wc_bookings_field_duration").val('4');
                                    }
                                    if(fieldNameData == 32985 || fieldNameData == 333771 || fieldNameData == 333779 || fieldNameData == 333765){
                                        $("select#wc_bookings_field_duration").val('5');
                                    }
                                    if(fieldNameData == 32986 || fieldNameData == 333772 || fieldNameData == 333780 || fieldNameData == 333766){
                                        $("select#wc_bookings_field_duration").val('6');
                                    }
                                    if(fieldNameData == 142892){
                                        $("select#wc_bookings_field_duration").val('7');
                                    }
                                    if(fieldNameData == 142891){
                                        $("select#wc_bookings_field_duration").val('12');
                                    }
                                    if(fieldNameData == 142887){
                                        $("select#wc_bookings_field_duration").val('7');
                                    }
                                    if(fieldNameData == 142888){
                                        $("select#wc_bookings_field_duration").val('9');
                                    }
                                    if(fieldNameData == 142889){
                                        $("select#wc_bookings_field_duration").val('7');
                                    }
                                    if(fieldNameData == 142890){
                                        $("select#wc_bookings_field_duration").val('9');
                                    }
                                    $('.wc-bookings-date-picker-date-fields input').val('');
                                    $('.wc_bookings_field_start_date .ht-choose-date legend, .wc_bookings_field_start_date .bookings-date-1 legend').css('display', 'block');
                                    $('.wc-bookings-date-picker-date-fields').css('display', 'none');
                                    if (!$('.block-picker li').length) {
                                        $('.wc-bookings-booking-cost').html('<span class="booking-error">Date is required - please choose one above</span>');

                                    }
                                    //$('.customer-info-field').css('display','none');
                                    //$('.tc-extra-product-options').css('display','none');
                                    $('form.cart').find('.single_add_to_cart_button').addClass('disabled');
                                    $('form.cart').find('.single_add_to_cart_button').attr("disabled", true);
                                }
                            }
                        }
                    });
                }
            }
        }
        $('#itinerary-highlights a.av-section-tab-title, #av_section_1 a.avia-button').click(function(event) {
            var url_acive_tab = $(this).attr('href');
            vp_auto_change_resource_and_tour_detail(url_acive_tab);
            var acive_tab = url_acive_tab.replace("#", "");
            $('#itinerary-highlights .av-tab-section-inner-container').addClass('mm-vp-tab-content');
            $('#itinerary-highlights .av-tab-section-inner-container .av-layout-tab.active-ss-tab').removeClass('active-ss-tab');
            $('#itinerary-highlights .av-tab-section-inner-container .av-layout-tab[data-tab-section-id="'+acive_tab+'"]').addClass('active-ss-tab');
        });
        $("#itinerary-highlights .av-section-tab-title").each(function() {
            var tab = $(this).data('av-tab-section-title');
            $(this).clone().prependTo( '.av-tab-section-inner-container .av-layout-tab[data-av-tab-section-content="'+tab+'"] .av-layout-tab-inner' );
            //jQuery('.av-tab-section-inner-container .av-layout-tab[data-av-tab-section-content="'+tab+' .av-layout-tab-inner"]').prepend('<div>'+$(this).clone()+'</div>');
        });
        $(document).on('click', '#itinerary-highlights .av-layout-tab-inner .av-section-tab-title', function (e) {
            e.preventDefault();
            var tab = $(this).data('av-tab-section-title');
            /* $('#itinerary-highlights .av-tab-section-tab-title-container .av-section-tab-title[data-av-tab-section-title="'+tab+'"]').trigger('click');
            $('html, body').animate({
                scrollTop: $('#itinerary-highlights .av-layout-tab[data-av-tab-section-content="'+tab+'"]').offset().top
            }, 2000);*/
        });
    }     
    $(document).on('click', '.tm-quantity [data-quantity="plus"]', function (e) {
        var fieldName = $(this).closest('.tm-quantity').find('input.tm-qty').attr('name');
        var currentVal = parseInt($('select[name=' + fieldName + ']').val());
        var quantity_min = $('select[name=' + fieldName + ']').attr('min');
        var quantity_max = $('select[name=' + fieldName + ']').attr('max');
        if (typeof quantity_max !== typeof undefined && quantity_max !== false) {
            if(quantity_max<=currentVal){
                $(this).closest('.tm-quantity').find('button[data-quantity="plus"]').attr("disabled", true);
                return;
            }
        }
        if (typeof quantity_min !== typeof undefined && quantity_min !== false) {
            if(quantity_min<=currentVal){
                $(this).closest('.tm-quantity').find('button[data-quantity="minus"]').attr("disabled", false);
            }
        } 
        if (!isNaN(currentVal)) {
            // Increment
            $('select[name=' + fieldName + ']').val(currentVal + 1);
            $('select[name=' + fieldName + ']').change();
        }
    });
    $(document).on('click', '.tm-quantity [data-quantity="minus"]', function (e) {
        e.preventDefault();
        var fieldName = $(this).closest('.tm-quantity').find('input.tm-qty').attr('name');
        var currentVal = parseInt($('select[name=' + fieldName + ']').val());
        var quantity_min = $('select[name=' + fieldName + ']').attr('min');
        var quantity_max = $('select[name=' + fieldName + ']').attr('max');
        if (typeof quantity_min !== typeof undefined && quantity_min !== false) {
            if(quantity_min>=currentVal){
                $(this).closest('.tm-quantity').find('[data-quantity="minus"]').attr("disabled", true);
                return;
            }
        }
        if (typeof quantity_max !== typeof undefined && quantity_max !== false) {
            if(quantity_max>currentVal){
                $(this).closest('.tm-quantity').find('[data-quantity="plus"]').attr("disabled", false);
            }
        }
        if (!isNaN(currentVal)) {
            // Increment
            $('select[name=' + fieldName + ']').val(currentVal - 1);
            $('select[name=' + fieldName + ']').change();
        }
    });
    if ($('.postid-577863').length){
        $(document).on('change', 'input[name="_sumo_pp_payment_type"]', function (e) {
            $("select.mm-bookings-field-select").change();
        });
    }
    function mm_dob_validateDate(dateValue){
        var selectedDate = dateValue;
        if(selectedDate == '')
            return false;
        var regExp = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/; //Declare Regex
        var dateArray = selectedDate.match(regExp); // is format OK?
        if (dateArray == null){
            return false;
        }
        var month = dateArray[1];
        var day= dateArray[3];
        var year = dateArray[5];        
        if (month < 1 || month > 12){
            return false;
        }else if (day < 1 || day> 31){ 
            return false;
        }else if ((month==4 || month==6 || month==9 || month==11) && day ==31){
            return false;
        }else if (month == 2){
            var isLeapYear = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));
            if (day> 29 || (day ==29 && !isLeapYear)){
                return false;
            }
        }
        var current_date = new Date();
        var DOB = new Date(year+'-'+month+'-'+day);
        var millisBetween = current_date.getTime() - DOB.getTime();
        var days = millisBetween / (1000 * 3600 * 24);
        var years = current_date.getFullYear() - DOB.getFullYear();
        if(years>100 || (years<=0 && days<0)){
            return false;
        }
        return true;
    }

    $('.woocommerce-checkout #billing_country').on('change', function(){
        setTimeout(function() {
            $('input#billing_state.input-text').attr('placeholder', 'Input your county');
            $('#billing_state_field .select2-selection__placeholder').text('Select an option…');
        },300);
    });
    if ($('#top #mm_bookings_total_price').length) {
        $(document).on('wc_booking_form_changed', mm_get_bookings_total_price);
    }
    function mm_get_bookings_total_price(){
        var get_price_cost = parseFloat($('.wc-bookings-booking-cost .custom-prc').text().replace(/,/g, ''));
       /* if($('.mmt-button-waitlist').css('display') == 'none'){
            $('#mm_bookings_total_price').hide();
        }else{
            $('#mm_bookings_total_price').show();
        }*/
        if($('.wc-bookings-booking-cost .custom-prc').length){
            var price_tax = (Math.round((get_price_cost * 0.095) * 100) / 100).toFixed(2);
            var woo_fee = $('#top #mm_bookings_total_price').data('fee');
            var total_guest = 0;
            var fee_total = 0;
            $(".form_field_person select.mm-bookings-field-select:not(#wc_bookings_field_duration,.mm_bookings_field_persons_Room, #wc_bookings_field_persons_22041)").each(function() {
                total_guest = total_guest + parseFloat($(this).val());
            });
            if(woo_fee!=''){
                for (var i=0; i < woo_fee.length; i++){
                    var fee_type = woo_fee[i]['type'];
                    var per_person = woo_fee[i]['per_person'];
                    var fee = woo_fee[i]['fee'];
                    if(fee_type == 'percentage'){
                        fee_total += get_price_cost*(fee/100);
                    }else{
                        if(per_person == 'on'){
                            fee_total += fee * total_guest;
                        }else{
                            fee_total += fee;
                        }
                    }
                }
            }
            var fee_addon = 0;
            if($('.tmcp-fee-field.tcenabled').length){
                $('.tmcp-fee-field.tcenabled').each(function() {
                    var rules = $(this).data('rules');
                    var tax_obj = $(this).data('tax-obj');
                    var tm_quantity = 1;
                    if($(this).closest('.tmcp-field-wrap').find('.tc-cell').hasClass('tm-quantity')){
                        tm_quantity = $(this).closest('.tmcp-field-wrap').find('input.tm-qty').val();
                    }
                    if($(this).prop("checked") == true){
                        if(rules!=''){
                            fee_addon += rules[0] * tm_quantity;
                            if(tax_obj!=''){
                                var tax_rate = tax_obj['tax_rate'];
                                var fee_addon_tax = rules[0] * tm_quantity * (tax_rate/100);
                                fee_addon +=fee_addon_tax;
                            }
                        }
                    }
                });
            }
            var total_price = parseFloat(get_price_cost) + parseFloat(price_tax) + parseFloat(fee_total) + parseFloat(fee_addon);
            $('#top #mm_bookings_total_price p .price').html('$' + Math.round(total_price) + ' USD');
        }
    }
    if($(".mmt-button-waitlist").length && $('#top #mm_bookings_total_price').length){
        var waitlist_form = $(".mmt-button-waitlist");
        if (waitlist_form[0]) {
            var observer = new MutationObserver(function(mutations) {
              mutations.forEach(function(mutation) {
                var attributeValue = $(mutation.target).prop(mutation.attributeName);
                if(attributeValue.display == ''){
                    $('#top #mm_bookings_total_price').hide();
                }else{
                    $('#top #mm_bookings_total_price').show();
                }

              });
            });

            observer.observe(waitlist_form[0], {
              attributes: true,
              attributeFilter: ['style']
            });
        }
    }
});
/*
jQuery(document).ready( function( $ ) {
    var customDatePicker = Marionette.Object.extend( {
    initialize: function() {
    
    this.listenTo( Backbone.Radio.channel( 'flatpickr' ), 'init', this.modifyDatepicker );
    },
    modifyDatepicker: function( dateObject, fieldModel ) {
    var tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate());
    dateObject.set("minDate", tomorrow );
    }
    });
    
    
    new customDatePicker();
} );
 
 */