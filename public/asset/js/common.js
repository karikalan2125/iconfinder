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


// Loading spinner
document.onreadystatechange = function () {
    if (document.readyState !== "complete") {
        document.body.classList.add('hidden-body'); // Hide body initially
        document.getElementById("loading_indicator").style.visibility = "visible";
    } else {
        setTimeout(() => {
            document.getElementById("loading_indicator").style.display = "none";
            document.body.classList.remove('hidden-body'); // Show body when loading is complete
        }, 1000);
    }
};



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

document.getElementById("scroll-to-top").addEventListener("click", function() {
    this.classList.add("animate-up");
    // Scroll to the top after the animation
    setTimeout(() => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
        // Optionally, remove the animate-up class after the animation
        setTimeout(() => {
            this.classList.remove("animate-up");
        }, 400); // Match this duration with the transition duration in CSS
    }, 400);
});

window.addEventListener("scroll", function() {
    var scrollTopButton = document.getElementById("scroll-to-top");
    if (window.scrollY > 200) { // Adjust the value to your preference
        scrollTopButton.style.display = "block";
    } else {
        scrollTopButton.style.display = "none";
    }
});


