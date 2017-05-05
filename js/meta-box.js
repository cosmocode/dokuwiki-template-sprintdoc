
/**
 * Sets up the behaviour of the meta box
 *
 * @author Andreas Gohr <gohr@cosmocode.de>
 * @author Jana Deutschlaender <deutschlaender@cosmocode.de>
 */
(function($) {


    /**
     * Register the click handler for the tabs
     *
     * Tabs can be added dynamically later on and this handler will still
     * provide the open/close functionality
     */
    var registerClickForTabsInMetaBox = function($metaBox) {

            $metaBox.on('click', '.meta-tabs a', function (e) {
                e.preventDefault();
                var $tab = $(this),
                    isopen = $tab.attr('aria-expanded') === 'true';

                // disable all existing tabs
                disableExistingTabs($metaBox);


                if (isopen) return; // tab was open, we closed it. we're done

                // enable current tab
                $tab
                    .attr('aria-expanded', 'true')
                    .closest('li')
                    .addClass('active');
                $metaBox.find($tab.attr('href'))
                    .addClass('active')
                    .attr('aria-hidden', 'false');

            }).find('.meta-content').on('click', 'a[href*="#"]', function (e) {
                disableExistingTabs($metaBox);
                /* uses custome event handler hide see spc.js */
            }).find('#tagging__edit').on('hide', function(e){
                disableExistingTabs($metaBox);
            });

            /**
             * in admin templates show toc tab, if available
             */
            if($('body').hasClass('do-admin')) {
                var $tocLink = $metaBox.find('a[href="#spr__tab-toc"]');
                if($tocLink.length === 1) {
                    $tocLink.trigger('click');
                }
            }
        },
        disableExistingTabs = function($metaBox) {
            $metaBox.find('.meta-tabs li')
                .removeClass('active')
                .find('a')
                .attr('aria-expanded', 'false');
            $metaBox.find('.meta-content .tab-pane')
                .removeClass('active')
                .attr('aria-hidden', 'false');
        };


    $(function(){
        var $metaBox = $('#spr__meta-box');
        if (!$metaBox.length) return;

        registerClickForTabsInMetaBox($metaBox);
    });


})(jQuery);
