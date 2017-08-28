/**
 * Sets up the sidebar behaviour
 *
 *  @author Andreas Gohr <gohr@cosmocode.de>
 *  @author Michael Große <gohr@cosmocode.de>
 *  @author Jana Deutschlaender <deutschlaender@cosmocode.de>
 */
jQuery(function () {
    var $nav = jQuery('#dokuwiki__aside');
    if (!$nav.length) return;

        /**
         * closes sidebar
         */
    var setWideContent = function () {
            $nav.find('div.nav-panel').hide(); // close all panels
            jQuery('body').addClass('wide-content');
            removeToggleStorage();
            window.sessionStorage.setItem('wide-content', true);
        },

        /**
         * removes information about the toggle-state
         */
        removeToggleStorage = function () {
            for (var index=0; index <= window.sessionStorage.length; index += 1) {
                var item = window.sessionStorage.getItem('sidebar-section-' + index + '-open');
                if (!item) {
                    continue;
                }
                window.sessionStorage.setItem('sidebar-section-' + index + '-open', 'false');
            }
        },

        /**
         * opens the sidebar
         */
        setDefaultContent = function () {
            jQuery('body').removeClass('wide-content');
            window.sessionStorage.setItem('wide-content', false);
        },

        /**
         * Accessibility helper, focuses the first link witih the given element
         *
         * @param {jQuery} $elem
         */
        focusFirstSubLink = function ($elem) {
            $elem.find('a').first().focus();
        },

        removeOpenStates = function() {
            $nav.find('.is-open').removeClass('is-open');
        },

        /**
         * Toggle a navigation panel
         *
         * @param {jQuery} $toggler The a toggler
         */
         toggleNav = function ($toggler) {
            var $panel = $toggler.parent().next('div.nav-panel');
            var isOpen = $panel.is(':visible');
            // open sidebar on interaction
            setDefaultContent();
            // toggle the panel, focus first link after opening
            $panel.dw_toggle(!isOpen, function () {
                if (!isOpen) {
                    focusFirstSubLink($panel);
                    $toggler.addClass('is-open');
                } else {
                    $toggler.removeClass('is-open');
                }
            });
            window.sessionStorage.setItem('sidebar-section-' + $toggler.data('index') + '-open', !isOpen);
        },

        /**
         * Initialize the content navigation
         *
         * It mangles the sidebar content and handles inline Icon configuration
         */
        initContentNav = function () {
            var $main = $nav.find('nav.nav-main');
            if (!$main.length) return;

            if(jQuery('body').hasClass('wide-content')) {
                removeToggleStorage();
            }

            var ELEMENT = JSINFO.template.sprintdoc.sidebar_toggle_elements;
            var $elements = $main.find(ELEMENT);
            $elements.each(function (index) {
                var $me = jQuery(this),

                // prepare text and the optional icon
                    data = $me.text().split('@', 2),
                    text = data[0].trim();

                var $icon = jQuery('<span class="ico">')
                    .text(text.substr(0, 1).toUpperCase() + text.substr(1, 1).toLowerCase())
                    .wrapInner('<strong>');
                if (data[1]) {
                    var src = data[1].trim();
                    $icon.load(DOKU_BASE + 'lib/tpl/sprintdoc/svg.php?svg=' + src + '&e=1'); // directly embed
                }

                // make the new toggler
                var $toggler = jQuery('<a>')
                        .attr('href', '#')
                        .attr('role', 'heading')
                        .attr('aria-level', '2')
                        .text(text)
                        .wrapInner('<span class="lbl">')
                        .prepend($icon)
                        .data('index', index)
                    ;
                $toggler = jQuery('<div class="nav">').prepend($toggler);


                // wrap all following siblings til the next element in a wrapper
                var $wrap = jQuery('<div>')
                    .addClass('nav-panel');
                var $sibs = $me.nextAll();

                for (var i = 0; i < $sibs.length; i++) {
                    var $sib = jQuery($sibs[i]);
                    if ($sib.is(ELEMENT)) break;
                    $sib.detach().appendTo($wrap);
                    addContentMenuCurrentStates($sib, $toggler);
                }
                $wrap.insertAfter($me);

                // replace element with toggler
                $me.replaceWith($toggler);

                if ($toggler.parent('li').length) {
                    $toggler.parent('li').addClass('toggler');
                }

                if (window.sessionStorage.getItem('sidebar-section-' + index + '-open') === 'true') {
                    $wrap.css('display', 'block');
                    setTogglerClass($toggler,'is-open');
                }

            });
        },

        /**
         * Initialize the open/close toggling of menu entries
         */
        initMenuHandling = function () {
            $nav.on('click', 'div.nav a', function (e) {
                toggleNav(jQuery(this));
                e.preventDefault();
            });
        },

        /**
         * adds a given class to the toggler link
         * @param $toggler link or parent of link to whom the class is added
         * @param classVal class to be added
         */
        setTogglerClass = function ($toggler, classVal) {
            if($toggler.is('a')) {
                $toggler.addClass(classVal);
            } else {
                $toggler.find('a').addClass(classVal);
            }
        },

        /**
         * marks a $toggler link as active if the following menu has an active state
         * @param $menuObj jQuery Object of the menu / container
         * @param $toggler
         */
        addContentMenuCurrentStates = function ($menuObj, $toggler) {
            if($menuObj[0] && String($menuObj[0].innerHTML).indexOf('curid') > 0) {
                setTogglerClass($toggler,'is-active');
            }
        },

        /**
         * Make sure the content area is always as high as the sidebar
         */
        initContentMinHeight = function () {
            var $sidebar = jQuery('.page-wrapper').find('> .tools').find('.col-xs-12');
            if ($sidebar.length == 1) {
                var num = parseFloat($sidebar.height());
                if (!isNaN(num)) {
                    jQuery('#dokuwiki__content').css('minHeight', num + 100);
                }
            }
        },

        /**
         * Initialize the sidebar handle behaviour
         */
        initSidebarToggling = function () {
            var $toggler = jQuery('.togglelink.page_main-content').find('a');
            $toggler.click(function (e) {
                e.preventDefault();
                if (jQuery('body').hasClass('wide-content')) {
                    setDefaultContent();
                } else {
                    setWideContent();
                    removeOpenStates();
                }
            });

            if (window.sessionStorage.getItem('wide-content') === 'true') {
                setWideContent();
            }
        },

        /**
         * Show sidebar when accessing the search
         */
        initSearchToggling = function () {
            jQuery('.toggleSearch').find('a').click(function (e) {
                setDefaultContent();
                e.preventDefault();
                jQuery('#qsearch__in').focus();
            });

        },

        /**
         * Open and close the sidebar in mobile view
         */
        initMobileToggling = function () {
            jQuery('.menu-togglelink').find('a').click(function (e) {
                e.preventDefault();
                var $body = jQuery('body');
                $body.toggleClass('show-mobile-sidebar');
            });
        },

        /**
         * set is-active class if body has at least one of the given selectors
         * @param selectorArray Array of selectors
         * @param $nav container in which the $toggler is situated
         */
        setActive = function(selectorArray, $nav) {
            for(var i=0; i< selectorArray.length; i++) {
                var mode = selectorArray[i];
                if(jQuery('body').is('.do-'+mode)){
                    setTogglerClass($nav.find('.nav'),'is-active');
                    $nav.find('a[href*="do='+mode+'"]').wrapAll('<span class="curid"></span>');
                }
            }
        },

        /**
         * sets active states in site tool menu and user tool menu for certain modes
         * adds sessionStorage behaviour equivalent approach to content menus
         *
         */
        initTemplateMenues = function () {
            var $body = jQuery('body'),
                $siteTools = $nav.find('> .nav-sitetools'),
                $userTools = $nav.find('> .nav-usermenu'),
                $templateMenus = $nav.find('> nav:not(.nav-main)'),

                stModes = ['recent', 'media', 'index'],
                utModes = ['profile','admin'],
                isWideContent = false;

            /* set active states for site tool menu and user tool menu */
            setActive(stModes,$siteTools);
            setActive(utModes,$userTools);

            if($body.is('.do-show') && $body.is('.wide-content')) {
                window.sessionStorage.setItem('wide-content', true);
                isWideContent = true;
            }



            /* set data attributes for sessionStorage and check onload if one of the template menus should be opened */
            $templateMenus.each(function( index ) {
                var $t = jQuery(this).find('.nav'),
                    y = $nav.find('.nav-main').find('.nav').length,
                    $toggler = ($t.is('a')) ? $t : $t.find('a:last'),
                    tIndex = y + index;
                $toggler.data('index', tIndex);

                var item = window.sessionStorage.getItem('sidebar-section-' + tIndex + '-open');
                if (item) {
                    if(isWideContent) {
                        window.sessionStorage.setItem('sidebar-section-' + tIndex + '-open', 'false');
                    } else {
                        if (item === 'true') {
                            jQuery(this).find('.nav-panel').css('display', 'block');
                            setTogglerClass($toggler, 'is-open');
                        }
                    }
                }
                //console.log(window.sessionStorage);

            });

        };


    // main
    initContentNav();
    initSidebarToggling();
    initTemplateMenues();
    initMenuHandling();
    initContentMinHeight();
    initSearchToggling();
    initMobileToggling();
});

