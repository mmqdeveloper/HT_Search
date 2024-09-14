(function ($) {

    $.fn.stickySidebar = function (options) {

        var config = $.extend({
            headerSelector: '#header_checkout',
            navSelector: 'nav',
            contentSelector: '#page_checkout_content',
            footerSelector: '#footer',
            sidebarTopMargin: 20, 
            footerThreshold: 40,
            rightWidth:0
        }, options);

        var fixSidebr = function () {

            var sidebarSelector = $(this);
            var viewportHeight = $(window).height();
            var viewportWidth = $(window).width();
            var documentHeight = $(document).height();
            var headerHeight = $(config.headerSelector).outerHeight();
            var navHeight = 0;//$(config.navSelector).outerHeight(); 
            var sidebarHeight = sidebarSelector.outerHeight(); 
            var contentHeight = $(config.contentSelector).outerHeight();
            var footerHeight = $(config.footerSelector).outerHeight() + 75 + $("#molokini-snorkeling-ttmn").outerHeight();
            var scroll_top = $(window).scrollTop();
            var fixPosition = contentHeight - sidebarHeight; 
            var breakingPoint1 = headerHeight + navHeight;
            var breakingPoint2 = documentHeight - (sidebarHeight + footerHeight + config.footerThreshold+ 50+85);
            var checkoutRightW = config.rightWidth;

            // calculate
            if(viewportWidth>750){
                if ((contentHeight > sidebarHeight) && (viewportHeight > sidebarHeight)) {

                    if (scroll_top < breakingPoint1) {

                        sidebarSelector.removeClass('sticky_scroll_mm');
                        sidebarSelector.css("position","relative");
                        sidebarSelector.css("top","0px");

                    } else if ((scroll_top >= breakingPoint1) && (scroll_top < breakingPoint2)) {

                        sidebarSelector.addClass('sticky_scroll_mm').css('top', config.sidebarTopMargin);
                        sidebarSelector.css("position","fixed"); 
                        sidebarSelector.css("width",checkoutRightW); 


                    } else {

                        var negative = breakingPoint2 - scroll_top;
                        sidebarSelector.addClass('sticky_scroll_mm').css('top',"968px");
                        sidebarSelector.css("position","absolute"); 
                        sidebarSelector.css("width",checkoutRightW); 

                    }

                }
            } else{ 
                sidebarSelector.removeClass('sticky_scroll_mm');
                sidebarSelector.css("position","relative");
                sidebarSelector.css("top","0px");
            }

        };
        var fixSidebrFixedWidth = function () {
             var sidebarSelector = $(this);
             sidebarSelector.css("width","auto");
        };
        return this.each(function () {
            $(window).on('scroll', $.proxy(fixSidebr, this));
            $(window).on('resize', $.proxy(fixSidebrFixedWidth, this))
            $.proxy(fixSidebr, this)();
        });

    };

}(jQuery));

