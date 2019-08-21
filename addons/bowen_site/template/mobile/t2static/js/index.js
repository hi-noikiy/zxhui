;(function () {
	'use strict';
	var sliderMain = function() {
		
	  	$('#fh5co-hero .flexslider').flexslider({
			animation: "fade",
			slideshowSpeed: 5000,
			directionNav: true,
			

	  	});

	};

	$(function(){

		sliderMain();
		
		//内容加载后的运动效果
	    dataAnimate();	

	});


}());
