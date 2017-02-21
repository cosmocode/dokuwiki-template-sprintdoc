/**
 * Sets up the sidebar behaviour
 */
jQuery(function () {
    const $nav = jQuery('#dokuwiki__aside');
    if (!$nav.length) return;

    /**
     * closes sidebar
     */
    const setWideContent = function () {
        $nav.find('div.nav-panel').hide(); // close all panels
        jQuery('body').addClass('wide-content');
    };

    /**
     * opens the sidebar
     */
    const setDefaultContent = function () {
        jQuery('body').removeClass('wide-content');

    };

    /**
     * Accessibility helper, focuses the first link witih the given element
     *
     * @param {jQuery} $elem
     */
    const focusFirstSubLink = function ($elem) {
        $elem.find('a').first().focus();
    };

    /**
     * Toggle a navigation panel
     *
     * @param {jQuery} $toggler The h6 toggler
     */
    const toggleNav = function ($toggler) {
        const $panel = $toggler.next('div.nav-panel');
        const isOpen = $panel.is(':visible');
        // open sidebar on interaction
        setDefaultContent();
        // toggle the panel, focus first link after opening
        $panel.dw_toggle(!isOpen, function () {
            if (!isOpen) {
                focusFirstSubLink($panel);
            }
        });
    };

    /**
     * Initialize the content navigation
     *
     * It mangles the sidebar content and handles inline Icon configuration
     */
    const initContentNav = function () {
        const $main = $nav.find('nav.nav-main');
        if (!$main.length) return;

        const ELEMENT = 'h1,h2,h3,h4,h5'; // FIXME move to config
        const $elements = $main.find(ELEMENT);
        $elements.each(function () {
            const $me = jQuery(this);

            // prepare text and the optional icon
            const data = $me.text().split('@', 2);
            const text = data[0].trim();
            const $icon = jQuery('<span class="ico">')
                .text(text.substr(0, 1).toUpperCase() + text.substr(1, 1).toLowerCase())
                .wrapInner('<strong>');
            if (data[1]) {
                const src = data[1].trim();
                $icon.load(DOKU_BASE + 'lib/tpl/sprintdoc/svg.php?svg=' + src + '&e=1'); // directly embed
            }

            // make the new toggler
            const $toggler = jQuery('<h6>')
                    .attr('role', 'heading')
                    .attr('aria-level', '2')
                    .text(text)
                    .wrapInner('<span class="lbl">')
                    .prepend($icon)
                ;

            // wrap all following siblings til the next element in a wrapper
            const $wrap = jQuery('<div>')
                .addClass('nav-panel');
            const $sibs = $me.nextAll();
            for (let i = 0; i < $sibs.length; i++) {
                const $sib = jQuery($sibs[i]);
                if ($sib.is(ELEMENT)) break;
                $sib.detach().appendTo($wrap);
            }
            $wrap.insertAfter($me);

            // replace element with toggler
            $me.replaceWith($toggler);
        });
    };

    /**
     * Initialize the open/close toggling of menu entries
     */
    const initMenuHandling = function () {
        $nav.on('click', 'h6', function () {
            toggleNav(jQuery(this));
        });
    };

    /**
     * Make sure the content area is always as high as the sidebar
     */
    const initContentMinHeight = function () {
        const $sidebar = jQuery('.page-wrapper').find('> .tools').find('.col-xs-12');
        if ($sidebar.length == 1) {
            const num = parseFloat($sidebar.height());
            if (!isNaN(num)) {
                jQuery('#dokuwiki__content').css('minHeight', num + 100);
            }
        }
    };

    /**
     * Initialize the sidebar handle behaviour
     */
    const initSidebarToggling = function () {
        const $toggler = jQuery('.togglelink.page_main-content').find('a');
        $toggler.click(function (e) {
            e.preventDefault();
            if (jQuery('body').hasClass('wide-content')) {
                setDefaultContent();
            } else {
                setWideContent();
            }
        });
    };

    // main
    initContentNav();
    initSidebarToggling();
    initMenuHandling();
    initContentMinHeight();
});

