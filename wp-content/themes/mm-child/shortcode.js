(function($)
{	
    "use strict";
	jQuery(document).ready(function($){
		//MM testimonials
		$.each([0, 1, 2, 3, 4, 5 , 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30 ], function( index, value ) {
			$(".avia-builder-el-"+value+" .slide-hover-image").hover(function(){
	
				$(".avia-builder-el-"+value+" .slider-new").css("display","block");
				$(".avia-builder-el-"+value+" .name-class").css("display","block");
				},function(){
				$(".avia-builder-el-"+value+" .slider-new").css("display","none");
				$(".avia-builder-el-"+value+" .name-class").css("display","none");
			});	
		});
		
		// MM creew
		$.each([ 1, 2, 3, 4, 5 , 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16], function( index, value ) {
			$(".mm_crew_loop_item_"+value+ " .button-Creew").click(function(){
				$(".text-click-creew").css("display","none");
				$(".button-Creew").css("background-color","#6FA907");
				$(".button-Creew").css("color","#fff");
				$(".button-Creew").css("border","none");
				$(".mm_crew_loop_item_"+value+" .text-click-creew").css("display","block");
				$(".mm_crew_loop_item_"+value+" .button-Creew").css("background-color","red");
				$(".mm_crew_loop_item_"+value+" .button-Creew").css("border","2px solid red");
				
			});   
		});
		
		// MM image
		$.each([ 1, 2, 3, 4, 5 , 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16], function( index, value ) {
			$(".slide-loop-"+value+ " img").hover(function(){
				var textvalue = $(".slide-loop-"+value+" .text_new").text();
				$('.text_new').css("display","none");
				if (screen.width > 767) {
					$('#text-below').text(textvalue);
					$("#text-below").css("display","block");}		
				if (screen.width < 767) {
					$(".slide-loop-"+value+" .text_new").css("display","block");
				}
			});
		});
		
		// MM image		
			$(".mm_expect_tour_container .mm_expect_tour_item.slick-slide").hover(function(){
				var hoverActive = $(".mm_expect_tour_container .mm_expect_tour_item.slick-slide").hasClass("hover_active");
				if (screen.width > 767) {
					if(hoverActive == true){
						$("#mm_expect_tour_show_info").css("display","block");
					}if(hoverActive == false){
						$("#mm_expect_tour_show_info").css("display","none");
					}}	
			});
		
		//MM Icon
		$.each([ 1, 2, 3, 4, 5 , 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16], function( index, value ) {
			$(".icon_columns-all:nth-child("+value+")").click(function(){
				$(".icon_columns-all").css("background-color","#f6f7f8");
				$(".icon_columns-all").css("border-bottom","3px solid #e1e1e1");	
				var texticon = $(".slide-icon-"+value+" .text-hover-icon").text();
				$('#text-below-icon').text(texticon);
				$("#text-below-icon").css("display","block");
				$(".icon_columns-all:nth-child("+value+")").css("background-color","#fff");
				$(".icon_columns-all:nth-child("+value+")").css("border-bottom","none");				
				$("#text-below-icon").css("background-color","#fff");
				if($(window).width() < 550){
					$(".icon_columns-all:nth-child("+value+")").css("border-bottom","none");
					$(".text-hover-icon").css("display","none");
					$(".icon_columns-all:nth-child("+value+") .text-hover-icon").css("display","block");
					$("#text-below-icon").css("display","none");
				}
			});
		});
		
		//icon new
		$.each([ 1, 2, 3, 4, 5 , 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16], function( index, value ) {
			$(".avia-icon-list-container ul .new-faq-wrap-full:nth-child("+value+") .iconlist_title_new").click(function(){
				$(".iconlist_content_new").css("display","none");
				var isActive = $(".avia-icon-list-container ul .new-faq-wrap-full:nth-child("+value+") .iconlist_title_new").hasClass("active");
				if(isActive == true){
					$(".avia-icon-list-container ul .new-faq-wrap-full:nth-child("+value+") .iconlist_title_new").removeClass("active");
					$(".avia-icon-list-container ul .new-faq-wrap-full:nth-child("+value+") .iconlist_content_new").css("display","none");
				} else{
					$(".iconlist_title_new").removeClass("active");
					$(".avia-icon-list-container ul .new-faq-wrap-full:nth-child("+value+") .iconlist_title_new").addClass("active");
					$(".avia-icon-list-container ul .new-faq-wrap-full:nth-child("+value+") .iconlist_content_new").css("display","block");
				}	
			});
		});
		
		//FAQ
		$.each([ 1, 2, 3, 4, 5 , 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16], function( index, value ) {
			$(".avia-icon-list-container ul .new-faq-wrap-left li:nth-child("+value+") .iconlist_title_new").click(function(){
				$(".iconlist_content_new").hide("slow");
				$(".title-faq").css("color","#464646");
				var isActive = $(".avia-icon-list-container ul .new-faq-wrap-left li:nth-child("+value+") .iconlist_title_new").hasClass("active");
				if(isActive == true){
					$(".avia-icon-list-container ul .new-faq-wrap-left li:nth-child("+value+") .iconlist_title_new").removeClass("active");
					$(".avia-icon-list-container ul .new-faq-wrap-left li:nth-child("+value+") .iconlist_content_new").hide("slow");
					$(".avia-icon-list-container ul .new-faq-wrap-left li:nth-child("+value+") .title-faq").css("color","#464646");
				} else{
					$(".iconlist_title_new").removeClass("active");
					$(".avia-icon-list-container ul .new-faq-wrap-left li:nth-child("+value+") .iconlist_title_new").addClass("active");
					$(".avia-icon-list-container ul .new-faq-wrap-left li:nth-child("+value+") .iconlist_content_new").show("slow");
					$(".avia-icon-list-container ul .new-faq-wrap-left li:nth-child("+value+") .title-faq").css("color","#f43737");
				}	
			});
		});
		
		$.each([ 1, 2, 3, 4, 5 , 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16], function( index, value ) {
			$(".avia-icon-list-container ul .new-faq-wrap-right li:nth-child("+value+") .iconlist_title_new").click(function(){
				$(".iconlist_content_new").hide("slow");
				$(".title-faq").css("color","#464646");
				var isActive = $(".avia-icon-list-container ul .new-faq-wrap-right li:nth-child("+value+") .iconlist_title_new").hasClass("active");
				if(isActive == true){
					$(".avia-icon-list-container ul .new-faq-wrap-right li:nth-child("+value+") .iconlist_title_new").removeClass("active");
					$(".avia-icon-list-container ul .new-faq-wrap-right li:nth-child("+value+") .iconlist_content_new").hide("slow");
					$(".avia-icon-list-container ul .new-faq-wrap-right li:nth-child("+value+") .title-faq").css("color","#464646");
				} else{
					$(".iconlist_title_new").removeClass("active");
					$(".avia-icon-list-container ul .new-faq-wrap-right li:nth-child("+value+") .iconlist_title_new").addClass("active");
					$(".avia-icon-list-container ul .new-faq-wrap-right li:nth-child("+value+") .iconlist_content_new").show("slow");
					$(".avia-icon-list-container ul .new-faq-wrap-right li:nth-child("+value+") .title-faq").css("color","#f43737");
				}	
			});
		});
		
		//Location
		$.each([ 1, 2, 3, 4, 5 , 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16], function( index, value ) {
			$(".class-location-"+value).click(function(){
				$(".test-image-1").css("display","block");
				$(".test-image-2").css("display","none");
				$(".text_location").css("display","none");
				$(".class-location-"+value+" .test-image-1").css("display","none");
				$(".class-location-"+value+" .test-image-2").css("display","block");
				$(".class-location-"+value+" .text_location").css("display","block");
			});
		});
		
		//ICON - FOOTER
		$.each([ 1, 2, 3, 4, 5 , 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16], function( index, value ) {
				$(".icon_footer li:nth-child("+value+") a img").hover(function(){
					/*$(".icon_hover").css("display","none");
					$(".icon_color").css("display","block");*/			
					$(".icon_color_"+value+"").css("display","none");
					$(".icon_hover_"+value+"").css("display","block");
				},function(){
					$(".icon_color_"+value+"").css("display","block");
					$(".icon_hover_"+value+"").css("display","none");
				});			
		});
		//molokini
		$.each([ 1, 2, 3, 4, 5 , 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16], function( index, value ) {
			$(".class-molokini-"+value).click(function(){
				$(".test-image-molikini-1").css("display","block");
				$(".test-image-molkini").css("display","none");
				var textleft = $(".class-molokini-"+value+" .text_molokini_left").text();
				var textright = $(".class-molokini-"+value+" .text_molokini_right").text();
				$(".class-molokini-"+value+" .test-image-molikini-1").css("display","none");
				$(".class-molokini-"+value+" .test-image-molkini").css("display","block");
				$(".class-molokini-"+value+" .text-below-molokini-left").css("display","block");
				$(".class-molokini-"+value+" .text-below-molokini-right").css("display","block");
				$(".text_left_1").css("display","none");
				$(".text_right_1").css("display","none");
				$('.text-below-molokini-left').text(textleft);
				$('.text-below-molokini-right').text(textright);
				$(".text-below-molokini-left").css("display","block");
				$(".text-below-molokini-right").css("display","block");
			});
		});
		
		

			
	});
})( jQuery );


 (function($){
	  //full slider images
     var width = $(document).width(); 
	 if(width > 767){
		var autoSL = setInterval(function(){autoHeightSlider();},1000); 
		function autoHeightSlider(){
			 var height_img = 0;
			 $('.red-slideshow').each(function(){  
				height_img = $(this).find('.avia-slideshow-inner .avia-slide-wrap img').height();
				$(this).find('.avia-caption').css('height',height_img);
			 });
			 if(height_img != 0){
				 clearInterval(autoSL);  
			 }
		}
		$(window).resize(function () {
			autoHeightSlider(); 
		}); 
	}
	$('.red-slideshow .avia-slideshow-arrows a').click(function(){
		$('.red-slideshow .avia-slideshow-arrows a').removeClass('active_slider');
		$(this).addClass('active_slider'); 
	});
	$('.btn_slider').click(function(){
		var data_silder = $(this).attr('data-slider');
		var type = $(this).attr('type_sl');
		console.log(data_silder+' '+type);
		$('.btn_slider').removeClass('active_btn');
		$(this).addClass('active_btn');
		if(type==='main'){
			var height = $('.'+data_silder).height();
			$('.'+data_silder).hide();
			$(this).parent().parent().parent().find('.container_'+data_silder).show();
			$(this).parent().parent().parent().find('.container_'+data_silder+' ul.avia-slideshow-inner').css('height',height+'px');
		}
		if(type==='child'){
			var height = $(this).parent().parent().parent().find('.container_'+data_silder).height();
			$('.'+data_silder).show();
			$('.'+data_silder).css({
				'z-index':'0',
			});
			$('.'+data_silder+'  ul.avia-slideshow-inner').css({
				'height':height+'px',
			});
			$(this).parent().parent().parent().find('.container_'+data_silder).hide();
			
		} 
	});
	/*  setTimeout(function(){
		$('.single-post .slick-arrow').click(function(){ */
			/*  setTimeout(function(){  
				 	$('.single-post .slick-current').css('padding-left','0px');
					$('.single-post .slick-active').css('padding-right','0px');
			 },1000);  */
		/* });
		
	},1000);  */
	
})( window.jQuery );