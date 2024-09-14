
//***---File /js/yousave.js ----*****
/* globals: jQuery, wc_bookings_booking_form, booking_form_params */

// globally accessible for tests
wc_you_save = {};

jQuery(function ($) {
    var wc_you_save_object = {
        init: function () {
            $(document).on('change', '.booking_date_day', this.change_date);
            if ($('.form-field.form_person_0').length) {
                $(document).on('click', '.form_field_person.form_person_0 [data-quantity="plus"]', this.plus_number_person_first);
                $(document).on('click', '.form_field_person.form_person_0 [data-quantity="minus"]', this.minus_number_person_first);
            }
            if ($('.form-field.form_person_1').length) {
                $(document).on('click', '.form_field_person.form_person_1 [data-quantity="plus"]', this.plus_number_person_second);
                $(document).on('click', '.form_field_person.form_person_1 [data-quantity="minus"]', this.minus_number_person_second);
            }
            if ($('.form-field.form_person_2').length) {
                $(document).on('click', '.form_field_person.form_person_2 [data-quantity="plus"]', this.plus_number_person_third);
                $(document).on('click', '.form_field_person.form_person_2 [data-quantity="minus"]', this.minus_number_person_third);
            }
            if ($('.form-field.form_person_3').length) {
                $(document).on('click', '.form_field_person.form_person_3 [data-quantity="plus"]', this.plus_number_person_four);
                $(document).on('click', '.form_field_person.form_person_3 [data-quantity="minus"]', this.minus_number_person_four);
            }

            $(document).on('click', '.list-costs-island li', this.resource_click);
        },
        plus_number_person_first: function () {
            var personFour, personFirst, personThird, personSecond, resource;
            var fieldName = $(this).attr('data-field');
            personFirst = parseInt($('input[name=' + fieldName + ']').attr("data-value")) + 1;
            if ($('.form-field.form_person_1').length) {
                personSecond = parseInt($('.form-field.form_person_1 input[type="number"]').attr("data-value"));
            } else {
                personSecond = 0;
            }
            if ($('.form-field.form_person_2').length) {
                personThird = parseInt($('.form-field.form_person_2 input[type="number"]').attr("data-value"));
            } else {
                personThird = 0;
            }
            if ($('.form-field.form_person_3').length) {
                personFour = parseInt($('.form-field.form_person_3 input[type="number"]').attr("data-value"));
            } else {
                personFour = 0;
            }
            if ($('.wc_bookings_field_resource').length) {
                resource = $("#wc_bookings_field_resource option:selected").val();
            }else{
                resource = 0;
            }
            wc_you_save_object.calc_you_save(personFirst, personSecond, personThird, personFour, resource);
        },
        minus_number_person_first: function () {
            var personFour, personFirst, personThird, personSecond, resource;
            var fieldName = $(this).attr('data-field');
            personFirst = parseInt($('input[name=' + fieldName + ']').attr("data-value")) - 1;
            if ($('.form-field.form_person_1').length) {
                personSecond = parseInt($('.form-field.form_person_1 input[type="number"]').attr("data-value"));
            } else {
                personSecond = 0;
            }
            if ($('.form-field.form_person_2').length) {
                personThird = parseInt($('.form-field.form_person_2 input[type="number"]').attr("data-value"));
            } else {
                personThird = 0;
            }
            if ($('.form-field.form_person_3').length) {
                personFour = parseInt($('.form-field.form_person_3 input[type="number"]').attr("data-value"));
            } else {
                personFour = 0;
            }
            if ($('.wc_bookings_field_resource').length) {
                resource = $("#wc_bookings_field_resource option:selected").val();
            }else{
                resource = 0;
            }
            wc_you_save_object.calc_you_save(personFirst, personSecond, personThird, personFour, resource);
        },
        plus_number_person_second: function () {
            var personFour, personFirst, personThird, personSecond, resource;
            var fieldName = $(this).attr('data-field');
            var personSecond = parseInt($('input[name=' + fieldName + ']').attr("data-value")) + 1;
            if ($('.form-field.form_person_0').length) {
                personFirst = parseInt($('.form-field.form_person_0 input[type="number"]').attr("data-value"));
            } else {
                personFirst = 0;
            }
            if ($('.form-field.form_person_2').length) {
                personThird = parseInt($('.form-field.form_person_2 input[type="number"]').attr("data-value"));
            } else {
                personThird = 0;
            }
            if ($('.form-field.form_person_3').length) {
                personFour = parseInt($('.form-field.form_person_3 input[type="number"]').attr("data-value"));
            } else {
                personFour = 0;
            }
            if ($('.wc_bookings_field_resource').length) {
                resource = $("#wc_bookings_field_resource option:selected").val();
            }else{
                resource = 0;
            }
            wc_you_save_object.calc_you_save(personFirst, personSecond, personThird, personFour, resource);
        },
        minus_number_person_second: function () {
            var personFour, personFirst, personThird, personSecond, resource;
            var fieldName = $(this).attr('data-field');
            personSecond = parseInt($('input[name=' + fieldName + ']').attr("data-value")) - 1;
            if ($('.form-field.form_person_0').length) {
                personFirst = parseInt($('.form-field.form_person_0 input[type="number"]').attr("data-value"));
            } else {
                personFirst = 0;
            }
            if ($('.form-field.form_person_2').length) {
                personThird = parseInt($('.form-field.form_person_2 input[type="number"]').attr("data-value"));
            } else {
                personThird = 0;
            }
            if ($('.form-field.form_person_3').length) {
                personFour = parseInt($('.form-field.form_person_3 input[type="number"]').attr("data-value"));
            } else {
                personFour = 0;
            }
            if ($('.wc_bookings_field_resource').length) {
                resource = $("#wc_bookings_field_resource option:selected").val();
            }else{
                resource = 0;
            }
            wc_you_save_object.calc_you_save(personFirst, personSecond, personThird, personFour, resource);
        },
        plus_number_person_third: function () {
            var personFour, personFirst, personThird, personSecond, resource;
            var fieldName = $(this).attr('data-field');
            personThird = parseInt($('input[name=' + fieldName + ']').attr("data-value")) + 1;
            if ($('.form-field.form_person_1').length) {
                personSecond = parseInt($('.form-field.form_person_1 input[type="number"]').attr("data-value"));
            } else {
                personSecond = 0;
            }
            if ($('.form-field.form_person_0').length) {
                personFirst = parseInt($('.form-field.form_person_0 input[type="number"]').attr("data-value"));
            } else {
                personFirst = 0;
            }
            if ($('.form-field.form_person_3').length) {
                personFour = parseInt($('.form-field.form_person_3 input[type="number"]').attr("data-value"));
            } else {
                personFour = 0;
            }
            if ($('.wc_bookings_field_resource').length) {
                resource = $("#wc_bookings_field_resource option:selected").val();
            }else{
                resource = 0;
            }
            wc_you_save_object.calc_you_save(personFirst, personSecond, personThird, personFour, resource);
        },
        minus_number_person_third: function () {
            var personFour, personFirst, personThird, personSecond, resource;
            var fieldName = $(this).attr('data-field');
            personThird = parseInt($('input[name=' + fieldName + ']').attr("data-value")) - 1;
            if ($('.form-field.form_person_1').length) {
                personSecond = parseInt($('.form-field.form_person_1 input[type="number"]').attr("data-value"));
            } else {
                personSecond = 0;
            }
            if ($('.form-field.form_person_0').length) {
                personFirst = parseInt($('.form-field.form_person_0 input[type="number"]').attr("data-value"));
            } else {
                personFirst = 0;
            }
            if ($('.form-field.form_person_3').length) {
                personFour = parseInt($('.form-field.form_person_3 input[type="number"]').attr("data-value"));
            } else {
                personFour = 0;
            }
            if ($('.wc_bookings_field_resource').length) {
                resource = $("#wc_bookings_field_resource option:selected").val();
            }else{
                resource = 0;
            }
            wc_you_save_object.calc_you_save(personFirst, personSecond, personThird, personFour, resource);
        },
        plus_number_person_four: function () {
            var personFour, personFirst, personThird, personSecond, resource;
            var fieldName = $(this).attr('data-field');
            personFour = parseInt($('input[name=' + fieldName + ']').attr("data-value")) + 1;
            if ($('.form-field.form_person_1').length) {
                personSecond = parseInt($('.form-field.form_person_1 input[type="number"]').attr("data-value"));
            } else {
                personSecond = 0;
            }
            if ($('.form-field.form_person_2').length) {
                personThird = parseInt($('.form-field.form_person_2 input[type="number"]').attr("data-value"));
            } else {
                personThird = 0;
            }
            if ($('.form-field.form_person_0').length) {
                personFirst = parseInt($('.form-field.form_person_0 input[type="number"]').attr("data-value"));
            } else {
                personFirst = 0;
            }
            if ($('.wc_bookings_field_resource').length) {
                resource = $("#wc_bookings_field_resource option:selected").val();
            }else{
                resource = 0;
            }
            wc_you_save_object.calc_you_save(personFirst, personSecond, personThird, personFour, resource);
        },
        minus_number_person_four: function () {
            var personFour, personFirst, personThird, personSecond, resource;
            var fieldName = $(this).attr('data-field');
            personFour = parseInt($('input[name=' + fieldName + ']').attr("data-value")) - 1;
            if ($('.form-field.form_person_1').length) {
                personSecond = parseInt($('.form-field.form_person_1 input[type="number"]').attr("data-value"));
            } else {
                personSecond = 0;
            }
            if ($('.form-field.form_person_2').length) {
                personThird = parseInt($('.form-field.form_person_2 input[type="number"]').attr("data-value"));
            } else {
                personThird = 0;
            }
            if ($('.form-field.form_person_0').length) {
                personFirst = parseInt($('.form-field.form_person_0 input[type="number"]').attr("data-value"));
            } else {
                personFirst = 0;
            }
            if ($('.wc_bookings_field_resource').length) {
                resource = $("#wc_bookings_field_resource option:selected").val();
            }else{
                resource = 0;
            }
            wc_you_save_object.calc_you_save(personFirst, personSecond, personThird, personFour, resource);
        },
        resource_click: function () {
            var personFour, personFirst, personThird, personSecond, resource;
            if ($('.form-field.form_person_3').length) {
                personFour = parseInt($('.form-field.form_person_3 input[type="number"]').attr("data-value"));
            } else {
                personFour = 0;
            }
            if ($('.form-field.form_person_1').length) {
                personSecond = parseInt($('.form-field.form_person_1 input[type="number"]').attr("data-value"));
            } else {
                personSecond = 0;
            }
            if ($('.form-field.form_person_2').length) {
                personThird = parseInt($('.form-field.form_person_2 input[type="number"]').attr("data-value"));
            } else {
                personThird = 0;
            }
            if ($('.form-field.form_person_0').length) {
                personFirst = parseInt($('.form-field.form_person_0 input[type="number"]').attr("data-value"));
            } else {
                personFirst = 0;
            }
            if ($('.wc_bookings_field_resource').length) {
                resource = $(this).attr('data-fields');
            }else{
                resource = 0;
            }
            wc_you_save_object.calc_you_save(personFirst, personSecond, personThird, personFour, resource);

        },
        change_date: function () {

            var personFour, personFirst, personThird, personSecond, resource;
            if ($('.form-field.form_person_3').length) {
                personFour = parseInt($('.form-field.form_person_3 input[type="number"]').attr("data-value"));
            } else {
                personFour = 0;
            }
            if ($('.form-field.form_person_1').length) {
                personSecond = parseInt($('.form-field.form_person_1 input[type="number"]').attr("data-value"));
            } else {
                personSecond = 0;
            }
            if ($('.form-field.form_person_2').length) {
                personThird = parseInt($('.form-field.form_person_2 input[type="number"]').attr("data-value"));
            } else {
                personThird = 0;
            }
            if ($('.form-field.form_person_0').length) {
                personFirst = parseInt($('.form-field.form_person_0 input[type="number"]').attr("data-value"));
            } else {
                personFirst = 0;
            }
            if ($('.wc_bookings_field_resource').length) {
                resource = $("#wc_bookings_field_resource option:selected").val();
            }else{
                resource = 0;
            }
            wc_you_save_object.calc_you_save(personFirst, personSecond, personThird, personFour, resource);
        },
        calc_you_save: function (personFirst, personSecond, personThird, personFour, resource) {
            var date = $('.booking_date_day').val();
            var month = $('.booking_date_month').val();
            var year = $('.booking_date_year').val();
            var id = $('.wc-booking-product-id').val();            
            $.ajax({
                type: "post",
                dataType: "text",
                url: AJAX.url,
                data: {
                    action: "booking_you_save",
                    date: date,
                    month: month,
                    year: year,
                    id: id,
                    person_first: personFirst,
                    person_second: personSecond,
                    person_third: personThird,
                    person_four: personFour,
                    resource: resource
                },
                success: function (response) {
                    $('.mm-you-save .price-you-save').text(response);                   
                    if (response.length !== 0 && response != 0) {
                        //$('.mm-you-save').css('display', 'block');
                    } else {
                        $('.mm-you-save').css('display', 'none');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {

                    console.log('The following error occured: ' + textStatus, errorThrown);
                },
            });
            return false;
        }

    };

    // export globally
    wc_you_save = wc_you_save_object;
    wc_you_save.init();
});

