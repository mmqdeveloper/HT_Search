jQuery(document).ready(function(){
   // 
	jQuery('.related_mm_post_blog').slick({
		  slidesToShow: 2,
		  slidesToScroll: 1,
		  responsive: [
			    {
			      breakpoint: 1024,
			      settings: {
			        slidesToShow: 2,
			        slidesToScroll: 1,
			        infinite: true,
			        dots: true
			      }
			    },
			    {
			      breakpoint: 600,
			      settings: {
			        slidesToShow: 1, 
			        slidesToScroll: 1 
			      }
			    },
			    {
			      breakpoint: 480,
			      settings: {
			        slidesToShow: 1,
			        slidesToScroll: 1
			      }
			    }
			  ]
		});
      //  
});
