/**
 * StudySync Digital Theme Scripts
 */

(function($) {
    'use strict';

    // Smooth scrolling for anchor links
    $('a[href^="#"]').on('click', function(e) {
        var target = $(this.getAttribute('href'));
        if (target.length) {
            e.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 100
            }, 1000);
        }
    });

    // Add animation on scroll
    function animateOnScroll() {
        $('.product-card, .category-card').each(function() {
            var elementTop = $(this).offset().top;
            var elementBottom = elementTop + $(this).outerHeight();
            var viewportTop = $(window).scrollTop();
            var viewportBottom = viewportTop + $(window).height();

            if (elementBottom > viewportTop && elementTop < viewportBottom) {
                $(this).addClass('animated');
            }
        });
    }

    // Run on scroll
    $(window).on('scroll', function() {
        animateOnScroll();
    });

    // Run on load
    $(document).ready(function() {
        animateOnScroll();
    });

    // Mobile menu toggle (if needed in future)
    $('.menu-toggle').on('click', function() {
        $('.main-navigation').toggleClass('active');
    });

    // External links in new tab
    $('a[href^="http"]').not('a[href*="' + window.location.hostname + '"]').attr({
        target: "_blank",
        rel: "noopener noreferrer"
    });

})(jQuery);
