/* Author: RealityGroup http://realitygroup.ru

*/

$(function(){
	Cufon.replace('.font-replace', { fontFamily: 'Myriad Pro Regular', textShadow: '1px 1px #eee', hover: true });
	//Cufon.now();
	
	$('div#slides').cycle({
		fx: 'fade',
		speed: '2000',
		easing: 'easeInOutExpo',
		timeout: 9000,
		prev: '#slide-prev',
		next: '#slide-next',
		width: 552,
		fit: 1
	});
	
	$('div#photo-stream').cycle({
		fx: 'fade',
		speed: '2000',
		easing: 'easeInOutExpo',
		timeout: 7000
	}); 		
	
	$('.scroll-pane').jScrollPane({
		showArrows: true,
		verticalDragMinHeight: 30,
		verticalDragMaxHeight: 80
	});	
});


