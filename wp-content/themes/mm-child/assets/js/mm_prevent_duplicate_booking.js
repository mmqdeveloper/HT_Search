function mm_get_cookie_bookings_info(cookieName) {
    let name = cookieName + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let cookieArray = decodedCookie.split(';');

    for (let i = 0; i < cookieArray.length; i++) {
        let cookie = cookieArray[i];
        while (cookie.charAt(0) === ' ') {
            cookie = cookie.substring(1);
        }
        if (cookie.indexOf(name) === 0) {
            return cookie.substring(name.length, cookie.length);
        }
    }
    return null;
}

jQuery(document).ready(function($) {
    if ($('body').hasClass('single-product')) {
        const userRoles = JSON.parse(prevent_duplicate_booking.user_role);
        let lockable = true;
        if (userRoles.includes("shop_manager") || userRoles.includes("administrator")) {
            lockable = false;
        }
        if (lockable == true && $('[name="tcaddtocart"]').val() && $('[name="tcaddtocart"]').val() == 6285) {
            const cookie_booking = mm_get_cookie_bookings_info(`mm_info_booking_${$('[name="tcaddtocart"]').val()}`);
            if (cookie_booking) {
                if ($('#wc-bookings-booking-form')) {
                    $('#wc-bookings-booking-form').append(`<div class="mm-message-has-booking-product">
                        <p>Online booking for this experience is unavailable.<br/>Please <a href="/contact-us">call us</a> to add guests.</p>
                    </div>`);
                }
            }
        }
    }
});