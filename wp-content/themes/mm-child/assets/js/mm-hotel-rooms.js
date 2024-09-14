jQuery(document).ready(function () {
    if (jQuery("#wc-bookings-booking-form .wc_booking_field_choose-hotel-room").length) {
        jQuery("#wc-bookings-booking-form .form_field_person .content-person input[type='number']").css('pointer-events', 'none');

        jQuery(".list-costs-island li").removeClass("selected");
        //jQuery(".list-costs-island li").css("pointer-events", "none");
        jQuery(".list-costs-island li:nth-child(1)").addClass("selected");
        //jQuery(".list-costs-island li:nth-child(1)").css("pointer-events", "auto"); 

        var intPerson_0 = parseInt(jQuery("#wc-bookings-booking-form .form_field_person.form_person_0 .content-person input[type='number']").attr('value')),
            intPerson_1 = parseInt(jQuery("#wc-bookings-booking-form .form_field_person.form_person_1 .content-person input[type='number']").attr('value')),
            intPerson = parseInt(intPerson_0 + intPerson_1),
            minPerson_0 = parseInt(jQuery("#wc-bookings-booking-form .form_field_person.form_person_0 .content-person input[type='number']").attr("min")),
            minPerson_1 = parseInt(jQuery("#wc-bookings-booking-form .form_field_person.form_person_1 .content-person input[type='number']").attr("min")),
            maxPerson_0 = parseInt(jQuery("#wc-bookings-booking-form .form_field_person.form_person_0 .content-person input[type='number']").attr("max")),
            maxPerson_1 = parseInt(jQuery("#wc-bookings-booking-form .form_field_person.form_person_1 .content-person input[type='number']").attr("max"));

        var checkPerson = function (intPerson) {
            if (intPerson == 1) {
                jQuery(".list-costs-island li:nth-child(4)").css("pointer-events", "none");
                jQuery(".list-costs-island li:nth-child(3)").css("pointer-events", "none");
                jQuery(".list-costs-island li:nth-child(2)").css("pointer-events", "none");
                jQuery(".list-costs-island li:nth-child(1)").css("pointer-events", "auto");
            }
            if (intPerson == 2) {
                jQuery(".list-costs-island li:nth-child(4)").css("pointer-events", "none");
                jQuery(".list-costs-island li:nth-child(3)").css("pointer-events", "none");
                jQuery(".list-costs-island li:nth-child(2)").css("pointer-events", "auto");
                jQuery(".list-costs-island li:nth-child(1)").css("pointer-events", "auto");
            }
            if (intPerson == 3) {
                jQuery(".list-costs-island li:nth-child(4)").css("pointer-events", "none");
                jQuery(".list-costs-island li:nth-child(3)").css("pointer-events", "auto");
                jQuery(".list-costs-island li:nth-child(2)").css("pointer-events", "auto");
                jQuery(".list-costs-island li:nth-child(1)").css("pointer-events", "auto");
            }
            if (intPerson >= 4) {
                jQuery(".list-costs-island li:nth-child(4)").css("pointer-events", "auto");
                jQuery(".list-costs-island li:nth-child(3)").css("pointer-events", "auto");
                jQuery(".list-costs-island li:nth-child(2)").css("pointer-events", "auto");
                jQuery(".list-costs-island li:nth-child(1)").css("pointer-events", "auto");
            }
        };

        var checkSelectedOption = function (intPerson) {
            if (intPerson == 1) {
                jQuery(".list-costs-island li:nth-child(4)").removeClass("selected");
                jQuery(".list-costs-island li:nth-child(3)").removeClass("selected");
                jQuery(".list-costs-island li:nth-child(2)").removeClass("selected");
                jQuery(".list-costs-island li:nth-child(1)").addClass("selected");
            }
            if (intPerson == 2) {
                jQuery(".list-costs-island li:nth-child(4)").removeClass("selected");
                jQuery(".list-costs-island li:nth-child(3)").removeClass("selected");
                if (!jQuery(".list-costs-island li:nth-child(2)").hasClass("selected")) {
                    jQuery(".list-costs-island li:nth-child(1)").addClass("selected");
                }
            }
            if (intPerson == 3) {
                jQuery(".list-costs-island li:nth-child(4)").removeClass("selected");
                if (!jQuery(".list-costs-island li:nth-child(3)").hasClass("selected")) {
                    if (!jQuery(".list-costs-island li:nth-child(2)").hasClass("selected")) {
                        jQuery(".list-costs-island li:nth-child(1)").addClass("selected");
                    }
                }
            }
        };

        var buttonMinusPerson_0 = function (intPerson_0) {
            if (intPerson_0 == minPerson_0) {
                jQuery("#wc-bookings-booking-form .form_field_person.form_person_0 .content-person button[data-quantity='minus']").css('pointer-events','none');
            } else {
                jQuery("#wc-bookings-booking-form .form_field_person.form_person_0 .content-person button[data-quantity='minus']").css('pointer-events','auto');
            }
        };

        var buttonMinusPerson_1 = function (intPerson_1) {
            if (intPerson_1 == minPerson_1) {
                jQuery("#wc-bookings-booking-form .form_field_person.form_person_1 .content-person button[data-quantity='minus']").css('pointer-events','none');
            } else {
                jQuery("#wc-bookings-booking-form .form_field_person.form_person_1 .content-person button[data-quantity='minus']").css('pointer-events','auto');
            }
        };

        var buttonPlusPerson_0 = function (intPerson_0) {
            if (intPerson_0 == maxPerson_0) {
                jQuery("#wc-bookings-booking-form .form_field_person.form_person_0 .content-person button[data-quantity='plus']").css('pointer-events','none');
            } else {
                jQuery("#wc-bookings-booking-form .form_field_person.form_person_0 .content-person button[data-quantity='plus']").css('pointer-events','auto');
            }
        };

        var buttonPlusPerson_1 = function (intPerson_1) {
            if (intPerson_1 == maxPerson_0) {
                jQuery("#wc-bookings-booking-form .form_field_person.form_person_1 .content-person button[data-quantity='plus']").css('pointer-events','none');
            } else {
                jQuery("#wc-bookings-booking-form .form_field_person.form_person_1 .content-person button[data-quantity='plus']").css('pointer-events','auto');
            }
        };

        if (intPerson_0 == minPerson_0) {
            jQuery("#wc-bookings-booking-form .form_field_person.form_person_0 .content-person button[data-quantity='minus']").css('pointer-events','none');
        }
        if (intPerson_1 == minPerson_1) {
            jQuery("#wc-bookings-booking-form .form_field_person.form_person_1 .content-person button[data-quantity='minus']").css('pointer-events','none');
        }

        jQuery("#wc-bookings-booking-form .form_field_person.form_person_0 .content-person button[data-quantity='minus']").click(function () {
            if (intPerson_0 > minPerson_0) {
                intPerson_0--;
            }

            intPerson = parseInt(intPerson_0 + intPerson_1);
            buttonMinusPerson_0(intPerson_0);
            buttonPlusPerson_0(intPerson_0);
            //checkPerson(intPerson);
            checkSelectedOption(intPerson);
        });

        jQuery("#wc-bookings-booking-form .form_field_person.form_person_0 .content-person button[data-quantity='plus']").click(function () {
            if (intPerson_0 < maxPerson_0) {
                intPerson_0++;
            }

            intPerson = parseInt(intPerson_0 + intPerson_1);
            buttonMinusPerson_0(intPerson_0);
            buttonPlusPerson_0(intPerson_0);
            //checkPerson(intPerson);
        });

        jQuery("#wc-bookings-booking-form .form_field_person.form_person_1 .content-person button[data-quantity='minus']").click(function () {
            if (intPerson_1 > minPerson_1) {
                intPerson_1--;
            }

            intPerson = parseInt(intPerson_0 + intPerson_1);
            buttonMinusPerson_1(intPerson_1);
            buttonPlusPerson_1(intPerson_1);
            //checkPerson(intPerson);
            checkSelectedOption(intPerson);
        });

        jQuery("#wc-bookings-booking-form .form_field_person.form_person_1 .content-person button[data-quantity='plus']").click(function () {
            if (intPerson_1 < maxPerson_1) {
                intPerson_1++;
            }

            intPerson = parseInt(intPerson_0 + intPerson_1);
            buttonMinusPerson_1(intPerson_1);
            buttonPlusPerson_1(intPerson_1);
            //checkPerson(intPerson);
        });

        jQuery(".list-costs-island li").click(function () {
            setTimeout(function () {
                jQuery("#wc-bookings-booking-form .wc-bookings-date-picker-choose-date").click();
            }, 200);
        });
    }
});