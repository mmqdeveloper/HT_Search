jQuery(document).ready(function ($) {
    function formatDate(date) {
        const month = (date.getMonth() + 1).toString().padStart(2, '0');
        const day = date.getDate().toString().padStart(2, '0');
        const year = date.getFullYear();
        return `${month}-${day}-${year}`;
    }

    function searchDataByArrivalDate(array, arrival_date) {
        for (var i = 0; i < array.length; i++) {
            if (array[i].arrival_date === arrival_date) {
                return array[i];
            }
        }
        return null;
    }

    function compareDates(formattedDate, dateNow) {
        const formattedDateObj = new Date(Date.parse(formattedDate.replace(/-/g, '/')));
        const dateNowObj = new Date(Date.parse(dateNow.replace(/-/g, '/')));

        return formattedDateObj >= dateNowObj;
    }

    $('#cruise-ship-name').on('change', function () {
        $(this).addClass('select-cs-name');
        let value = $(this).val();
        let slug = '#';
        let availableDates = '';
        if (value != 'all-cruise-ship') {
            availableDates = $('#cruise-ship-name option[value=' + value + ']').attr('data-cs-calendar').split(',');
        }
        $(".cruise-ship-calendar").prop("disabled", false).val("");
        if (availableDates != '') {
            $("#cruise-ship-calendar").datepicker("destroy");

            let dateNow = new Date().toLocaleString('en-US', {
                year: "numeric",
                month: "2-digit",
                day: "2-digit",
                timeZone: 'Pacific/Honolulu'
            });
            var defaultDate;

            availableDates.some(function (date) {
                if (compareDates(date, dateNow)) {
                    defaultDate = date;
                    return true;
                }
            });

            $("#cruise-ship-calendar").datepicker({
                beforeShowDay: function (date) {
                    var formattedDate = $.datepicker.formatDate('mm-dd-yy', date);

                    if ($.inArray(formattedDate, availableDates) !== -1 && compareDates(formattedDate, dateNow)) {

                        return [true, "available", "Available"]; // Available day
                    } else {
                        return [false, "unavailable", "Unavailable"]; // Unavailable day
                    }
                },
                showOtherMonths: true,
                selectOtherMonths: true,
                changeMonth: true,
                changeYear: true,
                yearRange: '2024:2025',
                dayNamesMin: ["S", "M", "T", "W", "T", "F", "S"],
                onSelect: function (date) {
                    $(".cruise-ship-calendar").val(date).change();
                    $(".cs-calender-box").hide();
                }
            });

            if (jQuery(window).width() < 769) {
                // $('.calendar-cruise-ship-mobile').append('<div id="cruise-ship-calendar-mb"></div>');
                $("#calendar-cruise-ship-mobile").datepicker("destroy");
                $("#calendar-cruise-ship-mobile").datepicker({
                    beforeShowDay: function (date) {
                        var formattedDate = $.datepicker.formatDate('mm-dd-yy', date);

                        if ($.inArray(formattedDate, availableDates) !== -1 && compareDates(formattedDate, dateNow)) {

                            return [true, "available", "Available"]; // Available day
                        } else {
                            return [false, "unavailable", "Unavailable"]; // Unavailable day
                        }
                    },
                    showOtherMonths: false,
                    selectOtherMonths: false,
                    changeMonth: true,
                    changeYear: true,
                    yearRange: '2024:2025',
                    dayNamesMin: ["S", "M", "T", "W", "T", "F", "S"],
                    onSelect: function (date) {
                        $(".cruise-ship-calendar").val(date).change();
                        $('.cruise-ship-see-detail')[0].click();
                    }
                });

                $("#calendar-cruise-ship-mobile .ui-datepicker-year").val(parseInt(defaultDate.slice(6))).change();
                $("#calendar-cruise-ship-mobile .ui-datepicker-month").val(parseInt(defaultDate.slice(0, 2)) - 1).change();

                $("#calendar-cruise-ship-mobile").append('<button class="cs-zoomin-calendar" type="button"></button>');
            }

            $("#cruise-ship-calendar .ui-datepicker-year").val(parseInt(defaultDate.slice(6))).change();
            $("#cruise-ship-calendar .ui-datepicker-month").val(parseInt(defaultDate.slice(0, 2)) - 1).change();
        }

        if (value == 'all-cruise-ship') {
            jQuery.ajax({
                type: "post",
                dataType: "html",
                url: ajax_custom_js.ajax_url,
                data: {
                    action: "load_calendar_with_cruise_ship"
                },
                beforeSend: function () {
                    $('.calendar-cruise-ship-section').addClass('loading');
                },
                success: function (response) {
                    $('.calendar-cruise-ship-section').empty().append(response);
                    $('.calendar-cruise-ship-section').removeClass('loading');
                    $('.calendar-cruise-ship .days .day_num .event').parent().addClass('available');
                    if (jQuery(window).width() < 769) {
                        sortListCruiseShipInCalendar();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                }
            });
            calendarOfAllCruiseShip()
        } else {
            jQuery.ajax({
                type: "post",
                dataType: "html",
                url: ajax_custom_js.ajax_url,
                data: {
                    action: "load_calendar_by_cruise_ship",
                    slug: value,
                    date: defaultDate
                },
                beforeSend: function () {
                    $('.calendar-cruise-ship-section').addClass('loading');
                },
                success: function (response) {
                    $('.calendar-cruise-ship-section').empty().append(response);
                    $('.calendar-cruise-ship-section').removeClass('loading');
                    $('.calendar-cruise-ship .days .day_num .event').parent().addClass('available');
                    if (jQuery(window).width() < 769) {
                        sortListCruiseShipInCalendar();
                        $('.calendar-cruise-ship .header').append('<button class="cs-zoomout-calendar" type="button"></button>');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                }
            });

            let domail = window.location.origin;
            slug = domail + '/excursions/' + jQuery('#cruise-ship-name').find(":selected").val();
        }

        $('a.cruise-ship-see-detail').attr('href', slug);
    });

    $(".cruise-ship-calendar").on('change', function () {
        let domail = window.location.origin;
        let date = formatDate(new Date($(this).val()));
        let slug = 'cruise/' + jQuery('#cruise-ship-name').find(":selected").val();
        $('a.cruise-ship-see-detail').attr('href', domail + '/' + slug + '/?date=' + date);
    });
    $('.cruise-ship-calendar').on('click', function () {
        $(".cruise-ship-filter-box .cs-calender-box").show();
    });
    // jQuery(document).click(function(e){
    //     if (jQuery(e.target).closest(".cruise-ship-filter-box .cs-calender-box").length == 0) {
    //         if(jQuery(e.target).closest(".cruise-ship-calendar").length != 0) {
    //
    //         } else {
    //             jQuery('.cruise-ship-filter-box .cs-calender-box').hide();
    //         }
    //     }
    // });
    $('.cs-back-choose-date').on('click', function () {
        $(".cs-calender-box").hide();
    })

    // cruiseShipShowMore();

    function cruiseShipShowMore() {
        let x = 9;
        $('.list-tours .products .product').slice(0, 9).show();
        $('.cs-show-more').on('click', function (e) {
            e.preventDefault();
            x = x + 9;
            $('.list-tours .products .product').slice(0, x).slideDown();
            if (x >= parseInt($(this).attr('data-count'))) {
                $('.cs-show-more').hide();
            }
        });
    }

    function comparatorCsTitle(a, b) {
        if (a.dataset.title < b.dataset.title)
            return -1;
        if (a.dataset.title > b.dataset.title)
            return 1;
        return 0;
    }

    function comparatorCsPriority(a, b) {
        if (a.dataset.priority < b.dataset.priority)
            return -1;
        if (a.dataset.priority > b.dataset.priority)
            return 1;
        return 0;
    }

    function SortTitleCruiseShip() {
        var title =
            document.querySelectorAll("[data-title]");
        var subjectsArray = Array.from(title);
        let sorted = subjectsArray.sort(comparatorCsTitle);
        sorted.forEach(e => document.querySelector(".list-cruise-ship").appendChild(e));
    }

    function SortPriorityCruiseShip() {
        var indexes = document.querySelectorAll("[data-priority]");
        var indexesArray = Array.from(indexes);
        let sorted = indexesArray.sort(comparatorCsPriority);
        sorted.forEach(e => document.querySelector(".list-cruise-ship").appendChild(e));
    }

    $('.list-cruise-ship-sort select').on('change', function () {
        let option = $(this).val();
        if (option == 'atoz') {
            SortTitleCruiseShip();
        }
        if (option == 'priority') {
            SortPriorityCruiseShip();
        }
    });

    $('.list-cruise-ship-sort select').each(function () {
        var $this = $(this), selectOptions = $(this).children('option').length;

        $this.addClass('hide-select');
        $this.wrap('<div class="cs-sort-select"></div>');
        $this.after('<div class="cs-sort-custom-select"></div>');

        var customSelect = $this.next('div.cs-sort-custom-select');
        if ($this.attr('data-sort-default') == 'priority') {
            customSelect.text('Priority');
        }
        if ($this.attr('data-sort-default') == 'atoz') {
            customSelect.text('A to Z');
        }

        var optionlist = $('<ul />', {
            'class': 'cs-sort-select-options'
        }).insertAfter(customSelect);

        for (var i = 0; i < selectOptions; i++) {
            $('<li />', {
                text: $this.children('option').eq(i).text(),
                rel: $this.children('option').eq(i).val()
            }).appendTo(optionlist);
        }

        var optionlistItems = optionlist.children('li');

        customSelect.click(function (e) {
            e.stopPropagation();
            $('div.cs-sort-custom-select.active').not(this).each(function () {
                $(this).removeClass('active').next('ul.cs-sort-select-options').hide();
            });
            $(this).toggleClass('active').next('ul.cs-sort-select-options').slideToggle();
        });

        optionlist.hide();

        optionlistItems.click(function (e) {
            e.stopPropagation();
            customSelect.text($(this).text()).removeClass('active');
            $this.val($(this).attr('rel')).change();
            optionlist.hide();
        });

        $(document).click(function () {
            customSelect.removeClass('active');
            optionlist.hide();
        });

    });

    $('.calendar-cruise-ship-section').on('change', '.calendar-cruise-ship .cs-month, .calendar-cruise-ship .cs-year', function () {
        let month = $('.calendar-cruise-ship-section .calendar-cruise-ship .cs-month').val();
        let year = $('.calendar-cruise-ship-section .calendar-cruise-ship .cs-year').val();
        let cruiseShip = $('#cruise-ship-name').val();
        jQuery.ajax({
            type: "post",
            dataType: "html",
            url: ajax_custom_js.ajax_url,
            data: {
                action: "load_calendar_with_cruise_ship",
                month: month,
                year: year,
                slug: cruiseShip
            },
            beforeSend: function () {
                $('.calendar-cruise-ship-section').addClass('loading');
            },
            success: function (response) {
                $('.calendar-cruise-ship-section').empty().append(response);
                $('.calendar-cruise-ship-section').removeClass('loading');
                $('.calendar-cruise-ship .days .day_num .event').parent().addClass('available');
                if (jQuery(window).width() < 769) {
                    sortListCruiseShipInCalendar();
                    let cruiseSelected = $('#cruise-ship-name').val();
                    if (cruiseSelected != null && cruiseSelected != 'all-cruise-ship' ) {
                        $('.calendar-cruise-ship .header').append('<button class="cs-zoomout-calendar" type="button"></button>');
                    }
                    $("#calendar-cruise-ship-mobile .ui-datepicker-year").val(parseInt(year)).change();
                    $("#calendar-cruise-ship-mobile .ui-datepicker-month").val(parseInt(month) - 1).change();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });
    });

    $('.calendar-cruise-ship-section').on('click', '.cs-prev-month', function () {
        let prev = $(this).attr('data-month');
        if (prev == 0) {
            let year = $('.calendar-cruise-ship-section .calendar-cruise-ship .cs-year').val();
            $('.calendar-cruise-ship-section .calendar-cruise-ship .cs-month').val(12);
            $('.calendar-cruise-ship-section .calendar-cruise-ship .cs-year').val(parseInt(year)-1).change();
        } else {
            $('.calendar-cruise-ship-section .calendar-cruise-ship .cs-month').val(parseInt(prev)).change();
        }
    });

    $('.calendar-cruise-ship-section').on('click', '.cs-next-month', function () {
        let next = $(this).attr('data-month');
        if (next == 13) {
            let year = $('.calendar-cruise-ship-section .calendar-cruise-ship .cs-year').val();
            $('.calendar-cruise-ship-section .calendar-cruise-ship .cs-month').val(1);
            $('.calendar-cruise-ship-section .calendar-cruise-ship .cs-year').val(parseInt(year)+1).change();
        } else {
            $('.calendar-cruise-ship-section .calendar-cruise-ship .cs-month').val(parseInt(next)).change();
        }
    });

    $('#cruise-ship-name').select2({
        dropdownParent: $(this).find('.cruise-ship-name-box')
    });

    $('.calendar-cruise-ship .days .day_num .event').parent().addClass('available');

    $('.calendar-cruise-ship-section').on('click', '.cs-zoomout-calendar', function () {
        $('.calendar-cruise-ship-section .calendar-cruise-ship').hide();
        $('#calendar-cruise-ship-mobile').fadeIn(500);
    });

    $('#calendar-cruise-ship-mobile').on('click', '.cs-zoomin-calendar', function () {
        $('#calendar-cruise-ship-mobile').hide();
        $('.calendar-cruise-ship-section .calendar-cruise-ship').fadeIn(500);
    });

    function sortListCruiseShipInCalendar() {
        var availableDivs = document.querySelectorAll('.calendar-cruise-ship .days .day_num.available');

        availableDivs.forEach(function (availableDiv) {
            var eventElements = availableDiv.querySelectorAll('.event');

            if (eventElements.length > 0) {
                var eventsDiv = document.createElement('div');
                eventsDiv.className = 'events';

                eventElements.forEach(function (eventElement) {
                    var clonedEvent = eventElement.cloneNode(true); // Clone each .event element
                    eventsDiv.appendChild(clonedEvent); // Append the cloned .event element to the .events div
                });

                // Insert the new .events div after the existing day information
                // availableDiv.insertBefore(eventsDiv, availableDiv.childNodes[1]);
                availableDiv.insertBefore(eventsDiv, availableDiv.childNodes[1]);
            }
        });
        $('.calendar-cruise-ship .days .day_num.available>.event').remove();
        $('.calendar-cruise-ship .days>div:not(.available)').remove();
    }

    if (jQuery(window).width() < 769) {
        sortListCruiseShipInCalendar();
        calendarOfAllCruiseShip();
    }

    function calendarOfAllCruiseShip() {
        let dateNow = new Date().toLocaleString('en-US', {
            year: "numeric",
            month: "2-digit",
            day: "2-digit",
            timeZone: 'Pacific/Honolulu'
        });
        if($('.cruise-ship-filter-box').length) {
            var csCalendarAvaiable = $('.cruise-ship-filter-box .cruise-ship-calendar-box').attr('data-datecruiseship').split(',');
            $("#cruise-ship-calendar").datepicker("destroy");
            $("#cruise-ship-calendar").datepicker({
                beforeShowDay: function (date) {
                    var formattedDate = $.datepicker.formatDate('mm-dd-yy', date);

                    if ($.inArray(formattedDate, csCalendarAvaiable) !== -1 && compareDates(formattedDate, dateNow)) {

                        return [true, "available", "Available"]; // Available day
                    } else {
                        return [false, "unavailable", "Unavailable"]; // Unavailable day
                    }
                },
                showOtherMonths: true,
                selectOtherMonths: true,
                changeMonth: true,
                changeYear: true,
                yearRange: '2024:2025',
                dayNamesMin: ["S", "M", "T", "W", "T", "F", "S"],
                onSelect: function (date) {
                    $(".cruise-ship-calendar").val(date).change();
                    $(".cs-calender-box").hide();
                    jQuery.ajax({
                        type: "post",
                        dataType: "html",
                        url: ajax_custom_js.ajax_url,
                        data: {
                            action: "load_cruise_ship_by_date",
                            date: date
                        },
                        beforeSend: function () {
                            $('.calendar-cruise-ship-section').addClass('loading');
                        },
                        success: function (response) {
                            $('.calendar-cruise-ship-section').empty().append(response);
                            $('.calendar-cruise-ship-section').removeClass('loading');
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                        }
                    });
                }
            });
        }
    }

    $('.cruise-ship-operator .operator-items .operator-item').each(function() {
        var $operatorList = $(this).find('.operator-list-cs');
        if ($operatorList.find('a').length > 2) {
            $operatorList.append('<div><button class="showMore"></button></div>');
            $operatorList.find('a').slice(0,2).addClass('shown');
            $operatorList.find('a').not('.shown').hide();

            $operatorList.find('.showMore').on('click',function(){
                $operatorList.find('a').not('.shown').toggle(300);
                $(this).toggleClass('showLess');
            });
        }
    });

    if (jQuery(window).width() < 576) {
        cruiseShipoperatorShowMore();
    }
    function cruiseShipoperatorShowMore() {
        let x = 8;
        let length = $('.cruise-ship-operator .operator-items .operator-item').length;
        $('.cruise-ship-operator .operator-items .operator-item').slice(8).hide();
        if(length > x) {
            $('.cruise-ship-operator').append('<button class="cs-operator-show-more">Show More</button>');
        }
        $('.cs-operator-show-more').on('click', function (e) {

            e.preventDefault();
            x = x + 8;
            $('.cruise-ship-operator .operator-items .operator-item').slice(0, x).slideDown();
            if (x >= length) {
                $('.cs-operator-show-more').hide();
            }
        });
    }
});

jQuery(window).on('load', function () {

    function csConvert(number) {
        var paddedNumber = (number < 10 ? '0' : '') + number;
        return paddedNumber;
    }

    jQuery('.cruise-ship-info input').prop('disabled', true);

    let csYear = jQuery('.single-product .ui-datepicker-current-day').attr('data-year');
    let csMonth = parseInt(jQuery('.single-product .ui-datepicker-current-day').attr('data-month')) + 1;
    let csDay = jQuery('.single-product .ui-datepicker-current-day a').attr('data-date');

    let dateBooking = csConvert(csMonth) + '-' + csConvert(csDay) + '-' + csYear;

    let searchParams = new URLSearchParams(window.location.search);
    var slugCruiseShip = searchParams.get('cruise-ship');
    var currentCruiseDate = searchParams.get('cruise-date');
    if (slugCruiseShip !== null && currentCruiseDate !== null) {
        var currentCruiseTime = searchParams.get('cruise-time');
        var cruiseDestination = searchParams.get('cruise-destination');

        // Add cruise ship info to booking box
        let cruiseShipName = slugCruiseShip.split('-').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');

        let htmlCruiseshipInfo = '<div class="cruise-info">Your Cruise Ship Info<p><span>' + cruiseDestination + '</span><span>' + slugCruiseShip.split('-')
            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
            .join(' ') + '</span><span>' + currentCruiseDate.replaceAll('-', '/') + '</span><span>' + currentCruiseTime + '</span></p></div>';

        jQuery('#mm-book-tour .av-woo-purchase-button').after(htmlCruiseshipInfo);

        jQuery('.tm-extra-product-options-fields .cruise-ship-info .cs-field-destination').val(cruiseDestination);
        jQuery('.tm-extra-product-options-fields .cruise-ship-info .cs-field-name').val(cruiseShipName);
        jQuery('.tm-extra-product-options-fields .cruise-ship-info .cs-field-date').val(currentCruiseDate.replaceAll('-', '/'));
        jQuery('.tm-extra-product-options-fields .cruise-ship-info .cs-field-time').val(currentCruiseTime);
        jQuery('.cruise-ship-info input').prop('disabled', false);

        if (dateBooking == currentCruiseDate) {
            jQuery(".list-costs-island li").click(function () {
                setTimeout(function () {
                    jQuery('.single-product .booking_date_day').val(csConvert(csDay));
                    jQuery('.single-product .booking_date_month').val(csConvert(csMonth));
                    jQuery('.single-product .booking_date_year').val(csYear);
                    jQuery('.single-product .booking_date_day').change();
                    jQuery('.single-product .ui-datepicker-current-day').trigger('click');
                }, 500);
            });
            setTimeout(function () {
                jQuery('.single-product .ui-datepicker-current-day').trigger('click');
            }, 300);
        }else {
            jQuery('.single-product .wc-bookings-booking-form-button.single_add_to_cart_button').hide();
            jQuery('.single-product .mmt-button-waitlist').show();
            jQuery('.single-product .wc-bookings-booking-cost').before(`<div style="display: flex;text-align: left;align-items: center;" class="mm-notice-booking-box">
            <img src="https://www.hawaiitours.com/wp-content/uploads/2023/11/alert-circle-2.svg" alt="notice-icon">
            <p>This tour is currently unavailable on `+currentCruiseDate.replaceAll('-', '/')+`</p>
            </div>`);
        }

        if(jQuery('.single-product #wc-bookings-booking-form').attr('data-cruise-tag') == 'rth-cruise-note') {
            jQuery('.single-product .wc-bookings-booking-cost').before(`<div style="display: flex;text-align: left;align-items: center;" class="mm-notice-booking-box">
            <img src="https://www.hawaiitours.com/wp-content/uploads/2023/11/alert-circle-2.svg" alt="notice-icon">
                <p>Book this Road to Hana shared tour only on your first day in port to ensure timely returns.</p>
            </div>`);
        }

        jQuery('.single-product .ht-choose-date').addClass('cruise-disable-calendar');
        jQuery('.single-product .bookings-date-1').addClass('cruise-disable-calendar');

        jQuery('.ht-choose-date, .bookings-date-1').on('click', function(e) {
            e.preventDefault();
            if(jQuery(this).hasClass('cruise-disable-calendar')) {
                jQuery(".mm-calendar-absolute").toggleClass("active");
            }
        });

        jQuery('.mm-hotel-to-pickup-div').addClass('cs-show-overlay');
        jQuery('.mm-hotel-to-pickup.set_price_per_person-div').addClass('cs-show-overlay');
        jQuery('.mm-hotel-cruise-ship-div').addClass('cs-show-overlay');

        if(cruiseDestination.indexOf('Kahului') !== -1){
            jQuery('.mm-hotel-to-pickup-div').each(function (index) {
                var optionExists1 = jQuery('select option[data-text="Cruise Ship Pier - Kahului, Maui"]', this).length;
                var optionExists2 = jQuery('select option[data-text="Cruise Ship Kahului"]', this).length;
                var optionExists3 = jQuery('select option[data-text="CRUISE SHIP - Kahului"]', this).length;
                if(optionExists1 > 0) {
                    jQuery('select', this).prop('disabled', false);
                    jQuery('select option[data-text="Cruise Ship Pier - Kahului, Maui"]', this).prop('selected', true);
                }else if(optionExists2 > 0) {
                    jQuery('select option[data-text="Cruise Ship Kahului"]', this).prop('selected', true);
                }else if(optionExists3 > 0) {
                    jQuery('select option[data-text="CRUISE SHIP - Kahului"]', this).prop('selected', true);
                } else {
                    let i = indexHotelByCruiseShip(index);
                    jQuery('select option:eq('+i+')', this).prop('selected', true);
                }
            });
            jQuery('.mm-hotel-cruise-ship').val('Cruise Ship Pier - Kahului, Maui');
            changeHotelToPickup();
        }else if (cruiseDestination.indexOf('Lahaina') !== -1) {
            jQuery('.mm-hotel-to-pickup-div').each(function (index) {
                var optionExists1 = jQuery('select option[data-text="Cruise Ship Tender - Lahaina, Maui"]', this).length;
                var optionExists2 = jQuery('select option[data-text="Cruise Ship Lahaina"]', this).length;
                var optionExists3 = jQuery('select option[data-text="CRUISE SHIP - Lahaina"]', this).length;
                if(optionExists1 > 0) {
                    jQuery('select option[data-text="Cruise Ship Tender - Lahaina, Maui"]', this).prop('selected', true);
                }else if(optionExists2 > 0) {
                    jQuery('select option[data-text="Cruise Ship Lahaina"]', this).prop('selected', true);
                }else if(optionExists3 > 0) {
                    jQuery('select option[data-text="CRUISE SHIP - Lahaina"]', this).prop('selected', true);
                }else {
                    let i = indexHotelByCruiseShip(index);
                    jQuery('select option:eq('+i+')', this).prop('selected', true);
                }
            });
            jQuery('.mm-hotel-cruise-ship').val('Cruise Ship Tender - Lahaina, Maui');
            changeHotelToPickup();
        }else if (cruiseDestination.indexOf('Oahu') !== -1) {
            jQuery('.mm-hotel-to-pickup-div').each(function (index) {
                var optionExists = jQuery('select option[data-text="Cruise Ship Pier - Honolulu, Oahu"]', this).length;
                var optionExists2 = jQuery('select option[data-text="Cruise Ship Pier - Honolulu ($25/person)"]', this).length;
                if(optionExists > 0) {
                    jQuery('select option[data-text="Cruise Ship Pier - Honolulu, Oahu"]', this).prop('selected', true);
                }else if(optionExists2 > 0) {
                    jQuery('select option[data-text="Cruise Ship Pier - Honolulu ($25/person)"]', this).prop('selected', true);
                }else {
                    let i = indexHotelByCruiseShip(index);
                    jQuery('select option:eq('+i+')', this).prop('selected', true);
                }
            });
            if(jQuery('.mm-hotel-to-pickup.set_price_per_person-div').length > 0) {
                jQuery('.mm-hotel-to-pickup.set_price_per_person-div').each(function (index) {
                    var optionExists = jQuery('select option[data-text="Cruise Ship Pier - Honolulu, Oahu"]', this).length;
                    var optionExists2 = jQuery('select option[data-text="Cruise Ship Pier - Honolulu ($25/person)"]', this).length;
                    if(optionExists > 0) {
                        jQuery('select option[data-text="Cruise Ship Pier - Honolulu, Oahu"]', this).prop('selected', true);
                    }else if(optionExists2 > 0) {
                        jQuery('select option[data-text="Cruise Ship Pier - Honolulu ($25/person)"]', this).prop('selected', true);
                    }else {
                        let i = indexHotelByCruiseShip(index);
                        jQuery('select option:eq('+i+')', this).prop('selected', true);
                    }
                });
            }
            jQuery('.mm-hotel-cruise-ship').val('Cruise Ship Pier - Honolulu, Oahu');
            changeHotelToPickup();
        }else if (cruiseDestination.indexOf('Kona') !== -1) {
            jQuery('.mm-hotel-to-pickup-div').each(function (index) {
                var optionExists = jQuery('select option[data-text="Cruise Ship Tender - Kailua-Kona, Hawaii"]', this).length;
                if(optionExists) {
                    jQuery('select option[data-text="Cruise Ship Tender - Kailua-Kona, Hawaii"]', this).prop('selected', true);
                }else {
                    let i = indexHotelByCruiseShip(index);
                    jQuery('select option:eq('+i+')', this).prop('selected', true);
                }
            });
            jQuery('.mm-hotel-cruise-ship').val('Cruise Ship Tender - Kailua-Kona, Hawaii');
            changeHotelToPickup();
        }else if (cruiseDestination.indexOf('Hilo') !== -1) {
            jQuery('.mm-hotel-to-pickup-div').each(function (index) {
                var optionExists = jQuery('select option[data-text="Cruise Ship Pier - Hilo, Hawaii"]', this).length;
                if(optionExists) {
                    jQuery('select option[data-text="Cruise Ship Pier - Hilo, Hawaii"]', this).prop('selected', true);
                }else {
                    let i = indexHotelByCruiseShip(index);
                    jQuery('select option:eq('+i+')', this).prop('selected', true);
                }
            });
            jQuery('.mm-hotel-cruise-ship').val('Cruise Ship Pier - Hilo, Hawaii');
            changeHotelToPickup();
        }else if (cruiseDestination.indexOf('Kauai') !== -1) {
            jQuery('.mm-hotel-to-pickup-div').each(function (index) {
                var optionExists = jQuery('select option[data-text="Cruise Ship Pier - Nawiliwili, Kauai"]', this).length;
                if(optionExists) {
                    jQuery('select option[data-text="Cruise Ship Pier - Nawiliwili, Kauai"]', this).prop('selected', true);
                }else {
                    let i = indexHotelByCruiseShip(index);
                    jQuery('select option:eq('+i+')', this).prop('selected', true);
                }
            });
            jQuery('.mm-hotel-cruise-ship').val('Cruise Ship Pier - Nawiliwili, Kauai');
            changeHotelToPickup();
        }
    }else {
        jQuery('.cruise-ship-info input').val('').prop('disabled', false);
    }

    if (jQuery(window).width() < 576) {
        let w = jQuery('.list-cruise-ship .cruise-ship-item').width();
        jQuery('.list-cruise-ship .cruise-ship-item').css('height', w + 'px');
        jQuery('.list-cruise-ship .cruise-ship-item img').css('height', w + 'px');
    }

    jQuery('.single-cruise .scroll-down-link').attr('href', '#cruise-calendar');
});

function changeHotelToPickup() {
    jQuery('.mm-hotel-to-pickup-div select').change();
    jQuery('.mm-hotel-to-pickup.set_price_per_person-div select').change();
}

function indexHotelByCruiseShip(i) {
    var index = jQuery(".mm-hotel-to-pickup:eq("+i+") option").filter(function() {
        var dataText = jQuery(this).attr('data-text');
        if (dataText) {
            let newText = dataText.toLowerCase();
            if(newText.indexOf('ruise ship') !== -1) {
                return dataText;
            }
        }
        return false;
    }).index();
    if (index < 0) {
        index = jQuery(".mm-hotel-to-pickup:eq("+i+") option").filter(function() {
            dataText = jQuery(this).attr('data-text');
            if (dataText) {
                let newText = dataText.toLowerCase();
                if(newText.indexOf('not list') !== -1) {
                    return dataText;
                }
            }
            console.log('not list');
            return false;
        }).index();
    }
    if (index < 0) {

        index = jQuery(".mm-hotel-to-pickup:eq("+i+") option").filter(function() {
            dataText = jQuery(this).attr('data-text');
            if (dataText) {
                let newText = dataText.toLowerCase();
                if(newText.indexOf('other') !== -1) {
                    return dataText;
                }
            }
            console.log('other');
            return false;
        }).index();
    }

    if (index == -1) {
        jQuery('.mm-hotel-to-pickup-div').removeClass('cs-show-overlay');
        jQuery('.mm-hotel-cruise-ship').removeClass('cs-show-overlay');
    }

    return index;
}