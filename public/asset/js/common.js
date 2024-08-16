// navbar sticky

document.addEventListener('DOMContentLoaded', function () {
    const searchForm = document.getElementById('search-form');
    const showHeight = 200; // Change this to the height at which you want to show the search form
    window.addEventListener('scroll', function () {
        if (window.scrollY >= showHeight) {
            searchForm.classList.add('show');
        } else {
            searchForm.classList.remove('show');
        }
    });
});

// scroll to top
$(function(){
	var offset = 200;
	var duration = 100;
	$(window).scroll(function() {
		if ($(this).scrollTop() > offset) {
			$('#scroll-to-top').fadeIn(duration);
		} else {
			$('#scroll-to-top').fadeOut(duration);
		}
	});
	
	$('#scroll-to-top').click(function(event) {
		event.preventDefault();
		$('html, body').animate({scrollTop: 0}, duration);
		return false;
	});
});