(function ($) {

    $.fn.stickyMolokini = function (options) {

        var config = $.extend({
            headerSelector: '#header_single_tours_forbidden',
            navSelector: 'nav',
            contentSelector: '#page_checkout_content',
            footerSelector: '#footer',
            sidebarTopMargin: 20, 
            footerThreshold: 40,
            rightWidth:0
        }, options);

        var fixSidebr = function () {

            var sidebarSelector = $(this);
            var viewportHeight = $(window).height();
            var viewportWidth = $(window).width();
            var documentHeight = $(document).height();
            var headerHeight = $(config.headerSelector).outerHeight();
            var navHeight = 0;//$(config.navSelector).outerHeight(); 
            var sidebarHeight = sidebarSelector.outerHeight(); 
            var contentHeight = $("#content_top_single_tours").outerHeight();
                contentHeight  = contentHeight + $("#molokini-snorkeling-ttmn").outerHeight();
                contentHeight  = contentHeight + $("#content_center_single_tours").outerHeight();
                contentHeight  = contentHeight + $("#slide_image_hover").outerHeight();
                contentHeight  = contentHeight + $("#text-tours-molokini1").outerHeight();
                contentHeight  = contentHeight + $("image_section_molokini").outerHeight();
                contentHeight  = contentHeight + $("content_bottom_single_tours").outerHeight();
                               ;
            var footerHeight = $(config.footerSelector).outerHeight() + 75 + $("#full_slider_1").outerHeight();
            var scroll_top = $(window).scrollTop();
            var fixPosition = contentHeight - sidebarHeight; 
            var breakingPoint1 = headerHeight + navHeight;
            var breakingPoint2 = documentHeight - (sidebarHeight + footerHeight + config.footerThreshold+62);
            var checkoutRightW = config.rightWidth;

            // calculate
            if(viewportWidth>750){
                if (contentHeight > sidebarHeight) { 

                    if (scroll_top < breakingPoint1) {

                        sidebarSelector.removeClass('sticky_scroll_mm');
                        sidebarSelector.css("position","relative");
                        sidebarSelector.css("top","0px");

                    } else if ((scroll_top >= breakingPoint1) && (scroll_top < breakingPoint2)) {

                        sidebarSelector.addClass('sticky_scroll_mm').css('top', config.sidebarTopMargin);
                        sidebarSelector.css("position","fixed"); 
                        sidebarSelector.css("width",checkoutRightW); 


                    } else {

                        var negative = breakingPoint2 - scroll_top;
                        sidebarSelector.addClass('sticky_scroll_mm').css('top',"3995px");
                        sidebarSelector.css("position","absolute"); 
                        sidebarSelector.css("width",checkoutRightW); 

                    }

                }
                else {
                     sidebarSelector.removeClass('sticky_scroll_mm');
                     sidebarSelector.css("position","relative");
                     sidebarSelector.css("top","0px");
                }
            } else{ 
                sidebarSelector.removeClass('sticky_scroll_mm');
                sidebarSelector.css("position","relative");
                sidebarSelector.css("top","0px");
            }

        };
        var fixSidebrFixedWidth = function () {
             var sidebarSelector = $(this);
             sidebarSelector.css("width","auto");
        };
        return this.each(function () {
            $(window).on('scroll', $.proxy(fixSidebr, this));
            $(window).on('resize', $.proxy(fixSidebrFixedWidth, this))
            $.proxy(fixSidebr, this)();
        });

    };

}(jQuery));
//Whale
(function ($) {

    $.fn.stickyWhale = function (options) {

        var config = $.extend({
            headerSelector: '#header_single_tours',
            navSelector: 'nav',
            contentSelector: '#page_checkout_content',
            footerSelector: '#footer',
            sidebarTopMargin: 20, 
            footerThreshold: 40,
            rightWidth:0
        }, options);

        var fixSidebr = function () {

            var sidebarSelector = $(this);
            var viewportHeight = $(window).height();
            var viewportWidth = $(window).width();
            var documentHeight = $(document).height();
            var headerHeight = $(config.headerSelector).outerHeight();
            var navHeight = 0;//$(config.navSelector).outerHeight(); 
            var sidebarHeight = sidebarSelector.outerHeight(); 
            var contentHeight = $("#content_top_single_tours").outerHeight();
                contentHeight  = contentHeight + $("#image_text_single_tours").outerHeight();
                contentHeight  = contentHeight + $("#molokini-snorkeling-ttmn").outerHeight();
                contentHeight  = contentHeight + $("#content_center_single_tours").outerHeight();
                contentHeight  = contentHeight + $("#slide_image_hover").outerHeight();
                contentHeight  = contentHeight + $("content_bottom_single_tours").outerHeight();
                               ;
            var footerHeight = $(config.footerSelector).outerHeight() + 75 + $("#full_slider_1").outerHeight();
            var scroll_top = $(window).scrollTop();
            var fixPosition = contentHeight - sidebarHeight; 
            var breakingPoint1 = headerHeight + navHeight;
            var breakingPoint2 = documentHeight - (sidebarHeight + footerHeight + config.footerThreshold+62);
            var checkoutRightW = config.rightWidth;

            // calculate
            if(viewportWidth>750){
                if (contentHeight > sidebarHeight) { 

                    if (scroll_top < breakingPoint1) {

                        sidebarSelector.removeClass('sticky_scroll_mm');
                        sidebarSelector.css("position","relative");
                        sidebarSelector.css("top","0px");

                    } else if ((scroll_top >= breakingPoint1) && (scroll_top < breakingPoint2)) {

                        sidebarSelector.addClass('sticky_scroll_mm').css('top', config.sidebarTopMargin);
                        sidebarSelector.css("position","fixed"); 
                        sidebarSelector.css("width",checkoutRightW); 


                    } else {

                        var negative = breakingPoint2 - scroll_top;
                        sidebarSelector.addClass('sticky_scroll_mm').css('top',"4506px");
                        sidebarSelector.css("position","absolute"); 
                        sidebarSelector.css("width",checkoutRightW); 

                    }

                }
                else {
                     sidebarSelector.removeClass('sticky_scroll_mm');
                     sidebarSelector.css("position","relative");
                     sidebarSelector.css("top","0px");
                }
            } else{ 
                sidebarSelector.removeClass('sticky_scroll_mm');
                sidebarSelector.css("position","relative");
                sidebarSelector.css("top","0px");
            }

        };
        var fixSidebrFixedWidth = function () {
             var sidebarSelector = $(this);
             sidebarSelector.css("width","auto");
        };
        return this.each(function () {
            $(window).on('scroll', $.proxy(fixSidebr, this));
            $(window).on('resize', $.proxy(fixSidebrFixedWidth, this))
            $.proxy(fixSidebr, this)();
        });

    };

}(jQuery));
//End Whale
//Chapter
(function ($) {

    $.fn.stickyChapter = function (options) {

        var config = $.extend({
            headerSelector: '#header_single_tours',
            navSelector: 'nav',
            contentSelector: '#page_checkout_content',
            footerSelector: '#footer',
            sidebarTopMargin: 20, 
            footerThreshold: 40,
            rightWidth:0
        }, options);

        var fixSidebr = function () {

            var sidebarSelector = $(this);
            var viewportHeight = $(window).height();
            var viewportWidth = $(window).width();
            var documentHeight = $(document).height();
            var headerHeight = $(config.headerSelector).outerHeight();
            var navHeight = 0;//$(config.navSelector).outerHeight(); 
            var sidebarHeight = sidebarSelector.outerHeight(); 
            var contentHeight = $("#content_top_single_tours").outerHeight();
                contentHeight  = contentHeight + $("#molokini-snorkeling-ttmn").outerHeight();
                contentHeight  = contentHeight + $("#content_center_single_tours_private").outerHeight();
                contentHeight  = contentHeight + $("#slide_image_hover").outerHeight();
                contentHeight  = contentHeight + $("content_bottom_single_tours").outerHeight();
                               ;
            var footerHeight = $(config.footerSelector).outerHeight() + 75 + $("#full_slider_1").outerHeight();
            var scroll_top = $(window).scrollTop();
            var fixPosition = contentHeight - sidebarHeight; 
            var breakingPoint1 = headerHeight + navHeight;
            var breakingPoint2 = documentHeight - (sidebarHeight + footerHeight + config.footerThreshold+62);
            var checkoutRightW = config.rightWidth;

            // calculate
            if(viewportWidth>750){
                if (contentHeight > sidebarHeight) { 

                    if (scroll_top < breakingPoint1) {

                        sidebarSelector.removeClass('sticky_scroll_mm');
                        sidebarSelector.css("position","relative");
                        sidebarSelector.css("top","0px");

                    } else if ((scroll_top >= breakingPoint1) && (scroll_top < breakingPoint2)) {

                        sidebarSelector.addClass('sticky_scroll_mm').css('top', config.sidebarTopMargin);
                        sidebarSelector.css("position","fixed"); 
                        sidebarSelector.css("width",checkoutRightW); 


                    } else {

                        var negative = breakingPoint2 - scroll_top;
                        sidebarSelector.addClass('sticky_scroll_mm').css('top',"3756px");
                        sidebarSelector.css("position","absolute"); 
                        sidebarSelector.css("width",checkoutRightW); 

                    }

                }
                else {
                     sidebarSelector.removeClass('sticky_scroll_mm');
                     sidebarSelector.css("position","relative");
                     sidebarSelector.css("top","0px");
                }
            } else{ 
                sidebarSelector.removeClass('sticky_scroll_mm');
                sidebarSelector.css("position","relative");
                sidebarSelector.css("top","0px");
            }

        };
        var fixSidebrFixedWidth = function () {
             var sidebarSelector = $(this);
             sidebarSelector.css("width","auto");
        };
        return this.each(function () {
            $(window).on('scroll', $.proxy(fixSidebr, this));
            $(window).on('resize', $.proxy(fixSidebrFixedWidth, this))
            $.proxy(fixSidebr, this)();
        });

    };

}(jQuery));