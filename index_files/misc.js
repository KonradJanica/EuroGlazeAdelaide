function isElementInViewport(elem) {
    var $elem = $(elem);

    // Get the scroll position of the page.
    var viewportTop = $(window).scrollTop();
    var viewportBottom = viewportTop + $(window).height();

    // Get the position of the element on the page.
    var elemTop = Math.round( $elem.offset().top );
    var elemBottom = elemTop + $elem.height();

    if ($elem.height() > $(window).height()) {
        var diff = $elem.height() - $(window).height();
        elemTop += (diff + 1) / 2;
        elemBottom -= (diff + 1) / 2;
    }

    return ((elemTop < viewportBottom) && (elemBottom > viewportTop));
}

// Check if it's time to start the animation.
function checkAnimation() {
    $('.project').each(function() {
        // If the animation has already been started
        //if ($(this).hasClass('reveal-animation')) return;

        if (isElementInViewport($(this))) {
            // Start the animation
            $(this).addClass('reveal-animation');
        } else {
            $(this).removeClass('reveal-animation');
        }
    });
}

// Capture scroll events
var timer;
$(window).scroll(function(){
    if (timer) {
        window.clearTimeout(timer);
    }

    timer = window.setTimeout(checkAnimation(), 10000);
});

$(document).ready(function(){
    //checkAnimation();

    $('a[href=#buynow]').on('click', function(e) {
        e.preventDefault();

        var contactUs = $('body>w-div:last>div');
        if (contactUs.size()) {
            contactUs.css('bottom', '30px');
        } else {
            window.location.href = "contactus.html"
        }
    });
});
