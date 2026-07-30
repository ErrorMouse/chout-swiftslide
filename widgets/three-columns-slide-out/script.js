/**
 * Chout - SwiftSlide: Three Columns Slide Out – Script
 *
 * Initializes the slideshow for each `.chout-tcso` widget on the page.
 * The transition interval is read from the `data-slide-duration` attribute (ms).
 */
(function () {
    'use strict';

    /**
     * Initializes the slideshow for a single `.chout-tcso` container.
     * @param {HTMLElement} wrap
     */
    function initTCSOSlider(wrap) {
        if (!wrap || wrap.dataset.choutInited) return;
        wrap.dataset.choutInited = '1';

        var slides = wrap.querySelectorAll('.image-slide');
        var total  = slides.length;

        // Requires at least 2 images to run the slideshow
        if (total < 2) return;

        var current      = 0;
        var slideDuration = parseInt(wrap.dataset.slideDuration, 10) || 4000;

        function showNext() {
            var prevSlide = slides[current];
            current = (current + 1) % total;
            var nextSlide = slides[current];

            // Clear the 'prev' state from all slides
            slides.forEach(function (s) { s.classList.remove('prev'); });

            // Push the current slide down to z-index 1
            prevSlide.classList.remove('active');
            prevSlide.classList.add('prev');

            // Activate the next slide
            nextSlide.classList.add('active');
        }

        setInterval(showNext, slideDuration);
    }

    /**
     * Initialize all TCSO widgets on the page.
     */
    function initAll() {
        document.querySelectorAll('.chout-tcso').forEach(initTCSOSlider);
    }

    // Run when the DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAll);
    } else {
        initAll();
    }

    // -------------------------------------------------------------------------
    // Elementor Frontend support (Live Preview in editor)
    // -------------------------------------------------------------------------
    window.addEventListener('load', function () {
        if (window.elementorFrontend && window.elementorFrontend.hooks) {
            window.elementorFrontend.hooks.addAction(
                'frontend/element_ready/chout_three_columns_slide_out.default',
                function ($scope) {
                    var wrap = $scope[0] ? $scope[0].querySelector('.chout-tcso') : null;
                    if (wrap) {
                        // Reset the init flag to allow re-initialization when the preview changes
                        delete wrap.dataset.choutInited;
                        initTCSOSlider(wrap);
                    }
                }
            );
        }
    });

})();
