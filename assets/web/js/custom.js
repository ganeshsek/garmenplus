/*back to top */
jQuery(document).ready(function(){
	jQuery("#scroll-up").hide();
	jQuery(function () {
		$(window).scroll(function(){
		if (jQuery(window).scrollTop()>50){
		jQuery("#scroll-up").fadeIn(1500);
		}
		else
		{
		$("#scroll-up").fadeOut(1500);
		}
		});
		
		$("#scroll-up").click(function(){
		$('body,html').animate({scrollTop:0},500);
		return false;
		});
		});

      
	  $(window).scroll(function(){
	  var sticky = $('.header'),
		  scroll = $(window).scrollTop();
	
	  if (scroll >= 1) sticky.addClass('header-fixed');
	  else sticky.removeClass('header-fixed');
	});
	
	$(window).scroll(function(){
	  var sticky = $('.banner-caption'),
		  scroll = $(window).scrollTop();
	
	  if (scroll >= 1) sticky.addClass('banner-space');
	  else sticky.removeClass('banner-space');
	});
	  
});

 wow = new WOW(
                      {
                      boxClass:     'wow',      // default
                      animateClass: 'animated', // default
                      offset:       0,          // default
                      mobile:       true,       // default
                      live:         true        // default
                    }
                    )
                    wow.init();


jQuery('#clients-carousel').owlCarousel({
    items:5,
    loop:true,
    nav:false,
    dots:false,
    margin:10,
    autoplay:true,
    autoplayTimeout:1000,
    autoplayHoverPause:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:5
        }
    }
})



		  
		  
		
