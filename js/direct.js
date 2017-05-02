
/**
 * Sets up the behaviour of direct menu links
 *
 * @author Jana Deutschlaender <deutschlaender@cosmocode.de>
 */
(function($) {


    var $body,

        /**
         * Register the click handler for the direct links
         * should scroll to the page area whether there is a fixed magic matcher bar or not
         *
         * @param $directMenu
         */
        scrollingForDirectNav = function($directMenu) {
            $body = $('body');
            checkAnchorsOnLoad($directMenu);
            registerClickForDirectLinks($directMenu);

        },

        /**
         * register click event listener for direct links
         * @param $menu
         */
        registerClickForDirectLinks = function($menu) {
            $menu.find('a').on('click', function (e) {
                e.stopPropagation();
                var target = $(this).attr('href');
                tasksBeforeScrolling(target);
                scrollToTarget(target);
            });
        },

        /**
         * scroll to / set focus to target of direct link if value of location hash equals direct link
         * @param $menu
         */
        checkAnchorsOnLoad = function($menu) {
            var hash = window.location.hash;
            if (hash) {
                $menu.find('a').each(function() {
                    var target = $(this).attr('href');
                    if(hash === target) {
                        tasksBeforeScrolling(target);
                        scrollToTarget(target);
                        setFocusOnLoad(target);
                    }
                });
            }
        },

        /**
         * todos that needs to be done before the scrolling can start
         * @param target
         */
        tasksBeforeScrolling = function(target) {
            switch (target) {
                case '#qsearch__in':
                    showSearchField(target);
                    break;

                case '#dokuwiki__usertools':
                    $(target).find('li:first-child').find('a').focus();
                    break;

            }
        },

        /**
         * set focus on target or first link found in target
         * @param target
         */
        setFocusOnLoad = function(target) {
            var $target = $(target);
            switch (target) {

                case '#qsearch__in':
                case '#spr__toggle-content':
                    $target.focus();
                    break;

                case '#dokuwiki__usertools':
                    break;

                default:
                    $target.attr('tabindex',0);
                    $target.focus();

            }
        },

        /**
         * trigger content toggle link to make the search field visible otherwise it neither be used for scrolling nor
         * for focus setting
         * @param target
         */
        showSearchField = function(target) {
            if($body.hasClass('wide-content')) {
                $('#spr__toggle-content').trigger('click');
            }
        },

        /**
         * scrolls to the target with an offset of 60px
         * @param target
         */
        scrollToTarget = function(target) {
            // scroll to each target
            $(target).velocity('scroll', {
                duration: 400,
                offset: -60,
                easing: 'ease-in-out'
            });
        };


    $(function(){

        var $directMenu = $('#spr__direct');
        if (!$directMenu.length) return;

        scrollingForDirectNav($directMenu);
    });


})(jQuery);
