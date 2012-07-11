$(function() {
	var path = window.location.href;
	$('ul li a').each(function() {
	    if (this.href === path) {
	        $(this).parent().addClass('active');
	    }
	    else {
	    	$(this).parent().removeClass('active');
	    }
	});
});