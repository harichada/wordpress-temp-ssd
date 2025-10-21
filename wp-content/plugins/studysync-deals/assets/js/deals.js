/**
 * StudySync Deals - Frontend JavaScript
 *
 * @package StudySync_Deals
 */

(function($) {
    'use strict';

    // Copy coupon code to clipboard
    window.ssdCopyCode = function(element) {
        var code = $(element).data('code');

        // Create temporary input to copy from
        var tempInput = $('<input>');
        $('body').append(tempInput);
        tempInput.val(code).select();

        try {
            // Copy to clipboard
            document.execCommand('copy');

            // Visual feedback
            $(element).addClass('copied');
            $(element).text('COPIED!');

            // Reset after 2 seconds
            setTimeout(function() {
                $(element).removeClass('copied');
                $(element).text(code);
            }, 2000);

        } catch (err) {
            console.error('Failed to copy:', err);
            alert('Coupon code: ' + code);
        }

        tempInput.remove();
    };

    // Deal card animations
    $(document).ready(function() {

        // Animate deal cards on scroll
        function animateDeals() {
            $('.ssd-deal-card').each(function() {
                var cardTop = $(this).offset().top;
                var cardBottom = cardTop + $(this).outerHeight();
                var viewportTop = $(window).scrollTop();
                var viewportBottom = viewportTop + $(window).height();

                if (cardBottom > viewportTop && cardTop < viewportBottom) {
                    $(this).addClass('animated');
                }
            });
        }

        // Run on scroll
        $(window).on('scroll', animateDeals);

        // Run on load
        animateDeals();

        // Track deal clicks for analytics (if you want to add tracking)
        $('.deal-button-active').on('click', function() {
            var dealTitle = $(this).closest('.ssd-deal-card, .ssd-single-deal').find('.deal-card-title, .single-deal-title').text().trim();

            // You can add Google Analytics or other tracking here
            if (typeof gtag !== 'undefined') {
                gtag('event', 'deal_click', {
                    'event_category': 'Deals',
                    'event_label': dealTitle
                });
            }
        });

        // Countdown timer for expiring deals (optional enhancement)
        function updateCountdowns() {
            $('.deal-expires').each(function() {
                // This is a placeholder for a more sophisticated countdown
                // You could implement real-time countdowns here
            });
        }

        // Update countdowns every minute
        setInterval(updateCountdowns, 60000);

    });

})(jQuery);
